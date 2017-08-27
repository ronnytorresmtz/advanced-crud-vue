<?php namespace MyCode\Repositories\Warehouse;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface WarehouseRepositoryInterface extends MyEloquentRepositoryInterface
{
	public function getAll($customerId);
	public function getById($id);
	public function getByPage($customerId, $itemsByPage);
	public function store($request);
	public function update($request, $id);
	public function delete($id);
	public function search($customerId, $value, $itemsByPage);
	public function importFile($file);
}