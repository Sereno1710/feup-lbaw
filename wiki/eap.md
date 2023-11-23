# EAP: Architecture Specification and Prototype

## A7: Web Resources Specification

This artifact provides an overview of the forthcoming web API, emphasizing the required resources along with their characteristics and associated JSON responses. The API encompasses functionalities for creating, reading, updating, and, if applicable, deleting operations for each resource.

### 1. Overview

This section describes the modules that will be part of the application.

| Modules             | Description                                                                                                         |
| ------------------- | ------------------------------------------------------------------------------------------------------------------- |
| M01: Authentication | Web resources for user authentication. These encompass key functionalities such as user login/logout, registration. |
| M02: Users          | Web resources associated with searching user information like what auctions he created or followes.                 |
| M03: Auctions       | Web resources associated with auctions like creating, bidding, commenting, following/unfollowing.                   |
| M04: Search         | Web resources associated to the search feature. Searching for users and auctions                                    |
| M05: Administration | Web resources associated web control like managing users and auctions.                                              |
| M06: Balance        | Web resources associated with managing user balance on the platform.                                                |

### 2. Permissions

This section has the permissions used in our modules, necessary to access its data and features.

| Identifier | Name           | Description                |
| ---------- | -------------- | -------------------------- |
| VIS        | Visitor        | An unauthenticated user    |
| USR        | User           | An authenticated user      |
| OWN        | Owner          | Owner of an auction        |
| SYS        | System Manager | Manages the platform       |
| ADM        | Admin          | Administrates the platform |

### 3. OpenAPI Specification

This section includes the [SoundSello OpenAPI Specification](https://git.fe.up.pt/lbaw/lbaw2324/lbaw2322/-/blob/main/docs/a7_openapi.yaml).

```yaml
openapi: 3.0.0

info:
 version: '1.0'
 title: 'SoundSello Web API'
 description: 'Web Resources Specification (A7) for SoundSello'

servers:
- url: https://lbaw2322.lbaw.fe.up.pt
  description: Production server

externalDocs:
 description: More info here.
 url: https://git.fe.up.pt/lbaw/lbaw2324/lbaw2322/wiki/eap

tags:
 - name: 'M01: Authentication'
 - name: 'M02: Users'
 - name: 'M03: Auctions'
 - name: 'M04: Search'
 - name: 'M05: Administration'

paths:

############################################ AUTENTICATION ############################################

######### LOGIN #########

  /login:

    get:
      operationId: R101
      summary: 'R101: Login Form'
      description: 'Provide login form. Access: VIS'
      tags:
        - 'M01: Authentication'

      responses:
        '200':
          description: 'OK. Show log-in UI'

    post:
      operationId: R102
      summary: 'R102: Login Action'
      description: 'Processes the login form submission. Access: VIS'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urllencoded:
            schema:
              properties:
                email:
                  type: string
                  format: email
                password:
                  type: string
                  format: password
              required:
                  - email
                  - password

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'OK. You are in. Redirect to homepage.'
                  value: '/home'
                302Failure:
                  description: 'You shall not pass. Redirect again to login form.'
                  value: '/login'

######### LOGOUT #########

  /logout:

    get:
      operationId: R103
      summary: 'R103 : Logout Action'
      description: 'Logout the current logged user. Access: USR, SYS ,ADM'
      tags:
        - 'M01: Authentication'

      responses:
        '302':
          description: 'Redirect after processing logout.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful logout. Redirect to public feed.'
                  value: '/'

######### REGISTER #########

  /register:

    get:
      operationId: R104
      summary: 'R104 : Register Form'
      description: 'Register a new user. Access: VIS'
      tags:
        - 'M01: Authentication'

      responses:
        '200':
          description: 'Ok. Lets Sign-up.'

    post:
      operationId: R105
      summary: 'R105 : Register Action'
      description: 'Processes the new user registration form submission. Access: VIS'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                username:
                  type: string
                email:
                  type: string
                  format: email
                password:
                  type: string
                  format: password
                confirm_password:
                  type: string
                  format: password
                date_of_birth:
                  type: string
                  format: date
                address:
                  type: string
                  format: address
              required:
                - username
                - email
                - password
                - confirm_password
                - date_of_birth;
## ask address----------------

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              example:
                  302Success:
                    description: 'Successful registration. Redirect to home page.'
                    value: '/home'
                  302Failure:
                    description: 'Failed registration. Redirect again to register form.'
                    value: '/register'


############################################ USERS ############################################

######### PROFILE #########

  /user/{id}:

    get:
      operationId: R201
      summary: 'R201: View user profile'
      description: 'Show the profile for an individual user, Access: CRE, ADM, SYS , VIS, CRE'
      tags:
        - 'M02: Users'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: True

      responses:
        '200':
          description: 'OK. Show the profile for an individual user'

######### VIEW USER AUCTIONS #########

/users/{id}/auctions:

      get:
        operationId: R202
        summary: 'R202: View user's auctions'
        description: 'Show auctions owned by a certain user, Access: CRE, SYS, ADM'
        tags:
          - 'M02: Users'

        parameters:
          -in: path
           name: id
           schema:
            type: integer
          required: True

        responses:
         '200':
           description: 'OK. Show list of auctions of an individual user'

######### VIEW USER FOLLOWED AUCTIONS #########

/users/{id}/followed_auctions:

      get:
        operationId: R203
        summary: 'R203: View user's follows auctions'
        description: 'Show auctions followed by a certain user, Access: CRE, SYS, ADM'
        tags:
          - 'M02: Users'

        parameters:
          -in: path
           name: id
           schema:
            type: integer
          required: True

        responses:
         '200':
           description: 'OK. Show list of auctions followed by a user'


############################################ AUCTIONS ############################################

######### CREATE AUCTION #########

  /auction/create:

    post:
      operationId: R301
      summary: 'R301: Create auction action'
      description: 'Auction post. Access: USR, SYS, ADM'
      tags:
        - 'M03: Auctions'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                media:
                  type: string
                  format: binary
                description:
                  type: string
                initial_price:
                  type: integer
                initial_date:
                  type: string
                  format: date
                end_date:
                  type: string
                  format: date

      responses:
        '201':
                    description: 'Auction created successfully.'
          headers:
            Location:
              schema:
                type: string


######### VIEW AUCTION DETAILS #########

    /auctions/{id}:

      get:
        operationId: R302
        summary: 'R302: Retrieve details of an auction'
        description: 'Retrieve details of a specific auction. Access: VIS , USR, CRE , SYS , ADM'
        tags:
          - 'M03: Auctions'

        parameters:
          - name: id
            in: path
            required: true
            description: 'Unique identifier of the auction.'
            schema:
              type: string

        responses:
          '200':
            description: 'Auction details retrieved successfully.'
            content:
              application/json:
                schema:
                  type: object
                  properties:
                    title:
                      type: string
                    description:
                      type: string
                    initial_price:
                      type: number
                    current_price:
                      type: number
                    initial_date:
                      type: string
                    end_date:
                      type: string
                    owner:
                      type: object
                      properties:
                        id:
                          type: string
                        username:
                          type: string
                  ## ver categorias e estados
          '404':
            description: 'Not found. Auction does not exist.'



##### FOLLOW AUCTION #####

  /auctions/{id}/follow:

    post:
      operationId: R303
      summary: 'R303: Follows Auction.'
      description: 'Follows auction. Access: USR, SYS, ADM'
      tags:
        - 'M03: Auctions'

      requestBody:
          required: true
          content:
            application/x-www-form-urlencoded:
              schema:
                type: object
                properties:
                  id:
                    type: integer
                required:
                  - id

      responses:
        '200':
          description: 'Ok. You followed a user.'
        '403':
          description: 'Forbiden action.'

######### UNFOLLOW AUCTION #########

  /auctions/{id}/unfollow:

    post:
      operationId: R304
      summary: 'R304: Unfollows auction.'
      description: 'Unfollows auction. Access: USR, SYS , ADM'
      tags:
        - 'M03: Auctions'

      requestBody:
          required: true
          content:
            application/x-www-form-urlencoded:
              schema:
                type: object
                properties:
                  id:
                    type: integer
                required:
                  - id

      responses:
        '200':
          description: 'Ok. You unfollowed an auction.'
        '403':
          description: 'Forbiden action.'


######### BID IN AUCTION #########

  /auctions/{id}/bid:

    post:
      operationId: R305
      summary: 'R305: Place Bid'
      description: 'Place Bid. Access: USR, SYS, ADM'
      tags:
        - 'M03: Auctions'

      parameters:
        - name: auction_id
          in: path
          required: true
          description: 'Unique identifier of the auction.'
          schema:
            type: string

      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              properties:
                bid_amount:
                  type: number
      responses:
        '200':
          description: 'New Bid.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                  new_highest_bid:
                    type: number

######### COMMENT IN AUCTION #########

/auctions/{id}/comment:

    post:
      operationId: R306
      summary: 'R306: Add a comment to an auction'
      description: 'Add a comment to a specific auction. Access: USR, CRE , SYS, ADM'
      tags:
        - 'M03: Auctions'

      parameters:
        - name: id
          in: path
          required: true
          description: 'Unique identifier of the auction.'
          schema:
            type: string

      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              properties:
                text:
                  type: string
                user_id:
                  type: string
                timestamp:
                  type: string

      responses:
        '201':
          description: 'Comment added successfully.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  comment:
                    type: string
                  id:
                    type: string
                  date:
                    type: string

        '400':
          description: 'Bad request. Invalid comment data.'
        '401':
          description: 'Unauthorized. User not authenticated.'
        '403':
          description: 'Forbidden. User does not have permission to add comments.'



############################################ SEARCH ############################################

  /api/user:

    get:
      operationId: R401
      summary: 'R401 : Search users'
      description: 'Search users. Access: VIS, USR, SYS,ADM'
      tags:
        - 'M04: Search'

      parameters:
        - in: query
          name: search
          description: 'Search content'
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Success. Returns a list of users information'


####### SEARCH AUCTION ######

/api/auctions:

    get:
      operationId: R402
      summary: 'R402: Search for auctions'
      description: 'Search for auctions based on specific criteria. Access: AUTH'
      tags:
        - 'Auctions'

      parameters:
        - in: query
          name: search
          description: 'Search content'
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Success. Returns a list of auctions information'

############################################ ADMINISTRATION ############################################

######### ADMIN PAGE #########

  /admin:

    get:
      operationId: R501
      summary: 'R501: View admin page'
      description: 'Show admin page UI, Access: ADM'
      tags:
        - 'M05: Administration'

      responses:
        '200':
          description: 'OK. Show the admin page UI'
        '403':
          description: 'This action is unauthorized.'

  /admin/users:

    get:
      operationId: R502
      summary: '502: View all users'
      description: 'View all users'
      tags:
        - 'M05'

        responses:
          '200':
            description: 'OK. Show all users page UI'
          '403':
            description: 'This action is unauthorized.'

/auctions/{id}:

    put:
      operationId: R503
      summary: 'R503: Change the state of an auction'
      description: 'Change the state of a specific auction. Access: CRE, SYS , ADM'
      tags:
        - 'Auctions'

      parameters:
        - name: id
          in: path
          required: true
          description: 'Unique identifier of the auction.'
          schema:
            type: string

      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              properties:
                auction_state:
                  type: string

      responses:
        '200':
          description: 'Auction state changed successfully.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  message:
                    type: string
                  new_state:
                    type: string
        '400':
          description: 'Bad request. Invalid status change data.'
        '401':
          description: 'Unauthorized. User not authenticated.'
        '403':
          description: 'Forbidden. User does not have permission to change the status.'
        '404':
          description: 'Not found. Auction does not exist.'



...
```

---

## A8: Vertical prototype

In this vertical prototype, we incorporated all the specified features outlined in both the general and theme-specific website requirements documents. We successfully addressed all high-priority user stories, as detailed below. Through this process, we gained valuable experience in navigating and utilizing the provided architecture and its associated technologies. Our implementation covered the visualization of various pages, including home, personal profiles, admin interfaces, search functionalities, and pages for other users. Additionally, we managed all aspects of auction logistics, encompassing the creation of auctions, bidding processes, and related functions.

### 1. Implemented Features

#### 1.1. Implemented User Stories

| User Story reference | Name                         | Priority | Description                                                                                                                                                                                                                                     |
| -------------------- | ---------------------------- | -------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| US01                 | See Home Page                | High     | As a user, I want to be able to see the home page whenever I enter the website so that I can start using the website.                                                                                                                           |
| US02                 | View Active Auctions         | High     | As a user, I want to be able to view a list of currently active auctions so that I can bid on items that are currently being auctioned.                                                                                                         |
| US03                 | View Auction Details         | High     | As a user, I want to be able to click on an auction from the list to view its detailed information, including item description, current highest bid, and auction end time, so that I can get more insight into the product.                     |
| US04                 | Exact match search           | High     | As a user, I want to be able to search with a specific text so that I can quickly find a specific item.                                                                                                                                         |
| US05                 | Full text search             | High     | As a user, I want to be able to search words or phrases within extensive text so that I can find the item I want faster.                                                                                                                        |
| US06                 | View User Profiles           | High     | As a user, I want to be able to view other user profiles that are registered on the platform so that I can see their activity and items they have listed or bid on.                                                                             |
| US10                 | Log in                       | High     | As a user, I want to be able to log in to my account so that I can manage my settings and track my activity securely.                                                                                                                           |
| US11                 | Register Account             | High     | As a user, I want to be able to register for a new account so that I can participate in auctions and save favorite items.                                                                                                                       |
| US13                 | Log out                      | High     | As an authenticated user, I want the ability to log out of my account so that I can end my session in a secure way preventing it from unauthorized access.                                                                                      |
| US14                 | Create Auction               | High     | As an authenticated user, I want to be able to create a new auction so that I can sell items to other users on the website.                                                                                                                     |
| US15                 | Bid on Auction               | High     | As an authenticated user, I want to be able to place bids on active auctions so that I can use it for making purchases and bidding on the website.                                                                                              |
| US16                 | View Own Profile             | High     | As an authenticated user, I want a section where I can see my own profile so that I can see all my activity and information about my account.                                                                                                   |
| US17                 | Edit Profile                 | High     | As an authenticated user, I want to be able to edit and update my user profile information so that I can keep my personal details and preferences updated.                                                                                      |
| US18                 | Deposit Money on Account     | High     | As an authenticated user, I want to be able to deposit money into my account so that I can use that money to participate in active auctions.                                                                                                    |
| US19                 | Withdraw Money from Account  | High     | As an authenticated user, I want to be able to withdraw money from my account into the bank.                                                                                                                                                    |
| US29                 | View Auction Bidding History | High     | As a seller, I want to be able to see all of the bids made in this auction, so that I can see the bids rise.                                                                                                                                    |
| US35                 | View Auction Bidding History | High     | As a seller, I want to be able to see all of the bids made in this auction, so that I can see the bids rise.                                                                                                                                    |
| US36                 | Disable Auction              | High     | As a seller, I want to be able to disable my auction if no one has submitted a bid so that I can keep my item if I change my mind. Whilst being able to make that same auction active again at another time.                                    |
| US38                 | Approve Auction              | High     | As a system manager, I want to be able to approve pending auctions, so that they can be ready to be bid on.                                                                                                                                     |
| US44                 | Manage User Accounts         | High     | As an administrator, I want to have the ability to manage users, including the ability to edit existing user profiles, create new accounts, search for certain users, and add system managers, so that I can have total control over the users. |

...

### 1.2. Implemented Web Resources

#### Module M01: Authentication

| Web Resource Reference | URL            |
| ---------------------- | -------------- |
| R101: Login Form       | GET /login     |
| R102: Login Action     | POST /login    |
| R103: Logout Action    | GET /logout    |
| R104: Register Form    | GET /register  |
| R105: Register Action  | POST /register |

#### Module M02: Users

| Web Resource Reference         | URL                 |
| ------------------------------ | ------------------- |
| R201: View Home Page           | GET /               |
| R202: View Home Page           | GET /home           |
| R204: View Own Profile         | GET /profile        |
| R205: Edit User Profile        | GET /profile/edit   |
| R206: Update User Profile      | PUT /profile/update |
| R207: View User Profiles       | GET /user/{userId}  |
| R208: View About Us Page       | GET /about-us       |
| R209: View FAQ Page            | GET /faq            |
| R210: View Contacts Page       | GET /contacts       |
| R211: View Terms of Use Page   | GET /terms-of-use   |
| R212: View Privacy Policy Page | GET /privacy-policy |

#### Module M03: Auction

| Web Resource Reference         | URL                    |
| ------------------------------ | ---------------------- |
| R301: View Active Auctions     | GET /auctions          |
| R302: View Create Auction Page | GET /auction/submit    |
| R303: Submit an Auction        | POST /auction/create   |
| R304: View an Auction          | GET /auction/{id}      |
| R305: Bid on Auction           | POST /auction/{id}/bid |

#### Module M04: Search

| Web Resource Reference | URL                 |
| ---------------------- | ------------------- |
| R401: Search Users     | GET /users/search   |
| R402: Search Auctions  | GET /auction/search |

#### Module M05: Administration

| Web Resource Reference       | URL                           |
| ---------------------------- | ----------------------------- |
| R501: View Admin Page        | GET /admin                    |
| R502: View All Users         | GET /admin/users              |
| R503: Demote User Account    | POST /admin/users/demote      |
| R504: Promote User Account   | POST /admin/users/promote     |
| R505: Disable User Account   | POST /admin/users/disable     |
| R506: View Pending Transfers | GET /admin/transfers          |
| R507: Approve Transfer       | POST /admin/transfers/approve |
| R508: Reject Transfer        | POST /admin/transfers/reject  |
| R509: View All Auctions      | GET /admin/auctions           |
| R510: Approve Auction        | POST /admin/auctions/approve  |
| R511: Reject Auction         | POST /admin/auctions/reject   |
| R512: Pause Auction          | POST /admin/auctions/pause    |
| R513: Resume Auction         | POST /admin/auctions/resume   |
| R514: Disable Auction        | POST /admin/auctions/disable  |

#### Module M06: Balance

| Web Resource Reference        | URL                    |
| ----------------------------- | ---------------------- |
| R601: View Balance Page       | GET /balance/deposit   |
| R602: Make a Deposit Request  | POST /balance/deposit  |
| R603: Make a Withdraw Request | POST /balance/withdraw |

## 2. Changes to Database

- New table: 'moneys';
- New insert values for the new table;
- New triggers: 'deposit' and 'withdrawal';
- Fixed error in relational schema;
- New states: 'report_state' and 'transfer_state';
- New attributes in table users: name, is_anonymizing and biography;
- New state in reports: 'report_state';
- Fix trigger: 'anonymaze_user_data';

## 3. Prototype

For this prototype we focused on implementing the main features of an online instruments auctions website. This includes a basic but functional design, making it easy to test every single feature.

The prototype is available at https://lbaw2322.lbaw.fe.up.pt

Credentials:

- Admin user: eduardo@email.com | 1234
- Regular user: daniel@email.com | 1234

The code is available at https://git.fe.up.pt/lbaw/lbaw2324/lbaw2322

## Revision history

No changes made yet.

---

GROUP0202, 23/11/2023

- Daniel Gago, up202108791@edu.fe.up.pt
- Eduardo Oliveira, up202108843@edu.fe.up.pt
- José Santos, up202108729@edu.fe.up.pt
- Máximo Pereira, up202108887@edu.fe.up.pt (Editor)
