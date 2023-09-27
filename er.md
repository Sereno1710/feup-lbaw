# **ER: Requirements Specification Component**

**Project vision:** SoundSello is being developed to facilitate music lovers and musical instrument collectors find what they want or need by bidding or auctioning intruments of all kind.    

## **A1: SoundSello**

SoundSello is being developed by a small group of students as a product targeted to those who want to buy or sell musical instruments.

The main goal of the project is to develop a web-based auctioning system for musical instruments with the purpose of assisting those in search of them. This tool can only be used by anyone above 18 or accompanied by an adult. To begin bidding or selling, users will need to create an account and log in. The system will be managed by system managers who will handle auctions and account-related issues.

Users will be divided into several groups, including the aforementioned system managers group, who will have the ability to manage auctions, such as editing a category of an ongoing auction or canceling an auction, as well as managing the search filter categories. Registered users, depending on their actions in the system, may be bidders, with the possibility of rating the seller or viewing their bidding history, or sellers, who are users that are currently  selling instruments, can edit their own auction, manage its status and cancel it in case there have been no bids. 

A user is considered a bidder when a bid has been submited and a seller when the user creates an auction. A user is able to be both bid and seller if he performs both acts.

Administrator is another group of users, who can manage user accounts and have control of the whole system. 

The online auction will have an adaptive design, allowing users to be on the system in any type of device or browser. It will also be easy to navigate throught the system giving the user a better experience.

## **Main features:**

### **User:** 
* Exact match search
* Full text search
* Search Filters
* Log in
* Register Account
* Recover Password
* View Active Auctions
* View User Profiles

### **Authenticated User:**
* Log out
* Create Auction
* Bid on Auction
* Deposit money on account
* View profile
* Edit profile
* Delete Account
* Receive and view personal notifications
* Support profile picture
* Follow Auction

### **Bidder:**
* Rate Seller
* View Auction Bidding History

### **Seller:**
* View Auction Bidding History
* Cancel Auction
* Edit Auction

### **System Manager:**
* Manage Auctions
* Delete Auctions
* Block User Accounts
* Manage Filter Categories

### **Private Notifications:**
* New Bid on Owned or Participating Auction
* Owned or Participating Auction Ending
* Owned or Participating Auction Ended
* Owned or Followed Auction Canceled
* Owned or Participating Auction Winner
  
### **Administrator:**
* Manage Auctions
* Delete Auctions
* Block Accounts
* Delete Accounts
* Manage users (edit,view, create, search)

### **Help:**
* Placeholders in Form Inputs
* Contextual Error Messages
* Contextual Help
* FAQ

### **Product Information:**
* About Us
* Main Features
* Contacts

## A2: Actors and User stories

> Brief presentation of the artifact goals.


### 1. Actors

The actors of the SoundSello are represented in Figure 1 and described in Table 1.

![Actors](https://media.discordapp.net/attachments/1154434520511164426/1156640104731918436/actors_1.png?ex=6515b48a&is=6514630a&hm=fef7d4f15e43ad642377577465edbde7e8465727fa67c931948a72bfc5cccbf2&=&width=473&height=675)

Figure 1: SoundSello Actors

<table>
<td>

**Identifiers**
</td>
<td>

**Description**
</td>
<tr>
<td>

User

</td>
<td> 
Generic actor that has access to all information,active auctions and profiles of the website.
</td>
</tr>
<tr>
<td>

Visitor

</td>
<td>

Unauthenticated user that is able to sign up, log in or recover password in the system. 

</td>
</tr>
<tr>
<td>

Authenticated User

</td>
<td>

Autenticated users are able to deposit money to their account,follow auctions, bid in auctions or create their own auctions. They are also able to manage their profile. 

</td>
</tr>
<tr>
<td>

Bidder

</td>
<td>

Bidders are authenticated users who are participating in a auction by bidding in it, making it possible to see all the current auctions that he is bidding on and receiving notifications with auction changes.

</td>
</tr>
<tr>
<td>

Seller

</td>
<td>

Sellers are authenticated users who created an auction.They are able to delete and edit their auctions. 

</td>
</tr>
<tr>
<td>

System Manager

</td>
<td>

System Manager are authenticated users who moderate the system being able to manage the auctions aswell as temporarily banning accounts.

</td>
</tr>
<tr>
<td>

Administrator

</td>
<td>

Administrator are able to manage accounts(changing account details,deleting accounts), aswell as managing category filters.

</td>
</tr>
</table>


### **2. User Stories**

#### **2.1. User**
<br>
<table>
<td>

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
<td>

**Priority**
</td>
<tr>
<td>US01</td>
<td>See Home Page</td>
<td>High</td>
<td>As a user, I want to be able to see the home page whenever I enter the website so that I can start using the website.</td>
</tr>
<tr>
<td>US02</td>
<td>View Active Auctions</td>
<td>High</td>
<td>As a user, I want to be able to view a list of currently active auctions so that I can bid on items that are currently being auctioned.</td>
</tr>
<tr>
<td>US03</td>
<td>Exact match search</td>
<td>High</td>
<td>As a user, I want to be able to search with a specific text so that I can quickly find a specific item.</td>
</tr>
<tr>
<td>US04</td>
<td>Full text search</td>
<td>High</td>
<td>As a user, I want to be able to search words or phrases within extensive text so that I can find the item I want faster.</td>
</tr>
<tr>
<td>US05</td>
<td>View User Profiles</td>
<td>High</td>
<td>As a user, I want to be able to view other user profiles that are registered in the platform so that I can see their activity and items they have listed or bid on.</td>
</tr>
<tr>
<td>US06</td>
<td>Search Filters</td>
<td>Medium</td>
<td>As a user, I want to be able to apply filters so that I can refine my search results based on instrument type, price, material quality and date.</td>
</tr>
<tr>
<td>US07</td>
<td>Consult FAQ / Help / Contacts</td>
<td>Medium</td>
<td>As a User, I want a ‘FAQ / Help’ section so that I can find a solution to a problem.</td>
</tr>
<tr>
<td>US08</td>
<td>See Main Features</td>
<td>Medium</td>
<td>As a user, I want to be able to see all the main features on the website so that I can see all the functionalities I can use. </td>
</tr>
</table>

#### **2.2. Visitor**
<table>
<td>

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
<td>

**Priority**
</td>
</tr>
<tr>
<td>US09</td>
<td>Log in</td>
<td>High</td>
<td>As a user, I want to be able to log in to my account so that I can manage my settings and track my activity securely.
</td>
</tr>
<tr>
<td>US10</td>
<td>Register Account</td>
<td>High</td>
<td>As a user, I want to be able to register for a new account so that I can participate in auctions and save favorite items.</td>
</tr>
<tr>
<td>US11</td>
<td>Recover Password</td>
<td>Medium</td>
<td>As a user, I want to be able to recover my password in case I forget it so that I can regain access to my account and continue to use the website.
</td>
</tr>
</table>

#### **2.3. Authenticated User**
<table>
<td>

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
<td>

**Priority**
</td>
</tr>
<tr>
<td>US12</td>
<td>Log out</td>
<td>High</td>
<td>As an authenticated user, I want the ability to log out of my account so that I can end my session in a secure way preventing it from unauthorized access.
</td>
</tr>
<tr>
<td>US13</td>
<td>Create Auction</td>
<td>High</td>
<td>As an authenticated user, I want to be able to create a new auction so that I can sell items to other users on the website.</td>
</tr>
<tr>
<td>US14</td>
<td>Bid on Auction</td>
<td>High</td>
<td>As an authenticated user, I want to be able to place bids on active auctions so that I can use it for making purchases and bidding on the website.</td>
</tr>
<tr>
<td>US15</td>
<td>View Profile</td>
<td>High</td>
<td>As an authenticated user, I want a section where I can see my own profile so that I can see all my activity and informations about my account.</td>
</tr>
<tr>
<td>US16</td>
<td>Edit Profile</td>
<td>High</td>
<td>As an authenticated user, I want to be able to edit and update my user profile information so that I can keep my personal details and preferences updated.</td>
</tr>
<tr>
<td>US17</td>
<td>Deposit Money on Account</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to deposit money into my account so that I can use that money to participate in active auctions.</td>
</tr>
<tr>
<td>US18</td>
<td>Delete Account</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to delete my account permanently so that I can create a brand new account using the same credentials or never use the website again.</td>
</tr>
<tr>
<td>US19</td>
<td>Receive and View Personal Notifications</td>
<td>Medium</td>
<td>As an authenticated user, I want to receive personal notifications about auctions, bids and messages so that I can stay informed on auctions I have liked or bid on.</td>
</tr>
<tr>
<td>US20</td>
<td>Support Profile Picture</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to upload and display a profile picture so that I can personalize my user profile and make it more recognizable to other users on the website.</td>
</tr>
</table>

#### **2.4. Bidder**
<table>
<td>

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
<td>

**Priority**
</td>
</tr>
<tr>
<td>US21</td>
<td>View Auction Bidding History</td>
<td>High</td>
<td>As a seller, I want to be able to see all of the bids made in this auction, so that I can see the bids rise.</td>
</tr>
<tr>
<td>US22</td>
<td>Rate Seller</td>
<td>Medium</td>
<td>As a bidder, I want to be able to give a rating from 1 to 5 to a seller i've purchased something from, so that I can give my opinion on them.
</td>
</tr>
<tr>
<td>US23</td>
<td>New bid on Participating Auction</td>
<td>Medium</td>
<td>As a bidder, I want to get a notification when someone outbids me, so that I can get a chance to send another bid immediately.</td>
</tr>
<tr>
<td>US24</td>
<td>Participating Auction Ending</td>
<td>Medium</td>
<td>As a bidder, I want to get a notification when an auction I'm participating in is 1 minute away from ending, so that I can keep up with it in the closing moments.</td>
</tr>
<tr>
<td>US25</td>
<td>Participating Auction Ended</td>
<td>Medium</td>
<td>As a bidder, I want to get a notification when an auction I'm participating in ends, so that I know the winning bid as soon as possible.</td>
</tr>
<tr>
<td>US26</td>
<td>Participating Auction Cancelled</td>
<td>Medium</td>
<td>As a bidder, I want to get a notification when an auction I'm participating in is cancelled, so that I know exactly when that happens.</td>
</tr>
</table>

#### **2.5. Seller**
<table>
<td>

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
<td>

**Priority**
</td>
</tr>
<tr>
<td>US27</td>
<td>View Auction Bidding History</td>
<td>High</td>
<td>As a seller, I want to be able to see all of the bids made in this auction, so that I can see the bids rise.
</td>
</tr>
<tr>
<td>US28</td>
<td>Cancel Auction</td>
<td>High</td>
<td>As a seller, I want to be able to cancel my auction if no one has submitted a bid so that I can keep my item if I change my mind.</td>
</tr>
<tr>
<td>US29</td>
<td>Edit Auction</td>
<td>High</td>
<td>As a seller, I want to be able to change the instrument type and material quality of my auction, so that I can correct a mistake I made.
</td>
</tr>
<tr>
<td>US30</td>
<td>Owned Auction Winner</td>
<td>Medium</td>
<td>As a seller, I want to know who won my auction, so that I can be informed about who my item will be with. 
</td>
</tr>
</table>

#### **2.6. System Manager**
<table>
<td>

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
<td>

**Priority**
</td>
</tr>
<tr>
<td>US31</td>
<td>Change Auction Content</td>
<td>Medium</td>
<td>As a system manager, I want to be able to change the content of an auction, such as its description or category, so that I can update or correct information.
</td>
</tr>
<tr>
<td>US32</td>
<td>Delete Auction Content</td>
<td>Medium</td>
<td>As a system manager, I want to be able to delete specific content within an auction, such as certain images, so that I can remove content that does not follow the guidelines without deleting the entire auction.
</td>
</tr>
<tr>
<td>US33</td>
<td>Pause Auctions</td>
<td>Medium</td>
<td>As a system manager, I want to be able to stop an auction, so that I can delay the auction process in case of technical issues, guideline violations, or other necessary reasons.
</td>
</tr>
<tr>
<td>US34</td>
<td>Resume Auctions</td>
<td>Medium</td>
<td>As an administrator, I want to be able to resume a previously paused auction, so that I can allow users to continue bidding.
</td>
</tr>
<tr>
<td>US35</td>
<td>Close Auctions</td>
<td>Medium</td>
<td>As a system manager, I want to be able to close an auction, so that I can end the bidding process without declaring a winner before the auction reaches its intended end time.
</td>
</tr>
<tr>
<td>US36</td>
<td>Delete Auctions</td>
<td>Medium</td>
<td>As a system manager, I want to be able to delete an auction, so that I can remove content that does not follow the guidelines.
</td>
</tr>
<tr>
<td>US37</td>
<td>Ban User Accounts</td>
<td>Medium</td>
<td>As a system manager, I want to be able to ban user accounts for a certain amount of time, so that I can restrict access to the platform for users who violated the guidelines.
</td>
</tr>
<tr>
<td>US38</td>
<td>Unban User Accounts</td>
<td>Medium</td>
<td>As a system manager, I want to be able to unban user accounts, so that I can bring back users to the website in case of a ban appeal.
</td>
</tr>
</table>

#### **2.7. Administrator**
<table>
<td>

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
<td>

**Priority**
</td>
</tr>
<tr>
<td>US39</td>
<td>Manage User Accounts</td>
<td>Medium</td>
<td>As an administrator, I want to have the ability to manage users, including the ability to edit existing user profiles, create new accounts and search for certain users, so that I can have total control over the users.
</td>
</tr>
<tr>
<td>US40</td>
<td>Delete User Accounts</td>
<td>Medium</td>
<td>As an administrator, I want to be able to delete user accounts, so that I can remove inactive or unauthorized users from the system completely.
</td>
</tr>
<tr>
<td>US41</td>
<td>Manage Filter Categories</td>
<td>Medium</td>
<td>As an administrator, I want to be able to manage filter categories, so that I can add or edit categories when deemed necessary.
</td>
</tr>
</table>

### **3. Supplementary Requirements**
<br> 

#### **3.1. Business rules**
<table>
<td> 

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
</tr>
<tr>
<td>BR01</td>
<td>Account Deletion</td>
<td>Upon account deletion, shared user data (e.g. comments, reviews, likes) is kept but is made anonymous.
</td>
</tr>
<tr>
<td>BR02</td>
<td>Administrator Accounts</td>
<td>Administrator accounts are independent of the user accounts, i.e. they cannot create or participate in auctions.
</td>
</tr>
<tr>
<td>BR03</td>
<td>Cancelling Auctions</td>
<td>An auction can only be cancelled if there are no bids.
</td>
</tr>
<tr>
<td>BR04</td>
<td>Bidding in Auctions</td>
<td>A user cannot bid if his bid is the current highest.
</td>
</tr>
<tr>
<td>BR05</td>
<td>Auction Deadline</td>
<td>When a bid is made in the last 15 minutes of the auction, the auction deadline is extended by 30 minutes.
</td>
</tr>
</table>

#### **3.2. Technical requirements**
<table>
<td> 

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
</tr>
<tr>
<td>TR01</td>
<td>Performance</td>
<td>The system should have response times shorter than 2s to ensure the user's attention.
</td>
</tr>
<tr>
<td>TR02</td>
<td>Robustness</td>
<td>The system must be prepared to handle and continue operating when runtime errors occur.
</td>
</tr>
<tr>
<td>TR03</td>
<td>Scalability</td>
<td>The system must be prepared to deal with the growth in the number of users and their actions.
</td>
</tr>
<tr>
<td>TR04</td>
<td>Accessibility</td>
<td>The system must ensure that everyone can access the pages, regardless of whether they have any handicap or not, or the Web browser they use.
</td>
</tr>
</table>

#### **3.3. Restrictions**
<table>
<td> 

**Identifier**
</td>
<td>

**Name**
</td>
<td>

**Description**
</td>
</tr>
<tr>
<td>R01</td>
<td>Restriction</td>
<td>Description
</td>
</tr>
</table>

---


## A3: Information Architecture

> Brief presentation of the artifact goals.


### 1. Sitemap

> Sitemap presenting the overall structure of the web application.  
> Each page must be identified in the sitemap.  
> Multiple instances of the same page (e.g. student profile in SIGARRA) are presented as page stacks.


### 2. Wireframes

> Wireframes for, at least, two main pages of the web application.
> Do not include trivial use cases (e.g. about page, contacts).


#### UIxx: Page Name

#### UIxx: Page Name


---


## Revision history

Changes made to the first submission:
1. Item 1
1. ...

***
GROUP0202, DD/MM/20YY

* Daniel Gago, up202108791@edu.fe.up.pt
* Eduardo Oliveira, up202108843@edu.fe.up.pt
* José Santos, up202108729@edu.fe.up.pt
* Máximo Pereira, up202108887@edu.fe.up.pt

