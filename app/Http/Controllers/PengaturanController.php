<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Mail;
use View;

//Call table
use App\Kategori;
use App\Proyek;
use App\User;
use App\UserSession;
use App\Setoran;
use App\Laporan;
use App\LaporanIsi;
use App\Metadata;

class PengaturanController extends Controller
{
    //Default construct and validation
    public function __construct()
    {
      $this->middleware('auth');

      $setoran_edit     = Setoran::where('setoran_type', '=', '0')
                              ->where('status', '=', '0')
                              ->where('created_at', '>=', Carbon::today())
                              ->get()
                              ->count();

      $tanggal_edit     = Setoran::where('setoran_type', '=', '0')
                              ->where('status', '=', '0')
                              ->where('created_at', '>=', Carbon::today())
                              ->orderBy('created_at', 'desc')
                              ->first();

      $setoran_qc       = Setoran::where('setoran_type', '=', '1')
                              ->where('status', '=', '0')
                              ->where('created_at', '>=', Carbon::today())
                              ->count();

      $tanggal_qc       = Setoran::where('setoran_type', '=', '1')
                              ->where('status', '=', '0')
                              ->where('created_at', '>=', Carbon::today())
                              ->orderBy('created_at', 'desc')
                              ->first();

      $laporan_qc       = LaporanIsi::where('created_at', '>=', Carbon::today())
                              ->where('status', '=', '0')
                              ->count();

      $tanggal_laporan  = LaporanIsi::where('created_at', '>=', Carbon::today())
                              ->where('status', '=', '0')
                              ->orderBy('created_at', 'desc')
                              ->first();

      $total_pemberitahuan = $setoran_edit + $setoran_qc + $laporan_qc;

      View::share('setoran_edit', $setoran_edit);
      View::share('setoran_qc', $setoran_qc);
      View::share('laporan_qc', $laporan_qc);
      View::share('total_pemberitahuan', $total_pemberitahuan);
      View::share('tanggal_edit', $tanggal_edit);
      View::share('tanggal_qc', $tanggal_qc);
      View::share('tanggal_laporan', $tanggal_laporan);
    }

    //Get homepage with template
    public function index(Request $request)
    {
      $user_info = Auth::user();

    	return view('html.pengaturan.index')
                ->with('user_info', $user_info);
    }

    //Get notifikasi with template
    public function notifikasi(Request $request)
    {
      $user_info 		= Auth::user();
      $metadata 		= Metadata::where('metadata_module', '=', 'notifikasi')
      												->where('user_id', '=', $user_info['id'])
      												->where('status', '=', '0')
      												->first();
      $notifikasi  	= json_decode($metadata['metadata_detail'], TRUE);

    	return view('html.pengaturan.notifikasi')
                ->with('user_info', $user_info)
                ->with('notifikasi', $notifikasi);
    }

    //Save notifikasi setting
    public function notifikasi_save(Request $request)
    {
      $user_info = Auth::user();

    	$metadata_detail = array(
    													"rilisan" 			=> $request['rilisan'],
													    "proyek" 				=> $request['proyek'],
													    "kategori" 			=> $request['kategori'],
													    "setoran_edit" 	=> $request['setoran_edit'],
													    "setoran_qc" 		=> 1,
													    "laporan_qc" 		=> $request['laporan_qc'],
    										);
    	$metadata = array(
    										"metadata_module_id"		=> 0,
    										"metadata_module"				=> 'notifikasi',
    										"metadata_detail"				=> json_encode($metadata_detail),
    										"user_id"								=> $request['user_id'],
    							);

    	//Check if data exist    	
    	$check_metadata = Metadata::where('metadata_module', '=', 'notifikasi')
  												->where('user_id', '=', $user_info['id'])
  												->where('status', '=', '0')
  												->first();

    	//Create if user didn't have any metadata for notifikasi
  		if (count($check_metadata) == 0) 
  		{
  			$metadata_create = Metadata::insert($metadata);

  			if (!$metadata_create) 
  			{
  				return redirect()->back()->withInput()->with('error_msg', 'Gagal menyimpan! Silakan coba lagi!');
  			}

  			return redirect('pengaturan/notifikasi')->with('success_msg', 'Pengaturan notifikasi berhasil disimpan!');
  		}
    	//End of create

    	$metadata_save = Metadata::where('metadata_module', '=', 'notifikasi')
    														->where('user_id', '=', $request['user_id'])
    														->update($metadata);

			if (!$metadata_save) 
			{
				return redirect()->back()->withInput()->with('error_msg', 'Gagal menyimpan! Silakan coba lagi!');
			}

			return redirect('pengaturan/notifikasi')->with('success_msg', 'Pengaturan notifikasi berhasil disimpan!');
    }
}
