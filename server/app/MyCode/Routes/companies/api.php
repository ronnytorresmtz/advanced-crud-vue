<?php

// Route::group(array('middleware' => 'auth'), function(){

    Route::get('shippers/companies/export', 'CompanyController@export');

    Route::post('shippers/companies/import', 'CompanyController@import');

    Route::get('shippers/companies/getAllCompaniesActive', 'CompanyController@getAllCompaniesActive');

    Route::get('shippers/companies/getAllCompaniesIdAndNamesActive', 'CompanyController@getAllCompaniesIdAndNamesActive');

    Route::resource('shippers/companies', 'CompanyController', array(
        'names' => array(
            'index'   => 'shippers.companies.index',
            'store'   => 'shippers.companies.store',
            'edit'    => 'shippers.companies.edit',
            'update'  => 'shippers.companies.update',
            'destroy' => 'shippers.companies.destoy'
        )
    ));
   
// });