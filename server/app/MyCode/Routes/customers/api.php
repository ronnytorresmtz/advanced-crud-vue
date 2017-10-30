<?php

// Route::group(array('middleware' => 'auth'), function(){

    Route::get('shippers/customers/export', 'CustomerController@export');

    Route::post('shippers/customers/import', 'CustomerController@import');

    Route::get('shippers/customers/getAllCountriesActive', 'CustomerController@getAllActive');

    Route::get('shippers/customers/getAllCustomersIdAndNamesActive', 'CustomerController@getAllCustomersIdAndNamesActive');

    Route::get('shippers/customers/company/{id}', 'CustomerController@getCustomerByCompanyID');

    Route::resource('shippers/customers', 'CustomerController', array(
        'names' => array(
            'index'   => 'shippers.customers.index',
            'store'   => 'shippers.customers.store',
            'edit'    => 'shippers.customers.edit',
            'update'  => 'shippers.customers.update',
            'destroy' => 'shippers.customers.destoy'
        )
    ));

  
   
// });