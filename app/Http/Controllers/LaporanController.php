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
      $laporan 		 = Laporan::get()->toArray();
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

	    	//Check if qc report already added
	    	$id_now = $request['laporan_category'].$request['laporan_episode'].$request['laporan_media'];
	    	$get_laporan = Laporan::where('laporan_category', '=', $request['laporan_category'])
	    													->where('laporan_episode', '=', $request['laporan_episode'])
	    													->where('laporan_media', '=', $request['laporan_media'])
	    													->first();

	    	if (count($get_laporan) > 0)
	    	{
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
      	return redirect()->back()->with('error_msg', 'Keselahan dalam penyimpanan!<br><br>Harap dicoba lagi!');
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
      	return redirect()->back()->with('error_msg', 'Keselahan dalam penyimpanan!<br><br>Harap dicoba lagi!');
      }

      return redirect('laporan')->with('success_msg', 'Laporan berhasil ditambahkan!');

    }

    //Get data and edit laporan
    public function edit($id)
    {
    	print_r($id);
    	exit();
    }
}
