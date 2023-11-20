-- Use a specific schema
DROP SCHEMA IF EXISTS lbaw2322 CASCADE;
CREATE SCHEMA IF NOT EXISTS lbaw2322;
SET search_path TO lbaw2322;

-- Drop old tables
DROP TABLE IF EXISTS follows CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS Bid CASCADE;

DROP TABLE IF EXISTS AuctionPhoto CASCADE;
DROP TABLE IF EXISTS AuctionWinner CASCADE;
DROP TABLE IF EXISTS Auction CASCADE;
DROP TABLE IF EXISTS moneys CASCADE;
DROP TABLE IF EXISTS Admin CASCADE;
DROP TABLE IF EXISTS SystemManager CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS MetaInfoValue CASCADE;
DROP TABLE IF EXISTS MetaInfo CASCADE;
DROP TABLE IF EXISTS AuctionMetaInfoValue CASCADE;
DROP TABLE IF EXISTS Notification CASCADE;

DROP TYPE IF EXISTS notification_type;
DROP TYPE IF EXISTS category_type;
DROP TYPE IF EXISTS auction_state;
DROP TYPE IF EXISTS transfer_state;
DROP TYPE IF EXISTS report_state;

DROP FUNCTION IF EXISTS user_fullsearch_update;
DROP FUNCTION IF EXISTS auction_search_update;

DROP FUNCTION IF EXISTS anonymize_user_data;
DROP FUNCTION IF EXISTS prevent_auction_cancellation;
DROP FUNCTION IF EXISTS enforce_bidding_rules;
DROP FUNCTION IF EXISTS extend_auction_deadline;
DROP FUNCTION IF EXISTS prevent_seller_self_follow;
DROP FUNCTION IF EXISTS check_bid_date;
DROP FUNCTION IF EXISTS check_user_age;
DROP FUNCTION IF EXISTS prevent_owner_bid;
DROP FUNCTION IF EXISTS send_comment_notification;
DROP FUNCTION IF EXISTS send_bid_notification;
DROP FUNCTION IF EXISTS send_upgrade_notification;
DROP FUNCTION IF EXISTS send_downgrade_notification;
DROP FUNCTION IF EXISTS send_auction_notification;
DROP FUNCTION IF EXISTS auto_follow;
DROP FUNCTION IF EXISTS update_owner_rating;
DROP FUNCTION IF EXISTS prevent_auction_winner_active;
DROP FUNCTION IF EXISTS transfer_approved;

/*

TYPES

*/

-- Define enums
CREATE TYPE notification_type AS ENUM (
    'auction_paused',
    'auction_finished',
    'auction_approved',
    'auction_denied',
    'auction_resumed', 
    'auction_comment',
    'auction_bid',
    'user_upgrade',
    'user_downgrade'
);


CREATE TYPE category_type AS ENUM (
    'strings',
    'woodwinds',
    'brass',
    'percussion'
);

CREATE TYPE auction_state AS ENUM (
    'pending',
    'active',
    'finished',
    'paused',
    'approved',
    'denied',
    'disabled'
);


CREATE TYPE transfer_state AS ENUM (
    'pending',
    'accepted',
    'denied'
);

CREATE TYPE report_state AS ENUM (
    'listed',
    'reviewed',
    'unrelated'
);
/*

TABLES

*/

-- users table
CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  balance MONEY NOT NULL DEFAULT 0,
  date_of_birth DATE NOT NULL,
  street VARCHAR(255) DEFAULT NULL,
  city VARCHAR(255) DEFAULT NULL,
  zip_code VARCHAR(10) DEFAULT NULL,
  country VARCHAR(255) DEFAULT NULL,
  rating FLOAT CHECK (rating >= 0 AND rating <= 5) DEFAULT NULL,
  image BYTEA
);
  ALTER TABLE users ADD COLUMN is_anonymizing BOOLEAN DEFAULT false;
-- SystemManager table
CREATE TABLE SystemManager (
  user_id INT REFERENCES users(id) ON UPDATE CASCADE,
  PRIMARY KEY (user_id)
);

-- Admin table
CREATE TABLE Admin (
  user_id INT REFERENCES users(id) ON UPDATE CASCADE,
  PRIMARY KEY (user_id)
);

CREATE TABLE moneys (
  id SERIAL PRIMARY KEY,
  user_id INT REFERENCES users(id) ON UPDATE CASCADE,
  amount MONEY  CHECK (amount > '0'::MONEY),
  type BOOL NOT NULL,
  state transfer_state DEFAULT 'pending'
);


-- Auction table
CREATE TABLE Auction (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  initial_price MONEY CHECK (initial_price >= '0'::MONEY),
  price MONEY CHECK (price >= initial_price),
  initial_time TIMESTAMP DEFAULT NULL,
  end_time TIMESTAMP DEFAULT NULL,
  category category_type DEFAULT NULL,
  state auction_state DEFAULT 'pending',
  owner INT REFERENCES users(id) ON UPDATE CASCADE
);

--AuctionWinner table
CREATE TABLE AuctionWinner (
  auction_id INT REFERENCES Auction(id) ON UPDATE CASCADE NOT NULL,
  user_id INT REFERENCES users(id) ON UPDATE CASCADE NOT NULL,
  rating INT CHECK (rating >= 0 AND rating <= 5) DEFAULT NULL,
  PRIMARY KEY (user_id, auction_id)
);

-- AuctionPhoto table
CREATE TABLE AuctionPhoto (
  id SERIAL PRIMARY KEY,
  auction_id INT REFERENCES Auction(id) ON UPDATE CASCADE NOT NULL,
  image BYTEA NOT NULL
);

-- Bid table
CREATE TABLE Bid (
  id SERIAL PRIMARY KEY,
  user_id INT REFERENCES users(id) ON UPDATE CASCADE NOT NULL,
  auction_id INT REFERENCES Auction(id) ON UPDATE CASCADE NOT NULL,
  amount MONEY NOT NULL CHECK (amount > '0'::MONEY),
  time TIMESTAMP CHECK (time <= NOW())
);

-- Report table
CREATE TABLE Report (
  user_id INT REFERENCES users(id) ON UPDATE CASCADE NOT NULL,
  auction_id INT REFERENCES Auction(id) ON UPDATE CASCADE NOT NULL,
  description TEXT NOT NULL,
  state report_state DEFAULT 'listed',
  PRIMARY KEY (user_id, auction_id)
);

-- follows table
CREATE TABLE follows (
  user_id INT REFERENCES users(id) ON UPDATE CASCADE,
  auction_id INT REFERENCES Auction(id) ON UPDATE CASCADE,
  PRIMARY KEY (user_id, auction_id)
);

-- Comment table
CREATE TABLE Comment (
  id SERIAL PRIMARY KEY,
  user_id INT REFERENCES users(id) ON UPDATE CASCADE,
  auction_id INT REFERENCES Auction(id) ON UPDATE CASCADE,
  message TEXT NOT NULL,
  time TIMESTAMP CHECK (time <= NOW())
);

-- MetaInfo table
CREATE TABLE MetaInfo (
  name VARCHAR(255) PRIMARY KEY
);

-- MetaInfoValue table
CREATE TABLE MetaInfoValue (
  id SERIAL PRIMARY KEY,
  meta_info_name VARCHAR(255) REFERENCES MetaInfo(name) ON UPDATE CASCADE,
  value TEXT NOT NULL
);

-- AuctionMetaInfoValue table
CREATE TABLE AuctionMetaInfoValue (
  auction_id INT REFERENCES Auction(id) ON UPDATE CASCADE,
  meta_info_value_id INT REFERENCES MetaInfoValue(id) ON UPDATE CASCADE,
  PRIMARY KEY (auction_id, meta_info_value_id)
);

-- Notification table
CREATE TABLE Notification (
  id SERIAL PRIMARY KEY,
  notification_type notification_type NOT NULL,
  date TIMESTAMP NOT NULL CHECK (date <= NOW()),
  viewed BOOLEAN DEFAULT false,
  receiver_id INT REFERENCES users(id) ON UPDATE CASCADE,
  bid_id INT REFERENCES Bid(id) ON UPDATE CASCADE,
  auction_id INT REFERENCES Auction(id) ON UPDATE CASCADE,
  comment_id INT REFERENCES Comment(id) ON UPDATE CASCADE
);

/*

INDEXES

*/

-- Index (IDX01)
CREATE INDEX username_search ON users USING HASH (username);

-- Index (IDX02)
CREATE INDEX notification_receiver ON Notification USING HASH (receiver_id);

-- Index (IDX03)
CREATE INDEX auction_state ON Auction USING HASH (state);

-- Index (IDX04)
ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION user_fullsearch_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.username), 'B') ||
            setweight(to_tsvector('english', NEW.name), 'A')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF NEW.username <> OLD.username THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', NEW.username), 'B') ||
                setweight(to_tsvector('english', NEW.name), 'A')
            );
        END IF;
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;
CREATE TRIGGER user_fullsearch_update
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
EXECUTE FUNCTION user_fullsearch_update();

CREATE INDEX search_user ON users USING GIN (tsvectors);

-- Index (IDX05)
ALTER TABLE Auction
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION auction_search_update() RETURNS TRIGGER AS $$
BEGIN
     IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.name), 'B') ||
            setweight(to_tsvector('english', NEW.category::text), 'A')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF NEW.name <> OLD.name OR NEW.category <> OLD.category THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', NEW.name), 'B') ||
                setweight(to_tsvector('english', NEW.category::text), 'A')
            );
        END IF;
    END IF;
    RETURN NEW;
END
$$ LANGUAGE plpgsql;
CREATE TRIGGER auction_search_update
BEFORE INSERT OR UPDATE ON Auction
FOR EACH ROW
EXECUTE FUNCTION auction_search_update();

CREATE INDEX search_auction ON Auction USING GIN (tsvectors);


/*

TRIGGERS

*/

-- Trigger (T01)
CREATE OR REPLACE FUNCTION anonymize_user_data()
RETURNS TRIGGER AS 
$$
BEGIN
  IF NEW.is_anonymizing THEN
    NEW.username := 'anonymous' || OLD.id;
    NEW.name := 'Anonymous';
    NEW.email := 'anonymous' || OLD.id || '@anonymous.com';
    NEW.password := 'anonymous';
    NEW.date_of_birth := '1900-01-01';
    NEW.balance := 0.00;
    NEW.street := NULL;
    NEW.city := NULL;
    NEW.zip_code := NULL;
    NEW.country := NULL;
    NEW.rating := NULL;
    NEW.image := NULL;
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER anonymize_user_data_trigger
BEFORE UPDATE ON users
FOR EACH ROW
EXECUTE FUNCTION anonymize_user_data();


-- Trigger (T02)
CREATE FUNCTION prevent_auction_cancellation()
RETURNS TRIGGER AS 
$$
DECLARE
  num_bids INTEGER;
BEGIN
  IF old.state = 'active' AND NEW.state = 'disabled' THEN
    SELECT COUNT(*) INTO num_bids FROM Bid WHERE auction_id = OLD.id;
    IF num_bids > 0 THEN
      RAISE EXCEPTION 'Cannot cancel the auction. There are % bids.', num_bids;
    END IF;
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER prevent_auction_cancellation_trigger
BEFORE UPDATE ON Auction
FOR EACH ROW
EXECUTE FUNCTION prevent_auction_cancellation();

-- Trigger (T03)
CREATE FUNCTION enforce_bidding_rules()
RETURNS TRIGGER AS 
$$
DECLARE
  current_highest_bid MONEY;
  highest_bidder INTEGER;
  i_price MONEY;
  user_balance MONEY;
  current_state auction_state;
BEGIN
  SELECT user_id, amount INTO highest_bidder, current_highest_bid
  FROM Bid
  WHERE auction_id = NEW.auction_id
  ORDER BY amount DESC
  LIMIT 1;
  SELECT initial_price, state INTO i_price, current_state
  FROM Auction
  WHERE id = NEW.auction_id;
  SELECT balance INTO user_balance
  FROM users
  WHERE id = NEW.user_id;


  
  IF NEW.amount <= current_highest_bid OR NEW.amount < i_price THEN
    RAISE EXCEPTION 'Your bid must be higher than the current highest bid.';
  ELSIF highest_bidder = NEW.user_id THEN
    RAISE EXCEPTION 'You cannot bid if you currently own the highest bid.';
  ELSIF user_balance < NEW.amount THEN
    RAISE EXCEPTION 'You do not have enough balance in your account.';
  ELSIF current_State <> 'active' THEN
    RAISE EXCEPTION 'You may only bid in active auctions.';
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER enforce_bidding_rules_trigger
BEFORE INSERT ON Bid
FOR EACH ROW
EXECUTE FUNCTION enforce_bidding_rules();

-- Trigger (T04)
CREATE FUNCTION extend_auction_deadline()
RETURNS TRIGGER AS 
$$
DECLARE
  e_time TIMESTAMP;
  fifteen_minutes_later TIMESTAMP;
BEGIN
  SELECT end_time INTO e_time
  FROM Auction
  WHERE id = NEW.auction_id;

  fifteen_minutes_later := NEW.time + INTERVAL '15 minutes';
  IF e_time < fifteen_minutes_later THEN
    UPDATE Auction
    SET end_time = end_time + INTERVAL '30 minutes'
    WHERE id = NEW.auction_id;
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER extend_auction_deadline_trigger
BEFORE INSERT ON Bid
FOR EACH ROW
EXECUTE FUNCTION extend_auction_deadline();

-- Trigger (T05)
CREATE FUNCTION prevent_seller_self_follow()
RETURNS TRIGGER AS 
$$
BEGIN
  IF NEW.user_id = (SELECT owner FROM Auction WHERE id = NEW.auction_id) THEN
    RAISE EXCEPTION 'A seller cannot follow their own auction.';
  END IF;

  RETURN NEW;
END;
$$
LANGUAGE plpgsql;
CREATE TRIGGER prevent_seller_self_follow_trigger
BEFORE INSERT ON follows
FOR EACH ROW
EXECUTE FUNCTION prevent_seller_self_follow();

-- Trigger (T06)
CREATE FUNCTION check_bid_date()
RETURNS TRIGGER AS 
$$
DECLARE last_bid_time TIMESTAMP;
BEGIN
  SELECT time, amount INTO last_bid_time
  FROM Bid 
  Where auction_id = NEW.auction_id
  ORDER BY amount DESC
  LIMIT 1;
  IF NEW.time <= last_bid_time THEN
    RAISE EXCEPTION 'The date of the incoming bid must be higher than the date of the current highest bid.';
  END IF;

  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER check_bid_date_trigger
BEFORE INSERT ON Bid
FOR EACH ROW
EXECUTE FUNCTION check_bid_date();

-- Trigger (T07)
CREATE FUNCTION check_user_age()
RETURNS TRIGGER AS 
$$
DECLARE
  user_age INT;
  current_18 INT;
BEGIN
  user_age := extract(YEAR FROM AGE(NEW.date_of_birth));
  current_18 := extract(YEAR FROM AGE(CURRENT_DATE - INTERVAL '18 years'));
  IF user_age < current_18 THEN
    RAISE EXCEPTION 'You must be at least 18 years old to register on this website.';
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER check_user_age_trigger
BEFORE INSERT ON users
FOR EACH ROW
EXECUTE FUNCTION check_user_age();

-- Trigger (T08)
CREATE FUNCTION prevent_owner_bid()
RETURNS TRIGGER AS 
$$
BEGIN
  IF NEW.user_id = (SELECT owner FROM Auction WHERE id = NEW.auction_id) THEN
    RAISE EXCEPTION 'You cannot bid on your own auction as the owner.';
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER check_owner_bid
BEFORE INSERT ON Bid
FOR EACH ROW
EXECUTE FUNCTION prevent_owner_bid();

-- Trigger (T09)
CREATE FUNCTION auto_follow()
RETURNS TRIGGER AS 
$$

BEGIN

  IF((SELECT COUNT(*) FROM follows WHERE auction_id = NEW.auction_id AND user_id = NEW.user_id) = 0) THEN
    INSERT INTO follows (user_id, auction_id)
    VALUES (NEW.user_id, NEW.auction_id);
  END IF;
 
  RETURN NEW;

END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER auto_follow_on_bid
AFTER INSERT ON Bid
FOR EACH ROW
EXECUTE FUNCTION auto_follow(); 


-- Trigger (T10)
CREATE FUNCTION update_owner_rating()
RETURNS TRIGGER AS 
$$
DECLARE 
  owner_id INT;
BEGIN
  SELECT owner into owner_id FROM auction WHERE id = NEW.auction_id;

  UPDATE users
  SET rating = (
    SELECT COALESCE(ROUND(AVG(AuctionWinner.rating), 2), 0)
    FROM AuctionWinner
    JOIN Auction ON AuctionWinner.auction_id = Auction.id
    WHERE Auction.owner = owner_id
  )
  WHERE id = owner_id;
  
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER calculate_owner_rating
AFTER INSERT OR UPDATE ON AuctionWinner
FOR EACH ROW
EXECUTE FUNCTION update_owner_rating();

-- Trigger (TR11)
CREATE FUNCTION prevent_auction_winner_active()
RETURNS TRIGGER AS 
$$
BEGIN
    IF (SELECT state FROM Auction WHERE id = NEW.auction_id) <> 'finished' THEN
        RAISE EXCEPTION 'The auction hasnt finished.';
    END IF;
    RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER prevent_auction_winner
BEFORE INSERT ON AuctionWinner
FOR EACH ROW
EXECUTE FUNCTION prevent_auction_winner_active();


-- Trigger (T12)
CREATE FUNCTION send_comment_notification()
RETURNS TRIGGER AS 
$$
BEGIN
  INSERT INTO Notification (notification_type, date, receiver_id, comment_id)
  VALUES ('auction_comment', NEW.time, NEW.user_id, NEW.id);

  INSERT INTO Notification (notification_type, date, receiver_id, comment_id)
  SELECT 'auction_comment', NEW.time, f.user_id, NEW.id
  FROM follows AS f
  WHERE f.auction_id = NEW.auction_id;

  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER comment_notification
AFTER INSERT ON Comment
FOR EACH ROW
EXECUTE FUNCTION send_comment_notification();

-- Trigger (T13)
CREATE FUNCTION send_bid_notification()
RETURNS TRIGGER AS 
$$
BEGIN
  INSERT INTO Notification (notification_type, date, receiver_id, bid_id)
  VALUES ('auction_bid', NEW.time, NEW.user_id, NEW.id);

  INSERT INTO Notification (notification_type, date, receiver_id, bid_id)
  SELECT 'auction_bid', NEW.time, f.user_id, NEW.id
  FROM follows AS f
  WHERE f.auction_id = NEW.auction_id;

  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER bid_notification
AFTER INSERT ON Bid
FOR EACH ROW
EXECUTE FUNCTION send_bid_notification();

-- Trigger (T14)
CREATE FUNCTION send_upgrade_notification()
RETURNS TRIGGER AS 
$$
BEGIN
  INSERT INTO Notification (notification_type, date, receiver_id)
  VALUES ('user_upgrade', NOW(), NEW.user_id);

  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER upgrade_notification
AFTER INSERT ON SystemManager
FOR EACH ROW
EXECUTE FUNCTION send_Upgrade_notification();

-- Trigger (T15)
CREATE FUNCTION send_downgrade_notification()
RETURNS TRIGGER AS 
$$
BEGIN
  INSERT INTO Notification (notification_type, date, receiver_id)
  VALUES ('user_downgrade', NOW(), NEW.user_id);

  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER downgrade_notification
AFTER DELETE ON SystemManager
FOR EACH ROW
EXECUTE FUNCTION send_downgrade_notification();

-- Trigger (T16)
CREATE FUNCTION send_auction_notification()
RETURNS TRIGGER AS 
$$
DECLARE
  t notification_type;
BEGIN
  IF OLD.state = 'active' AND NEW.state = 'paused' THEN
    t := 'auction_paused';
  ELSIF OLD.state = 'active' AND NEW.state = 'finished' THEN
    t := 'auction_finished';
  ELSIF OLD.state = 'pending' AND NEW.state = 'approved' THEN
    t := 'auction_approved';
  ELSIF OLD.state = 'pending' AND NEW.state = 'denied' THEN
    t := 'auction_denied';
  ELSIF OLD.state = 'paused' AND NEW.state = 'active' THEN
    t := 'auction_resumed';
  ELSE
    t := NULL;
  END IF;

  IF t IS NOT NULL THEN
    INSERT INTO Notification (notification_type, date, receiver_id, auction_id)
    VALUES (t, NOW(), NEW.owner, NEW.id);
    
    INSERT INTO Notification (notification_type, date, receiver_id, auction_id)
    SELECT t, NOW(), f.user_id, NEW.id
    FROM follows AS f
    WHERE f.auction_id = NEW.id;
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER auction_notification
AFTER UPDATE ON Auction
FOR EACH ROW
EXECUTE FUNCTION send_auction_notification();


-- Trigger (T17)
CREATE FUNCTION transfer_approved()
RETURNS TRIGGER AS
$$
DECLARE
  bal MONEY;
BEGIN
  SELECT balance INTO bal FROM users WHERE id = OLD.user_id;
  IF OLD.state = 'pending' AND NEW.state = 'accepted'  AND  NEW.type = true THEN
    UPDATE users
    SET balance = balance + NEW.amount
    WHERE id = OLD.user_id;
  ELSIF OLD.state = 'pending' AND NEW.state = 'accepted'  AND  NEW.type = false AND bal >= NEW.amount THEN
    UPDATE users
    SET balance = balance - NEW.amount
    WHERE id = OLD.user_id;
  END IF;
  RETURN NEW;
END;
$$
LANGUAGE plpgsql;
CREATE TRIGGER transfer_approved
AFTER UPDATE ON moneys
FOR EACH ROW
EXECUTE FUNCTION transfer_approved();
