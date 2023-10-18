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
| BR12 | The auction winner is the user with the highest bid on the auction when it ends. |
| BR13 | A user cannot bid in its own auction. |
| BR14 | A user can only report an auction or another user once. |
| BR15 | A user cannot bid in an auction where he is the highest bid. |
| BR16 | A user cannot follow an auction that he is already following. |

## A5: Relational Schema, validation and schema refinement

This artifact contains the Relational Schema obtained by the UML Class Diagram. The Relational Schema includes each relation schema, attributes, domains, primary keys, foreign keys and other integrity rules.
It also contains the database structure, including all domains and relations.

### 1. Relational Schema

This section contains the relational schema that resulted from the UML Class Diagram. It shows all the atributes,domains,keys and integrity rules in case of need.

| Relation reference | Relation Compact Notation |
| --- | --- |
| R01 | User (id **PK**, username **NN UK**, email **NN UK**, password **NN**, balance **NN DF 0**, date_of_birth **NN**,street **NN**, city **NN**, zip_code **NN**, country **NN**,image **NN**) |
| R02 | SystemManager (id -> User(id) **PK**) |
| R03 | Admin (id -> User(id) **PK**) |
| R04 | Auction (id **PK**, name **NN**, description **NN**, price **CK** price > 0, initial_time **CK initial_time <= today**, end_time **DF N**, category **DF NN**, state **NN DF**,**FK** owner -> User(id) **PK**, **FK** auction_winner -> User(id) **DF N**) |
| R05 | AuctionPhoto (id **PK**, **FK** auction_id -> Auction(id), image **NN**) |
| R06 | Bid (id **PK**, **FK** user_id -> User(id), **FK** auction_id ->  Auction(id), amount **NN** **CK** amount > 0,time **CK** time <= today) |
| R07 | Report (**FK** user_id -> User(id) **PK**,**FK** auction_id ->  Auction(id) **PK**, description **NN**) |
| R08 | follows (**FK** user_id -> User(id) **PK**, **FK** auction_id _> Auction(id) **PK**) |
| R09 | Comment(id **PK**, **FK** user_id -> User(id) **PK**,**FK** auction_id -> Auction(id) **PK**, message **NN**, time **CK** time <= today) |
| R10 |  MetaInfo(name **PK**) |
| R11 | MetaInfoValue(id **PK**, **FK** meta_info_name -> MetaInfo(name), value **NN**) |
| R12 | AuctionMetaInfoValue(**FK** auction_id -> Auction(id) **PK**, **FK** meta_info_value_id -> MetaInfoValue(id) **PK**) |
| R13 | Notification (id **PK**, date **NN CK** date <= today, viewed **NN DF false**, **FK** user_id ->  User(id)) | 
| R14 | user_notification(notificiation_id -> Notification(id) **PK**, notification_type) |
| R15 | auction_notification(notification_id -> Notification(id) **PK**, **FK** auction_id -> Auction(id), notification_type) |
| R16 | comment_notification(notificiation_id -> Notification(id) **PK**, **FK** comment_id -> Comment(id))|
| R17 | bid_notification(notification_id -> Notification(id) **PK**,**FK** bid_id -> Bid(id)) |

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
| notification | ENUM ('comment_notification, 'user_notification', 'auction_notification', 'bid_notification') |
| auction_notification_type  | ENUM ('auction_paused', 'auction_finished', 'auction_approved', 'auction_denied') |
| user_notification_type | ENUM ('user_upgrade', 'user_downgrade') |
| category_type | ENUM ('strings', 'woodwinds', 'bass', 'percussion') |
| auction_state | ENUM ('pending', 'active', 'finished', 'paused', 'approved', 'denied','disabled') |


### 3. Schema validation

Function dependencies identified as well as if it is in BCNF.

| **TABLE R01** | User |
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
| FD1301 | id → { date, viewed, user_id } |
| **NORMAL FORM** | BCNF |

| **TABLE R14** | user_notification |
| --- | --- |
| **Keys** | { notification_id } |
| **Functional Dependencies** | |
| FD1401 | { notification_id } → { notification_type } |
| **NORMAL FORM** | BCNF |

| **TABLE R15** | auction_notification |
| --- | --- |
| **Keys** | { notification_id } |
| **Functional Dependencies** | |
| FD1501 | { notification_id } → { notification_type , auction_id} |
| **NORMAL FORM** | BCNF |

| **TABLE R16** | comment_notification |
| --- | --- |
| **Keys** | { notification_id } |
| **Functional Dependencies** | |
| FD1601 | notification_id → { comment_id } |
| **NORMAL FORM** | BCNF |

| **TABLE R17** | bid_notification |
| --- | --- |
| **Keys** | { notification_id } |
| **Functional Dependencies** | |
| FD1701 | notification_id → { bid_id } |
| **NORMAL FORM** | BCNF |


## A6: Indexes, triggers, transactions and database population

> Brief presentation of the artifact goals.

### 1. Database Workload
 
> A study of the predicted system load (database load).
> Estimate of tuples at each relation.

| **Relation reference** | **Relation Name** | **Order of magnitude**        | **Estimated growth** |
| ------------------ | ------------- | ------------------------- | -------- |
| R01                | Table1        | units|dozens|hundreds|etc | order per time |
| R02                | Table2        | units|dozens|hundreds|etc | dozens per month |
| R03                | Table3        | units|dozens|hundreds|etc | hundreds per day |
| R04                | Table4        | units|dozens|hundreds|etc | no growth |


### 2. Proposed Indices

#### 2.1. Performance Indices
 
> Indices proposed to improve performance of the identified queries.

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | Relation where the index is applied    |
| **Attribute**       | Attribute where the index is applied   |
| **Type**            | B-tree, Hash, GiST or GIN              |
| **Cardinality**     | Attribute cardinality: low/medium/high |
| **Clustering**      | Clustering of the index                |
| **Justification**   | Justification for the proposed index   |
| `SQL code`                                                  ||


#### 2.2. Full-text Search Indices 

> The system being developed must provide full-text search features supported by PostgreSQL. Thus, it is necessary to specify the fields where full-text search will be available and the associated setup, namely all necessary configurations, indexes definitions and other relevant details.  

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | Relation where the index is applied    |
| **Attribute**       | Attribute where the index is applied   |
| **Type**            | B-tree, Hash, GiST or GIN              |
| **Clustering**      | Clustering of the index                |
| **Justification**   | Justification for the proposed index   |
| `SQL code`                                                  ||


### 3. Triggers
 
> User-defined functions and trigger procedures that add control structures to the SQL language or perform complex computations, are identified and described to be trusted by the database server. Every kind of function (SQL functions, Stored procedures, Trigger procedures) can take base types, composite types, or combinations of these as arguments (parameters). In addition, every kind of function can return a base type or a composite type. Functions can also be defined to return sets of base or composite values.  

| **Trigger**      | TRIGGER01                              |
| ---              | ---                                    |
| **Description**  | Trigger description, including reference to the business rules involved |
| `SQL code`                                             ||

### 4. Transactions
 
> Transactions needed to assure the integrity of the data.  

| SQL Reference   | Transaction Name                    |
| --------------- | ----------------------------------- |
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
GROUP0202, 18/10/2023

* Daniel Gago, up202108791@edu.fe.up.pt
* Eduardo Oliveira, up202108843@edu.fe.up.pt
* José Santos, up202108729@edu.fe.up.pt (Editor)
* Máximo Pereira, up202108887@edu.fe.up.pt
