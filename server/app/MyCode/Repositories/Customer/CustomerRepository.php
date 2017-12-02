<?php namespace MyCode\Repositories\Customer;
 
use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\Customer\CustomerRepositoryInterface;
use MyCode\Models\Customer;
use MyCode\Models\Company;

use Lang, DB, Exception, Log;
 

class CustomerRepository extends MyAbstractEloquentRepository implements CustomerRepositoryInterface 
{
 
	protected $customer;


	public function __construct(Customer $customer, Company $company) 
	{
	  
        $this->model = $customer; 
        
        $this->company = $company;
	
	}


	// public function getAll()
	// {
	// 	$customers=$this->model->withTrashed()->select(
	// 		'id', 'customer_name', 'customer_legal_name', 'customer_tax_id', 'customer_website',
	// 		'customer_email','customer_contact', 'customer_phone',	'customer_cellular',	'customer_address',
	// 		'customer_location', 'customer_postcode',	'customer_latitude',	'customer_longitude','deleted_at'
	// 	)->get();

	// 	return $customers;
	// }

	// public function getCustomerIdByName($customerName)
	// {
		
	// 	$customer = $this->model->withTrashed()->select('id', 'customer_name')
		
	// 	->where('customer_id', '=', $customerName)

	// 	->get();

	// 	return $customer;
	// }


	public function getAllWithFilters($request)
	{
		$customers = $this->model->withTrashed()->select(
		
        'customers.id',
        'customers.deleted_at', 
        'companies.company_name',
        'customers.customer_name', 
        'customers.customer_legal_name', 
        'customers.customer_tax_id', 
        'customers.customer_website', 
        'customers.customer_contact', 
        'customers.customer_email', 
        'customers.customer_phone', 
        'customers.customer_cellular',
        'customers.customer_location', 
        'customers.customer_address', 
        'customers.customer_postcode',
        'customers.customer_latitude',
        'customers.customer_longitude'
		
        )

        ->join('companies', 'companies.id', 'customers.company_id')
        
        ->where('company_id', '=', $request->companyId)

		->where(function ($query) use ($request) {
		
			if (isset($request->searchText)) {
		
				$query->orwhere('id','like','%' . $request->searchText . '%')
					->orwhere('customer_name','like','%' . $request->searchText . '%')
					->orwhere('customer_contact','like','%' . $request->searchText . '%')
					->orwhere('customer_email','like','%' . $request->searchText . '%')
					->orwhere('customer_phone','like','%' . $request->searchText . '%')
					->orwhere('customer_cellular','like','%' . $request->searchText . '%')
					->orwhere('customer_location','like','%' . $request->searchText . '%')
					->orwhere('customer_address','like','%' . $request->searchText . '%')
					->orwhere('customer_postcode','like','%' . $request->searchText . '%')
					->orwhere('customer_latitude','like','%' . $request->searchText . '%')
					->orwhere('customer_longitude','like','%' . $request->searchText . '%')
					->orwhere('customer_legal_name','like','%' . $request->searchText . '%')
					->orwhere('customer_tax_id','like','%' . $request->searchText . '%')
					->orwhere('customer_website','like','%' . $request->searchText . '%');
		
				}
		
		})	

		->where(function ($query) use ($request) {
		
			if ($request->filterSelected == 0) {
		
				$query->whereNull('deleted_at');
		
			}
		
			if ($request->filterSelected == 1) {
		
				$query->whereNotNull('deleted_at');
		
			}
			
		})
		// if first parameter is true the function is executed
		->when($request->fieldOrderBy, function ($query) use ($request) {
		
			$query->orderBy($request->fieldOrderBy, $request->orderBy);
		
		})

		->get();

		return $customers;

	}

	
	public function getAllActive($request)
	{
		$customers = $this->model->select(
			
			'id', 'customer_name', 'customer_legal_name', 'customer_tax_id', 'customer_website',
			'customer_email','customer_contact', 'customer_phone',	'customer_cellular',	'customer_address',
			'customer_location', 'customer_postcode',	'customer_latitude',	'customer_longitude','deleted_at'
			
        )
        
        ->where('company_id', '=', $request->companyId)
		
		->get();

		return $customers;
	}

	
	public function getAllIdAndNameActive($request)
	{
        $customers = $this->model->select('id', 'customer_name')

        ->where('company_id', '=', 1) //$request->companyId)
        
        ->get();

		return $customers;
	}


	public function getById($id)
	{
		$customers=$this->model->withTrashed()->select(
			
			'id', 'customer_name', 'customer_legal_name', 'customer_tax_id', 'customer_website',
			'customer_email','customer_contact', 'customer_phone',	'customer_cellular',	'customer_address',
			'customer_location', 'customer_postcode',	'customer_latitude',	'customer_longitude','deleted_at'

		)

		->where('id','=', $id)

		->get();

		return $customers;
	}

	public function getByPageWithFilters($request)
	{

		$customers = $this->model->withTrashed()->select(
			
			'id', 'deleted_at', 'customer_name', 'customer_legal_name', 'customer_tax_id', 'customer_website', 
			'customer_contact', 'customer_email', 'customer_phone', 'customer_cellular','customer_location', 
			'customer_address', 'customer_postcode','customer_latitude','customer_longitude'

        )
        
        ->where('company_id', '=', $request->companyId)
		
		->where(function ($query) use ($request) {
		
			if (isset($request->searchText)) {
		
				$query->orwhere('id','like','%' . $request->searchText . '%')
					->orwhere('customer_name','like','%' . $request->searchText . '%')
					->orwhere('customer_contact','like','%' . $request->searchText . '%')
					->orwhere('customer_email','like','%' . $request->searchText . '%')
					->orwhere('customer_phone','like','%' . $request->searchText . '%')
					->orwhere('customer_cellular','like','%' . $request->searchText . '%')
					->orwhere('customer_location','like','%' . $request->searchText . '%')
					->orwhere('customer_address','like','%' . $request->searchText . '%')
					->orwhere('customer_postcode','like','%' . $request->searchText . '%')
					->orwhere('customer_latitude','like','%' . $request->searchText . '%')
					->orwhere('customer_longitude','like','%' . $request->searchText . '%')
					->orwhere('customer_legal_name','like','%' . $request->searchText . '%')
					->orwhere('customer_tax_id','like','%' . $request->searchText . '%')
					->orwhere('customer_website','like','%' . $request->searchText . '%');
		
				}
		
		})	

		->where(function ($query) use ($request) {
		
			if ($request->filterSelected == 0) {
		
				$query->whereNull('deleted_at');
		
			}
		
			if ($request->filterSelected == 1) {
		
				$query->whereNotNull('deleted_at');
		
			}
			
		})
		// if first parameter is true the function is executed
		->when($request->fieldOrderBy, function ($query) use ($request) {
		
			$query->orderBy($request->fieldOrderBy, $request->orderBy);
		
		})

		->paginate($request->itemsByPage);

		return $customers;

	}

  	public function store($request)
	{
		try{
			// store the data to the database
			$model = new Customer;		
            
            $model->company_id = $request->company_id;
			$model->customer_name = $request->customer_name;
			$model->customer_legal_name = $request->customer_legal_name;
			$model->customer_tax_id	= $request->customer_tax_id;
			$model->customer_website = $request->customer_website;
			$model->customer_email = $request->customer_email;
			$model->customer_contact = $request->customer_contact;
			$model->customer_phone = $request->customer_phone;
			$model->customer_cellular = $request->customer_cellular;
			$model->customer_address = $request->customer_address;
			$model->customer_location = $request->customer_location;
			$model->customer_postcode = $request->customer_postcode;
			$model->customer_latitude = $request->customer_latitude;
			$model->customer_longitude = $request->customer_longitude;
			
			if (! $model->save()) {
		
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

            $model->company_id = $request->company_id;
			$model->customer_name = $request->customer_name;
			$model->customer_legal_name = $request->customer_legal_name;
			$model->customer_tax_id	= $request->customer_tax_id;
  		    $model->customer_website = $request->customer_website;
			$model->customer_email = $request->customer_email;
			$model->customer_contact = $request->customer_contact;
			$model->customer_phone = $request->customer_phone;
			$model->customer_cellular = $request->customer_cellular;
			$model->customer_address = $request->customer_address;
			$model->customer_location = $request->customer_location;
			$model->customer_postcode = $request->customer_postcode;
			$model->customer_latitude = $request->customer_latitude;
			$model->customer_longitude = $request->customer_longitude;
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
		
			if (! $model->delete()) {
		
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
		1) The top row of the data must be the fields hearder 
        2) if the row has a value in the ID Field it will be update if not will be added.
        3) The file can not contains duplicates id´s to avoid user errors
        4) The company_name filed must exist in the database
        5) Some fields can not be duplicated in the database based on the table unique indexes
        6) The deleted_at field will not affect the database
        7) The deleted_at field from the field could be delete it or leaved it from the file, it will not takes effect
		===================================================================================*/

		// Begin a Transaction
		DB::beginTransaction();
		
		try {
			
			$addedRecords = 0; // count add records

            $updateRecords = 0; //count update records
            
            $fileIds = []; //arrays of id´s in the file to validate duplication

			$results = \Excel::load($file->getRealPath())->get();

			foreach ($results as $key => $row) {

				$rowId = null;

				if (isset($row)) {

                    // Get and Validate Company Id from Company Name
					$company = $this->company->withTrashed()->select('id')

						->where('company_name', '=', $row->company_name)

                        ->first();
                        
                    if (empty($company)) {

                        DB::rollBack();
                        
                        if (isset($row->company_name)) {
                            return array(
                                'error' => true, 
                                'message' => Lang::get('messages.error_company_name_import_file') . ' (' . $row->company_name . ')'
                            );
                        } else {
                            return array(
                                'error' => true, 
                                'message' => Lang::get('messages.error_missing_headers_import_file')
                            );
                        }

                    }
                    
                    if (isset($row->id)) {
                        
                        // Validate id from file, if it is duplicated send an error
                        if (in_array($row->id, $fileIds)) {

                            DB::rollBack();
                            
                            return array('error' => true, 'message' => Lang::get('messages.error_id_import_duplicated') . ': ' . $row->id);

                         }
                        // if id is not duplicated add to array
                        array_push($fileIds, $row->id);
                        
                        // if id exist get the row from the database
                        $rowId = $this->model->withTrashed()->find($row->id);
                
                    }
                    
					//validate if $id was found so UPDATE it
					if (isset($rowId)) {
                    
                        $rowId->company_id = $company->id;
						$rowId->customer_name = $row->customer_name;
						$rowId->customer_legal_name = $row->customer_legal_name;
						$rowId->customer_tax_id	= $row->customer_tax_id;
						$rowId->customer_website = $row->customer_website;
						$rowId->customer_email = $row->customer_email;
						$rowId->customer_contact = $row->customer_contact;
						$rowId->customer_phone = $row->customer_phone;
						$rowId->customer_cellular = $row->customer_cellular;
						$rowId->customer_address = $row->customer_address;
						$rowId->customer_location = $row->customer_location;
						$rowId->customer_postcode = $row->customer_postcode;
						$rowId->customer_latitude = $row->customer_latitude;
						$rowId->customer_longitude = $row->customer_longitude;
						// $rowId->deleted_at = $row->delete_at;
						$rowId->save();
						$updateRecords++;
							
					} else { // validate no found so ADD it
					
                        $rowId = new $this->model;
                        
                        $rowId->company_id = $company->id;
						$rowId->customer_name = $row->customer_name;
						$rowId->customer_legal_name = $row->customer_legal_name;
						$rowId->customer_tax_id	= $row->customer_tax_id;
						$rowId->customer_website = $row->customer_website;
						$rowId->customer_email = $row->customer_email;
						$rowId->customer_contact = $row->customer_contact;
						$rowId->customer_phone = $row->customer_phone;
						$rowId->customer_cellular = $row->customer_cellular;
						$rowId->customer_address = $row->customer_address;
						$rowId->customer_location = $row->customer_location;
						$rowId->customer_postcode = $row->customer_postcode;
						$rowId->customer_latitude = $row->customer_latitude;
						$rowId->customer_longitude = $row->customer_longitude;
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

				DB::commit();

				return array('error' => false, 'message' => Lang::get('messages.success_add') . ' ' .  $addedRecords . ' ' . Lang::get('messages.success_update') . ' ' . $updateRecords . ' ' . Lang::get('messages.successfully'));

			} 
			
			return $message;

	    } catch (Exception $e) {

            DB::rollBack();

            throw new Exception($e->getMessage());
            
		}

	}
}