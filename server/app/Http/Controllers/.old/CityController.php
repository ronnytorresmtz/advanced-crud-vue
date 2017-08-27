<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MyCode\Repositories\City\CityRepositoryInterface;

class CityController extends Controller
{
    public function __construct(CityRepositoryInterface $cityRepository)
    {
        return response()->json(
            
            $this->cityRepository = $cityRepository

        );
    }
    
    
    public function getAllCities()
    {
        return response()->json(
            
            $this->CityRepository->getAllCitiesActive()
        
        );

    }
}
