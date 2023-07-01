# Online clothing and accessories store

The project was developed as a thesis using the PHP Laravel framework, as well as Docker, NGINX, MySQL, ElasticSearch.
Backend development was prioritized.

## About the project

The store is divided into groups of categories (person's gender). For each group of categories, there is a separate section of the store, where all menu items, brands (to which at least one product of this group of categories is attached), banners, etc. are displayed individually. That is, a group of categories is a large separate section (as in the store) in which everything is displayed individually for a given group of categories.

### The following functionality has been implemented:

#### _Product display_
Display is by category groups (Women/Men, etc.), categories and subcategories (subcategories and categories are provided separately for each category group).
#### _Product page_
On this page, all information about the product is displayed and it is possible to add it to the cart (for any user), as well as to leave feedback (for registered users).
#### _Banners_
They are located on the main page, individually for each group of categories.
#### _Product search_
Depending on the page from which it is carried out - the search for goods is performed taking into account the group of categories to which the page belongs. That is, if the user is in the section for men, then the search will be performed only on goods for men (_Implemented using the search engine **ElasticSearch**_).
#### _Product filtering_
Implemented filters for sizes, colors, brands, seasons, materials, prices (interval) (_Implemented using the search engine **ElasticSearch**_).
#### _Sorting_
On each page, there is provision for sorting the display of products both without applying filters and with them (_Implemented using the search engine **ElasticSearch**_).
#### _Basket_
Adding products to the cart is possible for both registered and unregistered users. There is an opportunity to choose promotional codes in the basket (more on them later).
#### _Order processing_
Also available to all store visitors.
#### _Promo Codes_
"Out of the box" (when using db:seed) in the database there are 2 promotional codes with which some functionality interacts: for each new user, a promotional code is issued for a 15% discount (with some conditions for application), for the total number of products in the cart (specified in the table).
#### _Personal office_
Each registered user has access to a personal account. There he can filter and view orders, their details and the status set by the administrator. It is also possible to change profile settings, password, mail, name, etc. The account also displays the user's active promotional codes that he can apply and their description, conditions of use. Information about the number of orders placed by the user and their amount is also displayed.
#### _Reviews_
Each registered user can leave a review about the product with a rating. Also, based on the ratings, "stars" and the number of reviews for each product are displayed on its page.
#### _Registration_
Registration is available for all users.
#### _Authorization_
Previously registered users can, of course, log in to their account. If the user has forgotten the password, there is a corresponding button on the login page to send a message to the user's mail with a link to reset the password.
#### _Roles_
Each user has a corresponding role 'user' by default. There are also "content manager", "orders manager", "feedback manager" and "super admin" roles "out of the box". According to their name, you can understand the set of their access to items admin panel and performing certain actions.
#### _Administrative panel_
The entire database can be adjusted by the administrator using the administrative panel (if access is available, see below). It displays all necessary data in tables, available for editing or creating new ones. Namely:
   
+ **Goods**. Adding, editing, deleting products, all their additional parameters (sizes, materials, brands, etc.) separately. For each product, a certain number of its sizes, which have the quantity of this same product, is fixed. For example, there are 1000 pieces of the 44th size in stock, 2000 pieces of the 45th size. All this can be adjusted when adding or editing products. Also setting a discount, linking to a banner (promotion), image, etc.
+ **Order**. Editing and viewing each order and giving it a specific status. When providing the status "Delivered" (from the box, when executing db:seed, these statuses will already be added) - for all products from a given order, the quantity of a certain size of this product will automatically be subtracted from the quantity of this product in the order (when a certain amount of a product of a certain size is taken from the warehouse and sent to the client).
+ **Properties of goods**. Seasons, sizes, materials, brands, colors - all this can be edited or added to the store.
+ **Categories**. All types of categories can also be edited, added and deleted.
+ **Message**. From the contact page, you can send feedback, which can be viewed by the relevant person (if there is a role) in this section of the admin panel.
+ **Promo codes**. You can also add and edit promotional codes and their terms of use.
+ **Banner**. Banners on the main page are also presented in the administrative panel for editing, removing or adding.
+ **Users**. So-called superadmins can edit users and give them role quality.

## Under development
- Covering Unit code with tests.

## Deployment of the project

In order to correctly deploy the project locally, you need to perform the following steps:

**_[ATTENTION!] To deploy the project locally, you need to have Docker installed (preferably. of course, you can do without deployment on a local server, but the ElasticSearch search engine will need to be installed and run additionally)_**

- Download the project;
- Open the project folder in the console and execute the following commands:
     + `docker-compose build`
     + `docker-compose up -d`
- After all the components are installed, you need to go to the console of the php container using the `docker-compose exec php bash` command;
- Then execute the following commands in the php container console:
     + `composer install`
     + `php artisan key:generate`
     + `php artisan migrate`
     + `php artisan db:seed`
- Next, execute the `php artisan search:reindex` command to index the products so that the search engine can see them and take them into account when performing searches.

After successful completion of the above points, the project will be available locally at http://localhost:8080.

If the project was deployed on cloud.google.com, then to display it, perform the following actions:

- Inside the console, on the panel, click on the "Web preview" icon
- Next, select "Change port" in the menu
- Enter the value `8080`
- Click "Change and preview".

The project should be completely ready to use with some initial data in the database.

### Accounts:
Depending on the role of the account, separate menu items are presented in the administrative panel. If you managed to execute the `php artisan db:seed` command earlier, then the "credentials" for logging into the accounts of already created users are presented below:

| Role                  |             Login             |                                Password |
|-----------------------|:-----------------------------:|----------------------------------------:|
| Administrator         |      admin@divisima.com       |                                   admin |
| Content manager       | content_manager@divisima.com  |                         content_manager |
| Orders manager        |  orders_manager@divisima.com  |                          orders_manager |
| Feedback manager      | feedback_manager@divisima.com |                        feedback_manager |
| User                  |       user@divisima.com       |                                    user |
