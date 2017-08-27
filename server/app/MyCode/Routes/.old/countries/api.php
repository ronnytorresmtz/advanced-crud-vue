<?php 

Route::get('countries/getAllCountries', 'CountryController@getAllCountries'); 

Route::get('countries/countrySelected/{countryId}', 'CountryController@getAllStatesByCountryId');
			   