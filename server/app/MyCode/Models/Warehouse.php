<?php

namespace MyCode\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];
}
