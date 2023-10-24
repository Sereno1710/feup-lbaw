# EBD: Database Specification Component

**Project vision:** SoundSello is being developed to facilitate music lovers and musical instrument collectors find what they want or need by bidding or auctioning instruments of all kinds.

## A4: Conceptual Data Model

Entities and its relationships that exist in SoundSello and it's database are described in this section.

### 1. Class diagram

The UML diagram presents the main organizational entities, their relationships, attributes domains, and the multiplicity of relationships for SoundSello.

![Class Diagram](/wiki/resources/UML.png)

Figure 7: UML Class diagram

### 2. Additional Business Rules
 
> Business rules can be included in the UML diagram as UML notes or in a table in this section.

| Identifier | Description |
| --- | --- |
| BR10' | The auction winner is the user with the highest bid on the auction when it ends. |
| BR11 | A user cannot bid in its own auction. |
| BR12 | A user can only report an auction once. |
| BR13 | A user cannot bid in an auction where he is the highest bid. |
| BR14 | A user cannot follow an auction that he is already following. |

## A5: Relational Schema, validation and schema refinement

This artifact contains the Relational Schema obtained by the UML Class Diagram. The Relational Schema includes each relation schema, attributes, domains, primary keys, foreign keys and other integrity rules.
It also contains the database structure, including all domains and relations.

### 1. Relational Schema

This section contains the relational schema that resulted from the UML Class Diagram. It shows all the atributes,domains,keys and integrity rules in case of need.

| Relation reference | Relation Compact Notation |
| --- | --- |
| R01 | users (id **PK**, username **NN UK**, email **NN UK**, password **NN**, balance **NN DF 0**, date_of_birth **NN**,street **NN**, city **NN**, zip_code **NN**, country **NN**,image) |
| R02 | SystemManager (id -> User(id) **PK**) |
| R03 | Admin (id -> User(id) **PK**) |
| R04 | Auction (id **PK**, name **NN**, description **NN**, price **CK** price > 0, initial_time  **DF N**, end_time **DF N**, category **DF NN**, state **NN DF**,**FK** owner -> User(id), **FK** auction_winner -> User(id) **DF N**) |
| R05 | AuctionPhoto (id **PK**, **FK** auction_id -> Auction(id), image **NN**) |
| R06 | Bid (id **PK**, **FK** user_id -> User(id), **FK** auction_id ->  Auction(id), amount **NN** **CK** amount > 0,time **CK** time <= today) |
| R07 | Report (**FK** user_id -> User(id) **PK**,**FK** auction_id ->  Auction(id) **PK**, description **NN**) |
| R08 | follows (**FK** user_id -> User(id) **PK**, **FK** auction_id _> Auction(id) **PK**) |
| R09 | Comment(id **PK**, **FK** user_id -> User(id) **PK**,**FK** auction_id -> Auction(id) **PK**, message **NN**, time **CK** time <= today) |
| R10 |  MetaInfo(name **PK**) |
| R11 | MetaInfoValue(id **PK**, **FK** meta_info_name -> MetaInfo(name), value **NN**) |
| R12 | AuctionMetaInfoValue(**FK** auction_id -> Auction(id) **PK**, **FK** meta_info_value_id -> MetaInfoValue(id) **PK**) |
| R13 | Notification (id **PK**, notification_type **NN**, date **NN CK** date <= today, viewed **NN DF false**, **FK** receiver_id ->  User(id), **FK** bid_id -> Bid(id), **FK** auction_id -> Auction(id), **FK** comment_id -> Comment(id)) | 

Annotation: <br>
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
| notification | ENUM ('comment_notification, 'bid_notification', 'user_upgrade', 'user_downgrade', 'auction_paused', 'auction_finished', 'auction_approved', 'auction_denied') |
| auction_state | ENUM ('pending', 'active', 'finished', 'paused', 'approved', 'denied','disabled') |
| category_type | ENUM ('strings', 'woodwinds', 'bass', 'percussion') |


### 3. Schema validation

Function dependencies identified as well as if it is in BCNF.

| **TABLE R01** | users |
| --- | --- |
| **Keys** | { id }, { email }, { username } |
| **Functional Dependencies** | |
| FD0101 | id → { username, email, password, balance, date_of_birth, street, city, zip_code, country, image } |
| FD0102 | email → { id, username, password, balance, date_of_birth, street, city, zip_code, country, image } |
| FD0103 | username → { id, email, password, balance, date_of_birth, street, city, zip_code, country, image } |
| **NORMAL FORM** | BCNF |

| **TABLE RO2** | SystemManager |
| --- | --- |
| Keys | { id } |
| Functional Dependencies |
| FD0101 | none |
| **NORMAL FORM** | BCNF |

| **TABLE RO3** | Admin |
| --- | --- |
| Keys | { id } |
| Functional Dependencies |
| FD0101 | none |
| **NORMAL FORM** | BCNF |

| **TABLE R04** | Auction |
| --- | --- |
| **Keys** | { id } |
| **Functional Dependencies** | |
| FD0401 | id → { name, description, price, initial_time, end_time, category, state, owner, auction_winner } |
| **NORMAL FORM** | BCNF |

| **TABLE R05** | AuctionPhoto |
| --- | --- |
| **Keys** | { id } |
| **Functional Dependencies** | |
| FD0501 | id → { auction_id, image } |
| **NORMAL FORM** | BCNF |

| **TABLE R06** | Bid |
| --- | --- |
| **Keys** | { id } |
| **Functional Dependencies** | |
| FD0601 | id → { user_id, auction_id, amount, time } |
| **NORMAL FORM** | BCNF |

| **TABLE R07** | Report |
| --- | --- |
| **Keys** | { user_id, auction_id } |
| **Functional Dependencies** | |
| FD0701 | { user_id, auction_id } → { description } |
| **NORMAL FORM** | BCNF |

| **TABLE R08** | follows |
| --- | --- |
| **Keys** | { user_id, auction_id } |
| **Functional Dependencies** | |
| FD0801 | { user_id, auction_id } → {} |
| **NORMAL FORM** | BCNF |

| **TABLE R09** | Comment |
| --- | --- |
| **Keys** | { id, user_id, auction_id } |
| **Functional Dependencies** | |
| FD0901 | { id, user_id, auction_id } → { message, time } |
| **NORMAL FORM** | BCNF |

| **TABLE R10** | MetaInfo |
| --- | --- |
| **Keys** | { name } |
| **Functional Dependencies** | |
| FD1001 | { name } → {} |
| **NORMAL FORM** | BCNF |

| **TABLE R11** | MetaInfoValue |
| --- | --- |
| **Keys** | { id } |
| **Functional Dependencies** | |
| FD1101 | id → { meta_info_name, value } |
| **NORMAL FORM** | BCNF |

| **TABLE R12** | AuctionMetaInfoValue |
| --- | --- |
| **Keys** | { auction_id, meta_info_value_id } |
| **Functional Dependencies** | |
| FD1201 | { auction_id, meta_info_value_id } → {} |
| **NORMAL FORM** | BCNF |

| **TABLE R13** | Notification |
| --- | --- |
| **Keys** | { id } |
| **Functional Dependencies** | |
| FD1301 | id → { date, viewed, receiver_id, bid_id, auction_id, comment_id} |
| **NORMAL FORM** | BCNF |


## A6: Indexes, triggers, transactions and database population

This artifact covers essential database optimization techniques. It includes the creation of indexes for faster data retrieval, the implementation of triggers for automated actions in response to events, ensuring data consistency and integrity through transactions, and database population with initial data for system setup and testing.

### 1. Database Workload
 
To develop a well-designed database, it is crucial to have a clear understanding of how tables will grow and how often they will be accessed. The following table presents these growth predictions:

| **Relation reference** | **Relation Name** | **Order of magnitude**        | **Estimated growth** |
| --- | --- | --- | --- |
| R01 | Users | 10k | 10 | 
| R02 | SystemManager | 10 | 1 |
| R03 | Admin | 1 | 1 |
| R04 | Auction | 1k | 1 |
| R05 | AuctionPhoto | 1k | 1 |
| R06 | Bid | 10k | 10 |
| R07 | Report | 100 | 1 |
| R08 | Follows | 1k | 1 |
| R09 | Comment | 10k | 10 |
| R10 | MetaInfo | 1 | 0 |
| R11 | MetaInfoValue | 100 | 0 | 
| R12 | AuctionMetaInfoValue | 10k | 10 |
| R13 | Notification | 10k | 1k |




### 2. Proposed Indices

#### 2.1. Performance Indices
 
> Indices proposed to improve performance of the identified queries.

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | users |
| **Attribute**       | username |
| **Type**            | Hash |
| **Cardinality**     | High |
| **Clustering**      | No |
| **Justification**   | The attribute username is subject to many searches in queries, like when showing auctions or comments, so creating an index for this attribute helps performance. Since in these queries, we will search for the exact username, we chose to use hashing, and clustering is not necessary. |

| **Index**           | IDX02                                  |
| ---                 | ---                                    |
| **Relation**        | Notification |
| **Attribute**       | receiver_id |
| **Type**            | Hash |
| **Cardinality**     | Medium |
| **Clustering**      | No |
| **Justification**   | The system will send a lot of notifications, and it always needs to see who to send it to, so receiver_id will be a part of many queries. These queries will look for the exact id, so we chose hashing as the type for the index, and clustering is not necessary. |

| **Index**           | IDX03                                  |
| ---                 | ---                                    |
| **Relation**        | users |
| **Attribute**       | username |
| **Type**            | Hash |
| **Cardinality**     | High |
| **Clustering**      | No |
| **Justification**   | The attribute username is subject to many searches in queries, like when showing auctions or comments, so creating an index for this attribute helps performance. Since in these queries, we will search for the exact username, we chose to use hashing, and clustering is not necessary. |
| `SQL code`                                                  ||


#### 2.2. Full-text Search Indices 

> The system being developed must provide full-text search features supported by PostgreSQL. Thus, it is necessary to specify the fields where full-text search will be available and the associated setup, namely all necessary configurations, indexes definitions and other relevant details.  

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | user   |
| **Attribute**       | username   |
| **Type**            | GIN              |
| **Clustering**      | No               |
| **Justification**   | To provide full-text search features to look for users based on matching usernames. The GIN index type is chosen because the indexed fields are not expected to change often.   |
```sql
ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;
CREATE FUNCTION user_fullsearch_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.username), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF NEW.username <> OLD.username THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', NEW.username), 'B')
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

| **Index**           | IDX02                                  |
| ---                 | ---                                    |
| **Relation**        | auction  |
| **Attribute**       | name   |
| **Type**            | GIN              |
| **Clustering**      | No               |
| **Justification**   | To provide full-text search features to look for auctions based on matching names. The GIN index type is chosen because the indexed fields are not expected to change often.   |
```sql
ALTER TABLE Auction
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION auction_search_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.name), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF NEW.name <> OLD.name THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', NEW.name), 'B')
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
 
> User-defined functions and trigger procedures that add control structures to the SQL language or perform complex computations, are identified and described to be trusted by the database server. Every kind of function (SQL functions, Stored procedures, Trigger procedures) can take base types, composite types, or combinations of these as arguments (parameters). In addition, every kind of function can return a base type or a composite type. Functions can also be defined to return sets of base or composite values.  

| **Trigger** | TRIGGER01 |
| --- | --- |
| **Description** | Upon account deletion, shared user data (e.g. comments, reviews, likes) is kept but is made anonymous. (business rule BR01) |
```sql
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
```


| **Trigger** | TRIGGER03 |
| --- | --- |
| **Description** | An auction can only be cancelled if there are no bids. (business rule BR03) |
```sql
CREATE FUNCTION prevent_auction_cancellation()
RETURNS TRIGGER AS 
$$
    DECLARE num_bids INTEGER;
BEGIN

  IF TG_OP = 'UPDATE' AND OLD.auction_state <> NEW.auction_state THEN

    SELECT COUNT(*) INTO num_bids FROM Bid WHERE auction_id = NEW.id;
    IF num_bids > 0 THEN
      RAISE EXCEPTION 'Cannot change the state. There are % bids.', num_bids;
    END IF;
  END IF;
  

  NEW.auction_state = OLD.auction_state;
  
  RETURN NEW;
END;
$$ 
LANGUAGE plpgsql;
CREATE TRIGGER prevent_auction_cancellation_trigger
BEFORE UPDATE ON Auction
FOR EACH ROW
EXECUTE FUNCTION prevent_auction_cancellation();
```

| **Trigger** | TRIGGER04 |
| --- | --- |
| **Description** | A user can only bid if their bid is higher than the current highest bid. A user cannot bid if their bid is the current highest. (business rule BR04) |
```sql
CREATE FUNCTION enforce_bidding_rules()
RETURNS TRIGGER AS 
$$
DECLARE
  current_highest_bid MONEY;
  highest_bidder INTEGER;
  i_price MONEY;
  user_balance MONEY;
BEGIN
  SELECT user_id, amount INTO highest_bidder, current_highest_bid
  FROM Bid
  WHERE auction_id = NEW.auction_id
  ORDER BY amount DESC
  LIMIT 1;
  SELECT price INTO i_price
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
    RAISE EXCEPTION 'You do not have enough balance in your account'.
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

| **Trigger** | TRIGGER05 |
| --- | --- |
| **Description** | When a bid is made in the last 15 minutes of the auction, the auction deadline is extended by 30 minutes. (business rule BR05) |
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

| **Trigger** | TRIGGER06 |
| --- | --- |
| **Description** | A seller cannot rate themselves. (business rule BR07) |
```

Se der tempo

```

| **Trigger** | TRIGGER07 |
| --- | --- |
| **Description** | A seller cannot follow their own auction. (business rule BR07) |
```sql
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
```

| **Trigger** | TRIGGER08 |
| --- | --- |
| **Description** | The date of an incoming bid has to be higher than the date of the current highest bid. The date when an auction closed has to be higher than the date of the last bid. (business rule BR08) |
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

| **Trigger** | TRIGGER09 |
| --- | --- |
| **Description** | Auctions should be automatically paused when the system is down. This ensures that the bidding process is not affected by technical errors. (business rule BR09) |
```sql

???????????

```

| **Trigger** | TRIGGER10 |
| --- | --- |
| **Description** | A user needs to be at least 18 years old to use this website. (business rule BR10) |
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


| **Trigger** | TRIGGER12 |
| --- | --- |
| **Description** | The auction winner is the user with the highest bid on the auction when it ends. (business rule BR12) |
```sql
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
```

| **Trigger** | TRIGGER13 |
| --- | --- |
| **Description** | A user cannot bid in its own auction. (business rule BR13) |
```sql
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
```

| **Trigger** | TRIGGER14  |
| --- | ---                                    |
| **Description**  | A user can only report an auction once. (business rule BR14) |
```sql
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
```


| **Trigger** | TRIGGER16 |
| --- | --- |
| **Description** | A user cannot follow an auction that he is already following. (business rule BR16) |
```sql
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
```



### 4. Transactions
 
> Transactions needed to assure the integrity of the data.  

| Transaction  | TRAN01                    |
| --------------- | ----------------------------------- |
| Description   | Buy an item  |
| Justification   | Justification for the transaction.  |
| Isolation level | Isolation level of the transaction. |
| `Complete SQL Code`                                   ||


## Annex A. SQL Code

> The database scripts are included in this annex to the EBD component.
> 
> The database creation script and the population script should be presented as separate elements.
> The creation script includes the code necessary to build (and rebuild) the database.
> The population script includes an amount of tuples suitable for testing and with plausible values for the fields of the database.
>
> The complete code of each script must be included in the group's git repository and links added here.

### A.1. Database schema

> The complete database creation must be included here and also as a script in the repository.

### A.2. Database population

> Only a sample of the database population script may be included here, e.g. the first 10 lines. The full script must be available in the repository.

---


## Revision history

No changes have been made to the first submission yet.

***
GROUP0202, 24/10/2023

* Daniel Gago, up202108791@edu.fe.up.pt
* Eduardo Oliveira, up202108843@edu.fe.up.pt
* José Santos, up202108729@edu.fe.up.pt (Editor)
* Máximo Pereira, up202108887@edu.fe.up.pt
