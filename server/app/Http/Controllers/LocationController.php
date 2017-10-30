<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\RegisterTransactionAccessEvent;
use MyCode\Repositories\Location\LocationRepositoryInterface;


class LocationController extends Controller
{
  protected $locationRepository;
  private $baseRoute = 'admin.locations';
  private $itemsByPage = 10;

  public function __construct(Request $request, LocationRepositoryInterface $locationRepository)
  {
    $this->locationRepository = $locationRepository;
    $this->itemsByPage = $request->per_pages;

  }
  
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $locations = $this->locationRepository->getByPage($this->itemsByPage);
    //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.index'));
    return response()->json($locations);
  }

  /**
    * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $result = [];
		
    $result = $this->locationRepository->store($request);

    if  ($result['error']){
     // Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.store'));
    }

		return response()->json($result);
  }

  /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
    $locations = $this->locationRepository->getById($id);
    //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.edit'));
    return response()->json($locations);
	}

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \MyCode\Models\Locations  $locations
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $result = [];
    
    $result = $this->locationRepository->update($request, $id);

    if (! $result['error']){
      //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.update'));
    }

		return response()->json($result);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \MyCode\Models\Locations  $locations
  * @return \Illuminate\Http\Response
  */
  public function destroy(Request $request)
  {
    $result = [];

		$result=$this->locationRepository->delete($request->id);

		if (! $result['error']){
			//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.delete'));		
		}

	 	return response()->json($result);
  }

  /**
  * Search the specified test in the storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function search(Request $request) 
	{
		$value = $request->searchText;

		$locations = $this->locationRepository->search($value, $this->itemsByPage);
		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.search'));

		return response()->json($locations);
	}

  /**
  * Export all moduleas to Excel
  *
  * @return Response
  */
	public function export() 
	{ 

    $locations = $this->locationRepository->get();

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($locations); 
	}

  public function import(Request $request) 
	{ 
    $result = [];

		$file = json_decode($request->data, true);
		//validate the request if file is missing send an error to user
		if (! empty($file)) {
			
			$result = $this->locationRepository->importFile($file);

			if (! $result['error']){
				//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.import'));
			}

		}
		
		return response()->json($result);
	}

  public function getAllLocationsActive() 
	{ 
    
    $locations = $this->locationRepository->getAll();

    //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($locations); 
	}

  public function show (Request $request) 
  {

  }
	
}
