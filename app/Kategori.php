<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
  protected $table 				= "tags";
	protected $primaryKey 	= "id";
	protected $guarded 			= array('id');
	public $timestamps 			= false;
}
