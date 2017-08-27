<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MyCode\Repositories\Country\CountryRepositoryInterface;
use MyCode\Repositories\State\StateRepositoryInterface;

class CountryController extends Controller
{
    public function __construct(CountryRepositoryInterface $countryRepository,
                                StateRepositoryInterface $stateRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
    }
    
    
    public function getAllCountries()
    {
        return response()->json(

            $this->countryRepository->getAllCountriesActive()
        
        );
    }

    
    public function getAllStatesByCountryId($countryId)
    {
        return response()->json(
            
            $this->stateRepository->getAllStatesActiveByCountryId($countryId)
            
        );
    }

}
