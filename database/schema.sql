-- Drop old tables
DROP TABLE IF EXISTS follows CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS Bid CASCADE;
DROP TABLE IF EXISTS AuctionPhoto CASCADE;
DROP TABLE IF EXISTS Auction CASCADE;
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

DROP FUNCTION IF EXISTS anonymize_user_data;
DROP FUNCTION IF EXISTS prevent_auction_cancellation;
DROP FUNCTION IF EXISTS enforce_bidding_rules;
DROP FUNCTION IF EXISTS extend_auction_deadline;
DROP FUNCTION IF EXISTS prevent_seller_self_follow;
DROP FUNCTION IF EXISTS check_bid_date;
DROP FUNCTION IF EXISTS check_user_age;
DROP FUNCTION IF EXISTS set_auction_winner;
DROP FUNCTION IF EXISTS prevent_owner_bid;
DROP FUNCTION IF EXISTS prevent_duplicate_report;
DROP FUNCTION IF EXISTS prevent_duplicate_follow;

/*

TYPES

*/

-- Define enums
CREATE TYPE notification_type AS ENUM (
    'auction_paused',
    'auction_finished',
    'auction_approved',
    'auction_denied',
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

/*

TABLES

*/

-- users table
CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  balance MONEY NOT NULL DEFAULT 0,
  date_of_birth DATE NOT NULL,
  street VARCHAR(255) NOT NULL,
  city VARCHAR(255) NOT NULL,
  zip_code VARCHAR(10) NOT NULL,
  country VARCHAR(255) NOT NULL,
  image BYTEA
);

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

-- Auction table
CREATE TABLE Auction (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  price MONEY CHECK (price >= '0'::MONEY),
  initial_time TIMESTAMP DEFAULT NULL,
  end_time TIMESTAMP DEFAULT NULL,
  category category_type DEFAULT NULL,
  state auction_state NOT NULL,
  owner INT REFERENCES users(id) ON UPDATE CASCADE,
  auction_winner INT REFERENCES users(id) ON UPDATE CASCADE DEFAULT NULL
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

TRIGGERS

*/

-- Trigger (T01)
CREATE FUNCTION anonymize_user_data()
RETURNS TRIGGER AS 
$$
DECLARE anonymous_user_id INT;
BEGIN
  SELECT id INTO anonymous_user_id FROM users WHERE username = 'Anonymous';
  IF anonymous_user_id IS NOT NULL THEN
    UPDATE Comment
    SET user_id = anonymous_user_id
    WHERE user_id = OLD.id;
    UPDATE Report
    SET user_id = anonymous_user_id
    WHERE user_id = OLD.id;
    UPDATE Bid
    SET user_id = anonymous_user_id
    WHERE user_id = OLD.id;
    UPDATE follows
    SET user_id = anonymous_user_id
    WHERE user_id = OLD.id;
    UPDATE Auction
    SET owner = anonymous_user_id
    WHERE owner = OLD.id;
    UPDATE Auction
    SET auction_winner = anonymous_user_id
    WHERE auction_winner = OLD.id;
  END IF;
  DELETE FROM Admin
  WHERE user_id = OLD.id;
  DELETE FROM SystemManager
  WHERE user_id = OLD.id;
  RETURN OLD;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER anonymize_user_data_trigger
BEFORE DELETE ON users
FOR EACH ROW
EXECUTE FUNCTION anonymize_user_data();

/*
-- Trigger (T02)
CREATE FUNCTION prevent_auction_cancellation()
RETURNS TRIGGER AS 
$$
DECLARE
  num_bids INTEGER;
BEGIN
  SELECT COUNT(*) INTO num_bids FROM Bid WHERE auction_id = OLD.id;
  IF num_bids > 0 THEN
    RAISE EXCEPTION 'Cannot cancel the auction. There are % bids.', num_bids;
  END IF;
  UPDATE Auction
  SET auction_state = 'disabled'
  WHERE id = OLD.id;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER prevent_auction_cancellation_trigger
BEFORE UPDATE ON Auction
FOR EACH ROW
EXECUTE FUNCTION prevent_auction_cancellation();
*/

-- Trigger (T04)
CREATE FUNCTION enforce_bidding_rules()
RETURNS TRIGGER AS 
$$
DECLARE
  current_highest_bid MONEY;
  highest_bidder INTEGER;
  i_price MONEY;
BEGIN
  SELECT user_id, amount INTO highest_bidder, current_highest_bid
  FROM Bid
  WHERE auction_id = NEW.auction_id
  ORDER BY amount DESC
  LIMIT 1;
  SELECT price INTO i_price
  FROM Auction
  WHERE id = NEW.auction_id;

  IF NEW.amount <= current_highest_bid OR NEW.amount < i_price THEN
    RAISE EXCEPTION 'Your bid must be higher than the current highest bid.';
  ELSIF highest_bidder = NEW.user_id THEN
    RAISE EXCEPTION 'You cannot bid if you currently own the highest bid.';
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER enforce_bidding_rules_trigger
BEFORE INSERT ON Bid
FOR EACH ROW
EXECUTE FUNCTION enforce_bidding_rules();

-- Trigger (T05)
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

-- Trigger (T06)
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

-- Trigger (T07)
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

-- Trigger (T08)
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

-- Trigger (T09)
CREATE FUNCTION set_auction_winner()
RETURNS TRIGGER AS 
$$
BEGIN
  IF NEW.state = 'finished' THEN
    SELECT user_id INTO NEW.auction_winner
    FROM Bid
    WHERE auction_id = NEW.id
    ORDER BY amount DESC
    LIMIT 1;
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER update_auction_winner
BEFORE UPDATE ON Auction
FOR EACH ROW
EXECUTE FUNCTION set_auction_winner();

-- Trigger (T10)
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

-- Trigger (T11)
CREATE FUNCTION prevent_duplicate_report()
RETURNS TRIGGER AS 
$$
BEGIN
  IF EXISTS (
    SELECT 1
    FROM Report
    WHERE user_id = NEW.user_id
    AND (auction_id = NEW.auction_id)
  ) THEN
    RAISE EXCEPTION 'A user can only report an auction once.';
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER check_duplicate_report
BEFORE INSERT ON Report
FOR EACH ROW
EXECUTE FUNCTION prevent_duplicate_report();

-- Trigger (T12)
CREATE FUNCTION prevent_duplicate_follow()
RETURNS TRIGGER AS 
$$
BEGIN
  IF EXISTS (
    SELECT 1
    FROM follows
    WHERE user_id = NEW.user_id
    AND auction_id = NEW.auction_id
  ) THEN
    RAISE EXCEPTION 'The user is already following this auction.';
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER check_duplicate_follow
BEFORE INSERT ON follows
FOR EACH ROW
EXECUTE FUNCTION prevent_duplicate_follow();