<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
  protected $table 				= "metadata";
	protected $primaryKey 	= "metadata_id";
	protected $guarded 			= array('metadata_id');
}
