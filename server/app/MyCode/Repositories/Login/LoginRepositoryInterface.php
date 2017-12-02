<?php 

namespace MyCode\Repositories\Login;

use MyCode\Repositories\Eloquent\MyEloquentRepositoryInterface;
 
interface LoginRepositoryInterface extends MyEloquentRepositoryInterface
{

    public function canUserLogin($request);
    public function sendTokenToUserViaMail($request);
    public function resetUserPassowrd($request);
    public function findToken($request);

}