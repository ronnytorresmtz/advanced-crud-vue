<?php namespace MyCode\Repositories\Country;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface CountryRepositoryInterface extends MyEloquentRepositoryInterface
{
	public function getModel();
	public function getAllCountriesActive();
	public function getCountryNameByID($id);
	public function getCountryIdByCountryName($countryName);
}