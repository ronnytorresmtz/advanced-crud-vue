<?php namespace MyCode\Repositories\Location;
 
use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\Location\LocationRepositoryInterface;
use MyCode\Models\Location;
use App\Exeptions\EmailAlreadyExistException;

use Lang, DB, Exception, Log;
 
class LocationRepository extends MyAbstractEloquentRepository implements LocationRepositoryInterface 
{
 
	protected $location;

	public function __construct(Location $location) 
	{
	  $this->model = $location; 
	}


	public function get()
	{
		$locations = $this->model->withTrashed()
		->select(
			'id', 
			'location_name', 
			'deleted_at'
		)->get();

		return $locations;
	}

	public function getAll()
	{
		$locations = $this->model
		->select(
			'id', 
			'location_name', 
			'deleted_at'
		)
		->get();

		return $locations;
	}

	public function getById($id)
	{
		$locations = $this->model->withTrashed()
		->select(
			'id', 
			'location_name', 
			'deleted_at'
		)

		->where('id','=', $id)
		->get();

		return $locations;
	}

	public function getByPage($itemsByPage)
	{
		$locations = $this->model->withTrashed()
		->select(
			'id', 
			'location_name', 
			'deleted_at'
		)
		
		->paginate($itemsByPage);

		return $locations;
	}

  public function store($request)
	{
		try{
			// store the data to the database
			$model = new Location;		
			$model->location_name = $request->input('location_name');
			
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
			$model->location_name = $request->input('location_name');
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


	public function delete($id){

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

  public function search($value, $itemsByPage)
	{
		$locations = $this->model->withTrashed()
			->select(
			'id', 
			'location_name', 
			'deleted_at'
		)

		->where('id','like','%' . $value . '%')
			->orwhere(function ($query) use ($value){
			  	$query->orwhere('location_name','like','%' . $value . '%');
		})
		
		->paginate($itemsByPage);
      	
		return $locations;
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
						$rowId->location_name = $file[$i]['location_name'];
						$rowId->deleted_at = null;
						$rowId->touch();  			//touch: update timestamps
						$rowId->save();
						$updateRecords++;
					} else {
						log::info('Error Row===>' . $rowId . ' ID:' . $file[$i]['id']);
					}
					
				} else {
					$id = $this->model->withTrashed()->select('id')->where('location_name',"=", $file[$i]['location_name'])->get();
					$rowId = $this->model->withTrashed()->find($id);
					if (isset($rowId)) {
						$rowId->location_name = $file[$i]['location_name'];
						$rowId->deleted_at = null;
						$rowId->touch();  			//touch: update timestamps
						$rowId->save();
						$updateRecords++;
					} else {
						$rowId = new $this->model;
						$rowId->location_name = $file[$i]['location_name'];
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