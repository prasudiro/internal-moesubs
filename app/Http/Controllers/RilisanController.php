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
use App\Rilisan;

class RilisanController extends Controller
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

    //Get homepage with template and data
    public function index(Request $request)
    {
      $user_info 			= Auth::user();
      $rilisan  			= Rilisan::where('deleted', '=', 0)->get()->toArray();

    	return view('html.rilisan.index')
                ->with('user_info', $user_info)
                ->with('rilisan', $rilisan);
    }

    //Get data for editing
    public function edit(Request $request, $id)
    {
      $user_info 	= Auth::user();
      $get_id     = preg_replace("/[^0-9]/", "", base64_decode($id));
      $rilisan 		= Rilisan::where('id_rilisan', '=', $get_id)->first();
      $kategori   = Kategori::get()->toArray();

    	return view('html.rilisan.edit')
                ->with('user_info', $user_info)
                ->with('rilisan', $rilisan)
                ->with('kategori', $kategori);
    }

    //Update data
    public function update(Request $request)
    {
      $user_info 		= Auth::user();
      $rilisan_data = array(
      											'judul_rilisan'	=> $request['judul_rilisan'],
      											'gambar'				=> $request['gambar'],
      											'tags_id'				=> $request['tags_id'],
      											'musim'					=> $request['musim'],
      											'isi'						=> $request['isi'],
      											'tayang'				=> $request['tayang'],
      											'sticky'				=> $request['sticky'],
      											'pinggir'				=> $request['pinggir'],
      											'updated_at'			=> date("Y-m-d H:i:s"),
      								);

      $rilisan_save = Rilisan::where('id_rilisan', '=', $request['id_rilisan'])->update($rilisan_data);

      if (!$rilisan_save) 
      {
      	return redirect()->back()->withInput()->with('error_msg', 'Kesalahan dalam penyimpanan!<br>Atau data tidak ada yang berubah!');
      }

      return redirect('rilisan')->with('success_msg', 'Rilisan berhasil diperbarui!');
    }
}
