<?php namespace MyCode\Repositories\Warehouse;
 
use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\Warehouse\WarehouseRepositoryInterface;
use MyCode\Models\Warehouse;
use App\Exeptions\EmailAlreadyExistException;

use Lang, DB, Exception, Log;
 
class WarehouseRepository extends MyAbstractEloquentRepository implements WarehouseRepositoryInterface 
{
 
	protected $warehouse;

	public function __construct(Warehouse $warehouse) 
	{
	  $this->model = $warehouse; 
	}


	public function getAll($customerId)
	{
		$warehouses = $this->model->withTrashed()
		->select(
			'id', 'warehouse_name', 'warehouse_location', 'warehouse_email',
			'warehouse_contact', 'warehouse_phone',	'warehouse_cellular','warehouse_address',
			'warehouse_postcode', 'warehouse_latitude','warehouse_longitude','deleted_at'
			
		)
		//->where('customer_id','=', $customerId)
		->get();

		return $warehouses;
	}

	public function getById($id)
	{
		$warehouses=$this->model->withTrashed()
		->select(
			'id', 'warehouse_name', 'warehouse_location', 'warehouse_email',
			'warehouse_contact', 'warehouse_phone',	'warehouse_cellular','warehouse_address',
			'warehouse_postcode', 'warehouse_latitude','warehouse_longitude','deleted_at'
		)

		->where('id','=', $id)
		->get();

		return $warehouses;
	}

	public function getByPage($customerId, $itemsByPage)
	{
		$warehouses = $this->model->withTrashed()
			->select(
				'id', 'warehouse_name', 'warehouse_location', 'warehouse_email',
				'warehouse_contact', 'warehouse_phone',	'warehouse_cellular','warehouse_address',
				'warehouse_postcode', 'warehouse_latitude','warehouse_longitude','deleted_at'
			) 
			->where('customer_id','=', $customerId)
			->paginate($itemsByPage);

		return $warehouses;
	}

  public function store($request)
	{
		try{
			// store the data to the database
			$model = new Warehouse;		
			
			$model->customer_id = $request->input('customer_id');
			$model->warehouse_name = $request->input('warehouse_name');
			$model->warehouse_location = $request->input('warehouse_location');
			$model->warehouse_email = $request->input('warehouse_email');
			$model->warehouse_contact = $request->input('warehouse_contact');
			$model->warehouse_phone = $request->input('warehouse_phone');
			$model->warehouse_cellular = $request->input('warehouse_cellular');
			$model->warehouse_address = $request->input('warehouse_address');
			$model->warehouse_postcode = $request->input('warehouse_postcode');
			$model->warehouse_latitude = $request->input('warehouse_latitude');
			$model->warehouse_longitude = $request->input('warehouse_longitude');
			
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

			$model->customer_id = $request->input('customer_id');
			$model->warehouse_name = $request->input('warehouse_name');
			$model->warehouse_location = $request->input('warehouse_location');
			$model->warehouse_email = $request->input('warehouse_email');
			$model->warehouse_contact = $request->input('warehouse_contact');
			$model->warehouse_phone = $request->input('warehouse_phone');
			$model->warehouse_cellular = $request->input('warehouse_cellular');
			$model->warehouse_address = $request->input('warehouse_address');
			$model->warehouse_postcode = $request->input('warehouse_postcode');
			$model->warehouse_latitude = $request->input('warehouse_latitude');
			$model->warehouse_longitude = $request->input('warehouse_longitude');
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

  public function search($customerId, $value, $itemsByPage)
	{
		$warehouses = $this->model->withTrashed()
			->select(
			'id', 'warehouse_name', 'warehouse_location', 'warehouse_email',
			'warehouse_contact', 'warehouse_phone',	'warehouse_cellular','warehouse_address',
			'warehouse_postcode', 'warehouse_latitude','warehouse_longitude','deleted_at'
		)
		->where('customer_id','=', $customerId)	
		->where('id','like','%' . $value . '%')
			->orwhere(function ($query) use ($value){
			  	$query->orwhere('warehouse_name','like','%' . $value . '%')
				  		->orwhere('warehouse_location','like','%' . $value . '%')
						->orwhere('warehouse_email','like','%' . $value . '%')
						->orwhere('warehouse_contact','like','%' . $value . '%')
						->orwhere('warehouse_phone','like','%' . $value . '%')
						->orwhere('warehouse_cellular','like','%' . $value . '%')
						->orwhere('warehouse_address','like','%' . $value . '%');
		})
		
		->paginate($itemsByPage);

		return $warehouses;
      	
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
						//$rowId->customerId = $file[$i]['customer_id'];
						$rowId->warehouse_name = $file[$i]['warehouse_name'];
						$rowId->warehouse_location = $file[$i]['warehouse_location'];
						$rowId->warehouse_email = $file[$i]['warehouse_email'];
						$rowId->warehouse_contact = $file[$i]['warehouse_contact'];
						$rowId->warehouse_phone = $file[$i]['warehouse_phone'];
						$rowId->warehouse_cellular = $file[$i]['warehouse_cellular'];
						$rowId->warehouse_address = $file[$i]['warehouse_address'];
						$rowId->warehouse_postcode = $file[$i]['warehouse_postcode'];
						$rowId->warehouse_latitude = $file[$i]['warehouse_latitude'];
						$rowId->warehouse_longitude = $file[$i]['warehouse_longitude'];
						$rowId->deleted_at = null;
						$rowId->touch();  			//touch: update timestamps
						$rowId->save();
						$updateRecords++;
					} else {
						log::info('Error Row===>' . $rowId . ' ID:' . $file[$i]['id']);
					}
					
				} else {
					$id = $this->model->withTrashed()->select('id')->where('warehouse_name',"=", $file[$i]['warehouse_name'])->get();
					$rowId = $this->model->withTrashed()->find($id);
					if (isset($rowId)) {
						//$rowId->customerId = $file[$i]['customer_id'];
						$rowId->warehouse_name = $file[$i]['warehouse_name'];
						$rowId->warehouse_location = $file[$i]['warehouse_location'];
						$rowId->warehouse_email = $file[$i]['warehouse_email'];
						$rowId->warehouse_contact = $file[$i]['warehouse_contact'];
						$rowId->warehouse_phone = $file[$i]['warehouse_phone'];
						$rowId->warehouse_cellular = $file[$i]['warehouse_cellular'];
						$rowId->warehouse_address = $file[$i]['warehouse_address'];
						$rowId->warehouse_postcode = $file[$i]['warehouse_postcode'];
						$rowId->warehouse_latitude = $file[$i]['warehouse_latitude'];
						$rowId->warehouse_longitude = $file[$i]['warehouse_longitude'];
						$rowId->deleted_at = null;
						$rowId->touch();  			//touch: update timestamps
						$rowId->save();
						$updateRecords++;
					} else {
						$rowId = new $this->model;
						//$rowId->customerId = $file[$i]['customer_id'];
						$rowId->warehouse_name = $file[$i]['warehouse_name'];
						$rowId->warehouse_location = $file[$i]['warehouse_location'];
						$rowId->warehouse_email = $file[$i]['warehouse_email'];
						$rowId->warehouse_contact = $file[$i]['warehouse_contact'];
						$rowId->warehouse_phone = $file[$i]['warehouse_phone'];
						$rowId->warehouse_cellular = $file[$i]['warehouse_cellular'];
						$rowId->warehouse_address = $file[$i]['warehouse_address'];
						$rowId->warehouse_postcode = $file[$i]['warehouse_postcode'];
						$rowId->warehouse_latitude = $file[$i]['warehouse_latitude'];
						$rowId->warehouse_longitude = $file[$i]['warehouse_longitude'];
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