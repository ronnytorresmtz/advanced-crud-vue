<?php

namespace MyCode\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];
}
