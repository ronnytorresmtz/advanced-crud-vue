<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\RegisterTransactionAccessEvent;
use MyCode\Repositories\Login\LoginRepositoryInterface;

use Auth, View;

/*use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\PasswordResetRequest;*/

class LoginController extends Controller {
	/**
	* Setup the layout used by the controller.
	*
	* @return void
	*/


    protected $loginService;

 	public function __construct(LoginRepositoryInterface $loginRepository)
    {

		$this->loginRepository = $loginRepository;

    }


    public function getLogIn()
	{

        return response()->json(['url' => '/']);

    }
   

	public function postLogIn(Request $request)
	{
		$result = [];
		//Verify if the user has access to the application
		if (!$this->loginRepository->canUserLogin($request)){
            
			return response()->json(['error' => true, 'message' => 'The username or password are not correct']);
           
		}

		// Event::fire(new RegisterTransactionAccessEvent('login.login.login'));
		return response()->json(['error' => false, 'message' => 'The user is authorize to access the application']);

    }

	
	public function getUserAuthenticated()
	{

		if (!Auth::check()){

			return response()->json(['error' => false, 'message' => 'NOK']);    

		}
		
		return response()->json(['error' => false, 'message' => 'OK']);

	}

	
	public function getLogOut()
	{
		\Log::info('beforelogout');
		// check if the user is loggeded 
		if (Auth::check()){
			// Event::fire(new RegisterTransactionAccessEvent('login.login.logout'));
			\Log::info('logout');

			Auth::logout();
		}
		\Log::info('afterlogout');
		return response()->json(['url' => '/']);

    }


	public function postSendYourPassword(Request $request)
	{	
		$result=[];
		// send a email to the user with a token 
		$result = $this->loginRepository->sendTokenToUserViaMail($request);

		if (!$result['error']){

			// if (Auth::check()){
			// 	Event::fire(new RegisterTransactionAccessEvent('login.login.sendYourPassword'));
			// }

			return response()->json($result);

		}

		// return back with input data
		return response()->json($result);
	}


	public function postResetYourPassword(Request $request)
	{

		$result=[];

		$result = $this->loginRepository->resetUserPassowrd($request);

		if (!$result['error']) {

		//	Event::fire(new RegisterTransactionAccessEvent('login.login.resetUserPassword'));

			return response()->json($result);

        }

		return response()->json($result);
	}


	public function postTokenExist(Request $request)
	{

		return response()->json($this->loginRepository->findToken($request));

    }

}