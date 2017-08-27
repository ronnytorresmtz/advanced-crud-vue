<?php

// Route::group(array('middleware' => 'auth'), function(){

    Route::get('admin/locations/search', 'LocationController@search'); 
    
    Route::get('admin/locations/export', 'LocationController@export');

    Route::post('admin/locations/import', 'LocationController@import');

    Route::get('admin/locations/getAllLocationsActive', 'LocationController@getAllLocationsActive');

    Route::resource('admin/locations', 'LocationController', array(
        'names' => array(
            'index'   => 'admin.locations.index',
            'store'   => 'admin.locations.store',
            'edit'    => 'admin.locations.edit',
            'update'  => 'admin.locations.update',
            'destroy' => 'admin.locations.destoy'
        )
    ));

    

   
// });