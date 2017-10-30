<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MyCode\Repositories\Company\CompanyRepository;
use MyCode\Repositories\Customer\CustomerRepository;
use MyCode\Repositories\Warehouse\WarehouseRepository;
use MyCode\Repositories\Location\LocationRepository;
use MyCode\Services\Document\DocumentService;
use MyCode\Models\Company;
use MyCode\Models\Customer;
use MyCode\Models\Warehouse;
use MyCode\Models\Location;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      
      $this->app->bind('MyCode\Repositories\Company\CompanyRepositoryInterface', function($app) 
      {

        return new CompanyRepository(new Company);

      });

      $this->app->bind('MyCode\Repositories\Customer\CustomerRepositoryInterface', function($app) 
      {

        return new CustomerRepository(new Customer, new Company);

      });

      $this->app->bind('MyCode\Repositories\Warehouse\WarehouseRepositoryInterface', function($app) 
      {

        return new WarehouseRepository(new Warehouse);

      });

      $this->app->bind('MyCode\Repositories\Location\LocationRepositoryInterface', function($app) 
      {
        
        return new LocationRepository(new Location);

      });
      //AppBind_Template Don´t Delete This Line

      $this->app->bind('MyCode\Services\Document\DocumentServiceInterface','MyCode\Services\Document\DocumentService');
    
    }

}
