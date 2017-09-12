<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;

//Call table
use App\Kategori;
use App\Proyek;
use App\Setoran;
use App\User;

class SetoranController extends Controller
{
		//Default construct and validation
    public function __construct()
    {
      $this->middleware('auth');
    }

    //Get homepage with template
    public function index()
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

        foreach ($emails as $key => $value) 
        { 
          Mail::send('html.mail.setoran', ['data' => $store, 'user' => $value, 'type' => $type, 'kategori' => $kategori, 'proyek' => $proyek, 'user_info' => $user_info], function ($m) use ($value, $type, $store, $kategori, $episode_detail, $setoran_episode, $user_info) {
            $m->from('admin@moesubs.com', 'Moesubs');
            $m->to($value['email'], $value['name'])->subject('(Testing Mail) [Setoran Siap '.strtoupper($type).'] '.$kategori["judul"].' - '.$episode_detail.' '.$setoran_episode.' ['.$user_info["name"].']');
          });
        }
      //End of send email notification
      
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

      $hapus_setoran = Setoran::where('setoran_id', '=', $request['setoran_id'])->update(array('status' => '1'));
      return redirect('setoran/'.$request['setoran_type'])->with('success_msg', 'Setoran berhasil dihapus!');

    }


/*
|--------------------------------------------------------------------------
| Setoran Edit Functions
|--------------------------------------------------------------------------
*/

    //Get list setoran for Edit
    public function list_edit()
    {
      $user_info = Auth::user();
      $setoran   = Setoran::leftjoin('tags', 'tags.id', '=', 'setoran.setoran_category')
      										->leftjoin('users', 'users.id', '=', 'setoran.user_id')
      										->select('*', 'setoran.created_at AS tanggal')
      										->where('setoran_type', '=', '0')
      										->where('status', '=', 1)
      										->orderBy('setoran.created_at', 'desc')
      										->get()
      										->toArray();

    	return view('html.setoran.list_edit')
                ->with('user_info', $user_info)
                ->with('setoran', $setoran);
    }

    //Add new setoran for Edit
    public function add_edit()
    {
      $user_info = Auth::user();
      $kategori  = Kategori::orderBy('judul', 'asc')->get()->toArray();

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
    public function list_qc()
    {
     $user_info = Auth::user();
      $setoran   = Setoran::leftjoin('tags', 'tags.id', '=', 'setoran.setoran_category')
      										->leftjoin('users', 'users.id', '=', 'setoran.user_id')
      										->select('*', 'setoran.created_at AS tanggal')
      										->where('setoran_type', '=', '1')
      										->where('status', '=', 1)
      										->orderBy('setoran.created_at', 'desc')
      										->get()
      										->toArray();

    	return view('html.setoran.list_qc')
                ->with('user_info', $user_info)
                ->with('setoran', $setoran);
    }

    //Add new setoran for QC
    public function add_qc()
    {
      $user_info = Auth::user();
      $kategori  = Kategori::orderBy('judul', 'asc')->get()->toArray();

    	return view('html.setoran.add_qc')
                ->with('user_info', $user_info)
                ->with('kategori', $kategori);
    }

}
