<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

//Call table
use App\Kategori;
use App\Setoran;

class SetoranController extends Controller
{
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

    //Get list setoran for Edit
    public function list_edit()
    {
      $user_info = Auth::user();

    	return view('html.setoran.list_edit')
                ->with('user_info', $user_info);
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

    //Store new setoran for Edit
    public function store_edit(Request $request)
    {

    	$path				 = 'uploads/edit/';
    	$file_upload = $request['setoran_file'];
    	$filename 	 = $file_upload->getClientOriginalName();
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

      $insert = Setoran::insert($store);

      if (!$insert) 
      {
      	return redirect('html.setoran.add_edit');
      }

    	return redirect('setoran/edit');

    }

    //Get list setoran for QC
    public function list_qc()
    {
      $user_info = Auth::user();

    	return view('html.setoran.list_qc')
                ->with('user_info', $user_info);
    }
}
