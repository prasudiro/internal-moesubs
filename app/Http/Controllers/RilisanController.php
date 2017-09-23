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

    //Get add page
    public function add(Request $request)
    {
      $user_info  = Auth::user();
      $kategori   = Kategori::orderBy('judul', 'asc')->get()->toArray();

      //Update session
        $session_detail = array(
                                "full_url"        => base64_encode($request->fullUrl()),
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Rilisan',
                                "users_sessions_action" => 'form',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Rilisan')
                                      ->where('users_sessions_action', '=', 'form')
                                      ->first();

          //Check if this session's page already exists, update it or just create a now of it
          if (count($check_session) > 0)
          {
              $update_session = UserSession::where('users_sessions_id', '=', $check_session['users_sessions_id'])->update(array('users_sessions_time' => date('Y-m-d H:i:s')));
          }
          else
          {
              $create_session = UserSession::insert($data_session);
          }
          //End of it
      //End of update session

      return view('html.rilisan.add')
                ->with('user_info', $user_info)
                ->with('kategori', $kategori);
    }

    //Save new data
    public function store(Request $request)
    {
      $user_info      = Auth::user();
      $rilisan_data   = array(
                              'judul_rilisan' => $request['judul_rilisan'],
                              'gambar'        => $request['gambar'],
                              'tags_id'       => $request['tags_id'],
                              'musim'         => $request['musim'],
                              'isi'           => $request['isi'],
                              'tanggal'       => date("Y-m-d"),
                              'jam'           => date("H:i:s"),
                              'tayang'        => $request['tayang'],
                              'sticky'        => $request['sticky'],
                              'pinggir'       => $request['pinggir'],
                              'updated_at'    => date("Y-m-d H:i:s"),
                        );

      $rilisan_save   = Rilisan::insert($rilisan_data);

      if (!$rilisan_save) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Kesalahan dalam penyimpanan!<br>Harap dicoba lagi!');
      }

      //Send email notification
      $emails = User::leftjoin('metadata', 'metadata.user_id', '=', 'users.id')
                    // ->select('name','email', 'metadata_detail')
                    ->where('level', '>', 1)
                    ->where('email', 'NOT LIKE', '%change.me%')
                    ->where('metadata_module', '=', 'notifikasi')
                    // ->where('metadata_detail', 'LIKE', '%"setoran_edit":"1"%')
                    ->get()
                    ->toArray();

      foreach ($emails as $key => $value) 
      {
          $active = json_decode($value['metadata_detail'], TRUE);
          if ($active['rilisan'] != 1) 
          {
              unset($emails[$key]);
          }
      }

      if(config('app.env') != 'local')
        {
          foreach ($emails as $key => $value) 
          { 
            Mail::send('html.mail.rilisan', ['data' => $request, 'user' => $value, 'user_info' => $user_info], function ($m) use ($value, $request, $user_info) {
              $m->from('admin@moesubs.com', 'Moesubs');
              $m->to($value['email'], $value['name'])->subject('[Rilisan Baru] '.$request['judul_rilisan'].' ['.$user_info["name"].']');
            });
          }
        }
      //End of send email notification

      //Update session
        $session_detail = array(
                                "name"        => $request['judul_rilisan'],
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Rilisan',
                                "users_sessions_action" => 'add',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Rilisan')
                                      ->where('users_sessions_action', '=', 'add')
                                      ->where('users_sessions_detail', json_encode($session_detail))
                                      ->first();

          //Check if this session's page already exists, update it or just create a now of it
          if (count($check_session) > 0)
          {
              $update_session = UserSession::where('users_sessions_id', '=', $check_session['users_sessions_id'])->update(array('users_sessions_time' => date('Y-m-d H:i:s')));
          }
          else
          {
              $create_session = UserSession::insert($data_session);
          }
          //End of it
      //End of update session 

      return redirect('rilisan')->with('success_msg', 'Rilisan berhasil ditambahkan!');
    }

    //Get data for editing
    public function edit(Request $request, $id)
    {
      $user_info 	= Auth::user();
      $get_id     = preg_replace("/[^0-9]/", "", base64_decode($id));
      $rilisan 		= Rilisan::where('id_rilisan', '=', $get_id)->first();
      $kategori   = Kategori::orderBy('judul', 'asc')->get()->toArray();

      //Update session
        $session_detail = array(
                                "full_url"        => base64_encode($request->fullUrl()),
                                "name"            => $rilisan['judul_rilisan'],
                                "owner"           => $user_info['name'],
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Rilisan',
                                "users_sessions_action" => 'edit',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Rilisan')
                                      ->where('users_sessions_action', '=', 'edit')
                                      ->where('users_sessions_detail', json_encode($session_detail))
                                      ->first();

          //Check if this session's page already exists, update it or just create a now of it
          if (count($check_session) > 0)
          {
              $update_session = UserSession::where('users_sessions_id', '=', $check_session['users_sessions_id'])->update(array('users_sessions_time' => date('Y-m-d H:i:s')));
          }
          else
          {
              $create_session = UserSession::insert($data_session);
          }
          //End of it
      //End of update session

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
