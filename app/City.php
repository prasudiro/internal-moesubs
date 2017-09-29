<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table 				= "city";
		protected $primaryKey 	= "city_inc_id";
		protected $guarded 			= array('city_inc_id');
}
