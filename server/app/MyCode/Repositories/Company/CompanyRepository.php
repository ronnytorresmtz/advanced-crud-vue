<?php namespace MyCode\Repositories\Company;
 
use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\Company\CompanyRepositoryInterface;
use MyCode\Models\Company;
use App\Exeptions\EmailAlreadyExistException;

use Lang, DB, Exception, Log;
 

class CompanyRepository extends MyAbstractEloquentRepository implements CompanyRepositoryInterface 
{
 
	protected $company;


	public function __construct(Company $company) 
	{
	  
		$this->model = $company; 
	
	}


	public function getAll()
	{
		$companies=$this->model->withTrashed()->select(
			'id', 'company_name', 'company_legal_name', 'company_tax_id', 'company_website',
			'company_email','company_contact', 'company_phone',	'company_cellular',	'company_address',
			'company_location', 'company_postcode',	'company_latitude',	'company_longitude','deleted_at'
		)->get();

		return $companies;
	}


	public function getAllWithFilters($request)
	{
		$companies = $this->model->withTrashed()->select(
		
		'id', 'deleted_at', 'company_name', 'company_legal_name', 'company_tax_id', 'company_website', 
		'company_contact', 'company_email', 'company_phone', 'company_cellular','company_location', 
		'company_address', 'company_postcode','company_latitude','company_longitude'
		
		)

		->where(function ($query) use ($request) {
		
			if (isset($request->searchText)) {
		
				$query->orwhere('id','like','%' . $request->searchText . '%')
					->orwhere('company_name','like','%' . $request->searchText . '%')
					->orwhere('company_contact','like','%' . $request->searchText . '%')
					->orwhere('company_email','like','%' . $request->searchText . '%')
					->orwhere('company_phone','like','%' . $request->searchText . '%')
					->orwhere('company_cellular','like','%' . $request->searchText . '%')
					->orwhere('company_location','like','%' . $request->searchText . '%')
					->orwhere('company_address','like','%' . $request->searchText . '%')
					->orwhere('company_postcode','like','%' . $request->searchText . '%')
					->orwhere('company_latitude','like','%' . $request->searchText . '%')
					->orwhere('company_longitude','like','%' . $request->searchText . '%')
					->orwhere('company_legal_name','like','%' . $request->searchText . '%')
					->orwhere('company_tax_id','like','%' . $request->searchText . '%')
					->orwhere('company_website','like','%' . $request->searchText . '%');
		
				}
		
		})	

		->where(function ($query) use ($request) {
		
			if ($request->optionSelected == 0) {
		
				$query->whereNull('deleted_at');
		
			}
		
			if ($request->optionSelected == 1) {
		
				$query->whereNotNull('deleted_at');
		
			}
			
		})
		// if first parameter is true the function is executed
		->when($request->fieldOrderBy, function ($query) use ($request) {
		
			$query->orderBy($request->fieldOrderBy, $request->orderBy);
		
		})

		->get();

		return $companies;

	}

	
	public function getAllActive()
	{
		$companies=$this->model->select(
			
			'id', 'company_name', 'company_legal_name', 'company_tax_id', 'company_website',
			'company_email','company_contact', 'company_phone',	'company_cellular',	'company_address',
			'company_location', 'company_postcode',	'company_latitude',	'company_longitude','deleted_at'
			
		)
		
		->get();

		return $companies;
	}

	
	public function getAllIdAndNameActive()
	{
		$companies=$this->model->select('id', 'company_name')->get();

		return $companies;
	}


	public function getById($id)
	{
		$companies=$this->model->withTrashed()->select(
			
			'id', 'company_name', 'company_legal_name', 'company_tax_id', 'company_website',
			'company_email','company_contact', 'company_phone',	'company_cellular',	'company_address',
			'company_location', 'company_postcode',	'company_latitude',	'company_longitude','deleted_at'

		)

		->where('id','=', $id)

		->get();

		return $companies;
	}

	public function getByPageWithFilters($request)
	{

		$companies = $this->model->withTrashed()->select(
			
			'id', 'deleted_at', 'company_name', 'company_legal_name', 'company_tax_id', 'company_website', 
			'company_contact', 'company_email', 'company_phone', 'company_cellular','company_location', 
			'company_address', 'company_postcode','company_latitude','company_longitude'

		)
		
		->where(function ($query) use ($request) {
		
			if (isset($request->searchText)) {
		
				$query->orwhere('id','like','%' . $request->searchText . '%')
					->orwhere('company_name','like','%' . $request->searchText . '%')
					->orwhere('company_contact','like','%' . $request->searchText . '%')
					->orwhere('company_email','like','%' . $request->searchText . '%')
					->orwhere('company_phone','like','%' . $request->searchText . '%')
					->orwhere('company_cellular','like','%' . $request->searchText . '%')
					->orwhere('company_location','like','%' . $request->searchText . '%')
					->orwhere('company_address','like','%' . $request->searchText . '%')
					->orwhere('company_postcode','like','%' . $request->searchText . '%')
					->orwhere('company_latitude','like','%' . $request->searchText . '%')
					->orwhere('company_longitude','like','%' . $request->searchText . '%')
					->orwhere('company_legal_name','like','%' . $request->searchText . '%')
					->orwhere('company_tax_id','like','%' . $request->searchText . '%')
					->orwhere('company_website','like','%' . $request->searchText . '%');
		
				}
		
		})	

		->where(function ($query) use ($request) {
		
			if ($request->optionSelected == 0) {
		
				$query->whereNull('deleted_at');
		
			}
		
			if ($request->optionSelected == 1) {
		
				$query->whereNotNull('deleted_at');
		
			}
			
		})
		// if first parameter is true the function is executed
		->when($request->fieldOrderBy, function ($query) use ($request) {
		
			$query->orderBy($request->fieldOrderBy, $request->orderBy);
		
		})

		->paginate($request->itemsByPage);

		return $companies;

	}

  	public function store($request)
	{
		try{
			// store the data to the database
			$model = new Company;		
			
			$model->company_name = $request->input('company_name');
			$model->company_legal_name = $request->input('company_legal_name');
			$model->company_tax_id	= $request->input('company_tax_id');
			$model->company_website = $request->input('company_website');
			$model->company_email = $request->input('company_email');
			$model->company_contact = $request->input('company_contact');
			$model->company_phone = $request->input('company_phone');
			$model->company_cellular = $request->input('company_cellular');
			$model->company_address = $request->input('company_address');
			$model->company_location = $request->input('company_location');
			$model->company_postcode = $request->input('company_postcode');
			$model->company_latitude = $request->input('company_latitude');
			$model->company_longitude = $request->input('company_longitude');
			
			if (! $model->save()){
		
				return array('error' => true, 'message' => Lang::get('messages.error'));
		
			}

			return array('error' => false, 'message' => Lang::get('messages.success'));

		} catch (Exception $e) {

			\Log::error($e);
			
				return array('error' => true, 'message' => Lang::get('messages.error_caught_exception') . ' ' . str_replace("'"," ", strstr($e->getMessage(), '(SQL:', true)));
		}	

	}


	public function update($request, $id)
	{
		 try{
			// store the data to the database
			$model = $this->model->withTrashed()->find($id);

			$model->company_name = $request->input('company_name');
			$model->company_legal_name = $request->input('company_legal_name');
			$model->company_tax_id	= $request->input('company_tax_id');
  		    $model->company_website = $request->input('company_website');
			$model->company_email = $request->input('company_email');
			$model->company_contact = $request->input('company_contact');
			$model->company_phone = $request->input('company_phone');
			$model->company_cellular = $request->input('company_cellular');
			$model->company_address = $request->input('company_address');
			$model->company_location = $request->input('company_location');
			$model->company_postcode = $request->input('company_postcode');
			$model->company_latitude = $request->input('company_latitude');
			$model->company_longitude = $request->input('company_longitude');
			$model->deleted_at = null;
			$model->touch();
			
			if (! $model->update()){
		
				return array('error' => true, 'message' => Lang::get('messages.error'));
		
			}

			return array('error' => false, 'message' => Lang::get('messages.success'));

		} catch (Exception $e) {

			\Log::error($e);

			return array('error' => true, 'message' => Lang::get('messages.error_caught_exception') . ' ' . str_replace("'"," ", strstr($e->getMessage(), '(SQL:', true)));
		}	
	}


	public function delete($id)
	{
		try{
		
			$model = $this->model->withTrashed()->find($id);
		
			if (! $model->delete()){
		
				return array('error' => true, 'message' => Lang::get('messages.error'));
		
			}

			return array('error' => false, 'message' => Lang::get('messages.success'));

		} catch (Exception $e) {

			\Log::error($e);

			return array('error' => true, 'message' => Lang::get('messages.error_caught_exception') . ' ' . str_replace("'"," ", strstr($e->getMessage(), '(SQL:', true)));
		}	

	}


	public function import($file)
	{
		/*=====================	RULES TO IMPORt FILES ========================================
		1) The first row must be the fields hearder .
		2) if the row has a value in the ID Field it will be update if not will be added.
		===================================================================================*/

		// Begin a Transaction
		DB::beginTransaction();
		
		try {
			
			$addedRecords = 0; // count add records

			$updateRecords = 0; //count update records

			$results = \Excel::load($file->getRealPath())->get();

			foreach ($results as $key => $row) {

				if (isset($row)) {
					// Validate if comapany name and email already exist
					$rowId = $this->model->withTrashed()

						->where('company_name', '=', $row->company_name)

						->where('company_email', '=', $row->company_email)

						->first();

					if (empty($rowId)) {
						// if not takes the id from the file
						if (isset($row->id)) {
					
							$rowId = $this->model->withTrashed()->find($row->id);
					
						}
					
					}
					//validate if $id was found so UPDATE it
					if (isset($rowId)) {
					
						$rowId->company_name = $row->company_name;
						$rowId->company_legal_name = $row->company_legal_name;
						$rowId->company_tax_id	= $row->company_tax_id;
						$rowId->company_website = $row->company_website;
						$rowId->company_email = $row->company_email;
						$rowId->company_contact = $row->company_contact;
						$rowId->company_phone = $row->company_phone;
						$rowId->company_cellular = $row->company_cellular;
						$rowId->company_address = $row->company_address;
						$rowId->company_location = $row->company_location;
						$rowId->company_postcode = $row->company_postcode;
						$rowId->company_latitude = $row->company_latitude;
						$rowId->company_longitude = $row->company_longitude;
						$rowId->deleted_at = null;
						$rowId->save();
						$updateRecords++;
							
					} else { // validate no found so ADD it
					
						$rowId = new $this->model;
						$rowId->company_name = $row->company_name;
						$rowId->company_legal_name = $row->company_legal_name;
						$rowId->company_tax_id	= $row->company_tax_id;
						$rowId->company_website = $row->company_website;
						$rowId->company_email = $row->company_email;
						$rowId->company_contact = $row->company_contact;
						$rowId->company_phone = $row->company_phone;
						$rowId->company_cellular = $row->company_cellular;
						$rowId->company_address = $row->company_address;
						$rowId->company_location = $row->company_location;
						$rowId->company_postcode = $row->company_postcode;
						$rowId->company_latitude = $row->company_latitude;
						$rowId->company_longitude = $row->company_longitude;
						$rowId->deleted_at = null;
						$rowId->save();
						$addedRecords++;
			
					}
				
				}
			
			}

			if (($addedRecords + $updateRecords)==0) {
				
				DB::rollBack();

				return array('error' => true, 'message' => Lang::get('messages.error') . ' ' . Lang::get('messages.error_file_format'));

			} else {

				\Log::error($e);
			
				DB::commit();

				return array('error' => false, 'message' => Lang::get('messages.success_add') . ' ' .  $addedRecords . ' ' . Lang::get('messages.success_update') . ' ' . $updateRecords . ' ' . Lang::get('messages.successfully'));

			} 
			
			return $message;

	    } catch (Exception $e) {

			\Log::error($e);

			DB::rollBack();

			return array('error' => true, 'message' => Lang::get('messages.error_caught_exception') . ' ' . str_replace("'"," ", strstr($e->getMessage(), '(SQL:', true)));
		}

	}
}