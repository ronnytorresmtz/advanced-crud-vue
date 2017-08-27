<?php

// Route::group(array('middleware' => 'auth'), function(){

    Route::get('shippers/warehouses/search', 'WarehouseController@search'); 
    
    Route::get('shippers/warehouses/export', 'WarehouseController@export');

    Route::post('shippers/warehouses/import', 'WarehouseController@import');

    Route::get('shippers/warehouses/getAllCountriesActive', 'WarehouseController@getAllActive');

    Route::get('shippers/warehouses/customer/{id}', 'WarehouseController@getWarehousesByCustumerID');

    Route::resource('shippers/warehouses', 'WarehouseController', array(
        'names' => array(
            'index'   => 'shippers.warehouses.index',
            'store'   => 'shippers.warehouses.store',
            'edit'    => 'shippers.warehouses.edit',
            'update'  => 'shippers.warehouses.update',
            'destroy' => 'shippers.warehouses.destoy'
        )
    ));

  
   
// });