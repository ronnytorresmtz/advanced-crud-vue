<?php

/** 
* To change the User Model from App namespace to another one like MyCode/Models
* you need to change the providers array in config/auth.php file
* form 'model' => App\User::class to 'model' => MyCode\Models\User::class,
*/

namespace MyCode\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;



class User extends Authenticatable
{
  use Notifiable;
  use SoftDeletes;
  /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
  protected $hidden = [
    'password', 'remember_token',
  ];
}
