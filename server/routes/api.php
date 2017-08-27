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



/*use App\Company;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::group(['middleware' => 'cors'], function(){
    Route::get('/test', function(){
         return response([1,2,3,4], 200);
    });
//});

Route::get('shippers/companies', function(){
    return response()->json(Company::select(
        'id', 'company_name', 'company_email', 'company_contact', 'company_phone', 'deleted_at'
    )->paginate(10));
});*/




