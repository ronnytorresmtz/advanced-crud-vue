<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MyCode\Repositories\State\StateRepositoryInterface;
use MyCode\Repositories\City\CityRepositoryInterface;

class StateController extends Controller
{
    public function __construct(StateRepositoryInterface $stateRepository,
                                CityRepositoryInterface $cityRepository)
    {
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
    }
    
    
    public function getAllStates()
    {
        return response()->json(
            
            $this->stateRepository->getAllStatesActive()
            
        );
    }


    public function getAllCitiesByStateId($stateId)
    {
        return response()->json(
            
            $this->cityRepository->getAllCitiesActiveByStateId($stateId)
        
        );
    }

}
