<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
  protected $table 				= "users_sessions";
	protected $primaryKey 	= "users_sessions_id";
	protected $guarded 			= array('users_sessions_id');
	public $timestamps 			= false;
}
