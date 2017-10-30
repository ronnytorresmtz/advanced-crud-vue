# An Advance SPA CRUD Example

<p align="left">
<img src="/architecture.png" width="800"/>
</p>
    
>With Vue, Vuex, VueRouter, Larevel, Axios, CORS, Bootstrap, Animate

1. CRUD with a Table and Form
2. Colum Table are Sorteable
3. Choose Field to Display in Table
4. Search Box and Filter Record Status
5. Use Vuex for State with Modules
6. Top Popup Messages
7. Form's Fields Validations on Client
8. Handle Languagues 
9. Import and Export functionalities
10. Use Bootstrap 3 and Animate
11. CORS Implementation 
12. Laravel API 5.4 for CRUD Operations
13. Integrate Gravatar Service
14. Location Searcheable Field
15. Language Traslations



>Some Components created from scratch
1. Pagination Component
2. Table Component 
    * Column Sort 
    * Choose a Field to Display (store in LocalStorage)
    * Pagination Per Page 
3. Popup Messaging Component
4. Language Component
5. Topbar Component
5. Sidebar Component
6. Avatar Component based on Gravatar Service
7. Location Component
8. Language Traslations Component

>Application Architecture

* The client is a VueJS Sigle Page Application 
* The server is a Laravel API 
* The Comunication uses CORS
* The Database is a MySQL Database

To use/play with application you need to runs npm run dev in the client directory and php artisan in the server directory


## TODO

1. Allow to add an image as avatar if the email does not exit in gravatar service
2. Review Security for CORS and Others possible security holes
2. Test spec's
3. Upgrate to Laravel 5.5  Vue 2.5 or lastest releases
4. Upgrate to  Vue 2.5 or last releases or lastest releases


## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report

# run unit tests
npm run unit

# run e2e tests
npm run e2e

# run all tests
npm test
```

For detailed explanation on how things work, checkout the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).
