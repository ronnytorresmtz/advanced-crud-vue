<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$allFiles = File::allFiles(base_path() . '\App\MyCode\Routes');

foreach ($allFiles as $file) {
   
    require_once ($file->getPathname());

}





