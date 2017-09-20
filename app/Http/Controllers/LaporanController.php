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

class LaporanController extends Controller
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
      $user_info	 = Auth::user();
      $laporan 		 = Laporan::get()->where('status', '=', 0)->toArray();
      $laporan_isi = LaporanIsi::leftjoin('users', 'users.id', '=', 'laporan_isi.user_id')
      												 	 ->leftjoin('laporan', 'laporan.laporan_id', '=', 'laporan_isi.laporan_id')
	    													 ->orderBy('laporan_isi.laporan_isi_id', 'ASC')
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
                                "users_sessions_module" => 'Laporan QC',
                                "users_sessions_action" => 'visit',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Laporan QC')
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

    	return view('html.laporan.index')
                ->with('user_info', $user_info)
                ->with('laporan', $laporan)
                ->with('laporan_isi', $laporan_isi);
    }

    //Create a new laporan
    public function add(Request $request)
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
                                "users_sessions_module" => 'Laporan QC',
                                "users_sessions_action" => 'form',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Laporan QC')
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

    	return view('html.laporan.add')
                ->with('user_info', $user_info)
                ->with('kategori', $kategori);
    }

    //Store a new data for laporan
    public function store(Request $request)
    {
    	$episode_detail = "Episode";
      if ($request['laporan_media'] == 1) 
      {
      	$episode_detail = "Film Layar Lebar";
      }
      elseif ($request['laporan_media'] == 2) 
      {
      	$episode_detail = "OVA";
      }
      elseif ($request['laporan_media'] == 3) 
      {
      	$episode_detail = "SP";
      }

      $episode = $request['laporan_media'] != 1 ? $request['laporan_episode'] < 10 ? "0".$request['laporan_episode'] : $request['laporan_episode'] :  "";

    	$kategori   = Kategori::where('id', '=', $request['laporan_category'])->first();
      $proyek     = Proyek::where('tags_id', '=', $request['laporan_category'])->first();
      $user_info  = User::where('id', '=', $request['user_id'])->first();

      $laporan = array("laporan_name"     => $kategori['judul'].' - '.$episode_detail.' '.$episode,
                       "laporan_category" => $request['laporan_category'],    
                       "laporan_episode"  => $request['laporan_episode'],
                       "laporan_media"    => $request['laporan_media'],
                       "created_at"       => date('Y-m-d H:i:s'),
                       "updated_at"       => date('Y-m-d H:i:s'),
                       );

	    	//Check if laporan qc already added
	    	$id_now = $request['laporan_category'].$request['laporan_episode'].$request['laporan_media'];
	    	$get_laporan = Laporan::where('laporan_category', '=', $request['laporan_category'])
	    													->where('laporan_episode', '=', $request['laporan_episode'])
	    													->where('laporan_media', '=', $request['laporan_media'])
                                ->where('status', '=', '0')
	    													->first();

        if ($laporan['laporan_media'] == 1)
        {
          $get_laporan = Laporan::where('laporan_category', '=', $request['laporan_category'])
                                // ->where('laporan_episode', '=', $request['laporan_episode'])
                                ->where('laporan_media', '=', $request['laporan_media'])
                                ->where('status', '=', '0')
                                ->first();
        }

	    	if (count($get_laporan) > 0)
	    	{
            //Check if user already reported that project
            $get_laporan_isi = LaporanIsi::where('laporan_id', '=', $get_laporan['laporan_id'])
                                          ->where('user_id', '=', $request['user_id'])
                                          ->where('status', '=', '0')
                                          ->first();

              if (count($get_laporan_isi) > 0) 
              {
                return redirect('laporan')->with('error_msg', 'Sehat? Anda sudah pernah melapor!');
              }

            //Save new laporan isi dan update laporan
            $laporan_isi = array("laporan_id"     => $get_laporan['laporan_id'],
                             "laporan_isi_detail" => base64_encode($request['laporan_isi']),
                             "user_id"            => $request['user_id'],
                             "created_at"         => date('Y-m-d H:i:s'),
                             "updated_at"         => date('Y-m-d H:i:s'),
                             );

            $laporan_isi_save = LaporanIsi::Insert($laporan_isi);

            $laporan_update   = Laporan::where('laporan_id', '=', $get_laporan['laporan_id'])->update(array('updated_at' => date('Y-m-d H:i:s')));

            //Send email notification if not local
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
                  if ($active['laporan_qc'] != 1) 
                  {
                      unset($emails[$key]);
                  }
              }

              $episode_detail = "Episode";
              if ($laporan["laporan_media"] == 1) 
                {
                  $episode_detail = "Film Layar Lebar";
                }
              elseif ($laporan["laporan_media"] == 2) 
                {
                  $episode_detail = "OVA";
                }
              elseif ($laporan["laporan_media"] == 3) 
                {
                  $episode_detail = "SP";
                }

              $laporan_episode = $laporan["laporan_media"] != 1 ? $laporan["laporan_episode"] < 10 ? '0'.$laporan["laporan_episode"] : $laporan["laporan_episode"] :  '';

              if(config('app.env') != 'local')
              {
                foreach ($emails as $key => $value) 
                { 
                  Mail::send('html.mail.laporan', ['data' => $laporan, 'user' => $value, 'kategori' => $kategori, 'proyek' => $proyek, 'user_info' => $user_info], function ($m) use ($value, $laporan, $kategori, $episode_detail, $laporan_episode, $user_info) {
                    $m->from('admin@moesubs.com', 'Moesubs');
                    $m->to($value['email'], $value['name'])->subject('[Laporan QC] '.$kategori['judul'].' - '.$episode_detail.' '.$laporan_episode.' ['.$user_info["name"].']');
                  });
                }
              }
            //End of send email notification

            //Update session
              $session_detail = array(
                                      "name"        => $kategori['judul']." ".$episode_detail." ".$laporan_episode,
                                );

              $data_session   = array(
                                      "users_sessions_detail" => json_encode($session_detail),
                                      "user_id"               => $user_info['id'],
                                      "users_sessions_time"   => date('Y-m-d H:i:s'),
                                      "users_sessions_module" => 'Laporan QC',
                                      "users_sessions_action" => 'lapor',
                                );

              $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                            ->where('users_sessions_module', '=', 'Laporan QC')
                                            ->where('users_sessions_action', '=', 'lapor')
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

	    			return redirect('laporan')->with('success_msg', 'Laporan berhasil ditambahkan!');
	    	}
	    	//End of check if qc report already added

    	$laporan_save = Laporan::insertGetId($laporan);

    	if (empty($laporan_save))
      {
      	return redirect()->back()->withInput()->with('error_msg', 'Kesalahan dalam penyimpanan!<br><br>Harap dicoba lagi!');
      }

    	$laporan_isi = array("laporan_id"				  => $laporan_save,
    											 "laporan_isi_detail" => base64_encode($request['laporan_isi']),
    											 "user_id"						=> $request['user_id'],
		    									 "created_at"					=> date('Y-m-d H:i:s'),
		    									 "updated_at"			  	=> date('Y-m-d H:i:s'),
    											 );

    	$laporan_isi_save = LaporanIsi::Insert($laporan_isi);

    	if (!$laporan_isi_save) 
      {
      	return redirect()->back()->withInput()->with('error_msg', 'Kesalahan dalam penyimpanan!<br><br>Harap dicoba lagi!');
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
            if ($active['laporan_qc'] != 1) 
            {
                unset($emails[$key]);
            }
        }

        $episode_detail = "Episode";
        if ($laporan["laporan_media"] == 1) 
          {
            $episode_detail = "Film Layar Lebar";
          }
        elseif ($laporan["laporan_media"] == 2) 
          {
            $episode_detail = "OVA";
          }
        elseif ($laporan["laporan_media"] == 3) 
          {
            $episode_detail = "SP";
          }

        $laporan_episode = $laporan["laporan_media"] != 1 ? $laporan["laporan_episode"] < 10 ? '0'.$laporan["laporan_episode"] : $laporan["laporan_episode"] :  '';

        if(config('app.env') != 'local')
        {   
          foreach ($emails as $key => $value) 
          { 
            Mail::send('html.mail.laporan', ['data' => $laporan, 'user' => $value, 'kategori' => $kategori, 'proyek' => $proyek, 'user_info' => $user_info], function ($m) use ($value, $laporan, $kategori, $episode_detail, $laporan_episode, $user_info) {
              $m->from('admin@moesubs.com', 'Moesubs');
              $m->to($value['email'], $value['name'])->subject('[Laporan QC] '.$kategori['judul'].' - '.$episode_detail.' '.$laporan_episode.' ['.$user_info["name"].']');
            });
          }
        }
      //End of send email notification

      //Update session
        $session_detail = array(
                                "name"        => $kategori['judul']." ".$episode_detail." ".$laporan_episode,
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Laporan QC',
                                "users_sessions_action" => 'lapor',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Laporan QC')
                                      ->where('users_sessions_action', '=', 'lapor')
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

      return redirect('laporan')->with('success_msg', 'Laporan berhasil ditambahkan!');

    }

    //Get data and edit laporan
    public function edit($id, Request $request)
    {
    	$user_info   = Auth::user();
      $kategori    = Kategori::orderBy('judul', 'asc')->get()->toArray();
    	$get_id      = preg_replace("/[^0-9]/", "", base64_decode($id));
    	$laporan_isi = LaporanIsi::leftjoin('laporan', 'laporan.laporan_id', '=', 'laporan_isi.laporan_id')
    														->leftjoin('tags', 'tags.id', '=', 'laporan.laporan_category')
    														->where('laporan_isi.laporan_isi_id', '=', $get_id)
    														->first();

      $laporan_isi_name  = $laporan_isi['laporan_name'];
      $laporan_isi_owner = User::where('id', '=', $laporan_isi['user_id'])->first();

      //Update session
        $session_detail = array(
                                "full_url"        => base64_encode($request->fullUrl()),
                                "name"            => $laporan_isi_name,
                                "owner"           => $laporan_isi_owner['name'],
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Laporan QC',
                                "users_sessions_action" => 'edit',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Laporan QC')
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

    	return view('html.laporan.edit')
                ->with('user_info', $user_info)
                ->with('kategori', $kategori)
                ->with('laporan_isi', $laporan_isi);
    }

    //Get data and edit laporan
    public function update(Request $request)
    {
      $user_info                  = Auth::user();
    	$data['laporan_isi_id'] 		= $request['laporan_isi_id'];
    	$data['laporan_isi_detail'] = base64_encode($request['laporan_isi_detail']);

    	$laporan_isi_update = LaporanIsi::where('laporan_isi_id', '=', $data['laporan_isi_id'])->update(array('laporan_isi_detail' => $data['laporan_isi_detail']));

    	if (!$laporan_isi_update) 
    	{
    		return redirect()->back()->withInput()->with('error_msg', 'Kesalahan dalam penyimpanan!<br><br>Harap dicoba lagi!');
    	}

      //Update session
        $laporan_isi_detail = LaporanIsi::leftjoin('laporan', 'laporan.laporan_id', '=', 'laporan_isi.laporan_id')
                                        ->leftjoin('tags', 'tags.id', '=', 'laporan.laporan_category')
                                        ->where('laporan_isi.laporan_isi_id', '=', $data['laporan_isi_id'])
                                        ->first();

        $laporan_isi_owner  = User::where('id', '=', $laporan_isi_detail['user_id'])->first();

        $session_detail = array(
                                "full_url"        => base64_encode($request->fullUrl()),
                                "name"    => $laporan_isi_detail['judul'],
                                "owner"   => $laporan_isi_owner['name'],
                          );

        $data_session   = array(
                                "users_sessions_detail" => json_encode($session_detail),
                                "user_id"               => $user_info['id'],
                                "users_sessions_time"   => date('Y-m-d H:i:s'),
                                "users_sessions_module" => 'Laporan QC',
                                "users_sessions_action" => 'update',
                          );

        $check_session = UserSession::where('user_id', '=', $data_session['user_id'])
                                      ->where('users_sessions_module', '=', 'Laporan QC')
                                      ->where('users_sessions_action', '=', 'update')
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

    	return redirect('laporan')->with('success_msg', 'Laporan berhasil diperbarui!');
    }
}
