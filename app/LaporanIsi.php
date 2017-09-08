<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanIsi extends Model
{
    protected $table 				= "laporan_isi";
		protected $primaryKey 	= "laporan_isi_id";
		protected $guarded 			= array('laporan_isi_id');
}
