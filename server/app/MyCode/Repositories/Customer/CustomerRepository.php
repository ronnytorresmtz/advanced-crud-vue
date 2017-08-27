<?php namespace MyCode\Repositories\Customer;
 
use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\Customer\CustomerRepositoryInterface;
use MyCode\Models\Customer;
use App\Exeptions\EmailAlreadyExistException;

use Lang, DB, Exception, Log;
 
class CustomerRepository extends MyAbstractEloquentRepository implements CustomerRepositoryInterface 
{
 
	protected $customer;

	public function __construct(Customer $customer) 
	{
	  $this->model = $customer; 
	}


	public function getAll($companyId)
	{
		$customers = $this->model->withTrashed()
		->select(
			'id', 'customer_commercial_name', 'customer_legal_name', 'customer_tax_id', 'customer_website',
			'customer_email','customer_contact', 'customer_phone',	'customer_cellular',	'customer_address',
			'customer_location', 'customer_postcode',	'customer_latitude',	'customer_longitude','deleted_at'
			
		)
		//->where('company_id','=', $companyId)
		->get();

		return $customers;
	}

	public function getAllActive()
	{
		$companies=$this->model
		->select(
			'id', 'customer_commercial_name', 'customer_legal_name', 'customer_tax_id', 'customer_website',
			'customer_email','customer_contact', 'customer_phone',	'customer_cellular', 'customer_address',
			'customer_location', 'customer_postcode', 'customer_latitude', 'customer_longitude','deleted_at'
			
		)->get();

		return $companies;
	}

	public function getAllIdAndNameActive()
	{
		$customers=$this->model->select('id', 'customer_commercial_name')->get();

		return $customers;
	}

	public function getById($id)
	{
		$customers=$this->model->withTrashed()
		->select(
			'id', 'customer_commercial_name', 'customer_legal_name', 'customer_tax_id', 'customer_website',
			'customer_email','customer_contact', 'customer_phone',	'customer_cellular',	'customer_address',
			'customer_location', 'customer_postcode',	'customer_latitude',	'customer_longitude','deleted_at'
		)

		->where('id','=', $id)
		->get();

		return $customers;
	}

	public function getByPage($companyId, $itemsByPage)
	{
		$customers = $this->model->withTrashed()
			->select(
				'id', 'customer_commercial_name', 'customer_legal_name', 'customer_tax_id', 'customer_website',
				'customer_email','customer_contact', 'customer_phone',	'customer_cellular',	'customer_address',
				'customer_location', 'customer_postcode',	'customer_latitude',	'customer_longitude','deleted_at'
			) 
			->where('company_id','=', $companyId)
			->paginate($itemsByPage);

		return $customers;
	}

  public function store($request)
	{
		try{
			// store the data to the database
			$model = new Customer;		
			
			$model->company_id = $request->input('company_id');
			$model->customer_commercial_name = $request->input('customer_commercial_name');
			$model->customer_legal_name = $request->input('customer_legal_name');
			$model->customer_tax_id	= $request->input('customer_tax_id');
  		    $model->customer_website = $request->input('customer_website');
			$model->customer_email = $request->input('customer_email');
			$model->customer_contact = $request->input('customer_contact');
			$model->customer_phone = $request->input('customer_phone');
			$model->customer_cellular = $request->input('customer_cellular');
			$model->customer_address = $request->input('customer_address');
			$model->customer_location = $request->input('customer_location');
			$model->customer_postcode = $request->input('customer_postcode');
			$model->customer_latitude = $request->input('customer_latitude');
			$model->customer_longitude = $request->input('customer_longitude');
			
			if (! $model->save()){
				return array('error' => true, 'message' => Lang::get('messages.error'));
			}

			return array('error' => false, 'message' => Lang::get('messages.success'));

		} catch (Exception $e) {
			
			 return array('error' => true, 'message' => Lang::get('messages.error_caught_exception') . ' ' . str_replace("'"," ", strstr($e->getMessage(), '(SQL:', true)));
		}	

	}


	public function update($request, $id)
	{
		try{
			// store the data to the database
			$model = $this->model->withTrashed()->find($id);

			$model->company_id = $request->input('company_id');
			$model->customer_commercial_name = $request->input('customer_commercial_name');
			$model->customer_legal_name = $request->input('customer_legal_name');
			$model->customer_tax_id	= $request->input('customer_tax_id');
  		    $model->customer_website = $request->input('customer_website');
			$model->customer_email = $request->input('customer_email');
			$model->customer_contact = $request->input('customer_contact');
			$model->customer_phone = $request->input('customer_phone');
			$model->customer_cellular = $request->input('customer_cellular');
			$model->customer_address = $request->input('customer_address');
			$model->customer_location = $request->input('customer_location');
			$model->customer_postcode = $request->input('customer_postcode');
			$model->customer_latitude = $request->input('customer_latitude');
			$model->customer_longitude = $request->input('customer_longitude');
			$model->deleted_at = null;
			$model->touch();
			
			if (! $model->update()){
				return array('error' => true, 'message' => Lang::get('messages.error'));
			}

			return array('error' => false, 'message' => Lang::get('messages.success'));

		} catch (Exception $e) {

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

			return array('error' => true, 'message' => Lang::get('messages.error_caught_exception') . ' ' . str_replace("'"," ", strstr($e->getMessage(), '(SQL:', true)));
		}	
	}

  public function search($companyId, $value, $itemsByPage)
	{
		$customers = $this->model->withTrashed()
			->select(
			'id', 'customer_commercial_name', 'customer_legal_name', 'customer_tax_id', 'customer_website',
			'customer_email','customer_contact', 'customer_phone',	'customer_cellular',	'customer_address',
			'customer_location', 'customer_postcode',	'customer_latitude',	'customer_longitude','deleted_at'
		)
		->where('company_id','=', $companyId)	
		->where('id','like','%' . $value . '%')
			->orwhere(function ($query) use ($value){
			  	$query->orwhere('customer_commercial_name','like','%' . $value . '%')
						->orwhere('customer_email','like','%' . $value . '%')
						->orwhere('customer_contact','like','%' . $value . '%')
						->orwhere('customer_phone','like','%' . $value . '%')
						->orwhere('customer_cellular','like','%' . $value . '%')
						->orwhere('customer_address','like','%' . $value . '%');
		})
		
		->paginate($itemsByPage);

		return $customers;
      	
	}

	public function importFile($file)
	{
		/*=====================	RULES TO IMPORt FILES ========================================
		1) The first row must be the fields hearder .
		2) if the row has a value in the ID Field it will be update if not will be added.
		===================================================================================*/
		// Begin a Transaction
		DB::beginTransaction();
		try {
			$addedRecords=0; // caount add records
			$updateRecords=0; // count update records
			for ($i=1; $i <=count($file) ; $i++) { 
				//validate if $id was found so UPDATE it
				if (array_key_exists('id', $file[$i])) {
					$rowId = $this->model->withTrashed()->find($file[$i]['id']);
					if (isset($rowId)){
						//$rowId->companyId = $file[$i]['company_id'];
						$rowId->customer_commercial_name = $file[$i]['customer_commercial_name'];
						$rowId->customer_legal_name = $file[$i]['customer_legal_name'];
						$rowId->customer_tax_id	= $file[$i]['customer_tax_id'];
						$rowId->customer_website = $file[$i]['customer_website'];
						$rowId->customer_email = $file[$i]['customer_email'];
						$rowId->customer_contact = $file[$i]['customer_contact'];
						$rowId->customer_phone = $file[$i]['customer_phone'];
						$rowId->customer_cellular = $file[$i]['customer_cellular'];
						$rowId->customer_address = $file[$i]['customer_address'];
						$rowId->customer_location = $file[$i]['customer_location'];
						$rowId->customer_postcode = $file[$i]['customer_postcode'];
						$rowId->customer_latitude = $file[$i]['customer_latitude'];
						$rowId->customer_longitude = $file[$i]['customer_longitude'];
						$rowId->deleted_at = null;
						$rowId->touch();  			//touch: update timestamps
						$rowId->save();
						$updateRecords++;
					} else {
						log::info('Error Row===>' . $rowId . ' ID:' . $file[$i]['id']);
					}
					
				} else {
					$id = $this->model->withTrashed()->select('id')->where('customer_name',"=", $file[$i]['customer_name'])->get();
					$rowId = $this->model->withTrashed()->find($id);
					if (isset($rowId)) {
						//$rowId->companyId = $file[$i]['company_id'];
						$rowId->customer_commercial_name = $file[$i]['customer_commercial_name'];
						$rowId->customer_legal_name = $file[$i]['customer_legal_name'];
						$rowId->customer_tax_id	= $file[$i]['customer_tax_id'];
						$rowId->customer_website = $file[$i]['customer_website'];
						$rowId->customer_email = $file[$i]['customer_email'];
						$rowId->customer_contact = $file[$i]['customer_contact'];
						$rowId->customer_phone = $file[$i]['customer_phone'];
						$rowId->customer_cellular = $file[$i]['customer_cellular'];
						$rowId->customer_address = $file[$i]['customer_address'];
						$rowId->customer_location = $file[$i]['customer_location'];
						$rowId->customer_postcode = $file[$i]['customer_postcode'];
						$rowId->customer_latitude = $file[$i]['customer_latitude'];
						$rowId->customer_longitude = $file[$i]['customer_longitude'];
						$rowId->deleted_at = null;
						$rowId->touch();  			//touch: update timestamps
						$rowId->save();
						$updateRecords++;
					} else {
						$rowId = new $this->model;
						//$rowId->companyId = $file[$i]['company_id'];
						$rowId->customer_commercial_name = $file[$i]['customer_commercial_name'];
						$rowId->customer_legal_name = $file[$i]['customer_legal_name'];
						$rowId->customer_tax_id	= $file[$i]['customer_tax_id'];
						$rowId->customer_website = $file[$i]['customer_website'];
						$rowId->customer_email = $file[$i]['customer_email'];
						$rowId->customer_contact = $file[$i]['customer_contact'];
						$rowId->customer_phone = $file[$i]['customer_phone'];
						$rowId->customer_cellular = $file[$i]['customer_cellular'];
						$rowId->customer_address = $file[$i]['customer_address'];
						$rowId->customer_location = $file[$i]['customer_location'];
						$rowId->customer_postcode = $file[$i]['customer_postcode'];
						$rowId->customer_latitude = $file[$i]['customer_latitude'];
						$rowId->customer_longitude = $file[$i]['customer_longitude'];
						$rowId->deleted_at = null;
						$rowId->save();
						$addedRecords++;
					}
				}
			}
			if (($addedRecords+$updateRecords)==0) {
				DB::rollBack();
				return array('error' => true, 'message' => Lang::get('messages.error') . ' ' . Lang::get('messages.error_file_format'));
			} else {
				DB::commit();
				return array('error' => false, 'message' => Lang::get('messages.success_add') . ' ' .  $addedRecords . ' ' . Lang::get('messages.success_update') . ' ' . $updateRecords . ' ' . Lang::get('messages.successfully'));
			} 
		} catch (Exception $e) {
			DB::rollBack();
			return array('error' => true, 'message' => Lang::get('messages.error_caught_exception') . ' ' . str_replace("'"," ", strstr($e->getMessage(), '(SQL:', true)));
		}
	}	
}