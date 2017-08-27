<?php namespace MyCode\Repositories\Location;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface LocationRepositoryInterface extends MyEloquentRepositoryInterface
{
	public function get();
	public function getAll();
	public function getById($id);
	public function getByPage($itemsByPage);
	public function store($request);
	public function update($request, $id);
	public function delete($id);
	public function search($value, $itemsByPage);
	public function importFile($file);
}