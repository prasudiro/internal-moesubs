<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

//Call table
use App\User;
use App\Kategori;
use App\Setoran;
use App\Laporan;
use App\LaporanIsi;

class LaporanController extends Controller
{
    //Default construct and validation
    public function __construct()
    {
      $this->middleware('auth');
    }

    //Get homepage with template
    public function index()
    {
      $user_info	 = Auth::user();
      $laporan 		 = Laporan::get()->where('status', '=', 0)->toArray();
      $laporan_isi = LaporanIsi::leftjoin('users', 'users.id', '=', 'laporan_isi.user_id')
      												 	 ->leftjoin('laporan', 'laporan.laporan_id', '=', 'laporan_isi.laporan_id')
	    													 ->orderBy('laporan_isi.laporan_isi_id', 'ASC')
	    													 ->get()
	    													 ->toArray();

    	return view('html.laporan.index')
                ->with('user_info', $user_info)
                ->with('laporan', $laporan)
                ->with('laporan_isi', $laporan_isi);
    }

    //Create a new laporan
    public function add()
    {
      $user_info = Auth::user();
      $kategori  = Kategori::orderBy('judul', 'asc')->get()->toArray();

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

    	$kategori = Kategori::where('id', '=', $request['laporan_category'])->first();

	    	//Check if laporan qc already added
	    	$id_now = $request['laporan_category'].$request['laporan_episode'].$request['laporan_media'];
	    	$get_laporan = Laporan::where('laporan_category', '=', $request['laporan_category'])
	    													->where('laporan_episode', '=', $request['laporan_episode'])
	    													->where('laporan_media', '=', $request['laporan_media'])
                                ->where('status', '=', '0')
	    													->first();

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
            //End of check if user already reported that project

	    			// $get_laporan_isi = LaporanIsi::where('laporan_id', '=', $get_laporan['laporan_id'])
        //                                   ->where('user_id', '=', $request['user_id'])
        //                                   ->update(array('laporan_isi_detail' => base64_encode($request['laporan_isi'])));

        //     return redirect('laporan')->with('success_msg', 'Laporan berhasil ditambahkan!');		    		

	    			$laporan_isi = array("laporan_id"			=> $get_laporan['laporan_id'],
	    											 "laporan_isi_detail" => base64_encode($request['laporan_isi']),
	    											 "user_id"						=> $request['user_id'],
			    									 "created_at"					=> date('Y-m-d H:i:s'),
			    									 "updated_at"			  	=> date('Y-m-d H:i:s'),
	    											 );

	    			$laporan_isi_save = LaporanIsi::Insert($laporan_isi);

	    			return redirect('laporan')->with('success_msg', 'Laporan berhasil ditambahkan!');
	    	}
	    	//End of check if qc report already added

    	$laporan = array("laporan_name"			=> $kategori['judul'].' - '.$episode_detail.' '.$episode,
    									 "laporan_category"	=> $request['laporan_category'],		
    									 "laporan_episode"	=> $request['laporan_episode'],
    									 "laporan_media"		=> $request['laporan_media'],
    									 "created_at"				=> date('Y-m-d H:i:s'),
    									 "updated_at"			  => date('Y-m-d H:i:s'),
    									 );

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

      return redirect('laporan')->with('success_msg', 'Laporan berhasil ditambahkan!');

    }

    //Get data and edit laporan
    public function edit($id)
    {
    	$user_info = Auth::user();
      $kategori  = Kategori::orderBy('judul', 'asc')->get()->toArray();
    	$get_id = preg_replace("/[^0-9]/", "", base64_decode($id));
    	$laporan_isi = LaporanIsi::leftjoin('laporan', 'laporan.laporan_id', '=', 'laporan_isi.laporan_id')
    														->leftjoin('tags', 'tags.id', '=', 'laporan.laporan_category')
    														->where('laporan_isi.laporan_isi_id', '=', $get_id)
    														->first();

    	return view('html.laporan.edit')
                ->with('user_info', $user_info)
                ->with('kategori', $kategori)
                ->with('laporan_isi', $laporan_isi);
    }

    //Get data and edit laporan
    public function update(Request $request)
    {
    	$data['laporan_isi_id'] 		= $request['laporan_isi_id'];
    	$data['laporan_isi_detail'] = base64_encode($request['laporan_isi_detail']);

    	$laporan_isi_update = LaporanIsi::where('laporan_isi_id', '=', $data['laporan_isi_id'])->update(array('laporan_isi_detail' => $data['laporan_isi_detail']));

    	if (!$laporan_isi_update) 
    	{
    		return redirect()->back()->withInput()->with('error_msg', 'Kesalahan dalam penyimpanan!<br><br>Harap dicoba lagi!');
    	}

    	return redirect('laporan')->with('success_msg', 'Laporan berhasil diperbarui!');
    }
}
