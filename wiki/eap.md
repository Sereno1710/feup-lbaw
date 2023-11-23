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
| M04: Administration | Web resources associated web control like managing users and auctions.                                              |
| M05: Balance        | Web resources associated with managing user balance on the platform.                                                |

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
  - name: 'M04: Balance'
  - name: 'M05: Administration'

paths:

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
              required:
                - username
                - email
                - password
                - confirm_password
                - date_of_birth;
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
  /:
    get:
      operationId: R201
      summary: 'R201: Home Page'
      description: 'Get the home page, Access: CRE, ADM, SYS , VIS, CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the home page'

  /home:
    get:
      operationId: R202
      summary: 'R202: Home Page'
      description: 'Get the home page, Access: CRE, ADM, SYS , VIS, CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the home page'

  /about-us:
    get:
      operationId: R203
      summary: 'R203: About Us'
      description: 'Get the about us page, Access: CRE, ADM, SYS , VIS, CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the about us page'

  /faq:
    get:
      operationId: R204
      summary: 'R204: FAQ'
      description: 'Get the FAQ page, Access: CRE, ADM, SYS , VIS, CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the FAQ page'

  /contacts:
    get:
      operationId: R205
      summary: 'R205: Contacts'
      description: 'Get the contacts page, Access: CRE, ADM, SYS , VIS, CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the contacts page'

  /terms-of-use:
    get:
      operationId: R206
      summary: 'R206: Terms of Use'
      description: 'Get the terms of use page, Access: CRE, ADM, SYS , VIS, CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the terms of use page'

  /privacy-policy:
    get:
      operationId: R207
      summary: 'R207: Privacy Policy'
      description: 'Get the privacy policy page, Access: CRE, ADM, SYS , VIS, CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the privacy policy page'

  /user/{id}:

    get:
      operationId: R208
      summary: 'R208: View user profile'
      description: 'Show the profile for an individual user, Access: CRE, ADM, SYS , VIS, CRE'
      tags:
        - 'M02: Users'

      parameters:
        - in: path
          name: id
          description: 'User ID'
          schema:
            type: integer
          required: True

      responses:
        '200':
          description: 'OK. Show the profile for an individual user'

  /users/{id}/auctions:

      get: 
        operationId: R209
        summary: 'R209: View user auctions'
        description: 'Show auctions owned by a certain user, Access: CRE, SYS, ADM'
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
           description: 'OK. Show list of auctions of an individual user'

  /users/{id}/followed_auctions:
    get:
      operationId: R210
      summary: 'R210: View users follows auctions'
      description: 'Show auctions followed by a certain user. Access: CRE, SYS, ADM'
      tags:
        - 'M02: Users'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'OK. Show list of auctions followed by a user'

  /users/search:
    get:
      operationId: R211
      summary: 'R211: Search users'
      description: 'Search for users'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the search results'


  /profile:
    get:
      operationId: R212
      summary: 'R212: View profile'
      description: 'View user profile, Access: CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the user profile'

  /profile/edit:
    get:
      operationId: R213
      summary: 'R213: Edit profile'
      description: 'Edit user profile, Access: CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Returns the edit profile page'

  /profile/update:
    post:
      operationId: R214
      summary: 'R214: Update profile'
      description: 'Update user profile, Access: CRE'
      tags:
        - 'M02: Users'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                username:
                  type: string
                name:
                  type: string
                email:
                  type: string
                  format: email
                password:
                  type: string
                  format: password
                biography:
                  type: string
                street:
                  type: string
                city:
                  type: string
                zip_code:
                  type: string
                country:
                  type: string
                image:
                  type: binary
      responses:
          '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              example:
                  302Success:
                    description: 'Successful profile update. Redirect to profile.'
                    value: '/profile'
                  302Failure:
                    description: 'Failed registration. Redirect again to edit form.'
                    value: '/profile/edit'
    put:
      operationId: R215
      summary: 'R215: Update profile'
      description: 'Update user profile, Access: CRE'
      tags:
        - 'M02: Users'
      responses:
        '200':
          description: 'OK. Profile updated successfully'

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
              example: '/auctions/{id}'

  /auctions/{id}:
    get:
      operationId: R302
      summary: 'R302: Retrieve details of an auction'
      description: 'Retrieve details of a specific auction. Access: VIS, USR, CRE, SYS, ADM'
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
        '404':
          description: 'Not found. Auction does not exist.'

    post:
      operationId: R303
      summary: 'R303: Change the state of an auction'
      description: 'Change the state of a specific auction. Access: SYS, ADM'
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

  /auction/submit:
    get:
      operationId: R304
      summary: 'R304: Submit auction'
      description: 'Show auction submission form'
      tags:
        - 'M03: Auctions'
      responses:
        '200':
          description: 'OK. Returns the auction submission form'

  /auctions/{id}/follow:
    post:
      operationId: R305
      summary: 'R305: Follows Auction.'
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
          description: 'Forbidden action.'

  /auctions/{id}/unfollow:
    post:
      operationId: R306
      summary: 'R306: Unfollows auction.'
      description: 'Unfollows auction. Access: USR, SYS, ADM'
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
          description: 'Forbidden action.'

  /auctions/{id}/bid:
    post:
      operationId: R307
      summary: 'R307: Place Bid'
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

  /auctions/{id}/comment:
    post:
      operationId: R308
      summary: 'R308: Add a comment to an auction'
      description: 'Add a comment to a specific auction. Access: USR, CRE, SYS, ADM'
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

  /auction/{id}/start:
      post:
        operationId: R309
        summary: 'R309: Start an auction'
        description: 'Start an auction with the specified ID'
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
          '201':
          description: 'Auction created successfully.'
          headers:
            Location:
              schema:
                type: string
              example: '/auctions/{id}'
          '404':
            description: 'Auction not found.'


  /balance:
    get:
      operationId: R401
      summary: 'R401: View balance'
      description: 'View user balance'
      tags:
        - 'M04: Balance'
      responses:
        '200':
          description: 'OK. Returns the user balance'

  /balance/deposit:
    post:
      operationId: R402
      summary: 'R402: Deposit balance'
      description: 'Deposit balance into user account'
      tags:
        - 'M04: Balance'
      responses:
        '200':
          description: 'OK. Balance deposited successfully'

  /balance/withdraw:
    post:
      operationId: R402
      summary: 'R402: Withdraw balance'
      description: 'Withdraw balance from user account'
      tags:
        - 'M04: Balance'
      responses:
        '200':
          description: 'OK. Balance withdrawn successfully'

  /admin:
    get:
      operationId: R501
      summary: 'R501: View admin page'
      description: 'Show admin page UI. Access: ADM'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Show the admin page UI'
          content:
            text/html:
              schema:
                type: string
                example: '<html>Admin Page Content</html>'
        '403':
          description: 'This action is unauthorized.'

  /admin/users:
    get:
      operationId: R502
      summary: 'R502: View all users'
      description: 'View all users. Access: ADM'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Show all users page UI'
          content:
            text/html:
              schema:
                type: string
                example: '<html>All Users Page Content</html>'
        '403':
          description: 'This action is unauthorized.'

  /admin/transfers:
    get:
      operationId: R503
      summary: 'R503: View all transfers'
      description: 'View all transfers. Access: ADM'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Show all transfers page UI'
          content:
            text/html:
              schema:
                type: string
                example: '<html>All transfers Content</html>'
        '403':
          description: 'This action is unauthorized.'

  /admin/transfers/approve:
    post:
      operationId: R504
      summary: 'R504: Approve transfer'
      description: 'Approve a transfer'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Transfer approved successfully'

  /admin/transfers/reject:
    post:
      operationId: R505
      summary: 'R505: Reject transfer'
      description: 'Reject a transfer'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Transfer rejected successfully'

  /admin/auctions:
    get:
      operationId: R506
      summary: 'R506: View all transfers'
      description: 'View all transfers. Access: ADM'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Show all transfers page UI'
          content:
            text/html:
              schema:
                type: string
                example: '<html>All transfers Content</html>'
        '403':
          description: 'This action is unauthorized.'

  /admin/auctions/approve:
    post:
      operationId: R507
      summary: 'R507: Approve auction'
      description: 'Approve an auction'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Auction approved successfully'

  /admin/auctions/reject:
    post:
      operationId: R508
      summary: 'R505: Reject auction'
      description: 'Reject an auction'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Auction rejected successfully'

  /admin/auctions/pause:
    post:
      operationId: R509
      summary: 'R509: Pause auction'
      description: 'Pause an auction'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Auction paused successfully'

  /admin/auctions/resume:
    post:
      operationId: R510
      summary: 'R510: Resume auction'
      description: 'Resume a paused auction'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Auction resumed successfully'

  /admin/auctions/disable:
    post:
      operationId: R511
      summary: 'R511: Disable auction'
      description: 'Disable an auction'
      tags:
        - 'M05: Administration'
      responses:
        '200':
          description: 'OK. Auction disabled successfully'

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
| R307: Bid on Auction           | POST /auction/{id}/bid |
| R309: Start Auction            | POST /auction/{id}/start|

#### Module M04: Administration

| Web Resource Reference       | URL                           |
| ---------------------------- | ----------------------------- |
| R401: View Admin Page        | GET /admin                    |
| R402: View All Users         | GET /admin/users              |
| R403: Demote User Account    | POST /admin/users/demote      |
| R404: Promote User Account   | POST /admin/users/promote     |
| R405: Disable User Account   | POST /admin/users/disable     |
| R406: View Pending Transfers | GET /admin/transfers          |
| R407: Approve Transfer       | POST /admin/transfers/approve |
| R408: Reject Transfer        | POST /admin/transfers/reject  |
| R409: View All Auctions      | GET /admin/auctions           |
| R410: Approve Auction        | POST /admin/auctions/approve  |
| R411: Reject Auction         | POST /admin/auctions/reject   |
| R412: Pause Auction          | POST /admin/auctions/pause    |
| R413: Resume Auction         | POST /admin/auctions/resume   |
| R414: Disable Auction        | POST /admin/auctions/disable  |

#### Module M05: Balance

| Web Resource Reference        | URL                    |
| ----------------------------- | ---------------------- |
| R501: View Balance Page       | GET /balance/deposit   |
| R502: Make a Deposit Request  | POST /balance/deposit  |
| R503: Make a Withdraw Request | POST /balance/withdraw |

## 2. Changes to Database

- New table: 'moneys';
- New insert values for the new table;
- New triggers: 'deposit' and 'withdrawal';
- Fixed error in relational schema;
- New states: 'report_state' and 'transfer_state';
- New attributes in table users: name, is_anonymizing and biography;
- New state in reports: 'report_state';
- Fix trigger: 'anonymaze_user_data';
- Changed from owner to owner_id;

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
