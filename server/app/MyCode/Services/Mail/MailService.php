<?php 

namespace MyCode\Services\Mail;

use Lang, Log, Mail;

class MailService implements MailServiceInterface{

	public function sentTokenToResetPassoword($user){
		
		//send a mail with token and security code to ther user	
		Mail::send(
			// HTML Template for the email to be send
			'emails.password_send', 
			//data to return to the view of the email to be send
			array(
				'link'						 => 'http://' . $_SERVER['HTTP_HOST'] . '/#!/resetYourPassword?token=' . $user->remember_token,
				'user_fullname'				 => $user->user_fullname,
				'remember_security_number'	 => $user->remember_security_number
			), 
			// Message Info using user data
			function($message) use ($user)
			{
			    $message->to($user->email, $user->user_fullname)->subject(Lang::get('labels.password_recovered'));
			}
		);
		// check if the mail fail
		if(count(Mail::failures()) > 0){
			//the mail was NOT send , it fail
			return false;
		}	
		
		if (env('APP_DEBUG')){
			Log::info ('Token: ' . $user->remember_token);
			Log::info ('Security Code: ' . $user->remember_security_number);
			Log::info ('-------------------------------------------------------------------');
		}
		
		//the mail send successfully
		return true;	
	}

}