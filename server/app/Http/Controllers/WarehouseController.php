<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\RegisterTransactionAccessEvent;
use MyCode\Repositories\Warehouse\WarehouseRepositoryInterface;
use MyCode\Services\Document\DocumentServiceInterface;


class WarehouseController extends Controller
{
  protected $warehouseRepository;

  protected $documentService;

  private $baseRoute = 'shipper.warehouses';

  private $itemsByPage = 10;

  public function __construct(WarehouseRepositoryInterface $warehouseRepository,
                              DocumentServiceInterface $documentService)

  {
    $this->warehouseRepository = $warehouseRepository;

    $this->documentService   = $documentService;
    
  }
  
  /**
  * Display a listing of the resource.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {

    $warehouses = $this->warehouseRepository->getByPageWithFilters($request);
    
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

    if (! $result['error']) {

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
  * Export all warehouses from Excel
  *
  * @param  \Illuminate\Http\Request  $request
  * @return Response
  */
	public function export(Request $request) 
	{ 
    $data = $this->warehouseRepository->getAllWithFilters($request);

		$result =$this->documentService->export($data, 'csv', 'Warehouses');

		if (! $result['error']){

			// Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		}

		return response()->json($result); 
  }
  
  /**
  * Import all warehouses from Excel
  *
  * @param  \Illuminate\Http\Request  $request
  * @return Response
  */
  public function import(Request $request) 
  {
    $result = [];

    $file = $request->file('fileToImport');
    //validate the request if file is missing send an error to user
    if (empty($file)) {
      
      $result = array('error' => true, 'message' => Lang::get('messages.error'));
      
      return response()->json($result);

    }
      
    $result = $this->warehouseRepository->import($file);

    if (! $result['error']) {

      // Event::fire(new RegisterTransactionAccessEvent('facilities.institutes.import'));

    }
    
    return response()->json($result);
  }

  
  public function getWarehouseByCustomerID(Request $request) 
  {
    $customerId = 1; 

    $warehouses = $this->warehouseRepository->getByPageWithFilters($request);

    return  response()->json($warehouses);
  }

  
  public function getAllWarehousesActive(Request $request) 
	{ 
    $warehouses = $this->warehouseRepository->getAllActive($request);

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($warehouses); 
	}

  
  public function getAllWarehousesIdAndNamesActive(Request $request) 
	{ 
    $warehouses = $this->warehouseRepository->getAllIdAndNameActive($request);

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($warehouses); 
	}


  public function show (Request $request) 
  {

  }
	
}
