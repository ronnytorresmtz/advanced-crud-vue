<?php namespace MyCode\Repositories\Country;
 

use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\Country\CountryRepositoryInterface;

use MyCode\Models\Country;
 
class CountryRepository extends MyAbstractEloquentRepository implements CountryRepositoryInterface 
{
	// Properties
	protected $model;

	//Constructor
	public function __construct(Country $model) 
	{
		$this->model = $model; 
	}


	public function getModel()
	{
		return  $this->model;
	}


	public function getAllCountriesActive()
	{
		return $this->model->all(array('id', 'country_shortname','country_name'));
	}


	public function getCountryNameByID($id)
	{
		return $this->model->where('id', '=', $id)->first();
	}


	public function getCountryIdByCountryName($countryName)
	{
		return $this->model->select('id')->where('country_name', '=', $countryName)->first();
	}
	
}