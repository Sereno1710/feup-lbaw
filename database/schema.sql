-- Drop old tables
DROP TABLE IF EXISTS follows CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS Bid CASCADE;
DROP TABLE IF EXISTS AuctionPhoto CASCADE;
DROP TABLE IF EXISTS Auction CASCADE;
DROP TABLE IF EXISTS Admin CASCADE;
DROP TABLE IF EXISTS SystemManager CASCADE;
DROP TABLE IF EXISTS User CASCADE;
DROP TABLE IF EXISTS AuctionMetaInfoValue CASCADE;
DROP TABLE IF EXISTS MetaInfoValue CASCADE;
DROP TABLE IF EXISTS MetaInfo CASCADE;
DROP TABLE IF EXISTS Notification CASCADE;
DROP TABLE IF EXISTS auction_notification CASCADE;
DROP TABLE IF EXISTS user_notification CASCADE;


-- Define enums
CREATE TYPE auction_notification AS ENUM (
    'auction_paused',
    'auction_finished',
    'auction_approved',
    'auction_denied'
);

CREATE TYPE user_notification AS ENUM (
    'user_upgrade',
    'user_downgrade'
);

CREATE TYPE category_type AS ENUM (
    'strings',
    'woodwinds',
    'bass',
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

-- 
CREATE TABLE User (
  id SERIAL PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  balance MONEY DEFAULT 0,
  date_of_birth DATE NOT NULL,
  street VARCHAR(255) NOT NULL,
  city VARCHAR(255) NOT NULL,
  zip_code VARCHAR(10) NOT NULL,
  country VARCHAR(255) NOT NULL,
  image BYTEA
);

-- SystemManager table
CREATE TABLE SystemManager (
  user_id INT REFERENCES User(id) PRIMARY KEY
);

-- Admin table
CREATE TABLE Admin (
  user_id INT REFERENCES User(id) PRIMARY KEY
);

-- Auction table
CREATE TABLE Auction (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  price MONEY CHECK (price >= 0),
  initial_time TIMESTAMP CHECK (initial_time <= NOW()),
  end_time TIMESTAMP NOT NULL,
  category category_type DEFAULT NULL,
  state auction_state NOT NULL,
  owner INT REFERENCES User(id),
  auction_winner INT REFERENCES User(id) DEFAULT NULL
);

-- AuctionPhoto table
CREATE TABLE AuctionPhoto (
  id SERIAL PRIMARY KEY,
  auction_id INT REFERENCES Auction(id) NOT NULL,
  image BYTEA NOT NULL
);

-- Bid table
CREATE TABLE Bid (
  id SERIAL PRIMARY KEY,
  user_id INT REFERENCES User(id),
  auction_id INT REFERENCES Auction(id) NOT NULL,
  amount MONEY NOT NULL CHECK (amount > 0),
  time TIMESTAMP CHECK (time <= NOW()),
  PRIMARY KEY (user_id, auction_id)
);

-- Report table
CREATE TABLE Report (
  user_id INT REFERENCES User(id),
  auction_id INT REFERENCES Auction(id),
  description TEXT NOT NULL,
  PRIMARY KEY (user_id, auction_id)
);

-- follows table
CREATE TABLE follows (
  user_id INT REFERENCES User(id),
  auction_id INT REFERENCES Auction(id),
  PRIMARY KEY (user_id, auction_id)
);

-- Comment table
CREATE TABLE Comment (
  id SERIAL PRIMARY KEY,
  user_id INT REFERENCES User(id),
  auction_id INT REFERENCES Auction(id),
  message TEXT NOT NULL,
  time TIMESTAMP CHECK (time <= Now())
);

-- MetaInfo table
CREATE TABLE MetaInfo (
  name VARCHAR(255) PRIMARY KEY
);

-- MetaInfoValue table
CREATE TABLE MetaInfoValue (
  id SERIAL PRIMARY KEY,
  meta_info_name VARCHAR(255) REFERENCES MetaInfo(name),
  value TEXT NOT NULL
);

-- AuctionMetaInfoValue table
CREATE TABLE AuctionMetaInfoValue (
  auction_id INT REFERENCES Auction(id),
  meta_info_value_id INT REFERENCES MetaInfoValue(id),
  PRIMARY KEY (auction_id, meta_info_value_id)
);

-- Notification table
CREATE TABLE Notification (
  id SERIAL PRIMARY KEY,
  date TIMESTAMP NOT NULL CHECK (date <= NOW()),
  viewed BOOLEAN DEFAULT false,
  user_id INT REFERENCES User(id)
);

-- user_notification table
CREATE TABLE user_notification (
  notification_id INT REFERENCES Notification(id) PRIMARY KEY,
  notification_type user_notification_type NOT NULL
);

-- auction_notification table
CREATE TABLE auction_notification (
  notification_id INT REFERENCES Notification(id) PRIMARY KEY,
  auction_id INT REFERENCES Auction(id),
  notification_type auction_notification_type NOT NULL,
);

-- comment_notification table
CREATE TABLE comment_notification (
  notification_id INT REFERENCES Notification(id),
  comment_id INT REFERENCES Comment(id),
);

-- auction_notification table
CREATE TABLE bid_notification (
  notification_id INT REFERENCES Notification(id) PRIMARY KEY,
  bid_id INT REFERENCES Bid(id)
);