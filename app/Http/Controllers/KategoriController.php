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

class KategoriController extends Controller
{
    //Default validation
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
      $kategori  			= Kategori::get()
                                ->toArray();
      $user_default   = User::where('name', '=', 'Himeko')->first();

      foreach ($kategori as $key => $value)
      {
        $metadata = Metadata::leftjoin('users', 'users.id', '=', 'metadata.user_id')
                            ->where('metadata_module', '=', 'kategori')
                            ->where('metadata_module_id', '=', $value['id'])
                            ->first();

        $kategori[$key]['metadata']        = isset($metadata) ? $metadata : array('status' => 0);
      }

      //Update session
        $session_detail = array(
                                "full_url"        => base64_encode($request->fullUrl()),
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Kategori',
                                "users_sessions_action" => 'visit',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Kategori')
                                      ->where('users_sessions_action', '=', 'visit')
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

    	return view('html.kategori.index')
                ->with('user_info', $user_info)
                ->with('kategori', $kategori)
                ->with('user_default', $user_default);
    }

    //Add new data
    public function add(Request $request)
    {
      $user_info = Auth::user();
      //Update session
        $session_detail = array(
                                "full_url"        => base64_encode($request->fullUrl()),
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Kategori',
                                "users_sessions_action" => 'form',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Kategori')
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

      return view('html.kategori.add')
            ->with('user_info', $user_info);
    }

    //Store new data
    public function store(Request $request)
    {
      $user_info     = Auth::user();

      //Check duplicate
        $check_kategori = Kategori::where('judul', '=', $request['judul'])
                                  ->where('tags', '=', $request['tags'])
                                  ->first();

        if (count($check_kategori) > 0) 
        {
          return redirect()->back()->withInput()->with('error_msg', 'Sehat? Kategori sudah pernah ditambahkan!');
        }
      //End of check

      $kategori_data = array(
                            "tags"  => $request['tags'],
                            "judul" => $request['judul'],
                      );
      $kategori_save = Kategori::insertGetId($kategori_data);

      if(!$kategori_save)
      {
        return redirect()->back()->withInput()->with('error_msg', 'Gagal menambahkan kategori baru!');
      }

      $metadata_detail = array(
                              "action"    => "add",
                              "user_id"   => Auth::user()['id'],
                              "user_name" => Auth::user()['name'],
                              "data"      => $request->all(),
                        );

      $metadata_data = array(
                            "metadata_module_id" => $kategori_save,
                            "metadata_module"    => "kategori",
                            "metadata_detail"    => json_encode($metadata_detail),
                            "user_id"            => $request['user_id'],
                            "created_at"         => date("Y-m-d H:i:s"),
                            "updated_at"         => date("Y-m-d H:i:s"),
                      );

      $metadata_save = Metadata::insert($metadata_data);

      //Update session
        $session_detail = array(
                                "name"        => $request['judul'],
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Kategori',
                                "users_sessions_action" => 'add',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Kategori')
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

      return redirect('kategori')->with('success_msg', 'Kategori baru berhasil ditambahkan');
    }

}
