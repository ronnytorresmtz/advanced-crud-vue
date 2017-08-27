<?php namespace MyCode\Repositories\Customer;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface CustomerRepositoryInterface extends MyEloquentRepositoryInterface
{
	public function getAll($companyId);
	public function getAllActive();
	public function getAllIdAndNameActive();
	public function getById($id);
	public function getByPage($companyId, $itemsByPage);
	public function store($request);
	public function update($request, $id);
	public function delete($id);
	public function search($companyId, $value, $itemsByPage);
	public function importFile($file);
}