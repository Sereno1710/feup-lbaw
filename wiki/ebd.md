# EBD: Database Specification Component

**Project vision:** SoundSello is being developed to facilitate music lovers and musical instrument collectors find what they want or need by bidding or auctioning instruments of all kinds.

## A4: Conceptual Data Model

Entities and it's relationships that exist in SoundSello are described in this section. This will be the foundation for the application's database.

### 1. Class diagram

The UML diagram presents the main organizational entities, their relationships, attributes domains, and the multiplicity of relationships for SoundSello.

![Class Diagram](/wiki/resources/UML.png)

Figure 7: UML Class diagram

### 2. Additional Business Rules
 
Some more business rules:

| Identifier | Description                                                                                 |
|------------|---------------------------------------------------------------------------------------------|
| BR09       | The auction winner is the user with the highest bid on the auction when it ends.            |
| BR10       | A user cannot bid in its own auction.                                                       |
| BR11       | A user can only report an auction once.                                                     |
| BR12       | A user cannot bid in an auction where he is the highest bid.                                |
| BR13       | A user cannot follow an auction that he is already following.                               |
| BR14       | A user will automatically follow an auction after bidding on an auction for the first time. |
| BR15       | A user can only bid if he has enough money in his accounts                                  |

## A5: Relational Schema, validation and schema refinement

This artifact contains the Relational Schema obtained by the UML Class Diagram. The Relational Schema includes each relation and it's attributes, domains, primary keys, foreign keys and other integrity rules.
It also represents the database structure, including all entities and relations.

### 1. Relational Schema

This section contains the relational schema that resulted from the UML Class Diagram. It shows all the atributes,domains,keys and integrity rules in case of need.

| Relation reference | Relation Compact Notation                                                                                                                                                                                                                                                                 |
|--------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| R01                | users (id **PK**,name **NN** ,username **NN UK**, email **NN UK**, password **NN**, balance **NN DF 0**, date_of_birth **NN**,street **NN**, city **NN**, zip_code **NN**, country, rating **CK** rating >= 0 && rating <= 5  **DF N**,**NN** image, state **DF** 'active', remember_token **DF** NULL)                                                 |
| R02                | SystemManager (id -> users(id) **PK**)                                                                                                                                                                                                                    |
| R03                | Admin (id -> users(id) **PK**)              |                                               
| R04                | moneys (id **PK**,**FK** user_id(id) **PK**, amount **CK** (amount > 0), type **NN**, state **CK** transfer_state)                          |
| R05                | Auction (id **PK**, name **NN**, description **NN**, initial_price **CK** initial_price > 0, price **CK** price >= initial_price, initial_time  **DF N**, end_time **DF N**, category **DF NN**, state **CK** auction_state, **FK** owner -> users(id), **FK** auction_winner -> users(id) **DF N**) |
| R06               | AuctionWinner (**FK** user_id -> users(id) **PK**, **FK** auction_id ->  Auction(id) **PK**, rating **CK** (rating >= 0 && rating <= 5 ) **DF N**)                                                                                                                                        |
| R07               | AuctionPhoto (id **PK**, **FK** auction_id -> Auction(id), image **NN**)                                                                                                                                                                                                                  |
| R08                | Bid (id **PK**, **FK** user_id -> users(id), **FK** auction_id ->  Auction(id), amount **NN** **CK** amount > 0, time **CK** time <= today)                                                                                                                                               |
| R09                | Report (**FK** user_id -> users(id) **PK**,**FK** auction_id ->  Auction(id) **PK**, description **NN**, state **CK** report_state )                                                                                                                                                                                 |
| R10                | follows (**FK** user_id -> users(id) **PK**, **FK** auction_id -> Auction(id) **PK**)                                                                                                                                                                                                     |
| R11                | Comment(id **PK**, **FK** user_id -> users(id) **PK**, **FK** auction_id -> Auction(id) **PK**, message **NN**, time **CK** time <= today)                                                                                                                                                |
| R12                | MetaInfo(name **PK**)                                                                                                                                                                                                                                                                     |
| R13                | MetaInfoValue(id **PK**, **FK** meta_info_name -> MetaInfo(name), value **NN**)                                                                                                                                                                                                           |
| R14                | AuctionMetaInfoValue(**FK** auction_id -> Auction(id) **PK**, **FK** meta_info_value_id -> MetaInfoValue(id) **PK**)                                                                                                                                                                      |
| R15                | Notification (id **PK**, notification_type **NN**, date **NN CK** date <= today, viewed **NN DF false**, **FK** receiver_id ->  users(id), **FK** bid_id -> Bid(id), **FK** auction_id -> Auction(id), **FK** comment_id -> Comment(id))                                                  | 

Annotation:

- **CK** - CHECK
- **NN** - NOT NULL    
- **N**  - NULL
- **FK** - FOREIGN KEY
- **PK** - PRIMARY KEY
- **UK** - UNIQUE KEY
- **DF** - DEFAULT

### 2. Domains

Specification of aditional domains:

| Domain Name | Domain Specification |
| --- | --- |
| today	| DATE DEFAULT CURRENT_DATE |
| notification | ENUM ('auction_comment', 'auction_bid', 'user_upgrade', 'user_downgrade', 'auction_paused', 'auction_finished', 'auction_approved', 'auction_denied', 'auction_resumed') |
| auction_state | ENUM ('pending', 'active', 'finished', 'paused', 'approved', 'denied','disabled') |
| category_type | ENUM ('strings', 'woodwinds', 'bass', 'percussion') |
| transfer_state | ENUM ('pending', 'approved', 'denied') |
| report_state | ENUM ('listed', 'reviewed', 'unrelated')|
| user_state | ENUM ('active', 'disabled', 'banned') |


### 3. Schema validation

Function dependencies identified as well as if it is in BCNF.

| **TABLE R01**               | users                                                                                                          |
|-----------------------------|----------------------------------------------------------------------------------------------------------------|
| **Keys**                    | { id }, { email }, { username }, { id, email }, { id, username}, { email, username}, { id, email, username }   |
| **Functional Dependencies** |                                                                                                                |
| FD0101                      | id → { username,name, email, password, balance, date_of_birth, street, city, zip_code, country, image,state,remember_token, rating }     |
| FD0102                      | email → { id, username,name, password, balance, date_of_birth, street, city, zip_code, country, image, rating }     |
| FD0103                      | username → { id,name, email, password, balance, date_of_birth, street, city, zip_code, country, image, state,remember_token, rating }     |
| FD0104                      | { email, username } → { id, name,password, balance, date_of_birth, street, city, zip_code, country, image,state,remember_token, rating } |
| FD0105                      | { id, email } → { username, name,password, balance, date_of_birth, street, city, zip_code, country, image,state,remember_token, rating } |
| FD0106                      | {id, username} → { name,email, password, balance, date_of_birth, street, city, zip_code, country, image, state,remember_token, rating }   |
| FD107                       | { id, email, username } → {name, password, balance, date_of_birth, street, city, zip_code, country, image,state,remember_token, rating}  |
| **NORMAL FORM** | BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF. |

| **TABLE RO2**               | SystemManager                                                 |
|-----------------------------|---------------------------------------------------------------|
| **Keys**                    | { id }                                                        |
| **Functional Dependencies** |
| FD0201                      | none                                                          |
| **NORMAL FORM**             | BCNF because there is no attribute that is not a primary key. |

| **TABLE RO3**               | Admin                                                          |
|-----------------------------|----------------------------------------------------------------|
| **Keys**                    | { id }                                                         |
| **Functional Dependencies** |
| FD0301                      | none                                                           |
| **NORMAL FORM**             | BCNF because there is no attribute that is not a primary key.. |


| **TABLE R04** | moneys | 
|-----------------------------|------------|
| **Keys** | {id} |
| **Functional Dependencies**| |
| FD401 |  id -> {user_id, amount, type, state}|
|**Normal Form**| BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF.  |

| **TABLE R05**               | Auction                                                                    |
|-----------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Keys**                    | { id }  |                      |
| **Functional Dependencies** |                                                             |
| FD0501                      | id → { name, description, initial_price, price, initial_time, end_time, category, state, owner }                                                                                                                                                                                                        |
| **NORMAL FORM**             | BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF. |

| **TABLE R06**               | AuctionWinner                                                      |
|-----------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Keys**                    | {user_id , auction_id}        |
| **Functional Dependencies** |                                                    |
| FD0601                      | {user_id , auction_id} -> {rating}                                                    |
| **NORMAL FORM**             | BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF. |


| **TABLE R07**               | AuctionPhoto        |
|-----------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Keys**                    | { id }                                                                                                                                                                                                                                                                                                  |
| **Functional Dependencies** |                                                                                                                                                                                                                                                                                                         |
| FD0701                      | id → { auction_id, image }                                                                                                                                                                                                                                                                              |
| **NORMAL FORM**             | BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF. |

| **TABLE R08**               | Bid                                                                                                                                                                                                                                                                                                     |
|-----------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Keys**                    | { id }                                                                                                                                                                                                                                                                                                  |
| **Functional Dependencies** |                                                                                                                                                                                                                                                                                                         |
| FD0801                      | id → { user_id, auction_id, amount, time }                                                                                                                                                                                                                                                              |
| **NORMAL FORM**             | BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF. |

| **TABLE R09**               | Report                                                                                                                                                                                                                                                                                                  |
|-----------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Keys**                    | { user_id, auction_id }                                                                                                                                                                                                                                                                                 |
| **Functional Dependencies** |                                                                                                                                                                                                                                                                                                         |
| FD0901                      | { user_id, auction_id } → { description }                                                                                                                                                                                                                                                               |
| **NORMAL FORM**             | BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF. |

| **TABLE R10** | follows |
| --- | --- |
| **Keys** | { user_id, auction_id } |
| **Functional Dependencies** | |
| FD1001 | { user_id, auction_id } → {} |
| **NORMAL FORM** | BCNF because there is no attribute that is not a primary key. |

| **TABLE R11** | Comment |
| --- | --- |
| **Keys** | { id, user_id, auction_id } |
| **Functional Dependencies** | |
| FD1101 | { id, user_id, auction_id } → { message, time } |
| **NORMAL FORM** | BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF. |

| **TABLE R12** | MetaInfo |
| --- | --- |
| **Keys** | { name } |
| **Functional Dependencies** | |
| FD1201 | { name } → {} |
| **NORMAL FORM** | BCNF because there is no attribute that is not a primary key. |

| **TABLE R13** | MetaInfoValue |
| --- | --- |
| **Keys** | { id } |
| **Functional Dependencies** | |
| FD1301 | id → { meta_info_name, value } |
| **NORMAL FORM** | BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF. |

| **TABLE R14** | AuctionMetaInfoValue |
| --- | --- |
| **Keys** | { auction_id, meta_info_value_id } |
| **Functional Dependencies** | |
| FD1401 | { auction_id, meta_info_value_id } → {} |
| **NORMAL FORM** | BCNF because there is no attribute that is not a primary key. |

| **TABLE R15** | Notification |
| --- | --- |
| **Keys** | { id } |
| **Functional Dependencies** | |
| FD1501 | id → { date, viewed, receiver_id, bid_id, auction_id, comment_id } |
| **NORMAL FORM** | BCNF because in each of these functional dependencies, the left-hand side is a superkey, since it uniquely determines the attributes on the right-hand side. Each functional dependency satisfies the requirement for BCNF, and the table has no partial dependencies, therefore, it is indeed in BCNF. |


## A6: Indexes, triggers, transactions and database population

This artifact delves into key strategies for optimizing databases. These encompass crafting indexes to expedite data retrieval, employing triggers to automate responses to events, upholding data integrity and consistency through transactions, and initializing the database with essential data to prepare the system for testing and setup.

### 1. Database Workload
 
To develop a well-designed database, it is crucial to have a clear understanding of how tables will grow and how often they will be accessed. The following table presents these growth predictions:

| **Relation reference** | **Relation Name**    | **Order of magnitude** | **Estimated growth** |
|------------------------|----------------------|------------------------|----------------------|
| R01                    | Users                | 10k                    | 10                   | 
| R02                    | SystemManager        | 10                     | 1                    |
| R03                    | Admin                | 1                      | 0                    |
| R04                    | Transfer             | 1k                     | 1                    |
| R05                    | Auction              | 1k                     | 1                    |
| R06                    | AuctionWinner        | 1k                     | 1                    |
| R07                    | AuctionPhoto         | 1k                     | 1                    |
| R08                    | Bid                  | 10k                    | 10                   |
| R09                    | Report               | 100                    | 1                    |
| R10                    | Follows              | 1k                     | 1                    |
| R11                    | Comment              | 10k                    | 10                   |
| R12                    | MetaInfo             | 1                      | 0                    |
| R13                    | MetaInfoValue        | 100                    | 0                    | 
| R14                    | AuctionMetaInfoValue | 10k                    | 10                   |
| R15                    | Notification         | 100k                   | 1k                   |




### 2. Proposed Indices

#### 2.1. Performance Indices
 
To improve querries it is essential to have performance indices. One for username search,
another for receiving notifications and lastly for auction state. The most important performance index is IDX01 since it involves user research.

| **Index**         | IDX01                                                                                                                                                                                                                                                                                      |
|-------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Relation**      | users                                                                                                                                                                                                                                                                                      |
| **Attribute**     | username                                                                                                                                                                                                                                                                                   |
| **Type**          | Hash                                                                                                                                                                                                                                                                                       |
| **Cardinality**   | High                                                                                                                                                                                                                                                                                       |
| **Clustering**    | No                                                                                                                                                                                                                                                                                         |
| **Justification** | The attribute username is subject to many searches in queries, like when showing auctions or comments, so creating an index for this attribute helps performance. Since in these queries, we will search for the exact username, we chose to use hashing, and clustering is not necessary. |
```sql
CREATE INDEX username_search ON users USING HASH (username);
```

| **Index**         | IDX02                                                                                                                                                                                                                                                               |
|-------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Relation**      | Notification                                                                                                                                                                                                                                                        |
| **Attribute**     | receiver_id                                                                                                                                                                                                                                                         |
| **Type**          | Hash                                                                                                                                                                                                                                                                |
| **Cardinality**   | Medium                                                                                                                                                                                                                                                              |
| **Clustering**    | No                                                                                                                                                                                                                                                                  |
| **Justification** | The system will send a lot of notifications, and it always needs to see who to send it to, so receiver_id will be a part of many queries. These queries will look for the exact id, so we chose hashing as the type for the index, and clustering is not necessary. |
```sql
CREATE INDEX notification_receiver ON Notification USING HASH (receiver_id);
```

| **Index**         | IDX03                                                                                                                                                                                                                                                                                                               |
|-------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Relation**      | Auction                                                                                                                                                                                                                                                                                                             |
| **Attribute**     | state                                                                                                                                                                                                                                                                                                               |
| **Type**          | Hash                                                                                                                                                                                                                                                                                                                |
| **Cardinality**   | Low                                                                                                                                                                                                                                                                                                                 |
| **Clustering**    | No                                                                                                                                                                                                                                                                                                                  |
| **Justification** | The attribute state will be involved in many queries, since every time we want to show auctions to an authenticated user, we will look only for the ones that are active. Hashing is the most effective method since we are don't need to sort the values, and it's also more effective if we don't use clustering. |
```sql
CREATE INDEX auction_state ON Auction USING HASH (state);
```


#### 2.2. Full-text Search Indices 

Full-text search must be provided for our system. User, Auction and category based auction searches are available in our database.


| **Index**         | IDX04                                                                                                                                                                                   |
|-------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Relation**      | user                                                                                                                                                                                    |
| **Attribute**     | name, username                                                                                                                                                                          |
| **Type**          | GIN                                                                                                                                                                                     |
| **Clustering**    | No                                                                                                                                                                                      |
| **Justification** | To provide full-text search features to look for users based on matching names and usernames. The GIN index type is chosen because the indexed fields are not expected to change often. |
```sql
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
```

| **Index**         | IDX05                                                                                                                                                                                                     |
|-------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Relation**      | auction                                                                                                                                                                                                   |
| **Attribute**     | name, category, description                                                                                                                                                                               |
| **Type**          | GIN                                                                                                                                                                                                       |
| **Clustering**    | No                                                                                                                                                                                                        |
| **Justification** | To provide full-text search features to look for auctions based on matching names, categories and descriptions. The GIN index type is chosen because the indexed fields are not expected to change often. |
```sql
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
``` 

### 3. Triggers

Triggers are used to enforce complex integrity rules that can't be achieved through simpler methods. They are defined by specifying when they should activate, what conditions they should check, and the code they should execute. Triggers also help maintain the accuracy of full-text indexes.

| **Trigger**     | TRIGGER01                                                                                                                                            |
|-----------------|------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Description** | Upon account deletion, shared user data (e.g. comments, reviews, likes) is kept but is made anonymous, in order to maintain system integrity. (BR01) |

```sql
CREATE OR REPLACE FUNCTION anonymize_user_data()
RETURNS TRIGGER AS 
$$
BEGIN
  IF NEW.state = 'disabled' THEN
    NEW.username := 'anonymous' || OLD.id;
    NEW.name := 'Anonymous';
    NEW.email := 'anonymous' || OLD.id || '@soundsello.com';
    NEW.password := 'anonymous';
    NEW.date_of_birth := '1900-01-01';
    NEW.balance := 0.00;
    NEW.street := NULL;
    NEW.city := NULL;
    NEW.zip_code := NULL;
    NEW.country := NULL;
    NEW.rating := NULL;
    NEW.remember_token := NULL;
    NEW.biography := NULL;
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER anonymize_user_data_trigger
BEFORE UPDATE ON users
FOR EACH ROW
EXECUTE FUNCTION anonymize_user_data();
```


| **Trigger**     | TRIGGER02                                                                  |
|-----------------|----------------------------------------------------------------------------|
| **Description** | An auction can only be disabled if there are no bids. (business rule BR02) |

```sql
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
```

| **Trigger** | TRIGGER03 |
| --- | --- |
| **Description** | A user can only bid if their bid is higher than the current highest bid. A user cannot bid if their bid is the current highest. (business rules BR03, BR06, BR11, BR12, BR15) |

```sql
CREATE FUNCTION enforce_bidding_rules()
RETURNS TRIGGER AS 
$$
DECLARE
  current_highest_bid MONEY;
  highest_bidder INTEGER;
  i_price MONEY;
  user_balance MONEY;
  current_state auction_state;
  user_state user_state;
BEGIN
  SELECT user_id, amount INTO highest_bidder, current_highest_bid
  FROM Bid
  WHERE auction_id = NEW.auction_id
  ORDER BY amount DESC
  LIMIT 1;
  SELECT initial_price, state INTO i_price, current_state
  FROM Auction
  WHERE id = NEW.auction_id;
  SELECT balance,state INTO user_balance,user_state
  FROM users
  WHERE id = NEW.user_id;


  IF current_State <> 'active' AND user_state <> 'banned' AND user_state <> 'disabled'THEN
    RAISE EXCEPTION 'You may only bid in active auctions.';
  ELSIF NEW.amount <= current_highest_bid OR NEW.amount < i_price THEN
    RAISE EXCEPTION 'Your bid must be higher than the current highest bid.';
  ELSIF highest_bidder = NEW.user_id THEN
    RAISE EXCEPTION 'You cannot bid if you currently own the highest bid.';
  ELSIF user_balance < NEW.amount THEN
    RAISE EXCEPTION 'You do not have enough balance in your account.';
  END IF;
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER enforce_bidding_rules_trigger
BEFORE INSERT ON Bid
FOR EACH ROW
EXECUTE FUNCTION enforce_bidding_rules();
```

| **Trigger** | TRIGGER04 |
| --- | --- |
| **Description** | When a bid is made in the last 15 minutes of the auction, the auction deadline is extended by 30 minutes. (business rule BR04) |

```sql
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
```


| **Trigger** | TRIGGER05 |
| --- | --- |
| **Description** | A seller cannot follow their own auction. (business rule BR06) |

```sql
CREATE FUNCTION prevent_seller_self_follow()
RETURNS TRIGGER AS 
$$
BEGIN
  IF NEW.user_id = (SELECT owner_id FROM Auction WHERE id = NEW.auction_id) THEN
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
```

| **Trigger** | TRIGGER06 |
| --- | --- |
| **Description** | The date of an incoming bid has to be higher than the date of the current highest bid. The date when an auction closed has to be higher than the date of the last bid. (business rule BR07) |

```sql
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
```

| **Trigger** | TRIGGER07 |
| --- | --- |
| **Description** | A user needs to be at least 18 years old to use this website. (business rule BR08) |

```sql
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
```


| **Trigger** | TRIGGER08 |
| --- | --- |
| **Description** | A user cannot bid in its own auction. (business rule BR12) |

```sql
CREATE FUNCTION prevent_owner_bid()
RETURNS TRIGGER AS 
$$
BEGIN
  IF NEW.user_id = (SELECT owner_id FROM Auction WHERE id = NEW.auction_id) THEN
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
```

| **Trigger** | TRIGGER09 |
| --- | --- |
| **Description** | When a user first bids on an auction, he will automatically follow it. (business rule BR14)|

```sql
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
```

| **Trigger** | TRIGGER10 |
| --- | --- |
| **Description** | When a new review is made, the auction owner's rating should change accordingly (it's the average of all ratings they have ever received) |

```sql
CREATE FUNCTION update_owner_rating()
RETURNS TRIGGER AS 
$$
DECLARE 
  this_owner_id INT;
BEGIN
  SELECT owner_id into this_owner_id FROM auction WHERE id = NEW.auction_id;

  UPDATE users
  SET rating = (
    SELECT COALESCE(ROUND(AVG(AuctionWinner.rating), 2), 0)
    FROM AuctionWinner
    JOIN Auction ON AuctionWinner.auction_id = Auction.id
    WHERE Auction.owner_id = this_owner_id
  )
  WHERE id = this_owner_id;
  
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER calculate_owner_rating
AFTER INSERT OR UPDATE ON AuctionWinner
FOR EACH ROW
EXECUTE FUNCTION update_owner_rating();
```

| **Trigger** | TRIGGER11 |
| --- | --- |
| **Description** | A user can only win an auction if and only if the auction has finished already.|

```sql
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
 ```

| **Trigger** | TRIGGER12 |
| --- | --- |
| **Description** | The auction owner and everyone following the auction should receive a notification when someone makes a new comment. |

```sql
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
 ```

| **Trigger** | TRIGGER13 |
| --- | --- |
| **Description** | The auction owner and everyone following the auction should receive a notification when a new bid is made. |

```sql
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
 ```

| **Trigger** | TRIGGER14 |
| --- | --- |
| **Description** | When a user is promoted to system manager, they should be notified. |

```sql
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
 ```

| **Trigger** | TRIGGER15 |
| --- | --- |
| **Description** | When a user is underpromoted from system manager to a regular user, they should be notified. |

```sql
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
 ```

| **Trigger** | TRIGGER16 |
| --- | --- |
| **Description** | The auction owner and everyone following the auction should receive a notification when it's state is updated. |

```sql
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
    VALUES (t, NOW(), NEW.owner_id, NEW.id);
    
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
 ```

| **TRIGGER** | TRIGGER17 |
|-------------|-----------|
| **Description** |  After admin updates transfer request (changing its state to accepted), it adds or removes transfer amount if possible.|

```sql
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
```

### 4. Transactions
 
The following transactions ensure data integrity when multiple operations are conducted and deemed essential.

| Transaction  | TRAN01                    |
| --------------- | ----------------------------------- |
| Description   | Bid on an auction |
| Justification   | When a user bids on an auction, several things must happen: the last bidder must get the value of their bid back in their balance, the current highest bid amount must be subtracted from the current bidder's balance, and the current highest bid of the auction must be updated to its new value. Should any of these steps fail, the bid should not go through, and none of these things should happen, in order to keep the information consistent. For this transaction, we need to ensure protection against potential data anomalies, so the isolation level should be serializable. |
| Isolation level | SERIALIZABLE. |
|                                                       |


```sql
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;

UPDATE users
SET balance = balance + LastBid.amount
FROM (
    SELECT user_id, amount
    FROM bid
    WHERE auction_id = :auction_id
    ORDER BY amount DESC
    LIMIT 1
) AS LastBid
WHERE users.id = LastBid.user_id;

INSERT INTO Bid(user_id, auction_id, amount, time)
  VALUES ($user_id, $auction_id, $amount, $time);

UPDATE users SET balance = balance - $amount WHERE id = $user_id;

UPDATE Auction SET price = $amount WHERE id = $user_id;

END TRANSACTION;
```

| Transaction | TRAN02 |
| --- | --- |
| Description   | End of auction |
| Justification   | When an auction closes, its state will be updated to "finished", the owner of the auction will get the value of the winning bid added to their balance and the auction will have a winner. If either of these steps fail, the other should not go through, so it makes sense to use a transaction for this event. The isolation level is serializable, since values will be updated and we must ensure consistency in every user's balance. |
| Isolation level | SERIALIZABLE. |


```sql
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;

UPDATE Auction SET state = 'finished' WHERE id = $id;


INSERT INTO AuctionWinner (user_id, auction_id, rating)
  VALUES(
    (SELECT user_id FROM Bid WHERE auction_id = $id ORDER BY amount DESC LIMIT 1),
    $id,
    NULL
  );

UPDATE users SET balance= balance + (SELECT price
FROM Auction WHERE id= $id)
WHERE id = (SELECT owner FROM Auction  WHERE id = $id);

END TRANSACTION;
```

## Annex A. SQL Code

> The database scripts are included in this annex to the EBD component.
> 
> The database creation script and the population script should be presented as separate elements.
> The creation script includes the code necessary to build (and rebuild) the database.
> The population script includes an amount of tuples suitable for testing and with plausible values for the fields of the database.
>
> The complete code of each script must be included in the group's git repository and links added here.

### A.1. Database schema

```sql
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
DROP TABLE IF EXISTS admin CASCADE;
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
DROP TYPE IF EXISTS user_state;

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

CREATE TYPE user_state AS ENUM (
    'active',
    'disabled',
    'banned'
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
  biography VARCHAR(255) DEFAULT NULL,
  street VARCHAR(255) DEFAULT NULL,
  city VARCHAR(255) DEFAULT NULL,
  zip_code VARCHAR(10) DEFAULT NULL,
  country VARCHAR(255) DEFAULT NULL,
  rating FLOAT CHECK (rating >= 0 AND rating <= 5) DEFAULT NULL,
  state user_state DEFAULT 'active',
  remember_token VARCHAR(256) DEFAULT NULL
);
-- SystemManager table
CREATE TABLE SystemManager (
  user_id INT REFERENCES users(id) ON UPDATE CASCADE,
  PRIMARY KEY (user_id)
);

-- Admin table
CREATE TABLE admin (
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
  owner_id INT REFERENCES users(id) ON UPDATE CASCADE
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
  IF NEW.state = 'disabled' THEN
    NEW.username := 'anonymous' || OLD.id;
    NEW.name := 'Anonymous';
    NEW.email := 'anonymous' || OLD.id || '@soundsello.com';
    NEW.password := 'anonymous';
    NEW.date_of_birth := '1900-01-01';
    NEW.balance := 0.00;
    NEW.street := NULL;
    NEW.city := NULL;
    NEW.zip_code := NULL;
    NEW.country := NULL;
    NEW.rating := NULL;
    NEW.remember_token := NULL;
    NEW.biography := NULL;
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
  user_state user_state;
BEGIN
  SELECT user_id, amount INTO highest_bidder, current_highest_bid
  FROM Bid
  WHERE auction_id = NEW.auction_id
  ORDER BY amount DESC
  LIMIT 1;
  SELECT initial_price, state INTO i_price, current_state
  FROM Auction
  WHERE id = NEW.auction_id;
  SELECT balance,state INTO user_balance,user_state
  FROM users
  WHERE id = NEW.user_id;


  IF current_State <> 'active' AND user_state <> 'banned' AND user_state <> 'disabled'THEN
    RAISE EXCEPTION 'You may only bid in active auctions.';
  ELSIF NEW.amount <= current_highest_bid OR NEW.amount < i_price THEN
    RAISE EXCEPTION 'Your bid must be higher than the current highest bid.';
  ELSIF highest_bidder = NEW.user_id THEN
    RAISE EXCEPTION 'You cannot bid if you currently own the highest bid.';
  ELSIF user_balance < NEW.amount THEN
    RAISE EXCEPTION 'You do not have enough balance in your account.';
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
  IF NEW.user_id = (SELECT owner_id FROM Auction WHERE id = NEW.auction_id) THEN
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
  IF NEW.user_id = (SELECT owner_id FROM Auction WHERE id = NEW.auction_id) THEN
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
  this_owner_id INT;
BEGIN
  SELECT owner_id into this_owner_id FROM auction WHERE id = NEW.auction_id;

  UPDATE users
  SET rating = (
    SELECT COALESCE(ROUND(AVG(AuctionWinner.rating), 2), 0)
    FROM AuctionWinner
    JOIN Auction ON AuctionWinner.auction_id = Auction.id
    WHERE Auction.owner_id = this_owner_id
  )
  WHERE id = this_owner_id;
  
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
    VALUES (t, NOW(), NEW.owner_id, NEW.id);
    
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






```

### A.2. Database population

```sql
INSERT INTO users (username, name , email, password, balance, date_of_birth, biography, street, city, zip_code, country, rating)
VALUES
 ('gago','Daniel Gago' ,'daniel@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 3500.00, '2003-11-15', '', 'Rua do Twistzz', 'Faro', '12345', 'Portugal', NULL),
 ('sereno','José Santos', 'jose@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 2000.00, '2003-03-23', '', 'Avenida dos Desdentados', 'Guimaraes', '123123', 'Portugal', NULL),
 ('edu','Eduardo Oliveira' ,'eduardo@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 1000.00, '2003-07-21', 'I love watching football, tv shows, and birds :)', 'Praça dos Maluquinhos', 'Santo Tirso', '4780-666', 'Portugal', NULL),
 ('max',' Máximo Pereira','maximo@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 1000.00, '2003-01-13', '', 'Rua do Inspetor', 'Gondomar', '4420-123', 'Portugal', NULL),
 ('zemanel','José Manuel' ,'zemanel@hotmail.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 5.00, '1992-02-10', '', 'Rua Santa Catarina', 'Porto', '34567', 'Portugal', NULL),
 ('darkknight','Bruce Wayne' ,'brucewayne@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 1000000.00, '1980-05-10', '', 'Gotham Street', 'Gotham City', '12345', 'USA', NULL),
 ('webslinger','Peter Parker' ,'peterparker@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 50000.00, '1995-02-14', '', 'Web Avenue', 'New York', '54321', 'USA', NULL),
 ('greenqueen','Pamela Isley', 'pamelaisley@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 75000.00, '1987-09-20', '', 'Vine Lane', 'Gotham City', '67890', 'USA', NULL),
 ('speedster','Barry Allen' ,'barryallen@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1986-03-30', '', 'Speedster Street', 'Central City', '98765', 'USA', NULL),
 ('emeraldarcher','Oliver Queen', 'oliverqueen@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 80000.00, '1981-11-11', '', 'Arrow Road', 'Star City', '23456', 'USA', NULL),
 ('manofsteel','Clark Kent' ,'clarkkent@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 95000.00, '1978-07-01', '', 'Super Lane', 'Metropolis', '76543', 'USA', NULL),
 ('wonderwoman','Diana Prince' ,'dianaprince@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 85000.00, '1985-04-15', '', 'Paradise Island', 'Themyscira', '78901', 'Amazon', NULL),
 ('thor','Thor Odinson' ,'thor@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 70000.00, '1980-12-25', '', 'Asgard Road', 'Asgard', '11223', 'Asgard', NULL),
 ('spymaster', 'Natasha Romanoff','natasharomanoff@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 60000.00, '1984-08-03', '', 'Red Room Street', 'Moscow', '00123', 'Russia', NULL),
 ('starkgenius', 'Tony Stark','tonystark@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 1200000.00, '1970-06-21', '', 'Stark Tower', 'New York', '54321', 'USA', NULL),
 ('godofthunder', 'Loki Odinson','loki@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1972-03-05', '', 'Asgard Palace', 'Asgard', '11223', 'Asgard', NULL),
 ('hawkeye', 'Clint Barton','clintbarton@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 75000.00, '1976-09-08', '', 'Archery Way', 'Brooklyn', '45678', 'USA', NULL),
 ('scarletwitch', 'Wanda Maximoff' ,'wandamaximoff@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 70000.00, '1989-12-16', '', 'Hex Street', 'Transia', '98765', 'Transia', NULL),
 ('aquaman', 'Arthur Curry' ,'arthurcurry@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 85000.00, '1982-07-30', '', 'Atlantis Avenue', 'Atlantis', '54321', 'Atlantis', NULL),
 ('beastmode','Hank Mccoy' ,'hankmccoy@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 60000.00, '1988-02-04', '', 'X-Mansion Road', 'Westchester', '33333', 'USA', NULL),
 ('stormrider','Ororo Munroe' ,'ororomunroe@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 95000.00, '1987-06-10', '', 'Wakanda Avenue', 'Wakanda', '11223', 'Wakanda', NULL),
 ('greenlantern','Hal Jordan' ,'haljordan@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 80000.00, '1983-04-20', '', 'Oa Street', 'Oa', '22222', 'Oa', NULL),
 ('wolverine','James Howlett','logan@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 70000.00, '1842-03-22', '', 'Logan Street', 'Alberta', '77777', 'Canada', NULL),
 ('wallywest','Wally West' ,'wallywest@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1992-08-15', '', 'Speedster Lane', 'Keystone City', '11111', 'USA', NULL),
 ('wadeywilson','Wade Wilson' ,'wadewilson@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 80000.00, '1974-02-20', '', 'Regeneration Road', 'New York', '54321', 'USA', NULL),
 ('blackpanther','Tchalla' ,'tchalla@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 85000.00, '1980-11-29', '', 'Wakanda Street', 'Wakanda', '11223', 'Wakanda', NULL),
 ('magentawitch','Wanda Sheperd' ,'wandashepherd@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 75000.00, '1993-05-07', '', 'Salem Road', 'Westview', '54321', 'USA', NULL),
 ('ladyhawk','Katelyn' ,'katebishop@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 70000.00, '1999-12-03', '', 'Archer Avenue', 'New York', '45678', 'USA', NULL),
 ('captainspandex','Steve' ,'steve@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 95000.00, '1920-07-04', '', 'Freedom Street', 'Washington, D.C.', '12345', 'USA', NULL),
 ('aquaticmariner','Namor' ,'namor@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1940-01-10', '', 'Atlantean Lane', 'Atlantis', '22222', 'Atlantis', NULL),
 ('starlord','Peter Quill' ,'peterquill@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 80000.00, '1982-12-18', '', 'Milano Avenue', 'Xandar', '98765', 'Xandar', NULL),
 ('blackbolt','Black Agar' ,'blackagar@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 75000.00, '1975-06-02', '', 'Inhuman Road', 'Attilan', '54321', 'Attilan', NULL),
 ('colossus','Piotr rasputin' ,'piotrrasputin@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1978-03-14', '', 'X-Mansion Lane', 'Westchester', '33333', 'USA', NULL),
 ('gamora', 'Gamora','gamora@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 85000.00, '1984-09-03', '', 'Zen-Whoberi Street', 'Zen-Whoberi', '11223', 'Zen-Whoberi', NULL),
 ('antman','Scott Lang' ,'scottlang@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 70000.00, '1980-01-22', '', 'Pym Particles Lane', 'New York', '45678', 'USA', NULL),
 ('zatanna','Zatanna Zatara' ,'zatannazatara@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 80000.00, '1986-10-31', '', 'Mystic Road', 'Shadowcrest', '54321', 'USA', NULL),
 ('stormqueen','Aurora Munroe' ,'auroramunroe@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1985-07-19', '', 'Wakanda Lane', 'Wakanda', '98765', 'Wakanda', NULL),
 ('redskull','Johann Schmidt' ,'johannschmidt@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 75000.00, '1941-11-02', '', 'Nazi Avenue', 'Berlin', '00123', 'Germany', NULL),
 ('mysterio','Quentin Beck' ,'quentinbeck@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 70000.00, '1969-04-15', '', 'Fishbowl Street', 'New York', '54321', 'USA', NULL),
 ('cyclops','Scott Summer' ,'scottsummers@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 85000.00, '1973-08-26', '', 'X-Mansion Avenue', 'Westchester', '33333', 'USA', NULL),
 ('rogue','Anna Marie' ,'annamarie@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1987-06-04', '', 'Mississippi Road', 'Caldecott', '54321', 'USA', NULL),
 ('iceprincess','Bobby Drake' ,'bobbydrake@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 70000.00, '1982-03-30', '', 'Frost Lane', 'North Salem', '11223', 'USA', NULL),
 ('blacksuit','Eddie Mayne' ,'eddieredmayne@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 80000.00, '1988-12-14', '', 'Symbiote Street', 'New York', '45678', 'USA', NULL),
 ('scarecrow', 'John Crane','jonathancrane@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 75000.00, '1970-10-20', '', 'Fear Lane', 'Gotham City', '00123', 'USA', NULL),
 ('invisiblewoman','Susan Storm' ,'susanstorm@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1983-07-22', '', 'Fantastic Road', 'New York', '54321', 'USA', NULL),
 ('nightcrawler','Kurt Wagner' ,'kurtwagner@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 85000.00, '1984-05-05', '', 'Bamf Avenue', 'Bavaria', '22222', 'Germany', NULL),
 ('lizardking','Connor','drconnors@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 80000.00, '1977-09-11', '', 'Reptile Lane', 'New York', '98765', 'USA', NULL),
 ('rocketraccoon','Rocket' ,'rocket@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 75000.00, '1990-12-05', '', 'Guardian Avenue', 'Halfworld', '54321', 'Halfworld', NULL),
 ('sandman', 'Flint','flintmarko@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1965-03-18', '', 'Desert Lane', 'New York', '11223', 'USA', NULL),
 ('starfire', 'Korian' ,'koriandrs@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 85000.00, '1988-07-29', '', 'Tamaran Road', 'Tamaran', '12345', 'Tamaran', NULL),
 ('juggernaut','Cain' ,'cainmarko@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 80000.00, '1971-02-03', '', 'Juggernaut Street', 'Cain Marko', '33333', 'Marko', NULL),
 ('raven', 'Rachel','rachelroth@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 70000.00, '1980-10-26', '', 'Azarath Lane', 'Azarath', '54321', 'Azarath', NULL),
 ('magneto', 'Erik Lensherr' ,'eriklensherr@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 90000.00, '1963-06-05', '', 'Mutant Lane', 'Genosha', '22222', 'Genosha', NULL),
 ('hulk', 'Bruce Banner','brucebanner@email.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 85000.00, '1962-05-02', '', 'Gamma Road', 'New York', '98765', 'USA', NULL);
 
INSERT INTO moneys (user_id, amount,type, state) 
VALUES 
  (1,10.00,true,'pending'),
  (2,200.00,false, 'denied'),
  (3, 400.00,true, 'accepted'),
  (4, 250.00,false, 'pending'),
  (5, 100.00,true, 'accepted');

INSERT INTO Auction (name, description, initial_price, price, initial_time, end_time, category, state, owner_id)
VALUES
  ('Rare Acoustic Guitar', 'A vintage acoustic guitar with a unique sound.', 80.00, 90.00,'2023-09-01 10:00:00', '2024-10-26 01:30:00', 'strings', 'active', 3),
  ('Handcrafted Flute', 'A beautifully handcrafted flute with exquisite details.', 70.00, 380.00, '2023-09-05 14:00:00', '2024-11-20 14:00:00', 'woodwinds', 'active', 1),
  ('Vintage Bass Guitar', 'An old-school bass guitar with a unique vibe.', 30.00, 290.00 , '2023-09-03 12:00:00', '2024-11-18 12:00:00', 'brass', 'active', 5),
  ('Handmade Drum Set', 'A custom-made drum set for professional drummers.', 25.00, 250.00 , '2023-09-10 15:00:00', '2024-11-25 15:00:00', 'percussion', 'active', 6),
  ('Grand Piano', 'A beautifully maintained grand piano with a rich, deep tone.', 60.00, 230.00 ,'2023-09-07 11:00:00', '2024-11-22 11:00:00', 'strings', 'active', 7),
  ('Vintage Trumpet', 'A classic trumpet with a warm and mellow sound.', 27.00, 245.00 ,'2023-09-02 09:00:00', '2024-11-17 09:00:00', 'brass', 'active', 8),
  ('Electric Guitar Kit', 'A DIY electric guitar kit for guitar enthusiasts.', 45.00, 200.00 ,'2023-09-04 13:00:00', '2024-11-19 13:00:00', 'strings', 'active', 9),
  ('Cajon Drum', 'A versatile and portable cajon drum for musicians on the go.', 60.00, 250.00, '2023-09-08 16:00:00', '2024-11-23 16:00:00', 'percussion', 'active', 10),
  ('Saxophone Quartet', 'A set of four saxophones for ensemble performances.', 35.00, 35.00 ,'2023-09-06 10:00:00', '2024-11-21 10:00:00', 'woodwinds', 'active', 11),
  ('Electronic Keyboard', 'A modern electronic keyboard with various sound options.', 20.00, 20.00 ,'2023-09-09 14:00:00', '2024-10-24 14:00:00', 'percussion', 'finished', 12),
  ('Violin and Bow Set', 'A high-quality violin with a matching bow.', 18.00, 190.00 , '2023-10-11 10:00:00', '2023-10-25 10:00:00', 'strings', 'finished', 3),
  ('Classic Flute', 'A classic flute for professional musicians.',30.00 ,300.00, '2023-10-12 11:00:00', '2023-10-26 11:00:00', 'woodwinds', 'finished', 3),
  ('Vintage Drum Machine', 'A vintage drum machine for electronic music production.',40.00 ,90.00, '2023-09-13 12:00:00', '2023-10-27 12:00:00', 'percussion', 'finished', 3),
  ('Saxophone Solo', 'A high-end saxophone for solo performances.', 400.00 ,400.00, '2023-10-14 13:00:00', '2023-10-28 13:00:00', 'woodwinds', 'finished', 19),
  ('Trumpet Masterclass', 'A masterclass session with a renowned trumpet player.', 150.00,150.00, '2023-10-15 14:00:00', '2023-10-29 14:00:00', 'brass', 'finished', 21),
  ('Bass Guitar Workshop', 'A workshop on advanced bass guitar techniques.',50.00 , 180.00, '2023-09-25 15:00:00', '2023-10-22 15:00:00', 'brass', 'finished', 23),
  ('Piano Concerto Tickets', 'Tickets for a grand piano concerto event.', 80.00, 120.00, '2023-10-17 16:00:00', '2023-10-31 16:00:00', 'strings', 'finished', 25),
  ('Electronic Music Production Course', 'A comprehensive course on electronic music production.', 200.00 , 220.00, '2023-10-18 17:00:00', '2023-11-01 17:00:00', 'percussion', 'finished', 27),
  ('Accordion Performance', 'A live performance featuring accordion music.',10, 180.00, '2023-10-19 18:00:00', '2023-11-02 18:00:00', 'woodwinds', 'finished', 29),
  ('Drumming Masterclass', 'A masterclass session on advanced drumming techniques.',350.00, 350.00, '2023-10-20 19:00:00', '2023-11-03 19:00:00', 'percussion', 'finished', 31),
  ('Guitar Effects Pedal', 'A high-quality effects pedal for electric guitars.', 80.00 ,80.00, '2023-10-21 10:00:00', '2023-11-04 10:00:00', 'strings', 'paused', 33),
  ('Digital Piano', 'A digital piano with realistic piano sound.',300.00 ,300.00, '2023-10-22 11:00:00', '2023-11-05 11:00:00', 'strings', 'paused', 34),
  ('Trombone Ensemble', 'A set of trombones for ensemble performances.',180.00 ,180.00, '2023-10-23 12:00:00', '2023-11-06 12:00:00', 'brass', 'paused', 35),
  ('Synthesizer Keyboard', 'A synthesizer keyboard for electronic music artists.', 250.00 , 250.00, '2023-10-24 13:00:00', '2023-11-07 13:00:00', 'percussion', 'paused', 36),
  ('Harmonica Set', 'A set of harmonicas for blues and folk music.',100.00 ,100.00, '2023-10-25 14:00:00', '2023-11-08 14:00:00', 'woodwinds', 'paused', 37),
  ('Drumming Workshop', 'A workshop on drumming techniques for beginners.', 150.00, 150.00, '2023-10-26 15:00:00', '2023-11-09 15:00:00', 'percussion', 'paused', 38),
  ('Guitar and Vocal Lessons', 'Lessons for both guitar and vocal training.',200.00, 200.00, '2023-10-27 16:00:00', '2023-11-10 16:00:00', 'strings', 'paused', 39),
  ('Flute Duet', 'A duet of high-quality flutes for musicians.',180.00, 180.00, '2023-10-28 17:00:00', '2023-11-11 17:00:00', 'woodwinds', 'paused', 40),
  ('Percussion Ensemble', 'An ensemble performance featuring various percussion instruments.', 300.00,300.00, '2023-10-29 18:00:00', '2023-11-12 18:00:00', 'percussion', 'paused', 41),
  ('Saxophone Solo Performance', 'A live solo performance with a saxophone.',150.00 ,150.00, '2023-10-30 19:00:00', '2023-11-13 19:00:00', 'woodwinds', 'paused', 42),
  ('Electric Violin', 'An electric violin with modern sound capabilities.',400.00 ,400.00, '2023-11-01 10:00:00', '2023-11-15 10:00:00', 'strings', 'approved', 43),
  ('Clarinet Duet', 'A duet of high-quality clarinets for musicians.',300.00 , 300.00, '2023-11-02 11:00:00', '2023-11-16 11:00:00', 'woodwinds', 'approved', 44),
  ('Trumpet Quartet', 'A quartet of trumpets for ensemble performances.', 250.00 ,250.00, '2023-11-03 12:00:00', '2023-11-17 12:00:00', 'brass', 'approved', 45),
  ('Guitar Masterclass', 'A masterclass session with a renowned guitarist.', 350.00, 350.00, '2023-11-04 13:00:00', '2023-11-18 13:00:00', 'strings', 'approved', 46),
  ('Piano Duet', 'A duet of grand pianos for classical music lovers.', 500.00 ,500.00, '2023-11-05 14:00:00', '2023-11-19 14:00:00', 'strings', 'approved', 47),
  ('Drumming Workshop', 'A workshop on advanced drumming techniques.', 250.00 ,250.00, '2023-11-06 15:00:00', '2023-11-20 15:00:00', 'percussion', 'approved', 48),
  ('Accordion Ensemble', 'An ensemble performance featuring accordions.',200.00, 200.00, '2023-11-07 16:00:00', '2023-11-21 16:00:00', 'woodwinds', 'approved', 49),
  ('Saxophone Solo Performance', 'A live solo performance with a saxophone.', 300.00 , 300.00, '2023-11-08 17:00:00', '2023-11-22 17:00:00', 'woodwinds', 'approved', 50),
  ('Vocal Masterclass', 'A masterclass session with a renowned vocalist.',200.00 ,200.00, '2023-11-09 18:00:00', '2023-11-23 18:00:00', 'percussion', 'approved', 51),
  ('Bass Guitar Solo', 'A live solo performance featuring a bass guitar.',150.00 ,150.00, '2023-11-10 19:00:00', '2023-11-24 19:00:00', 'brass', 'approved', 52),
  ('Xylophone Set', 'A set of xylophones for school and ensemble use.', 200.00 , 200.00, '2023-11-11 10:00:00', '2023-11-25 10:00:00', 'percussion', 'denied', 53),
  ('Keyboard Ensemble', 'An ensemble performance featuring electronic keyboards.', 180.00 ,180.00, '2023-11-12 11:00:00', '2023-11-26 11:00:00', 'percussion', 'disabled', 45),
  ('Harmonica Masterclass', 'A masterclass session for harmonica enthusiasts.', 250.00,250.00, '2023-11-13 12:00:00', '2023-11-27 12:00:00', 'woodwinds', 'denied', 52),
  ('Drumming Solo', 'A live solo drumming performance by a professional.', 200.00 , 200.00, '2023-11-14 13:00:00', '2023-11-28 13:00:00', 'percussion', 'denied', 26),
  ('Guitar Ensemble', 'An ensemble performance featuring various guitars.', 300.00, 300.00 ,'2023-11-15 14:00:00', '2023-11-29 14:00:00', 'strings', 'denied', 20),
  ('Brass Quartet', 'A quartet of brass instruments for ensemble performances.', 180.00, 180.00,'2023-11-16 15:00:00', '2023-11-30 15:00:00', 'brass', 'disabled', 5),
  ('Piano Solo Performance', 'A live solo piano performance by a professional pianist.', 250.00, 250.00 ,'2023-11-17 16:00:00', '2023-12-01 16:00:00', 'strings', 'denied', 7),
  ('Flute Solo', 'A live solo flute performance by a professional flutist.', 200.00, 200.00 ,'2023-11-18 17:00:00', '2023-12-02 17:00:00', 'woodwinds', 'denied', 9),
  ('Trumpet Masterclass', 'A masterclass session with a renowned trumpet player.', 300.00, 300.00,'2023-11-19 18:00:00', '2023-12-03 18:00:00', 'brass', 'denied', 6),
  ('Accordion Workshop', 'A workshop on accordion playing for beginners.', 150.00, 150.00 ,'2023-11-20 19:00:00', '2023-12-04 19:00:00', 'woodwinds', 'denied', 23);

INSERT INTO AuctionWinner (user_id, auction_id, rating)
VALUES
  (16, 12, 4),
  (18, 13, 3),
  (24, 16, NULL),
  (26, 17, NULL),
  (28, 18, NULL),
  (30, 19, NULL),
  (32, 20, NULL);

INSERT INTO Bid (user_id, auction_id, amount, time)
VALUES
  (13, 1, 90.00, '2023-09-17 15:30:00'),
  (11, 2, 90.00, '2023-09-19 15:30:00'),
  (13, 2, 120.00, '2023-09-20 17:45:00'),
  (14, 2, 140.00, '2023-09-21 09:15:00'),
  (10, 2, 180.00, '2023-09-22 11:30:00'),
  (7, 2, 210.00, '2023-09-23 14:00:00'),
  (15, 2, 250.00, '2023-09-23 16:45:00'),
  (12, 2, 290.00, '2023-09-24 09:15:00'),
  (17, 2, 320.00, '2023-09-24 13:30:00'),
  (9, 2, 350.00, '2023-09-30 15:45:00'),
  (8, 2, 380.00, '2023-10-01 18:00:00'),
  (19, 3, 130.00, '2023-09-20 09:30:00'),
  (20, 3, 160.00, '2023-09-21 13:15:00'),
  (21, 3, 190.00, '2023-09-23 15:45:00'),
  (18, 3, 220.00, '2023-09-24 18:00:00'),
  (23, 3, 260.00, '2023-09-26 09:15:00'),
  (22, 3, 290.00, '2023-09-27 12:30:00'),
  (26, 4, 100.00, '2023-09-21 11:30:00'),
  (28, 4, 130.00, '2023-09-23 14:45:00'),
  (27, 4, 150.00, '2023-09-24 17:00:00'),
  (24, 4, 180.00, '2023-09-25 19:15:00'),
  (30, 4, 220.00, '2023-09-27 09:30:00'),
  (29, 4, 250.00, '2023-09-28 13:00:00'),
  (34, 5, 80.00, '2023-09-22 09:30:00'),
  (36, 5, 110.00, '2023-09-23 11:45:00'),
  (35, 5, 140.00, '2023-09-24 14:00:00'),
  (32, 5, 170.00, '2023-09-25 16:15:00'),
  (38, 5, 200.00, '2023-09-26 18:30:00'),
  (37, 5, 230.00, '2023-09-27 20:45:00'),
  (42, 6, 95.00, '2023-09-22 12:00:00'),
  (45, 6, 125.00, '2023-09-23 14:15:00'),
  (44, 6, 155.00, '2023-09-24 16:30:00'),
  (41, 6, 185.00, '2023-09-25 18:45:00'),
  (47, 6, 215.00, '2023-09-26 21:00:00'),
  (46, 6, 245.00, '2023-09-28 09:15:00'),
  (51, 7, 109.00, '2023-09-23 11:30:00'),
  (53, 7, 140.00, '2023-09-24 13:45:00'),
  (52, 7, 170.00, '2023-09-25 16:00:00'),
  (49, 7, 200.00, '2023-09-26 18:15:00'),
  (2, 8, 100.00, '2023-09-24 09:30:00'),
  (11, 8, 130.00, '2023-09-25 11:45:00'),
  (3, 8, 160.00, '2023-09-26 14:00:00'),
  (43, 8, 190.00, '2023-09-27 16:15:00'),
  (2, 8, 220.00, '2023-09-28 18:30:00'),
  (3, 8, 250.00, '2023-09-29 20:45:00');


INSERT INTO follows (user_id, auction_id)
VALUES
  (1, 7),
  (2, 1),
  (5, 1),
  (2, 2),
  (3, 2),
  (5, 2),
  (6, 3),
  (7, 3),
  (8, 3),
  (9, 3),
  (10, 4),
  (11, 4),
  (12, 4),
  (13, 4),
  (14, 5),
  (15, 5),
  (16, 5),
  (17, 5),
  (18, 6),
  (19, 6),
  (20, 6),
  (21, 6),
  (22, 7),
  (23, 7),
  (24, 7),
  (25, 7),
  (26, 8),
  (27, 8),
  (28, 8),
  (29, 8),
  (30, 9),
  (31, 9),
  (32, 9),
  (33, 9),
  (34, 10),
  (35, 10),
  (36, 10),
  (37, 10);


INSERT INTO Report (user_id, auction_id, description, state)
VALUES 
  (2, 1, 'Suspicious activity.', 'listed'),
  (3, 1, 'Possible fraud.', 'reviewed'),
  (4, 1, 'Unusual behavior.', 'unrelated'),
  (5, 1, 'Concerns about the auction.', 'unrelated'),
  (6, 1, 'Reporting irregularities.', 'listed'),
  (7, 1, 'Please investigate.', 'unrelated'),
  (8, 1, 'Alerting to potential issues.', 'reviewed'),
  (9, 1, 'Flagging this auction.', 'listed'),
  (10, 1, 'Noticed something strange.', 'unrelated');

INSERT INTO Comment (user_id, auction_id, message, time)
VALUES
  (2, 1, 'Great item! Im interested in bidding.', '2023-09-20 12:30:00'),
  (3, 2, 'This flute looks amazing. Cant wait to play it!', '2023-09-20 14:45:00'),
  (4, 3, 'I have a question about the bass guitar. Can you provide more details?', '2023-09-21 10:15:00'),
  (5, 4, 'Is the drum set still available? Im ready to bid.', '2023-09-22 16:20:00'),
  (6, 5, 'The piano is beautiful. Im considering placing a bid.', '2023-09-23 09:45:00'),
  (7, 1, 'Im also interested in the guitar. How much does it weigh?', '2023-09-24 13:50:00'),
  (8, 2, 'What type of wood was used for the flute? It looks exquisite.', '2023-09-25 11:30:00'),
  (9, 3, 'The bass guitar has a unique vibe. Im eager to bid.', '2023-09-26 15:25:00'),
  (10, 4, 'I love the drum set! Can you ship it internationally?', '2023-09-27 17:10:00'),
  (11, 5, 'Is the piano tuned and in good condition? Ready to place a bid.', '2023-09-28 10:00:00'),
  (12, 1, 'Great to see so many musical instruments available.', '2023-09-29 12:30:00'),
  (13, 2, 'I hope the flute has a clear and crisp sound.', '2023-09-30 14:45:00'),
  (14, 3, 'Im excited about the bass guitar! It has a fantastic design.', '2023-09-21 10:15:00'),
  (15, 4, 'Im ready to bid on the drum set. Whats the current price?', '2023-09-22 16:20:00'),
  (16, 5, 'The piano is exactly what Ive been looking for. Placing a bid.', '2023-09-23 09:45:00'),
  (17, 1, 'How long is the guitar warranty? Interested in bidding.', '2023-09-24 13:50:00'),
  (18, 2, 'I play the flute, and this one looks top-notch. Cant wait to get it!', '2023-09-25 11:30:00'),
  (19, 3, 'The bass guitars vintage vibe is so appealing. Ready to bid.', '2023-09-26 15:25:00'),
  (20, 4, 'The drum set is calling my name. Hows the sound quality?', '2023-09-27 17:10:00'),
  (21, 5, 'The pianos craftsmanship is outstanding. Placing a competitive bid.', '2023-09-28 10:00:00'),
  (22, 1, 'Im considering bidding on the guitar. Any accessories included?', '2023-09-29 12:30:00'),
  (23, 2, 'The flute is exquisite. I hope it sounds as good as it looks.', '2023-09-30 14:45:00'),
  (24, 3, 'The bass guitars design is a work of art. Ready to make an offer.', '2023-09-21 10:15:00'),
  (25, 4, 'Im serious about the drum set. Can you provide shipping details?', '2023-09-22 16:20:00'),
  (26, 5, 'The piano will be the highlight of my collection. Placing a significant bid.', '2023-09-23 09:45:00'),
  (27, 1, 'I love the guitar. Is it suitable for beginners? Ready to bid.', '2023-09-24 13:50:00'),
  (28, 2, 'Im a flute enthusiast, and this one is on my list. Cant wait to play it!', '2023-09-25 11:30:00'),
  (29, 3, 'The bass guitars character is unique. Im eager to start bidding.', '2023-09-26 15:25:00'),
  (30, 4, 'I have a studio and need the drum set. Please share the specs.', '2023-09-27 17:10:00'),
  (31, 5, 'The piano will complete my music room. Placing a competitive bid.', '2023-09-28 10:00:00'),
  (32, 1, 'Im thinking about the guitar for a project. Any discount available?', '2023-09-29 12:30:00'),
  (33, 2, 'I perform with flutes regularly. This one looks perfect for me.', '2023-09-30 14:45:00'),
  (34, 3, 'The bass guitar has a timeless design. Ready to make a serious bid.', '2023-09-21 10:15:00'),
  (35, 4, 'The drum set is just what my band needs. Can you provide shipping options?', '2023-09-22 16:20:00'),
  (36, 5, 'The piano will be the centerpiece of my music studio. Placing a substantial bid.', '2023-09-23 09:45:00'),
  (37, 1, 'Im considering the guitar for a gift. Do you offer gift wrapping?', '2023-09-24 13:50:00'),
  (38, 2, 'The flutes craftsmanship is impressive. Cant wait to add it to my collection.', '2023-09-25 11:30:00'),
  (39, 3, 'The bass guitar has a classic vibe. Im excited to place a bid.', '2023-09-26 15:25:00'),
  (40, 4, 'Im ready to make a substantial bid on the drum set. Please provide details.', '2023-09-27 17:10:00'),
  (41, 5, 'The piano is a dream come true. Placing a competitive bid to secure it.', '2023-09-28 10:00:00'),
  (42, 1, 'The guitar has a fantastic design. Is it available for immediate purchase?', '2023-09-29 12:30:00'),
  (43, 2, 'Ive been searching for the perfect flute. This might be it!', '2023-09-30 14:45:00'),
  (44, 3, 'The bass guitars tone seems promising. Im eager to place a serious bid.', '2023-09-21 10:15:00'),
  (45, 4, 'Im a drummer in a band. This set is what we need. Shipping options, please.', '2023-09-22 16:20:00'),
  (46, 5, 'The piano will complete my home studio. Placing a significant bid to secure it.', '2023-09-23 09:45:00'),
  (47, 1, 'Im ready to bid on the guitar. Can you provide more photos?', '2023-09-24 13:50:00'),
  (48, 2, 'Ive played many flutes, and this one looks exceptional. Ready to make an offer.', '2023-09-25 11:30:00'),
  (49, 3, 'The bass guitars character is unique. Im eager to start bidding.', '2023-09-26 15:25:00'),
  (50, 4, 'Im a drummer, and this seTransfert is on my wishlist. Shipping information, please.', '2023-09-27 17:10:00');


INSERT INTO SystemManager (user_id)
SELECT id
FROM users
WHERE id BETWEEN 2 AND 5;

INSERT INTO Admin (user_id)
SELECT id
FROM users
WHERE id BETWEEN 2 AND 4;

INSERT INTO MetaInfo (name)
VALUES
  ('Brand'),
  ('Size'),
  ('Color'),
  ('Material'),
  ('Condition'),
  ('Year');

INSERT INTO MetaInfoValue (meta_info_name, value)
VALUES
  ('Brand', 'Yamaha'),
  ('Brand', 'Gibson'),
  ('Brand', 'Fender'),
  ('Brand', 'Roland'),
  ('Brand', 'Takamine'),
  ('Color', 'Black'),
  ('Color', 'Blue'),
  ('Color', 'Green'),
  ('Color', 'Orange'),
  ('Color', 'Purple'),
  ('Color', 'Red'),
  ('Color', 'Yellow'),
  ('Condition', 'Damaged'),
  ('Condition', 'New'),
  ('Condition', 'Refurbished'),
  ('Material', 'Aluminum'),
  ('Material', 'Glass'),
  ('Material', 'Leather'),
  ('Material', 'Metal'),
  ('Material', 'Plastic'),
  ('Material', 'Wood'),
  ('Size', 'Large'),
  ('Size', 'Medium'),
  ('Size', 'Small'),
  ('Year', '1920s'),
  ('Year', '1930s'),
  ('Year', '1940s'),
  ('Year', '1950s'),
  ('Year', '1960s'),
  ('Year', '1970s'),
  ('Year', '1980s'),
  ('Year', '1990s'),
  ('Year', '2000s'),
  ('Year', '2010s'),
  ('Year', '2020s');

INSERT INTO AuctionMetaInfoValue (auction_id, meta_info_value_id)
VALUES
  (1, 1), 
  (1, 10),
  (2, 2),
  (2, 13),
  (3, 3),
  (3, 10);

```

---


## Revision history

Changes made to the first submission:

### 9/11/2023
1. Changed admin estimation growth to 0
2. Changed Full-Text Search indices(added search by name to user and added search by description to auction)

- Eduardo Olveira (Editor)

### 17/11/2023

1. Added moneys table to UML,SQL,Relational Schema
2. Added deposit and withdrawal trigger
3. Fixed error in relational schema
4. Added report_state and transfer_state
5. Added insert values for new table
6. Added name and is_anonymizing to users table
7. Added report_state to reports
8. Fix anonymaze_user_data() trigger

- José Santos (Editor)

### 10/12/2023

1. Fixed Transaction 1 to match laravel code
- Daniel Gago (Editor)

### 12/12/2023

1. Removed is_anonymizing from users table
2. Added user_state to UML,SQL,Relational Schema
3. Fixed triggers associated with user_state

- José Santos (Editor)

### 13/12/2023

1. Changed anonymize trigger, email not NULL now 

- José Santos (Editor)

***
GROUP0202, 25/10/2023

* Daniel Gago, up202108791@edu.fe.up.pt (Editor)
* Eduardo Oliveira, up202108843@edu.fe.up.pt 
* José Santos, up202108729@edu.fe.up.pt
* Máximo Pereira, up202108887@edu.fe.up.pt
