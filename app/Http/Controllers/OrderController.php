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

class OrderController extends Controller
{ 
		//Default construct and validation
    public function __construct()
    {
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
    
    //Pemesanan form
    public function order(Request $request)
    {
      $user_info = Auth::user();
      $gachi     = Shops::where('shops_product', 'LIKE', '%gantungan%')->where('status', '=', '0')->first();
      $metadata  = Metadata::where('metadata_module', '=', 'shops')->where('metadata_module_id', '=', $gachi['shops_id'])->first();

      $meta_detail = json_decode($metadata['metadata_detail'], TRUE);

    	return view('html.order.index')
            ->with('gachi', $gachi)
            ->with('meta_detail', $meta_detail)
            ->with('user_info', $user_info);
    }

    //Pemesanan save and validation
    public function order_add(Request $request)
    {
      // return redirect()->back()->with('error_msg', 'Pemesanan belum dibuka!<br>Tunggu informasi lanjutan!');
      // exit();
      $user_info = Auth::user();
      $gachi     = Shops::where('shops_product', 'LIKE', '%gantungan%')->where('status', '=', '0')->first();
      $detail    = ShopsDetail::where('shops_detail_email', '=', $request['email'])->first();
      $metadata  = Metadata::where('metadata_module', '=', 'shops')->where('metadata_module_id', '=', $gachi['shops_id'])->first();

      $meta_detail = json_decode($metadata['metadata_detail'], TRUE);

      if (base64_decode($request['shops_price']) != $gachi['shops_price']) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Total harga tidak sesuai!<br>Silakan coba lagi!');
      }

      if (count($detail) > 0) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Anda sudah pernah memesan sebelumnya!<br>Hubungi kami jika ada masalah!');
      }

      $information  = array(
                            'nama'      => $request['fullname'],
                            'alamat'    => $request['alamat'],
                            'nohp'      => $request['hp'],
                            'email'     => $request['email'],
                            'pesanan'   => $request['pesanan']
                      );

      $order_data = array(
                          'shops_id'                  => $request['shops_id'],
                          'shops_detail_quantity'     => $request['pesanan'],
                          'shops_detail_buyer'        => $request['fullname'],
                          'shops_detail_email'        => $request['email'],
                          'shops_detail_information'  => json_encode($information),
                          'created_at'                => date("Y-m-d H:i:s"),
                          'updated_at'                => date("Y-m-d H:i:s"),
                    );

      $order_save = ShopsDetail::insert($order_data);

      if (!$order_data) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Pesanan gagal!<br>Silakan coba lagi!');
      }

      //Email to user
      Mail::send('html.mail.order_add', ['data' => $request, 'user_info' => $user_info, 'produk' => $gachi, 'meta_detail' => $meta_detail], function ($m) use ($request, $gachi) {
              $m->from('admin@moesubs.com', 'Moeshops');
              $m->to($request['email'], $request['fullname'])->subject('[Pre-Order] '.$gachi['shops_product'].' [Pemesanan Diterima]');
            });

      //Email to admin
      $admin_email = ['symphoniaofdark@gmail.com', 'prassaiyan@gmail.com'];
      $admin_name  = ['iLuminarie', 'Himeko'];
      Mail::send('html.mail.admin_order_add', ['data' => $request, 'user_info' => $user_info, 'produk' => $gachi, 'meta_detail' => $meta_detail], function ($m) use ($request, $gachi, $admin_email, $admin_name) {
              $m->from('admin@moesubs.com', 'Moeshops');
              $m->to($admin_email, $admin_name)->subject('[Pesanan Baru] '.$gachi['shops_product'].' ['.$request['fullname'].']');
            });

      return redirect()->back()->with('success_msg', 'Pemesanan berhasil! <br>Silakan cek email untuk lebih detailnya!');
    }

    //View template
    public function template_view()
    {
      return view('html.mail.order_add');
    }
}
