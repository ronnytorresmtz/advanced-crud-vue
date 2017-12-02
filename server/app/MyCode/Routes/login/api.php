<?php

Route::group(array('middleware' => 'guest'), function(){
	
	Route::get('/', array(

		'as' 			=> '/', 
		'uses'			=> 'LoginController@getLogIn'
	));	

	Route::get('/login', array( 

		'as' 			=> 'login', 
		'uses'			=> 'LoginController@getLogIn'
	));

	Route::post('login/sendYourPassword', array(

	    'as' 			=> 'login.sendYourPassword',
	    'uses'			=> 'LoginController@postSendYourPassword'
	));

	Route::post('login/resetYourPassword', array(

		'as'			=> 'login.resetYourPassword',
		'uses'			=> 'LoginController@postResetYourPassword'
	));

	Route::get('login/userAuthenticated', array(

		'as'			=> 'login.userAuthenticated',
		'uses'			=> 'LoginController@getUserAuthenticated'
	));

	Route::post('login/tokenExist', array(

		'as'			=> 'login.tokenExist',
		'uses'			=> 'LoginController@postTokenExist'
	));


});


// Route::group(array('middleware' => 'auth'), function() {

	Route::get('login/logOut', array(

		'as' 			=> 'login.logOut', 
		'uses' 			=> 'LoginController@getLogOut'
    ));
    
// });


Route::post('login/logIn', array(

	'as' 			=> 'login.logIn', 
	'uses'			=> 'LoginController@postLogIn'
));	

