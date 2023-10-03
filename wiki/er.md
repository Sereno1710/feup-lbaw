# **ER: Requirements Specification Component**

**Project vision:** SoundSello is being developed to facilitate music lovers and musical instrument collectors find what they want or need by bidding or auctioning instruments of all kinds.

## **A1: SoundSello**

SoundSello is being developed by a small group of students as a product targeted to those who want to buy or sell musical instruments.

The main goal of the project is to develop a web-based auction system for musical instruments with the purpose of assisting those in search of them. This tool can only be used by anyone above 18. To begin bidding or selling, users will need to create an account and log in. To sell an instrument, the user has to send the product to our headquarters so we can evaluate the veracity of the product. The system will be managed by system managers who will handle auctions and account-related issues.

Auctions will have a countdown timer, bidders can see it and the current highest auction at any given time, and they can bid as long as they are not the current highest bidder. If someone bids when the auction has less than 15 minutes remaining, the deadline is increased by 30 minutes. When the timer hits zero, the highest bidder is announced as the winner.

Users will be divided into several groups, visitors, authenticated users, system managers, as mentioned before and administrators.

Visitors are unregistered users with minimal access to the site features being only able to see active auctions and profiles, as well as FAQ, About Us and contacts. After they log in/sign in, they become authenticated users.

Authenticated users are able to sell or bid on products and if so, they become either a bidder or seller.

A bidder is a user whose bids have been submitted and a seller when the user submits an auction. They are both able to see the bidding history of that specific auction/auctions. 

Bidders can rate sellers and receive notifications about an auction in which they are bidding.

Sellers can cancel auctions (if the requirements are met) as well as receive notifications about who won their auction.

System managers are users who were promoted by an administrator and are capable of approving auctions, as well as managing them. They can also ban/unban users.  

Administrator is another group of users, who can manage user accounts and have control of the whole system. 

The online auction will have an adaptive design, allowing users to be on the system in any type of device or browser. It will also be easy to navigate through the system giving the user a better experience.

## **Main Features:**

### **User:** 
* **Exact match search auctions**
* **Full text search auctions**
* Search filters
* **Log in**
* **Register fccount**
* Recover password
* **View active auctions**
* **View user profiles**


### **Authenticated User:**
* **Log out**
* **Submit auction**
* **Bid on auction**
* Deposit money on account
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
* Main Features
* Contacts

## A2: Actors and User stories

This artifact contains actors and user stories. Represent the type of users that will use our website, as well as the features it is going to have for each type of user.

### 1. Actors

The actors of SoundSello are represented in Figure 1 and described in Table 1.

![Actors](/wiki/resources/actors.png)

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
Generic actor that has access to all information, active auctions and profiles of the website.
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

Authenticated users are able to deposit money into their account, follow auctions, bid in auctions and create their own auctions. They are also able to manage their own profile. 

</td>
</tr>
<tr>
<td>

Bidder

</td>
<td>

Bidders are authenticated users who are participating in a auction by having bid on it. They can see all the current auctions that they are bidding on and receive notifications when a change occurs in them.

</td>
</tr>
<tr>
<td>

Seller

</td>
<td>

Sellers are authenticated users who created an auction. They are able to delete and edit their auctions. 

</td>
</tr>
<tr>
<td>

System Manager

</td>
<td>

System Manager are authenticated users who moderate the system, being able to manage the auctions as well as temporarily banning accounts.

</td>
</tr>
<tr>
<td>

Administrator

</td>
<td>

Administrator are able to manage accounts (changing account details, deleting accounts), as well as managing category filters.

</td>
</tr>
</table>
Table 1: Actors descriptions


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
<td>View Auction Details</td>
<td>High</td>
<td>As a user, I want to be able to click on an auction from the list to view its detailed information, including item description, current highest bid, and auction end time, so that I can get more insight into the product.
</td>
</tr>
<tr>
<td>US04</td>
<td>Exact match search</td>
<td>High</td>
<td>As a user, I want to be able to search with a specific text so that I can quickly find a specific item.</td>
</tr>
<tr>
<td>US05</td>
<td>Full text search</td>
<td>High</td>
<td>As a user, I want to be able to search words or phrases within extensive text so that I can find the item I want faster.</td>
</tr>
<tr>
<td>US06</td>
<td>View User Profiles</td>
<td>High</td>
<td>As a user, I want to be able to view other user profiles that are registered in the platform so that I can see their activity and items they have listed or bid on.</td>
</tr>
<tr>
<td>US07</td>
<td>Search Filters</td>
<td>Medium</td>
<td>As a user, I want to be able to apply filters so that I can refine my search results based on instrument type, price, material quality and date.</td>
</tr>
<tr>
<td>US08</td>
<td>Consult FAQ / Help</td>
<td>Medium</td>
<td>As a user, I want a ‘FAQ / Help’ section so that I can find a solution to a problem.</td>
</tr>
<tr>
<td>US09</td>
<td>See "About us" Page</td>
<td>Low</td>
<td>As a user, I want to be able to see an "About Us" page, so that I can know more about the website and its creators. </td>
</tr>
</table>
Table 2: User stories for the User

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
<td>US10</td>
<td>Log in</td>
<td>High</td>
<td>As a user, I want to be able to log in to my account so that I can manage my settings and track my activity securely.
</td>
</tr>
<tr>
<td>US11</td>
<td>Register Account</td>
<td>High</td>
<td>As a user, I want to be able to register for a new account so that I can participate in auctions and save favorite items.</td>
</tr>
<tr>
<td>US12</td>
<td>Recover Password</td>
<td>Medium</td>
<td>As a user, I want to be able to recover my password in case I forget it so that I can regain access to my account and continue to use the website.
</td>
</tr>
</table>
Table 3: User stories for the Visitor

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
<td>US13</td>
<td>Log out</td>
<td>High</td>
<td>As an authenticated user, I want the ability to log out of my account so that I can end my session in a secure way preventing it from unauthorized access.
</td>
</tr>
<tr>
<td>US14</td>
<td>Create Auction</td>
<td>High</td>
<td>As an authenticated user, I want to be able to create a new auction so that I can sell items to other users on the website.</td>
</tr>
<tr>
<td>US15</td>
<td>Bid on Auction</td>
<td>High</td>
<td>As an authenticated user, I want to be able to place bids on active auctions so that I can use it for making purchases and bidding on the website.</td>
</tr>
<tr>
<td>US16</td>
<td>View Own Profile</td>
<td>High</td>
<td>As an authenticated user, I want a section where I can see my own profile so that I can see all my activity and information about my account.</td>
</tr>
<tr>
<td>US17</td>
<td>Edit Profile</td>
<td>High</td>
<td>As an authenticated user, I want to be able to edit and update my user profile information so that I can keep my personal details and preferences updated.</td>
</tr>
<tr>
<td>US18</td>
<td>View My Bidding History</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to view all the bids I've done on the platform so that I can keep track of my history.</td>
</tr>
<tr>
<td>US19</td>
<td>Deposit Money on Account</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to deposit money into my account so that I can use that money to participate in active auctions.</td>
</tr>
<tr>
<td>US20</td>
<td>View My Auctions</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to view my auctions so that I can see all the items I'm selling and all the items I've bought.</td>
</tr>
<tr>
<td>US21</td>
<td>View Followed Auctions</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to see all the auctions I've followed so that I can keep track of those auctions.</td>
</tr>
<tr>
<td>US22</td>
<td>Delete Account</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to delete my account permanently so that I can create a brand new account using the same credentials or never use the website again.</td>
</tr>
<tr>
<td>US23</td>
<td>Like an Auction</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to like/follow an auction, so that I can receive notifications about an auction without having to bid on them.</td>
</tr>
<tr>
<td>US24</td>
<td>Receive and View Personal Notifications</td>
<td>Medium</td>
<td>As an authenticated user, I want to receive personal notifications about auctions, bids and messages so that I can stay informed on auctions I have liked or bid on.</td>
</tr>
<tr>
<td>US25</td>
<td>Support Profile Picture</td>
<td>Medium</td>
<td>As an authenticated user, I want to be able to upload and display a profile picture so that I can personalize my user profile and make it more recognizable to other users on the website.</td>
</tr>
<tr>
<td>US26</td>
<td>Report Auctions</td>
<td>Low</td>
<td>As an authenticated user, I want the ability to report auctions th3 guidelines, so that I can contribute to maintaining a safe auction environment.</td>
</tr>
<tr>
<td>US27</td>
<td>Report User Accounts</td>
<td>Low</td>
<td>As an authenticated user, I want the ability to report user accounts that seem suspicious, so that I can contribute to maintaining a safe user base.</td>
</tr>
<tr>
<td>US28</td>
<td>Comment Auctions</td>
<td>Low</td>
<td>As an authenticated user, I want the ability to comment on an auction, so that I can get answers and express my opinion.</td>
</tr>
</table>
Table 4: User stories for the Authenticated User

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
<td>US29</td>
<td>View Auction Bidding History</td>
<td>High</td>
<td>As a seller, I want to be able to see all of the bids made in this auction, so that I can see the bids rise.</td>
</tr>
<tr>
<td>US30</td>
<td>Rate Seller</td>
<td>Medium</td>
<td>As a bidder, I want to be able to give a rating from 1 to 5Ito a seller i've purchased something from, so that I can give my opinion on them.
</td>
</tr>
<tr>
<td>US31</td>
<td>New bid on Participating Auction Notification</td>
<td>Medium</td>
<td>As a bidder, I want to get a notification when someone outbids me, so that I can get a chance to send another bid immediately.</td>
</tr>
<tr>
<td>US32</td>
<td>Participating Auction Ending Notification</td>
<td>Medium</td>
<td>As a bidder, I want to get a notification when an auction I'm participating in is 1 minute away from ending, so that I can keep up with it in the closing moments.</td>
</tr>
<tr>
<td>US33</td>
<td>Participating Auction Ended Notification</td>
<td>Medium</td>
<td>As a bidder, I want to get a notification when an auction I'm participating in ends, so that I know the winning bid as soon as possible.</td>
</tr>
<tr>
<td>US34</td>
<td>Participating Auction Cancelled Notification</td>
<td>Medium</td>
<td>As a bidder, I want to get a notification when an auction I'm participating in is cancelled, so that I know exactly when that happens.</td>
</tr>
</table>
Table 5: User stories for the Bidder

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
<td>US35</td>
<td>View Auction Bidding History</td>
<td>High</td>
<td>As a seller, I want to be able to see all of the bids made in this auction, so that I can see the bids rise.
</td>
</tr>
<tr>
<td>US36</td>
<td>Cancel Auction</td>
<td>High</td>
<td>As a seller, I want to be able to cancel my auction if no one has submitted a bid so that I can keep my item if I change my mind
</td>
</tr>
<tr>
<td>US37</td>
<td>My Auction's Winner</td>
<td>Medium</td>
<td>As a seller, I want to know who won my auction, so that I can be informed about who will get my item and how much was their bid.
</td>
</tr>
</table>
Table 6: User stories for the Seller

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
<td>US38</td>
<td>Approve Auction</td>
<td>High</td>
<td>As a system manager, I want to be able to approve pending auctions, so that they can be ready to be bid on.
</td>
</tr>
<tr>
<td>US39</td>
<td>Pause Auctions</td>
<td>Medium</td>
<td>As a system manager, I want to be able to stop an auction, so that I can delay the auction process in case of technical issues, guideline violations, or other necessary reasons.
</td>
</tr>
<tr>
<td>US40</td>
<td>Resume Auctions</td>
<td>Medium</td>
<td>As an administrator, I want to be able to resume a previously paused auction, so that I can allow users to continue bidding.
</td>
</tr>
<tr>
<td>US41</td>
<td>Close Auctions</td>
<td>Medium</td>
<td>As a system manager, I want to be able to close an auction, so that I can end the bidding process without declaring a winner before the auction reaches its intended end time.
</td>
</tr>
<tr>
<td>US42</td>
<td>Delete Auctions</td>
<td>Medium</td>
<td>As a system manager, I want to be able to delete an auction, so that I can remove content that does not follow the guidelines.
</td>
</tr>
<tr>
<td>US43</td>
<td>Ban/Unban User Accounts</td>
<td>Medium</td>
<td>As a system manager, I want to be able to ban and unban user accounts, so that I can keep the user base healthy and punish those that don't follow the guidelines.
</td>
</tr>
<tr>
<td>US44</td>
<td>Manage Report System</td>
<td>Medium</td>
<td>As a system manager/administrator, I want to have the ability to manage the report system, including reviewing and responding to user and auction reports, so that I can take appropriate actions to address the reported issues.
</td>
</tr>
</table>
Table 7: User stories for the System Manager

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
<td>US45</td>
<td>Manage User Accounts</td>
<td>High</td>
<td>As an administrator, I want to have the ability to manage users, including the ability to edit existing user profiles, create new accounts, search for certain users and add system managers, so that I can have total control over the users.
</td>
</tr>
<tr>
<td>US46</td>
<td>Delete User Accounts</td>
<td>Medium</td>
<td>As an administrator, I want to be able to delete user accounts, so that I can remove inactive or unauthorized users from the system completely.
</td>
</tr>
<tr>
<td>US47</td>
<td>Manage Filter Categories</td>
<td>Low</td>
<td>As an administrator, I want to be able to manage filter categories, so that I can add or edit categories when deemed necessary.
</td>
</tr>
<td>US48</td>
<td>Access System Manager Activity Log</td>
<td>Low</td>
<td>As an administrator, I want to access a system manager activity log, which includes records of all system manager's actions and they time they happened, so that I can investigate any irregularities or issues effectively.
</td>
</tr>
</table>
Table 8: User stories for the Administrator

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
<td>A user can only bid if their bid is higher than the current highest bid. A user cannot bid if his bid is the current highest.
</td>
</tr>
<tr>
<td>BR05</td>
<td>Auction Deadline</td>
<td>When a bid is made in the last 15 minutes of the auction, the auction deadline is extended by 30 minutes.
</td>
</tr>
<tr>
<td>BR06</td>
<td>Seller Comments</td>
<td>A seller can comment on their own auctions.
</td>
</tr>
<tr>
<td>BR07</td>
<td>Seller Actions</td>
<td>A seller cannot rate themselves, follow their own auction, or bid on it. 
</td>
</tr>
<tr>
<td>BR08</td>
<td>Dates</td>
<td>The date of an incoming bid has to be higher than the date of the current highest bid. The date when an auction closed has to be higher than the date of the last bid.
</td>
</tr>
<tr>
<td>BR09</td>
<td>Pausing Auctions</td>
<td>Auctions should be automatically paused when the system is down. This ensures that the bidding process is not affected by technical errors.
</td>
</tr>
<tr>
<td>BR10</td>
<td>Minimum Age</td>
<td>A user needs to be at least 18 years old to use this website.
</td>
</tr>
<tr>
<td>BR11</td>
<td>Closing Auctions</td>
<td>An auction is only closed when the bidder confirms they got their item. 
</td>
</tr>
</td>
</tr>
</table>
Table 9: Business rules

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
<td>

**TR02**
</td>
<td>

**Accessibility**
</td>
<td>

**The system must ensure that everyone can access the pages, regardless of whether they have any handicap or not, or the Web browser they use.**
</td>
</tr>
<tr>
<td>TR03</td>
<td>Robustness</td>
<td>The system must be prepared to handle and continue operating when runtime errors occur.
</td>
</tr>
<tr>
<td>

**TR04**
</td>
<td>

**Usability**
</td>
<td>

**The system should be simple and intuitive.**
</td>
</tr>
<tr>
<td>TR05</td>
<td>Scalability</td>
<td>The system must be prepared to deal with the growth in the number of users and their actions.
</td>
</tr>
<tr>
<td>

**TR06**
</td>
<td>

**Security**
</td>
<td>

**The system should protect any user's information, so that only the administrators of SoundSello and the user themselves can access a user's data.**
</td>
</tr>
<tr>
<td>TR07</td>
<td>Availability</td>
<td>The system must have an uptime of 99% or more.
</td>
</tr>
<tr>
<td>TR08</td>
<td>Database</td>
<td>The system should have a reliable database to store information.
</td>
</tr>
</table>
Table 10: Technical requirements

Usability and accessibility are two of the most important technical requirements because this platform only works when users use it, so it should be easy and convenient for anyone to browse our website.

Since the user will be submitting their private information to the system, we need to ensure their privacy, making security an equally important technical requirement. 


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
<td>Database</td>
<td>The database should use PostgreSQL
</td>
<tr>
<td>R02</td>
<td>Deadline</td>
<td>This project should be ready to use by the end of the semester
</td>
<tr>
<td>R03</td>
<td>Payment Processor</td>
<td>This project has PayPal as its payment processing service.
</td>
</tr>
</table>
Table 11: Other restrictions

---


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
2. Links to a page to deposit money into the user account (left), submit an auction into the platform (middle) and view all auctions available (right).
3. Link to the user profile.
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
4. Footer that contains all the links to "About Us", FAQ, Contacts, Terms of Use and Privacy Policy
5. Breadcrumbs to help the user navigate.
6. Search bar to help the user find auctions and other users.
7. Links to a page with the user's complete bidding history (left) and complete seller history (right).
8. Link to edit profile page, where you can change name and profile picture (only visible if it's the user's own profile).
9. Each auction card has a link to the auction in question.
10. View all of your followed auctions.

#### UI10: View Auction

![Auction](/wiki/resources/auction.png)

Figure 5: Auction page

1. Link to the home page.
2. Links to a page to deposit money into the user account (left), submit an auction into the platform (middle) and view all auctions available (right).
3. Link to the user profile.
4. Footer that contains all the links to "About Us", FAQ, Contacts, Terms of Use and Privacy Policy
5. Breadcrumbs to help the user navigate.
6. Search bar to help the user find auctions and other users.
7. Image of the auctioned item.
8. Section displaying all user bids.
9. Details about the specific item.
10. Countdown timer displaying remaining auction time to users.

#### UI09: Active Auctions Page

![Auctions](/wiki/resources/active_auctions.png)

Figure 6: Active auctions page

1. Link to the home page.
2. Links to a page to deposit money into the user account (left), submit an auction into the platform (middle) and view all active auctions (right).
3. Link to the user profile.
4. Footer that contains all the links to "About Us", FAQ, Contacts, Terms of Use and Privacy Policy
5. Breadcrumbs to help the user navigate.
6. Search bar to help the user find auctions and other users.
7. Button for using filters to assist users in searching auctions.
8. Each auction card has a link to the auction in question.

---


## Revision history

No changes have been made to the first submission yet.

***
GROUP0202, 03/10/2023

* Daniel Gago, up202108791@edu.fe.up.pt
* Eduardo Oliveira, up202108843@edu.fe.up.pt
* José Santos, up202108729@edu.fe.up.pt
* Máximo Pereira, up202108887@edu.fe.up.pt

