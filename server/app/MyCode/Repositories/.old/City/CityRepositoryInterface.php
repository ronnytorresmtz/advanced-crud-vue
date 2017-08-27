<?php namespace MyCode\Repositories\City;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface CityRepositoryInterface extends MyEloquentRepositoryInterface
{
	public function getModel();
	public function getAllCitiesActive();
	public function getCityNameByID($id);
	public function getCityIdByCityName($cityName);
	public function getAllCitiesActiveByStateId($stateId);
}