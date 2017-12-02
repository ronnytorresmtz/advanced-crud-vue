<?php 

namespace MyCode\Services\Mail;


Interface MailServiceInterface {

	/**
	* Send a user a email with a token ana a security code to change his forgot password
	*
	* @param 	$user: A user record from the database with information like user name, user email, token, a security code, etc.
	*
	* @return 	Boolean: Return True if the mail was sent and false if it fail
	*/
	public function sentTokenToResetPassoword($user);


}
	