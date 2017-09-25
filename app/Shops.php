<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shops extends Model
{
  protected $table 				= "shops";
	protected $primaryKey 	= "shops_id";
	protected $guarded 			= array('shops_id');
}
