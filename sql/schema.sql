-- Drop old tables
DROP TABLE IF EXISTS follows CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS Bid CASCADE;
DROP TABLE IF EXISTS AuctionPhoto CASCADE;
DROP TABLE IF EXISTS Auction CASCADE;
DROP TABLE IF EXISTS Admin CASCADE;
DROP TABLE IF EXISTS SystemManager CASCADE;
DROP TABLE IF EXISTS userss CASCADE;
DROP TABLE IF EXISTS AuctionMetaInfoValue CASCADE;
DROP TABLE IF EXISTS MetaInfoValue CASCADE;
DROP TABLE IF EXISTS MetaInfo CASCADE;
DROP TABLE IF EXISTS Notification CASCADE;



-- Define enums
CREATE TYPE notification_type AS ENUM (
    'auction_paused',
    'auction_finished',
    'auction_approved',
    'auction_denied',
    'auction_comment',
    'auction_bid',
    'users_upgrade',
    'users_downgrade' 
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

-- users table
CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  usersname VARCHAR(255) NOT NULL UNIQUE,
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
  user_id INT REFERENCES users(id) PRIMARY KEY
);

-- Admin table
CREATE TABLE Admin (
  user_id INT REFERENCES users(id) PRIMARY KEY
);

-- Auction table
CREATE TABLE Auction (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  price MONEY CHECK (price >= 0),
  initial_time TIMESTAMP NOT NULL,
  end_time TIMESTAMP NOT NULL,
  category category_type DEFAULT NULL,
  state auction_state NOT NULL,
  owner INT REFERENCES users(id),
  auction_winner INT REFERENCES users(id) DEFAULT NULL
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
  user_id INT REFERENCES users(id),
  auction_id INT REFERENCES Auction(id) NOT NULL,
  amount MONEY NOT NULL CHECK (amount > 0),
  time TIMESTAMP CHECK (time <= NOW()),
  PRIMARY KEY (users_id, auction_id)
);

-- Report table
CREATE TABLE Report (
  user_id INT REFERENCES users(id),
  auction_id INT REFERENCES Auction(id),
  description TEXT NOT NULL,
  PRIMARY KEY (users_id, auction_id)
);

-- follows table
CREATE TABLE follows (
  user_id INT REFERENCES users(id),
  auction_id INT REFERENCES Auction(id),
  PRIMARY KEY (users_id, auction_id)
);

-- Comment table
CREATE TABLE Comment (
  id SERIAL PRIMARY KEY,
  user_id INT REFERENCES users(id),
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
  notification_type notification_type NOT NULL,
  date TIMESTAMP NOT NULL CHECK (date <= NOW()),
  viewed BOOLEAN DEFAULT false,
  receiver_id INT REFERENCES users(id),
  bid_id INT REFERENCES Bid(id),
  auction_id INT REFERENCES Auction(id),
  comment_id INT REFERENCES Comment(id),
);
