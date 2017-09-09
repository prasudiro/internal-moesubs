<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rilisan extends Model
{
    protected $table 				= "rilisan";
		protected $primaryKey 	= "id_rilisan";
		protected $guarded 			= array('id_rilisan');
}
