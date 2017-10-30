<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\RegisterTransactionAccessEvent;
use MyCode\Repositories\Customer\CustomerRepositoryInterface;
use MyCode\Services\Document\DocumentServiceInterface;


class CustomerController extends Controller
{
  protected $customerRepository;

  protected $documentService;

  private $baseRoute = 'shipper.customers';

  private $itemsByPage = 10;

  public function __construct(CustomerRepositoryInterface $customerRepository,
                              DocumentServiceInterface $documentService)

  {
    $this->customerRepository = $customerRepository;

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

    $customers = $this->customerRepository->getByPageWithFilters($request);
    
    //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.index'));
    
    return response()->json($customers);
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
		
    $result = $this->customerRepository->store($request);

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
    $customers = $this->customerRepository->getById($id);

    //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.edit'));

    return response()->json($customers);
	}

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \MyCode\Models\Customer  $customers
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $result = [];

    $result = $this->customerRepository->update($request, $id);

    if (! $result['error']) {

      //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.update'));

    }

    return response()->json($result);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \MyCode\Models\Customer  $customers
  * @return \Illuminate\Http\Response
  */
  public function destroy(Request $request)
  {
    $result = [];

		$result=$this->customerRepository->delete($request->id);

		if (! $result['error']){

      //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.delete'));		
      
		}

	 	return response()->json($result);
  }

  /**
  * Export all customers from Excel
  *
  * @param  \Illuminate\Http\Request  $request
  * @return Response
  */
	public function export(Request $request) 
	{ 
    $data = $this->customerRepository->getAllWithFilters($request);

    \Log::info($data);
		$result =$this->documentService->export($data, 'csv', 'Customers');

		if (! $result['error']){

			// Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		}

		return response()->json($result); 
  }
  
  /**
  * Import all customers from Excel
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
      
    $result = $this->customerRepository->import($file);

    if (! $result['error']) {

      // Event::fire(new RegisterTransactionAccessEvent('facilities.institutes.import'));

    }
    
    return response()->json($result);
  }

  
  public function getCustomerByCompanyID(Request $request) 
  {
    $companyId = 1; 

    $customers = $this->customerRepository->getByPageWithFilters($request);

    return  response()->json($customers);
  }

  
  public function getAllCustomersActive(Request $request) 
	{ 

    $customers = $this->customerRepository->getAllActive($request);

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($customers); 
	}

  
  public function getAllCustomersIdAndNamesActive(Request $request) 
	{ 
    $customers = $this->customerRepository->getAllIdAndNameActive($request);

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($customers); 
	}


  public function show (Request $request) 
  {

  }
	
}
