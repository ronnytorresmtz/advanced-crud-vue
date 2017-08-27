<?php namespace MyCode\Repositories\State;
 

use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\State\StateRepositoryInterface;

use MyCode\Models\State;
 
class StateRepository extends MyAbstractEloquentRepository implements StateRepositoryInterface 
{
 
	// Properties

	protected $model;

	 
	//Constructor
	   
	public function __construct(State $model) 
	{
		$this->model = $model; 
	}


	public function getModel()
	{
		return  $this->model;
	}


	public function getAllStatesActive()
	{
		return $this->model->all(array('id', 'state_shortname','state_name'));
	}


	public function getStateNameByID($id)
	{
		return $this->model->where('id', '=', $id)->first();
	}


	public function getStateIdByStateName($stateName)
	{
		return $this->model->select('id')->where('state_name', '=', $stateName)->first();
	}

	public function getAllStatesActiveByCountryId($countryId)
	{
		return $this->model
		->where('country_id', '=', $countryId)
		->orwhere('country_id', '=', 0) // Add an Item named as "Select an option"
		->get();
	}

}