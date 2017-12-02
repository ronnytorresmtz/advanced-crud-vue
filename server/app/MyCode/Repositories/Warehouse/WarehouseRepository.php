<?php namespace MyCode\Repositories\Warehouse;
 
use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\Warehouse\WarehouseRepositoryInterface;
use MyCode\Models\Warehouse;
use MyCode\Models\Customer;

use Lang, DB, Exception, Log;
 

class WarehouseRepository extends MyAbstractEloquentRepository implements WarehouseRepositoryInterface 
{
 
	protected $warehouse;


	public function __construct(Warehouse $warehouse, Customer $customer) 
	{
	  
        $this->model = $warehouse; 
        
        $this->customer = $customer;
	
	}


	// public function getAll()
	// {
	// 	$warehouses=$this->model->withTrashed()->select(
	// 		'id', 'warehouse_name', 'warehouse_legal_name', 'warehouse_tax_id', 'warehouse_website',
	// 		'warehouse_email','warehouse_contact', 'warehouse_phone',	'warehouse_cellular',	'warehouse_address',
	// 		'warehouse_location', 'warehouse_postcode',	'warehouse_latitude',	'warehouse_longitude','deleted_at'
	// 	)->get();

	// 	return $warehouses;
	// }

	// public function getWarehouseIdByName($warehouseName)
	// {
		
	// 	$warehouse = $this->model->withTrashed()->select('id', 'warehouse_name')
		
	// 	->where('warehouse_id', '=', $warehouseName)

	// 	->get();

	// 	return $warehouse;
	// }


	public function getAllWithFilters($request)
	{
		$warehouses = $this->model->withTrashed()->select(
		
        'warehouses.id',
        'warehouses.deleted_at', 
        'customers.customer_name',
        'warehouses.warehouse_name', 
        'warehouses.warehouse_contact', 
        'warehouses.warehouse_email', 
        'warehouses.warehouse_phone', 
        'warehouses.warehouse_cellular',
        'warehouses.warehouse_location', 
        'warehouses.warehouse_address', 
        'warehouses.warehouse_postcode',
        'warehouses.warehouse_latitude',
        'warehouses.warehouse_longitude'
		
        )

        ->join('customers', 'customers.id', 'warehouses.customer_id')
        
        ->where('customer_id', '=', $request->customerId)

		->where(function ($query) use ($request) {
		
			if (isset($request->searchText)) {
		
				$query->orwhere('id','like','%' . $request->searchText . '%')
					->orwhere('warehouse_name','like','%' . $request->searchText . '%')
					->orwhere('warehouse_contact','like','%' . $request->searchText . '%')
					->orwhere('warehouse_email','like','%' . $request->searchText . '%')
					->orwhere('warehouse_phone','like','%' . $request->searchText . '%')
					->orwhere('warehouse_cellular','like','%' . $request->searchText . '%')
					->orwhere('warehouse_location','like','%' . $request->searchText . '%')
					->orwhere('warehouse_address','like','%' . $request->searchText . '%')
					->orwhere('warehouse_postcode','like','%' . $request->searchText . '%')
					->orwhere('warehouse_latitude','like','%' . $request->searchText . '%')
					->orwhere('warehouse_longitude','like','%' . $request->searchText . '%');
		
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

		return $warehouses;

	}

	
	public function getAllActive($request)
	{
		$warehouses = $this->model->select(
			
			'warehouses.id',
			'warehouses.deleted_at', 
			'customers.customer_name',
			'warehouses.warehouse_name', 
			'warehouses.warehouse_contact', 
			'warehouses.warehouse_email', 
			'warehouses.warehouse_phone', 
			'warehouses.warehouse_cellular',
			'warehouses.warehouse_location', 
			'warehouses.warehouse_address', 
			'warehouses.warehouse_postcode',
			'warehouses.warehouse_latitude',
			'warehouses.warehouse_longitude'
			
        )
        
        ->where('customer_id', '=', $request->customerId)
		
		->get();

		return $warehouses;
	}

	
	public function getAllIdAndNameActive($request)
	{
		$warehouses = $this->model->select('id', 'warehouse_name')

        ->where('customer_id', '=', $request->customerId)
        
        ->get();

		return $warehouses;
	}


	public function getById($id)
	{
		$warehouses=$this->model->withTrashed()->select(
			
			'warehouses.id',
			'warehouses.deleted_at', 
			'customers.customer_name',
			'warehouses.warehouse_name', 
			'warehouses.warehouse_contact', 
			'warehouses.warehouse_email', 
			'warehouses.warehouse_phone', 
			'warehouses.warehouse_cellular',
			'warehouses.warehouse_location', 
			'warehouses.warehouse_address', 
			'warehouses.warehouse_postcode',
			'warehouses.warehouse_latitude',
			'warehouses.warehouse_longitude'

		)

		->where('id','=', $id)

		->get();

		return $warehouses;
	}

	public function getByPageWithFilters($request)
	{

		$warehouses = $this->model->withTrashed()->select(
			
			'warehouses.id',
			'warehouses.deleted_at', 
			'warehouses.warehouse_name', 
			'warehouses.warehouse_contact', 
			'warehouses.warehouse_email', 
			'warehouses.warehouse_phone', 
			'warehouses.warehouse_cellular',
			'warehouses.warehouse_location', 
			'warehouses.warehouse_address', 
			'warehouses.warehouse_postcode',
			'warehouses.warehouse_latitude',
			'warehouses.warehouse_longitude'

        )
        
        ->where('customer_id', '=', $request->customerId)
		
		->where(function ($query) use ($request) {
		
			if (isset($request->searchText)) {
		
				$query->orwhere('id','like','%' . $request->searchText . '%')
					->orwhere('warehouse_name','like','%' . $request->searchText . '%')
					->orwhere('warehouse_contact','like','%' . $request->searchText . '%')
					->orwhere('warehouse_email','like','%' . $request->searchText . '%')
					->orwhere('warehouse_phone','like','%' . $request->searchText . '%')
					->orwhere('warehouse_cellular','like','%' . $request->searchText . '%')
					->orwhere('warehouse_location','like','%' . $request->searchText . '%')
					->orwhere('warehouse_address','like','%' . $request->searchText . '%')
					->orwhere('warehouse_postcode','like','%' . $request->searchText . '%')
					->orwhere('warehouse_latitude','like','%' . $request->searchText . '%')
					->orwhere('warehouse_longitude','like','%' . $request->searchText . '%');
		
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

		return $warehouses;

	}

  	public function store($request)
	{
		try{
			// store the data to the database
			$model = new Warehouse;		
            
            $model->customer_id = $request->customer_id;
			$model->warehouse_name = $request->warehouse_name;
			$model->warehouse_email = $request->warehouse_email;
			$model->warehouse_contact = $request->warehouse_contact;
			$model->warehouse_phone = $request->warehouse_phone;
			$model->warehouse_cellular = $request->warehouse_cellular;
			$model->warehouse_address = $request->warehouse_address;
			$model->warehouse_location = $request->warehouse_location;
			$model->warehouse_postcode = $request->warehouse_postcode;
			$model->warehouse_latitude = $request->warehouse_latitude;
			$model->warehouse_longitude = $request->warehouse_longitude;
			
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
		\Log::info($request);
		try{
			// store the data to the database
			$model = $this->model->withTrashed()->find($id);

            $model->customer_id = $request->customer_id;
			$model->warehouse_name = $request->warehouse_name;
			$model->warehouse_email = $request->warehouse_email;
			$model->warehouse_contact = $request->warehouse_contact;
			$model->warehouse_phone = $request->warehouse_phone;
			$model->warehouse_cellular = $request->warehouse_cellular;
			$model->warehouse_address = $request->warehouse_address;
			$model->warehouse_location = $request->warehouse_location;
			$model->warehouse_postcode = $request->warehouse_postcode;
			$model->warehouse_latitude = $request->warehouse_latitude;
			$model->warehouse_longitude = $request->warehouse_longitude;
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
        4) The customer_name filed must exist in the database
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

                    // Get and Validate Customer Id from Customer Name
					$customer = $this->customer->withTrashed()->select('id')

						->where('customer_name', '=', $row->customer_name)

                        ->first();
                        
                    if (empty($customer)) {

                        DB::rollBack();
                        
                        if (isset($row->customer_name)) {
                            return array(
                                'error' => true, 
                                'message' => Lang::get('messages.error_customer_name_import_file') . ' (' . $row->customer_name . ')'
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
                    
                        $rowId->customer_id = $customer->id;
						$rowId->warehouse_name = $row->warehouse_name;
						$rowId->warehouse_email = $row->warehouse_email;
						$rowId->warehouse_contact = $row->warehouse_contact;
						$rowId->warehouse_phone = $row->warehouse_phone;
						$rowId->warehouse_cellular = $row->warehouse_cellular;
						$rowId->warehouse_address = $row->warehouse_address;
						$rowId->warehouse_location = $row->warehouse_location;
						$rowId->warehouse_postcode = $row->warehouse_postcode;
						$rowId->warehouse_latitude = $row->warehouse_latitude;
						$rowId->warehouse_longitude = $row->warehouse_longitude;
						// $rowId->deleted_at = $row->delete_at;
						$rowId->save();
						$updateRecords++;
							
					} else { // validate no found so ADD it
					
                        $rowId = new $this->model;
                        
                        $rowId->customer_id = $customer->id;
						$rowId->warehouse_name = $row->warehouse_name;
						$rowId->warehouse_email = $row->warehouse_email;
						$rowId->warehouse_contact = $row->warehouse_contact;
						$rowId->warehouse_phone = $row->warehouse_phone;
						$rowId->warehouse_cellular = $row->warehouse_cellular;
						$rowId->warehouse_address = $row->warehouse_address;
						$rowId->warehouse_location = $row->warehouse_location;
						$rowId->warehouse_postcode = $row->warehouse_postcode;
						$rowId->warehouse_latitude = $row->warehouse_latitude;
						$rowId->warehouse_longitude = $row->warehouse_longitude;
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