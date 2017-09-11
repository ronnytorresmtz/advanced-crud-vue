<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\RegisterTransactionAccessEvent;
use MyCode\Repositories\Company\CompanyRepositoryInterface;
use MyCode\Services\Document\DocumentServiceInterface;


class CompanyController extends Controller
{
  protected $companyRepository;
  protected $documentService;

  private $baseRoute = 'shipper.companies';
  private $itemsByPage = 10;


  public function __construct(Request $request, 
                              CompanyRepositoryInterface $companyRepository,
                              DocumentServiceInterface $documentService)
  {
    $this->companyRepository = $companyRepository;
    $this->documentService   = $documentService;
    if ($request->per_pages) {
      $this->itemsByPage = $request->per_pages;
    } else {
      $this->itemsByPage = $this->itemsByPage;
    }
  }
  
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    $companies = $this->companyRepository->getByPage($request);
    //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.index'));
    return response()->json($companies);
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
		
    $result = $this->companyRepository->store($request);

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
    $companies = $this->companyRepository->getById($id);
    //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.edit'));
    return response()->json($companies);
	}

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \MyCode\Models\Companies  $companies
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $result = [];

    $result = $this->companyRepository->update($request, $id);

    if (! $result['error']){
      //Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.update'));
    }

		return response()->json($result);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \MyCode\Models\Companies  $companies
  * @return \Illuminate\Http\Response
  */
  public function destroy(Request $request)
  {
    
    $result = [];
 
 		$result = $this->companyRepository->delete($request->id);
		if (! $result['error']){
			//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.delete'));		
		}

	 	return response()->json($result);
  }

  /**
  * Export all moduleas to Excel
  *
  * @return Response
  */
	public function export() 
	{ 

    $data = $this->companyRepository->getAll();

		$result =$this->documentService->export($data, 'csv', 'Module');

		if (! $result['error']){

			// Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		}

		return response()->json($result); 
	}

  public function import(Request $request) 
	{ 
    $result = [];

		$file = json_decode($request->data, true);
		//validate the request if file is missing send an error to user
		if (! empty($file)) {
			
			$result = $this->companyRepository->importFile($file);

			if (! $result['error']){
				//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.import'));
			}

		}
		
		return response()->json($result);
	}


  public function getAllCompaniesActive() 
	{ 

    $companies = $this->companyRepository->getAllActive();

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($companies); 
	}

  public function getAllCompaniesIdAndNamesActive() 
	{ 

    $companies = $this->companyRepository->getAllIdAndNameActive();

		//Event::fire(new RegisterTransactionAccessEvent($this->baseRoute . '.export'));

		return response()->json($companies); 
	}


  public function show (Request $request) 
  {

  }
	
}
