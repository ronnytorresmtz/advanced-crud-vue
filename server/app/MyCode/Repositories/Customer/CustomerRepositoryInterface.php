<?php namespace MyCode\Repositories\Customer;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface CustomerRepositoryInterface extends MyEloquentRepositoryInterface
{
	// public function getAll($request);
	public function getAllWithFilters($request);
	public function getAllActive($request);
	public function getAllIdAndNameActive($request);
	public function getById($id);
	public function getByPageWithFilters($request);
	public function store($request);
	public function update($request, $id);
	public function delete($id);
	public function import($file);
}