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
use App\Shops;
use App\ShopsDetail;


class ShopsController extends Controller
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
      $product   = Shops::where('status', '=', '0')->get()->toArray();

      foreach ($product as $key => $value) 
      {
      	$order 			= ShopsDetail::where('shops_id', '=', $value['shops_id'])->count();
      	$unpaid 		= ShopsDetail::where('shops_id', '=', $value['shops_id'])->where('shops_detail_status', '=', 0)->count();
      	$paid 			= ShopsDetail::where('shops_id', '=', $value['shops_id'])->where('shops_detail_status', '=', 1)->count();
      	$delivered 	= ShopsDetail::where('shops_id', '=', $value['shops_id'])->where('shops_detail_status', '=', 2)->count();

      	//Add data to each product
      	$product[$key]['shops_order']  		= $order;
      	$product[$key]['shops_unpaid']  	= $unpaid;
      	$product[$key]['shops_paid']  		= $paid;
      	$product[$key]['shops_delivered'] = $delivered;
      }

    	return view('html.shops.index')
    						->with('product', $product)
                ->with('user_info', $user_info);
    }    

    //Detail data with template
    public function detail($id, Request $request)
    {
      $user_info = Auth::user();
      $get_id    = preg_replace("/[^0-9]/", "", base64_decode($id));
      $product	 = Shops::where('shops_id', '=', $get_id)->first();
      $detail    = ShopsDetail::where('shops_id', '=', $id)->get()->toArray();

    	return view('html.shops.detail')
    						->with('product', $product)
                ->with('detail', $detail)
                ->with('user_info', $user_info);

    }


}
