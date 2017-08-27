<?php namespace MyCode\Repositories\City;
 

use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\City\CityRepositoryInterface;

use MyCode\Models\City;
 
class CityRepository extends MyAbstractEloquentRepository implements CityRepositoryInterface 
{
 
	// Properties

	protected $model;

	 
	//Constructor
	   
	public function __construct(City $model) 
	{
		$this->model = $model; 
	}


	public function getModel()
	{
		return  $this->model;
	}


	public function getAllCitiesActive()
	{
		return $this->model->all(array('id', 'city_shortname','city_name'));
	}


	public function getCityNameByID($id)
	{
		return $this->model->where('id', '=', $id)->first();
	}


	public function getCityIdByCityName($cityName)
	{
		return $this->model->select('id')->where('city_name', '=', $cityName)->first();
	}

	public function getAllCitiesActiveByStateId($stateId)
	{
		return $this->model
		->where('state_id', '=', $stateId)
		->orwhere('state_id', '=', 0) // Add an Item named as "Select an option"
		->get();
	}

}