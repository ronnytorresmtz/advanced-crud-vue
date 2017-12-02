<?php 

namespace MyCode\Repositories\Login;

// use App\Events\RegisterTransactionAccessEvent;
use MyCode\Repositories\Eloquent\MyAbstractEloquentRepository;
use MyCode\Repositories\Login\LoginRepositoryInterface;
use MyCode\Services\Mail\MailServiceInterface;
use  MyCode\Models\User;

use Auth, Exception, Hash;
 
class LoginRepository extends MyAbstractEloquentRepository implements LoginRepositoryInterface 
{
 
    protected $model;
    
	protected $mailService;

    
    public function __construct(User $user, MailServiceInterface $mailService)
	{
        
        $this->model = $user; 
        
        $this->mailService  = $mailService;
        
    }


    public function canUserLogin($request)
	{
		
		$credentials = [

			'email' => $request->username, 
			
			'password' => $request->password

		];
		
		// atempt to authenticate the user to login 
		return Auth::attempt($credentials, true);
	
	}


    public function sendTokenToUserViaMail($request)
	{
		try 
		{
			DB::beginTransaction();
		
			//get the first user with the email
			$user = $this->model->where('email','=', $request['email'])->first();
            
            //email was not found redirect to same view
			if (!isset($user)){
				//set the error message for the user
				return ['error' => true, 'message' => Lang::get('messages.error_email_no_found')];
			}
            
            //generated and save remember_security_number and token in user table
            $user->remember_security_number = str_random(8);
            
			$user->remember_token = str_random(60);		

			// save the remember token and security number in the user table
			if (! $user->save()){

				DB::rollBack();

				return ['error' => true, 'message' => Lang::get('messages.error_password_sent')];
            
            }
				// send a mail with the token and security code to reset his passoword
			if (!$this->mailService->sentTokenToResetPassoword($user)){

				DB::rollBack();
            
                //set the error message for the user
				return ['error' => true, 'message' => Lang::get('messages.error_password_sent')];
            
            }
			
			DB::commit();

			//set the error message for the user
			return ['error' => false, 'message' => Lang::get('messages.success_password_sent')];

		} catch (Exception $e) {

			DB::rollback();
            
            //set the error message for the user
			return ['error' => true, 'message' => Lang::get('messages.error_caught_exception') .' ' . str_replace("'"," ", $e->getMessage())];
        
        }
	}


	// reset the user passoword base on a token and security number sent to him via mail.
	public function resetUserPassowrd($request)
	{
		try
		{
			//get the first user with the token and security number
			$user = $this->model
					->where('remember_security_number','=', $request['security_number'])
					->where('remember_token','=', $request['token'])
					->first();
            
                    //verity if the security code does not exsit in the database to display a message error
			if (!isset($user)){
				return ['error' => true, 'message' => Lang::get('messages.error_remember_security_number_noexist')];
            }		
            
			//reset the user password in the database
			$user->password	= Hash::make($request['new_password']);
			$user->remember_security_number	='';
            $user->remember_token ='';
            
			//save the reset ot the user password in the user table
			if (! $user->save()){
				//set the error message for the user
				return array('error' => true, 'message' => Lang::get('messages.error_password_wasnot_reset'));
			}
			//set the info message for the user
			return array('error' => false, 'message' => Lang::get('messages.success_password_was_reset'));

		} catch (Exception $e) {
			//set the error message for the user
			return array('error' => true, 'message' =>  Lang::get('messages.error_caught_exception') .'&nbsp;' . str_replace("'"," ", $e->getMessage()));
		}
	}


    public function findToken($request) 
    {
		///get the token of the first user find with a request->token
		$token = $this->model->select('remember_token')->where('remember_token','=', $request['token'])->first();
		//ckeck if the token was not found
		if (!isset($token['remember_token'])){
			//token was not found
			return false;
		}
		//token was found
		return true;
	}

}