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
		$companies=$this->model->withTrashed()
		->select(
			'id', 'company_name', 'company_legal_name', 'company_tax_id', 'company_website',
			'company_email','company_contact', 'company_phone',	'company_cellular',	'company_address',
			'company_location', 'company_postcode',	'company_latitude',	'company_longitude','deleted_at'
			
		)->get();

		return $companies;
	}

	public function getAllActive()
	{
		$companies=$this->model
		->select(
			'id', 'company_name', 'company_legal_name', 'company_tax_id', 'company_website',
			'company_email','company_contact', 'company_phone',	'company_cellular',	'company_address',
			'company_location', 'company_postcode',	'company_latitude',	'company_longitude','deleted_at'
			
		)->get();

		return $companies;
	}

	public function getAllIdAndNameActive()
	{
		$companies=$this->model->select('id', 'company_name')->get();

		return $companies;
	}

	public function getById($id)
	{
		$companies=$this->model->withTrashed()
		->select(
			'id', 'company_name', 'company_legal_name', 'company_tax_id', 'company_website',
			'company_email','company_contact', 'company_phone',	'company_cellular',	'company_address',
			'company_location', 'company_postcode',	'company_latitude',	'company_longitude','deleted_at'
		)

		->where('id','=', $id)
		->get();

		return $companies;
	}

	public function getByPage($itemsByPage)
	{
		$companies = $this->model->withTrashed()
			->select(
				'id', 'deleted_at','company_name', 'company_contact', 'company_email', 'company_phone',
				'company_cellular',	'company_location', 'company_address', 'company_postcode',	
				'company_latitude',	'company_longitude', 'company_legal_name', 'company_tax_id', 'company_website'
			)
			
			->paginate($itemsByPage);

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
		$companies = $this->model->withTrashed()
			->select(
			'id', 'company_name', 'company_legal_name', 'company_tax_id', 'company_website',
			'company_email','company_contact', 'company_phone',	'company_cellular',	'company_address',
			'company_location', 'company_postcode',	'company_latitude',	'company_longitude','deleted_at'
		)

		->where('id','like','%' . $value . '%')
			->orwhere(function ($query) use ($value){
			  	$query->orwhere('company_name','like','%' . $value . '%')
						->orwhere('company_email','like','%' . $value . '%')
						->orwhere('company_contact','like','%' . $value . '%')
						->orwhere('company_phone','like','%' . $value . '%')
						->orwhere('company_cellular','like','%' . $value . '%')
						->orwhere('company_address','like','%' . $value . '%');
		})
		
		->paginate($itemsByPage);

		return $companies;
      	
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
						$rowId->company_name = $file[$i]['company_name'];
						$rowId->company_legal_name = $file[$i]['company_legal_name'];
						$rowId->company_tax_id	= $file[$i]['company_tax_id'];
						$rowId->company_website = $file[$i]['company_website'];
						$rowId->company_email = $file[$i]['company_email'];
						$rowId->company_contact = $file[$i]['company_contact'];
						$rowId->company_phone = $file[$i]['company_phone'];
						$rowId->company_cellular = $file[$i]['company_cellular'];
						$rowId->company_address = $file[$i]['company_address'];
						$rowId->company_location = $file[$i]['company_location'];
						$rowId->company_postcode = $file[$i]['company_postcode'];
						$rowId->company_latitude = $file[$i]['company_latitude'];
						$rowId->company_longitude = $file[$i]['company_longitude'];
						$rowId->deleted_at = null;
						$rowId->touch();  			//touch: update timestamps
						$rowId->save();
						$updateRecords++;
					} else {
						log::info('Error Row===>' . $rowId . ' ID:' . $file[$i]['id']);
					}
					
				} else {
					$id = $this->model->withTrashed()->select('id')->where('company_name',"=", $file[$i]['company_name'])->get();
					$rowId = $this->model->withTrashed()->find($id);
					if (isset($rowId)) {
						$rowId->company_name = $file[$i]['company_name'];
						$rowId->company_legal_name = $file[$i]['company_legal_name'];
						$rowId->company_tax_id	= $file[$i]['company_tax_id'];
						$rowId->company_website = $file[$i]['company_website'];
						$rowId->company_email = $file[$i]['company_email'];
						$rowId->company_contact = $file[$i]['company_contact'];
						$rowId->company_phone = $file[$i]['company_phone'];
						$rowId->company_cellular = $file[$i]['company_cellular'];
						$rowId->company_address = $file[$i]['company_address'];
						$rowId->company_location = $file[$i]['company_location'];
						$rowId->company_postcode = $file[$i]['company_postcode'];
						$rowId->company_latitude = $file[$i]['company_latitude'];
						$rowId->company_longitude = $file[$i]['company_longitude'];
						$rowId->deleted_at = null;
						$rowId->touch();  			//touch: update timestamps
						$rowId->save();
						$updateRecords++;
					} else {
						$rowId = new $this->model;
						$rowId->company_name = $file[$i]['company_name'];
						$rowId->company_legal_name = $file[$i]['company_legal_name'];
						$rowId->company_tax_id	= $file[$i]['company_tax_id'];
						$rowId->company_website = $file[$i]['company_website'];
						$rowId->company_email = $file[$i]['company_email'];
						$rowId->company_contact = $file[$i]['company_contact'];
						$rowId->company_phone = $file[$i]['company_phone'];
						$rowId->company_cellular = $file[$i]['company_cellular'];
						$rowId->company_address = $file[$i]['company_address'];
						$rowId->company_location = $file[$i]['company_location'];
						$rowId->company_postcode = $file[$i]['company_postcode'];
						$rowId->company_latitude = $file[$i]['company_latitude'];
						$rowId->company_longitude = $file[$i]['company_longitude'];
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