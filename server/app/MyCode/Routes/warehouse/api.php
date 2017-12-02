<?php

// Route::group(array('middleware' => 'auth'), function(){

    Route::get('shippers/warehouses/export', 'WarehouseController@export');

    Route::post('shippers/warehouses/import', 'WarehouseController@import');

    Route::get('shippers/warehouses/getAllCountriesActive', 'WarehouseController@getAllActive');

    Route::get('shippers/warehouses/getAllWarehousesIdAndNamesActive', 'WarehouseController@getAllWarehousesIdAndNamesActive');

    Route::get('shippers/warehouses/company/{id}', 'WarehouseController@getWarehouseByCustomerID');

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