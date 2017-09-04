<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
  protected $table 				= "setoran";
	protected $primaryKey 	= "setoran_id";
	protected $guarded 			= array('setoran_id');
}
