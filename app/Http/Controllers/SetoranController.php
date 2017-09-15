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

class SetoranController extends Controller
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

    	return view('html.setoran.index')
                ->with('user_info', $user_info);
    }

    //Save data and file for setoran
    public function store(Request $request)
    {
    	$type 			 = $request['setoran_type'] == 1 ? "qc" : "edit";
    	$path				 = 'uploads/'.$type.'/';
    	$file_upload = $request['setoran_file'];
    	$filename 	 = basename($file_upload->getClientOriginalName(), '.'.$file_upload->getClientOriginalExtension()).'_'.date('ymdhis').'.'.$file_upload->getClientOriginalExtension();
    	$file_upload->move($path, $filename);
    	$store = array(
    									'setoran_name'			=> $filename,
    									'setoran_type'			=> $request['setoran_type'],
    									'setoran_category'	=> $request['setoran_category'],
    									'setoran_episode'		=> $request['setoran_episode'],
    									'setoran_media'			=> $request['setoran_media'],
    									'setoran_file'			=> $path.$filename,
    									'user_id'						=> $request['user_id'],
    									'created_at'				=> date('Y-m-d H:i:s'),
    									'updated_at'				=> date('Y-m-d H:i:s'),
    					);

      $kategori   = Kategori::where('id', '=', $request['setoran_category'])->first();
      $proyek     = Proyek::where('tags_id', '=', $request['setoran_category'])->first();
      $user_info  = User::where('id', '=', $request['user_id'])->first();

      //Check if user already add setoran on certain category
        print"<pre>";
        $check_setoran = Setoran::where('setoran_type', '=', $request['setoran_type'])
                                  ->where('setoran_category', '=', $request['setoran_category'])
                                  ->where('setoran_media', '=', $request['setoran_media'])
                                  ->where('setoran_episode', '=', $request['setoran_episode'])
                                  ->where('user_id', '=', $request['user_id'])
                                  ->where('status', '=', '0')
                                  ->first();
        if (count($check_setoran) > 0) 
        {
          return redirect('setoran/'.$type)->with('error_msg', 'Sehat? Anda sudah pernah menyetor!');
        }
      //End of check if user already add setoran on certain category

      $insert = Setoran::insert($store);

      if (!$insert) 
      {
      	return redirect()->back()->withInput()->with('error_msg', 'Kesalahan dalam penyimpanan!<br><br>Harap dicoba lagi!');
      }

      //Send email notification
        $emails = User::select('name','email')->where('level', '>', 1)->where('email', 'NOT LIKE', '%change.me%')->get()->toArray();

        $episode_detail = "Episode";
              if ($store["setoran_media"] == 1) 
                {
                  $episode_detail = "Film Layar Lebar";
                }
              elseif ($store["setoran_media"] == 2) 
                {
                  $episode_detail = "OVA";
                }
              elseif ($store["setoran_media"] == 3) 
                {
                  $episode_detail = "SP";
                }

        $setoran_episode = $store["setoran_media"] != 1 ? $store["setoran_episode"] < 10 ? "0".$store["setoran_episode"] : $store["setoran_episode"] :  "";

      if(config('app.env') != 'local')
        {
          foreach ($emails as $key => $value) 
          { 
            Mail::send('html.mail.setoran', ['data' => $store, 'user' => $value, 'type' => $type, 'kategori' => $kategori, 'proyek' => $proyek, 'user_info' => $user_info], function ($m) use ($value, $type, $store, $kategori, $episode_detail, $setoran_episode, $user_info) {
              $m->from('admin@moesubs.com', 'Moesubs');
              $m->to($value['email'], $value['name'])->subject('[Setoran Siap '.strtoupper($type).'] '.$kategori["judul"].' - '.$episode_detail.' '.$setoran_episode.' ['.$user_info["name"].']');
            });
          }
        }
      //End of send email notification

      //Update session
        $type_add = $type == "qc" ? strtoupper($type) : ucfirst($type);
        $session_detail = array(
                                "setoran_name"        => $kategori['judul']." ".$episode_detail." ".$setoran_episode,
                                "setoran_type"        => "Setoran Siap ".$type_add,
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Setoran '.$type_add,
                                "users_sessions_action" => 'add',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Setoran '.$type_add)
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
      
    	return redirect('setoran/'.$type)->with('success_msg', 'Setoran berhasil ditambahkan!');

    }

    //Download file for setoran
    public function download_setoran($id)
    {
    	$setoran = Setoran::where('setoran_name', '=', base64_decode($id))->first();

      if(count($setoran) > 0)
      {
        return response()->download($setoran['setoran_file']);
      }

      return redirect()->back()->withInput()->with('error_msg', 'Berkas tidak ditemukan!');
    }

    //Delete file for setoran
    public function delete_setoran(Request $request)
    {
      if ($request['hapus_setoran'] != "HAPUS") 
      {
        return redirect()->back()->with('error_msg', 'Data gagal dihapus!');
      }

      //Update session
        $user_info      = Auth::user();
        $check_setoran  = Setoran::where('setoran_id', '=', $request['setoran_id'])->first();
        $kategori       = Kategori::where('id', '=', $check_setoran['setoran_category'])->first();
        $setoran_owner  = User::where('id', '=', $check_setoran['user_id'])->first();
        $setoran_type   = $check_setoran['setoran_type'] == 0 ? "Edit" : "QC";

        $episode_detail = "Episode";
            if ($check_setoran["setoran_media"] == 1) 
              {
                $episode_detail = "Film Layar Lebar";
              }
            elseif ($check_setoran["setoran_media"] == 2) 
              {
                $episode_detail = "OVA";
              }
            elseif ($check_setoran["setoran_media"] == 3) 
              {
                $episode_detail = "SP";
              }

        $setoran_episode = $check_setoran["setoran_media"] != 1 ? $check_setoran["setoran_episode"] < 10 ? "0".$check_setoran["setoran_episode"] : $check_setoran["setoran_episode"] :  "";
        $setoran_name    = $kategori['judul']." - ".$episode_detail." ".$setoran_episode;

        $session_detail = array(
                                "setoran_name"        => $setoran_name,
                                "setoran_type"        => $setoran_type,
                                "setoran_owner"       => $setoran_owner['name'],
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Setoran '.$setoran_type,
                                "users_sessions_action" => 'delete',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Setoran '.$setoran_type)
                                      ->where('users_sessions_action', '=', 'delete')
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

      $hapus_setoran = Setoran::where('setoran_id', '=', $request['setoran_id'])->update(array('status' => '1'));
      return redirect('setoran/'.$request['setoran_type'])->with('success_msg', 'Setoran berhasil dihapus!');

    }


/*
|--------------------------------------------------------------------------
| Setoran Edit Functions
|--------------------------------------------------------------------------
*/

    //Get list setoran for Edit
    public function list_edit(Request $request)
    {
      $user_info = Auth::user();
      $setoran   = Setoran::leftjoin('tags', 'tags.id', '=', 'setoran.setoran_category')
      										->leftjoin('users', 'users.id', '=', 'setoran.user_id')
      										->select('*', 'setoran.updated_at AS tanggal')
      										->where('setoran_type', '=', '0')
      										->where('status', '=', 1)
      										->orderBy('setoran.updated_at', 'desc')
      										->get()
      										->toArray();

      //Update session
          $session_detail = array(
                                  "full_url"        => base64_encode($request->fullUrl()),
                            );

          $data_session   = array(
                                  "users_sessions_detail" => json_encode($session_detail),
                                  "user_id"               => $user_info['id'],
                                  "users_sessions_time"   => date('Y-m-d H:i:s'),
                                  "users_sessions_module" => 'Setoran Edit',
                                  "users_sessions_action" => 'visit',
                            );

          $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                        ->where('users_sessions_module', '=', 'Setoran Edit')
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

    	return view('html.setoran.list_edit')
                ->with('user_info', $user_info)
                ->with('setoran', $setoran);
    }

    //Add new setoran for Edit
    public function add_edit(Request $request)
    {
      $user_info = Auth::user();
      $kategori  = Kategori::orderBy('judul', 'asc')->get()->toArray();

      //Update session
        $session_detail = array(
                                "full_url"        => base64_encode($request->fullUrl()),
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Setoran Edit',
                                "users_sessions_action" => 'form',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Setoran Edit')
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

    	return view('html.setoran.add_edit')
                ->with('user_info', $user_info)
                ->with('kategori', $kategori);
    }

/*
|--------------------------------------------------------------------------
| Setoran QC Functions
|--------------------------------------------------------------------------
*/

    //Get list setoran for QC
    public function list_qc(Request $request)
    {
     $user_info = Auth::user();
      $setoran   = Setoran::leftjoin('tags', 'tags.id', '=', 'setoran.setoran_category')
      										->leftjoin('users', 'users.id', '=', 'setoran.user_id')
      										->select('*', 'setoran.updated_at AS tanggal')
      										->where('setoran_type', '=', '1')
      										->where('status', '=', 1)
      										->orderBy('setoran.updated_at', 'desc')
      										->get()
      										->toArray();

      //Update session
        $session_detail = array(
                                "full_url"        => base64_encode($request->fullUrl()),
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Setoran QC',
                                "users_sessions_action" => 'visit',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Setoran QC')
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

    	return view('html.setoran.list_qc')
                ->with('user_info', $user_info)
                ->with('setoran', $setoran);
    }

    //Add new setoran for QC
    public function add_qc(Request $request)
    {
      $user_info = Auth::user();
      $kategori  = Kategori::orderBy('judul', 'asc')->get()->toArray();

      //Update session
        $session_detail = array(
                                "full_url"        => base64_encode($request->fullUrl()),
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Setoran QC',
                                "users_sessions_action" => 'form',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Setoran QC')
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

    	return view('html.setoran.add_qc')
                ->with('user_info', $user_info)
                ->with('kategori', $kategori);
    }

}
