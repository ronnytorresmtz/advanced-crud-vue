<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\RegisterTransactionAccessEvent;
use MyCode\Repositories\Customer\CustomerRepositoryInterface;


class CustomerController extends Controller
{
  protected $customerRepository;
  private $baseRoute = 'shipper.customers';
  private $itemsByPage = 10;

  public function __construct(Request $request, CustomerRepositoryInterface $customerRepository)
  {
    $this->customerRepository = $customerRepository;
    $this->itemsByPage = $request->per_pages;
  }
  
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $companyId = 1;

    $customers = $this->customerRepository->getByPage($companyId, $this->itemsByPage);
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

    if (! $result['error']){
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
  * Search the specified test in the storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function search(Request $request) 
	{

		$customers = $this->customerRepository->search(
          $request->companyId,  
          $request->searchText, 
          $this->itemsByPage
    );
		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.search'));

		return response()->json($customers);
	}

  /**
  * Export all moduleas to Excel
  *
  * @return Response
  */
	public function export() 
	{ 

    $customers = $this->customerRepository->getAll();

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($customers); 
	}

  public function import(Request $request) 
	{ 
    $result = [];

		$file = json_decode($request->data, true);
		//validate the request if file is missing send an error to user
		if (! empty($file)) {
			
			$result = $this->customerRepository->importFile($file);

			if (! $result['error']){
				//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.import'));
			}

		}
		
		return response()->json($result);
	}

  
  public function getCustomerByCompanyID($id) 
  {
    $customers = $this->customerRepository->getByPage($id, $this->itemsByPage);

    return  response()->json($customers);
  }

  public function getAllCustomersActive() 
	{ 

    $customers = $this->customerRepository->getAllActive();

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($customers); 
	}

  public function getAllCustomersIdAndNamesActive() 
	{ 
    $customers = $this->customerRepository->getAllIdAndNameActive();

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($customers); 
	}


  public function show (Request $request) 
  {

  }
	
}
