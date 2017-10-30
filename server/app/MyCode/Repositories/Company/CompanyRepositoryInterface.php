<?php namespace MyCode\Repositories\Company;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface CompanyRepositoryInterface extends MyEloquentRepositoryInterface
{
	public function getAll();
	public function getCompanyIdByName($companyName);
	public function getAllWithFilters($request);
	public function getAllActive();
	public function getAllIdAndNameActive();
	public function getById($id);
	public function getByPageWithFilters($itemsByPage);
	public function store($request);
	public function update($request, $id);
	public function delete($id);
	public function import($file);
}