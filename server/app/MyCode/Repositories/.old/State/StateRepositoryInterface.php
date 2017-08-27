<?php namespace MyCode\Repositories\State;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface StateRepositoryInterface extends MyEloquentRepositoryInterface
{
	public function getModel();
	public function getAllStatesActive();
	public function getStateNameByID($id);
	public function getStateIdByStateName($stateName);
	public function getAllStatesActiveByCountryId($countryId);
}