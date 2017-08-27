<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\RegisterTransactionAccessEvent;
use MyCode\Repositories\Warehouse\WarehouseRepositoryInterface;


class WarehouseController extends Controller
{
  protected $warehouseRepository;
  private $baseRoute = 'shipper.warehouses';
  private $itemsByPage = 10;

  public function __construct(Request $request, WarehouseRepositoryInterface $warehouseRepository)
  {
    $this->warehouseRepository = $warehouseRepository;
    $this->itemsByPage = $request->per_pages;
  }
  
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $warehouseId = 1;

    $warehouses = $this->warehouseRepository->getByPage($warehouseId, $this->itemsByPage);
    //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.index'));
    return response()->json($warehouses);
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
		
    $result = $this->warehouseRepository->store($request);

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
    $warehouses = $this->warehouseRepository->getById($id);
    //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.edit'));
    return response()->json($warehouses);
	}

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \MyCode\Models\Warehouse  $warehouses
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $result = [];
    
    $result = $this->warehouseRepository->update($request, $id);

    if (! $result['error']){
      //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.update'));
    }

		return response()->json($result);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \MyCode\Models\Warehouse  $warehouses
  * @return \Illuminate\Http\Response
  */
  public function destroy(Request $request)
  {
    $result = [];

		$result=$this->warehouseRepository->delete($request->id);

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

		$warehouses = $this->warehouseRepository->search(
          $request->warehouseId,  
          $request->searchText, 
          $this->itemsByPage
    );
		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.search'));

		return response()->json($warehouses);
	}

  /**
  * Export all moduleas to Excel
  *
  * @return Response
  */
	public function export() 
	{ 

    $warehouses = $this->warehouseRepository->getAll();

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($warehouses); 
	}

  public function import(Request $request) 
	{ 
    $result = [];

		$file = json_decode($request->data, true);
		//validate the request if file is missing send an error to user
		if (! empty($file)) {
			
			$result = $this->warehouseRepository->importFile($file);

			if (! $result['error']){
				//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.import'));
			}

		}
		
		return response()->json($result);
	}

  
  public function getWarehousesByCustumerID($id) 
  {
    $warehouses = $this->warehouseRepository->getByPage($id, $this->itemsByPage);

    return  response()->json($warehouses);
  }


  public function show (Request $request) 
  {

  }
	
}
