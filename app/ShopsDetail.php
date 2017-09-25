<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopsDetail extends Model
{
  protected $table 				= "shops_detail";
	protected $primaryKey 	= "shops_detail_id";
	protected $guarded 			= array('shops_detail_id');
}
