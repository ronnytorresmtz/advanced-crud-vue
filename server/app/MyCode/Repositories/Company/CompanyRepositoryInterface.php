<?php namespace MyCode\Repositories\Company;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface CompanyRepositoryInterface extends MyEloquentRepositoryInterface
{
	public function getAll();
	public function getAllActive();
	public function getAllIdAndNameActive();
	public function getById($id);
	public function getByPage($itemsByPage);
	public function store($request);
	public function update($request, $id);
	public function delete($id);
	public function search($value, $itemsByPage);
	public function importFile($file);
}