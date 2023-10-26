# **ER: Requirements Specification Component**

**Project vision:** SoundSello is being developed to facilitate music lovers and musical instrument collectors find what they want or need by bidding or auctioning instruments of all kinds.

## **A1: SoundSello**

SoundSello is being developed by a small group of students as a product targeted to those who want to buy or sell musical instruments.

The main goal of the project is to develop a web-based auction system for musical instruments with the purpose of assisting those in search of them. This tool can only be used by anyone above 18. Users will be divided into several groups: visitors, authenticated users, system managers, and administrators. To start bidding and/or selling, users will need to create an account and log in to be authenticated in the system.

To sell an instrument, the user first has to fill in the auction creation form on our website. Then, they need to send the product to our headquarters so we can evaluate the veracity of the product. If the product doesn't meet the expected conditions, it is returned to the user and the user is notified that it has been rejected. Otherwise, the user will be notified that the auction has been approved and is ready to start whenever the user wishes. The auction can always be disabled, as long as no one has bid on it yet.

Auctions will have a countdown timer, which any user can see, as well as the current highest bid. They can bid as long as they are not the current highest bidder and they are not the owner of the auction. If someone bids when the auction has less than 15 minutes remaining, the deadline is increased by 30 minutes. When the timer hits zero, the highest bidder is announced as the winner.

The system will be managed by the system managers who will handle auctions and account-related issues. The administrators can do everything that a system manager can do, in addition to being able to 

The online auction will have an adaptive design, allowing users to be on the system in any type of device or browser. It will also be easy to navigate through the system giving the user a better experience.

## **Main Features:**

### **User:** 
* **Exact match search auctions**
* **Full text search auctions**
* Search filters
* **Log in**
* **Register Account**
* Recover password
* **View active auctions**
* **View user profiles**


### **Authenticated User:**
* **Log out**
* **Submit auction**
* **Bid on auction**
* **Deposit money on account**
* **Withdraw money from account**
* **View profile**
* **Edit profile**
* Delete account
* Receive and view personal notifications
* Support profile picture
* Follow auction
* View followed auctions
* View my bidding history
* **View my auctions**
* Comment on auctions

### **Bidder:**
* Rate seller
* **View auction's bidding history**

### **Seller:**
* **View auction's bidding history**
* Cancel auction

### **System Manager:**
* **Approve auctions**
* Access user activity logs
* Ban/unban user accounts
* Manage filter categories

### **Private Notifications:**
* New bid on owned or participating auction
* Owned or participating auction ending
* Owned or participating auction ended
* Owned or followed auction cancelled
* Owned or participating auction winner
  
### **Administrator:**
* Delete accounts
* **Manage users (edit, view, create, search, promote)**
* Manage filters
* Access system managers activity log 

### **Help:**
* Placeholders in form inputs
* Contextual error messages
* Contextual help
* FAQ

### **Product Information:**
* About Us
* Contacts
* Terms of Use
* Privacy Policy

## A2: Actors and User stories

This artifact contains actors and user stories. Represent the type of users that will use our website, as well as the features it is going to have for each type of user.

### 1. Actors

The actors of SoundSello are represented in Figure 1 and described in Table 1.

![Actors](/wiki/resources/actors.png)

Figure 1: SoundSello Actors

| Identifiers | Description |
| ---| --- |
| User | Generic actor that has access to all information, active auctions, and profiles of the website. |
| Visitor | Unauthenticated user that is able to sign up, log in, or recover a password in the system. |
| Authenticated User | Authenticated users are able to deposit money into their account, follow auctions, bid in auctions, and create their own auctions. They are also able to manage their own profile. |
| Bidder | Bidders are authenticated users who are participating in an auction by having bid on it. They can see all the current auctions that they are bidding on and receive notifications when a change occurs in them. |
| Seller | Sellers are authenticated users who created an auction. They are able to delete and edit their auctions. |
| System Manager | System Managers are authenticated users who moderate the system, being able to manage the auctions as well as temporarily banning accounts. |
| Administrator | Administrators are able to manage accounts (changing account details, deleting accounts), as well as managing category filters. |

Table 1: Actors descriptions


### **2. User Stories**

#### **2.1. User**

| Identifier | Name | Description | Priority |
| --- | --- | --- | --- |
| US01 | See Home Page | As a user, I want to be able to see the home page whenever I enter the website so that I can start using the website. | High |
| US02 | View Active Auctions | As a user, I want to be able to view a list of currently active auctions so that I can bid on items that are currently being auctioned. | High |
| US03 | View Auction Details | As a user, I want to be able to click on an auction from the list to view its detailed information, including item description, current highest bid, and auction end time, so that I can get more insight into the product. | High |
| US04 | Exact match search | As a user, I want to be able to search with a specific text so that I can quickly find a specific item. | High |
| US05 | Full text search | As a user, I want to be able to search words or phrases within extensive text so that I can find the item I want faster. | High |
| US06 | View User Profiles | As a user, I want to be able to view other user profiles that are registered on the platform so that I can see their activity and items they have listed or bid on. | High |
| US07 | Search Filters | As a user, I want to be able to apply filters so that I can refine my search results based on instrument type, price, material quality, and date. | Medium |
| US08 | Consult FAQ / Help | As a user, I want an FAQ / Help section so that I can find a solution to a problem. | Medium |
| US09 | See "About us" Page | As a user, I want to be able to see an "About Us" page so that I can learn more about the website and its creators. | Low |

Table 2: User stories for the User

#### **2.2. Visitor**

| Identifier | Name | Description | Priority |
| --- | --- | --- | --- |
| US10 | Log in | As a user, I want to be able to log in to my account so that I can manage my settings and track my activity securely. | High     |
| US11 | Register Account  | As a user, I want to be able to register for a new account so that I can participate in auctions and save favorite items. | High     |
| US12 | Recover Password  | As a user, I want to be able to recover my password in case I forget it so that I can regain access to my account and continue to use the website. | Medium   |


Table 3: User stories for the Visitor

#### **2.3. Authenticated User**

| Identifier | Name                                    | Description                                                                                                                                                                                | Priority |
|------------|-----------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------| --- |
| US13       | Log out                                 | As an authenticated user, I want the ability to log out of my account so that I can end my session in a secure way preventing it from unauthorized access.                                 | High |
| US14       | Create Auction                          | As an authenticated user, I want to be able to create a new auction so that I can sell items to other users on the website.                                                                | High |
| US15       | Bid on Auction                          | As an authenticated user, I want to be able to place bids on active auctions so that I can use it for making purchases and bidding on the website.                                         | High |
| US16       | View Own Profile                        | As an authenticated user, I want a section where I can see my own profile so that I can see all my activity and information about my account.                                              | High |
| US17       | Edit Profile                            | As an authenticated user, I want to be able to edit and update my user profile information so that I can keep my personal details and preferences updated.                                 | High |
| US18       | Deposit Money on Account                | As an authenticated user, I want to be able to deposit money into my account so that I can use that money to participate in active auctions.                                               | High |
| US19       | Withdraw Money from Account             | As an authenticated user, I want to be able to withdraw money from my account into the bank.                                                                                               | High |
| US20       | View My Bidding History                 | As an authenticated user, I want to be able to view all the bids I've done on the platform so that I can keep track of my history.                                                         | Medium |
| US21       | View My Auctions                        | As an authenticated user, I want to be able to view my auctions so that I can see all the items I'm selling and all the items I've bought.                                                 | Medium |
| US22       | View Followed Auctions                  | As an authenticated user, I want to be able to see all the auctions I've followed so that I can keep track of those auctions.                                                              | Medium |
| US23       | Delete Account                          | As an authenticated user, I want to be able to delete my account permanently so that I can create a brand new account using the same credentials or never use the website again.           | Medium |
| US24       | Follow an Auction                       | As an authenticated user, I want to be able to like/follow an auction, so that I can receive notifications about an auction without having to bid on them.                                 | Medium |
| US25       | Receive and View Personal Notifications | As an authenticated user, I want to receive personal notifications about auctions, bids, and messages so that I can stay informed on auctions I have liked or bid on.                      | Medium |
| US26       | Support Profile Picture                 | As an authenticated user, I want to be able to upload and display a profile picture so that I can personalize my user profile and make it more recognizable to other users on the website. | Medium |
| US27       | Report Auctions                         | As an authenticated user, I want the ability to report auctions that do not follow the guidelines, so that I can contribute to maintaining a safe auction environment.                     | Low |
| US28       | Comment Auctions                        | As an authenticated user, I want the ability to comment on an auction, so that I can get answers and express my opinion.                                                                   | Low |

Table 4: User stories for the Authenticated User

#### **2.4. Bidder**

| Identifier | Name | Description | Priority |
|------------| --- | --- | --- |
| US29       | View Auction Bidding History | As a seller, I want to be able to see all of the bids made in this auction, so that I can see the bids rise. | High |
| US30       | Rate Seller | As a bidder, I want to be able to give a rating from 1 to 5 to a seller I've purchased something from, so that I can give my opinion on them. | Medium |
| US31       | New bid on Participating Auction Notification | As a bidder, I want to get a notification when someone outbids me, so that I can get a chance to send another bid immediately. | Medium |
| US32       | Participating Auction Ending Notification | As a bidder, I want to get a notification when an auction I'm participating in is 30 minute away from ending, so that I can keep up with it in the closing moments. | Medium |
| US33       | Participating Auction Ended Notification | As a bidder, I want to get a notification when an auction I'm participating in ends, so that I know the winning bid as soon as possible. | Medium |
| US34       | Participating Auction Cancelled Notification | As a bidder, I want to get a notification when an auction I'm participating in is cancelled, so that I know exactly when that happens. | Medium |

Table 5: User stories for the Bidder

#### **2.5. Seller**

| Identifier | Name | Description | Priority |
|------------| --- | --- | --- |
| US35       | View Auction Bidding History | As a seller, I want to be able to see all of the bids made in this auction, so that I can see the bids rise. | High |
| US36       | Disable Auction | As a seller, I want to be able to disable my auction if no one has submitted a bid so that I can keep my item if I change my mind. Whilst being able to make that same auction active again at another time. | High |
| US37       | My Auction's Winner | As a seller, I want to know who won my auction, so that I can be informed about who will get my item and how much was their bid. | Medium |

Table 6: User stories for the Seller

#### **2.6. System Manager**

| Identifier | Name | Description | Priority |
|------------| --- | --- | --- |
| US38       | Approve Auction | As a system manager, I want to be able to approve pending auctions, so that they can be ready to be bid on. | High |
| US39       | Pause Auctions | As a system manager, I want to be able to stop an auction, so that I can delay the auction process in case of technical issues, guideline violations, or other necessary reasons. | Medium |
| US40       | Resume Auctions | As an administrator, I want to be able to resume a previously paused auction, so that I can allow users to continue bidding. | Medium |
| US41       | Disable Auctions | As a system manager, I want to be able to disable an auction, so that I can hide content that does not follow the guidelines. | Medium |
| US42       | Ban/Unban User Accounts | As a system manager, I want to be able to ban and unban user accounts, so that I can keep the user base healthy and punish those that don't follow the guidelines. | Medium |
| US43       | Manage Report System | As a system manager/administrator, I want to have the ability to manage the report system, including reviewing and responding to user and auction reports, so that I can take appropriate actions to address the reported issues. | Medium |

Table 7: User stories for the System Manager

#### **2.7. Administrator**

| Identifier | Name                               | Description                                                                                                                                                                                                                                     | Priority |
|------------|------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------| --- |
| US44       | Manage User Accounts               | As an administrator, I want to have the ability to manage users, including the ability to edit existing user profiles, create new accounts, search for certain users, and add system managers, so that I can have total control over the users. | High |
| US45       | Deactivate User Accounts           | As an administrator, I want to be able to deactivate user accounts, so that I can remove inactive or unauthorized users from the system completely.                                                                                             | Medium |
| US46       | Manage Filter Categories           | As an administrator, I want to be able to manage filter categories, so that I can add or edit categories when deemed necessary.                                                                                                                 | Low |
| US47       | Access System Manager Activity Log | As an administrator, I want to access a system manager activity log, which includes records of all system manager's actions and the time they happened, so that I can investigate any irregularities or issues effectively.                     | Low |


Table 8: User stories for the Administrator

### **3. Supplementary Requirements**

#### **3.1. Business rules**

| Identifier | Name | Description |
| --- | --- | --- |
| BR01 | Account Deletion | Upon account deletion, shared user data (e.g. comments, reviews, likes) is kept but is made anonymous. |
| BR02 | Disabling Auctions | An auction can only be disabled if there are no bids. |
| BR03 | Bidding in Auctions | A user can only bid if their bid is higher than the current highest bid. A user cannot bid if their bid is the current highest. |
| BR04 | Auction Deadline | When a bid is made in the last 15 minutes of the auction, the auction deadline is extended by 30 minutes. |
| BR05 | Seller Comments | A seller can comment on their own auctions. |
| BR06 | Seller Actions | A seller cannot rate themselves, follow their own auction, or bid on it. |
| BR07 | Dates | The date of an incoming bid has to be higher than the date of the current highest bid. The date when an auction closed has to be higher than the date of the last bid. |
| BR08 | Minimum Age | A user needs to be at least 18 years old to use this website.                                                   |


Table 9: Business rules

#### **3.2. Technical requirements**

| Identifier | Name | Description |
| --- | --- | --- |
| TR01 | Performance | The system should have response times shorter than 2s to ensure the user's attention. |
| TR02 | **Accessibility** | The system must ensure that everyone can access the pages, regardless of whether they have any handicap or not, or the Web browser they use. |
| TR03 | Robustness   | The system must be prepared to handle and continue operating when runtime errors occur. |
| TR04 | **Usability** | The system should be simple and intuitive. |
| TR05 | Scalability | The system must be prepared to deal with the growth in the number of users and their actions. |
| TR06 | **Security** | The system should protect any user's information, so that only the administrators of SoundSello and the user themselves can access a user's data. |
| TR07 | Availability | The system must have an uptime of 99% or more. |
| TR08 | Database | The system should have a reliable database to store information. |


Table 10: Technical requirements

Usability and accessibility are two of the most important technical requirements because this platform only works when users use it, so it should be easy and convenient for anyone to browse our website.

Since the user will be submitting their private information to the system, we need to ensure their privacy, making security an equally important technical requirement. 


#### **3.3. Restrictions**

| **Identifier** | **Name** | **Description** |
| --- | --- | --- |
| R01 | Database | The database should use PostgreSQL |
| R02 | Deadline | This project should be ready to use by the end of the semester|
| R03 | Payment Processor | This project has PayPal as its payment processing service. |

Table 11: Other restrictions


## A3: Information Architecture

This artifact contains SoundSello's sitemap which shows how the information is organized and some wireframes for essential pages functionality and content. These are useful to clarify user requirements and evaluate the product's user interface.



### 1. Sitemap

This diagram shows the pages that are going to exist on our web application and how they interact with each other.

![Sitemap](/wiki/resources/sitemap.png)

Figure 2: SoundSello Sitemap


### 2. Wireframes

The wireframes below show the content of the most important pages on our web application.

#### UI01: Home Page

![Home](/wiki/resources/homepage.png)

Figure 3: SoundSello's home page 

1. Link to the home page.
2. Link to a page with active auctions.
3. Buttons for the visitor to sign up or sign in.
4. Footer that contains all the links to "About Us", FAQ, Contacts, Terms of Use and Privacy Policy
5. Breadcrumbs to help the user navigate.
6. Search bar to help the user find auctions and other users.
7. Message and visual content to greet users.
8. Each auction card has a link to the auction in question.


#### UI02: Profile Page

![Profile](/wiki/resources/profile.png)

Figure 4: User profile page

1. Link to the home page.
2. Links to a page to deposit money into the user account (left), submit an auction into the platform (middle) and view all auctions available (right).
3. Link to the user profile.
4. Notifications button
5. Footer that contains all the links to "About Us", FAQ, Contacts, Terms of Use and Privacy Policy
6. Breadcrumbs to help the user navigate.
7. Search bar to help the user find auctions and other users.
8. Links to a page with the user's complete bidding history (left) and complete seller history (right).
9. Link to edit profile page, where you can change name and profile picture (only visible if it's the user's own profile).
10. Each auction card has a link to the auction in question.
11. View all of your followed auctions.

#### UI10: View Auction

![Auction](/wiki/resources/auction.png)

Figure 5: Auction page

1. Link to the home page.
2. Links to a page to deposit money into the user account (left), submit an auction into the platform (middle) and view all auctions available (right).
3. Link to the user profile.
4. Notifications button
5. Footer that contains all the links to "About Us", FAQ, Contacts, Terms of Use and Privacy Policy
6. Breadcrumbs to help the user navigate.
7. Search bar to help the user find auctions and other users.
8. Input area to place bid.


#### UI09: Active Auctions Page

![Auctions](/wiki/resources/active_auctions.png)

Figure 6: Active auctions page

1. Link to the home page.
2. Links to a page to deposit money into the user account (left), submit an auction into the platform (middle) and view all active auctions (right).
3. Link to the user profile.
4. Notifications button
5. Footer that contains all the links to "About Us", FAQ, Contacts, Terms of Use and Privacy Policy
6. Breadcrumbs to help the user navigate.
7. Search bar to help the user find auctions and other users.
8. Button for using filters and sorting to assist users in searching auctions.
9. Each auction card has a link to the auction in question.

---


## Revision history

Changes made to the first submisson:

### 18/10/2023
1. Deleted user story for deleting auctions
2. Changed the project description to explain better how item selling works

- Daniel Gago (Editor)
- José Santos 

### 24/10/2023
1. Changed 'Canceled' auction to 'Disabled' auction
2. Deleted some business rules we found unnecessary or didn't make sense

- Daniel Gago (Editor)
- José Santos

### 25/10/2023
1. Removed one more business rule that we found unnecessary

- José Santos (Editor)

### 26/10/2023
1. Removed one user story that we found unnecessary
2. Changed priority in one user story (US18 was medium)
3. Changed description in US31
4. Added Withdraw money user story.

- Eduardo Oliveira 
- José Miguel Santos (Editor)
***

GROUP0202, 26/10/2023

* Daniel Gago, up202108791@edu.fe.up.pt 
* Eduardo Oliveira, up202108843@edu.fe.up.pt (Editor)
* José Santos, up202108729@edu.fe.up.pt
* Máximo Pereira, up202108887@edu.fe.up.pt

