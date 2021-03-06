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
use App\City;

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
      $city      = City::orderBy('city_name', 'asc')->get()->toArray();

      if (count($gachi) == 0) 
      {
        return redirect('undefined');
      }

      if (strtotime($gachi['shops_closed']) < strtotime(date("y-m-d H:i:s"))) 
      {
        return view('html.errors.closed');
      }

      $meta_detail = json_decode($metadata['metadata_detail'], TRUE);

    	return view('html.order.index')
            ->with('gachi', $gachi)
            ->with('meta_detail', $meta_detail)
            ->with('user_info', $user_info)
            ->with('city', $city);
    }

    //Pemesanan save and validation
    public function order_add(Request $request)
    {
      $number = is_numeric($request['hp']);
      // return redirect()->back()->with('error_msg', 'Pemesanan belum dibuka!<br>Tunggu informasi lanjutan!');
      // exit();
      $user_info = Auth::user();
      $gachi     = Shops::where('shops_product', 'LIKE', '%gantungan%')->where('status', '=', '0')->first();
      $detail    = ShopsDetail::where('shops_detail_email', '=', $request['email'])->first();
      $metadata  = Metadata::where('metadata_module', '=', 'shops')->where('metadata_module_id', '=', $gachi['shops_id'])->first();

      $ongkir['city_id']    = $request['kabkota'];
      $ongkir['cost']       = $this->tracking($request['kabkota'])['cost'];
      $ongkir['etd']        = $this->tracking($request['kabkota'])['etd'];
      $ongkir['city']       = $this->tracking($request['kabkota'])['city'];

      $meta_detail = json_decode($metadata['metadata_detail'], TRUE);

      if (base64_decode($request['shops_price']) != $gachi['shops_price']) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Total harga tidak sesuai!<br>Silakan coba lagi!');
      }

      if (count($detail) > 0) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Anda sudah pernah memesan sebelumnya!<br>Hubungi kami jika ada masalah!');
      }

      if ($number != 1)
      {
        return redirect()->back()->withInput()->with('error_msg', 'nomor HP gunakan hanya angka!<br>Silakan coba lagi');
      }

      $information  = array(
                            'nama'        => $request['fullname'],
                            'alamat'      => $request['alamat'],
                            'kabkota'     => $ongkir['city'],
                            'kecamatan'   => $request['kecamatan'],
                            'provinsi'    => $request['provinsi'],
                            'kodepos'     => $request['kodepos'],
                            'nohp'        => $request['hp'],
                            'email'       => $request['email'],
                            'pesanan'     => $request['pesanan'],
                            'ongkir'      => $ongkir['cost'],
                            'estimasi'    => $ongkir['etd'],
                      );

      $order_data = array(
                          'shops_id'                  => $request['shops_id'],
                          'shops_detail_quantity'     => $request['pesanan'],
                          'shops_detail_buyer'        => $request['fullname'],
                          'shops_detail_email'        => $request['email'],
                          'shops_detail_information'  => json_encode($information),
                    );

      $order_save = ShopsDetail::create($order_data);

      if (!$order_save) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Pesanan gagal!<br>Silakan coba lagi!');
      }

      //Email to user
      Mail::send('html.mail.order_add', ['data' => $request, 'ongkir' => $ongkir, 'user_info' => $user_info, 'produk' => $gachi, 'meta_detail' => $meta_detail, 'order_save' => $order_save], function ($m) use ($request, $gachi, $order_save) {
              $m->from('admin@moesubs.com', 'Moeshops');
              $m->to($request['email'], $request['fullname'])->subject('[Pre-Order] '.$gachi['shops_product'].' [Pemesanan Diterima]');
            });

      //Email to admin
      $admin_email = ['symphoniaofdark@gmail.com', 'prassaiyan@gmail.com', 'handband.handband@gmail.com'];
      $admin_name  = ['iLuminarie', 'Himeko', 'HB-chan'];
      Mail::send('html.mail.admin_order_add', ['data' => $request, 'ongkir' => $ongkir, 'user_info' => $user_info, 'produk' => $gachi, 'meta_detail' => $meta_detail, 'order_save', $order_save], function ($m) use ($request, $gachi, $admin_email, $admin_name) {
              $m->from('admin@moesubs.com', 'Moeshops');
              $m->to($admin_email, $admin_name)->subject('[Pesanan Baru] '.$gachi['shops_product'].' ['.$request['fullname'].']');
            });

      return redirect()->back()->with('success_msg', 'Pemesanan berhasil! <br>Silakan cek email untuk lebih detailnya!');
    }

    //Cek status, it's like a mini profile page
    public function status($id, $code, Request $request)
    {
      $get_id     = preg_replace("/[^0-9]/", "", base64_decode($id));
      $code       = str_replace('_usermail', '', base64_decode($code));

      $order_detail = ShopsDetail::where('shops_detail_id', '=', $get_id)->where('shops_detail_email', '=', $code)->first();
      $product      = Shops::where('shops_id', '=', $order_detail['shops_id'])->first();
      $metadata     = Metadata::where('metadata_module', '=', 'shops')->where('metadata_module_id', '=', $order_detail['shops_id'])->first();
      $confirmation = Metadata::where('metadata_module', '=', 'confirmation')
                              ->where('metadata_module_id', '=', $order_detail['shops_id'])
                              ->where('user_id', '=', $order_detail['shops_detail_id'])->first();

      $meta_detail          = json_decode($metadata['metadata_detail'], TRUE);
      $confirmation_detail  = json_decode($confirmation['metadata_detail'], TRUE);
      $order_info           = json_decode($order_detail['shops_detail_information'], TRUE);

      if (count($order_detail) == 0) 
      {
        return redirect('undefined');
      }
      
if($order_detail['status'] == '1')
{
return redirect('undefined');
}

      return view('html.order.status')
            ->with('order_detail', $order_detail)
            ->with('product', $product)
            ->with('meta_detail', $meta_detail)
            ->with('order_info', $order_info)
            ->with('confirmation_detail', $confirmation_detail);
    }

    //Add user confirmation
    public function add_confirm(Request $request)
    {
      $user_info = Auth::user();
      $request['shops_id']        = preg_replace("/[^0-9]/", "", base64_decode($request['shops_id']));
      $request['shops_detail_id'] = preg_replace("/[^0-9]/", "", base64_decode($request['shops_detail_id']));

      $product = Shops::where('shops_id', '=', $request['shops_id'])->first();
      $detail  = ShopsDetail::where('shops_detail_id', '=', $request['shops_detail_id'])->first();



      $payment_upload = "";
      $proof_name     = "";
      if (isset($request['gambar_penyetor'])) 
      {
        $path         = 'uploads/confirmation/'.$request['shops_id'].'/';
        $proof        = $request['gambar_penyetor'];
        $proof_name   = strtolower(str_replace(" ", "_", 'confirmation_'.base64_encode("confirmationsent".$request['shops_detail_id']."userid").date("ymdhis").'.'.$proof->getClientOriginalExtension()));
        $proof->move($path, $proof_name);
      }

      $metadata_detail  = array(
                                'shops_detail_id' => $request['shops_detail_id'],
                                'shops_id'        => $request['shops_id'],
                                'nama_penyetor'   => $request['nama_penyetor'],
                                'bank_penyetor'   => $request['bank_penyetor'],
                                'norek_penyetor'  => $request['norek_penyetor'],
                                'tujuan_penyetor' => $request['tujuan_penyetor'],
                                'jumlah_penyetor' => $request['jumlah_penyetor'],
                                'gambar_penyetor' => $proof_name,
                                'status_penyetor' => 'diterima',
                          );

      $metadata   = array(
                          'metadata_module_id'    => $request['shops_id'],
                          'metadata_module'       => 'confirmation',
                          'metadata_detail'       => json_encode($metadata_detail),
                          'user_id'               => $request['shops_detail_id'],
                          'created_at'            => date("y-m-d H:i:s"),
                          'updated_at'            => date("y-m-d H:i:s"),
                    );

      $metadata_save = Metadata::insert($metadata);

      if (!$metadata_save) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Konfirmasi gagal!<br>Silakan dicoba kembali!');
      }

      //Email to user
      Mail::send('html.mail.order_confirm', ['data' => $request, 'user_info' => $user_info, 'product' => $product, 'detail' => $detail], function ($m) use ($request, $product, $detail) {
              $m->from('admin@moesubs.com', 'Moeshops');
              $m->to($detail['shops_detail_email'], $detail['shops_detail_buyer'])->subject('[Pre-Order] '.$product['shops_product'].' [Konfirmasi Pembayaran Diterima]');
            });

      //Email to admin
      $admin_email = ['symphoniaofdark@gmail.com', 'prassaiyan@gmail.com', 'handband.handband@gmail.com'];
      $admin_name  = ['iLuminarie', 'Himeko', 'HB-chan'];
      Mail::send('html.mail.admin_order_confirm', ['data' => $request, 'user_info' => $user_info, 'product' => $product, 'detail' => $detail], function ($m) use ($request, $product, $detail, $admin_email, $admin_name) {
              $m->from('admin@moesubs.com', 'Moeshops');
              $m->to($admin_email, $admin_name)->subject('[Konfirmasi Baru] '.$product['shops_product'].' ['.$detail['shops_detail_buyer'].']');
            });

      return redirect()->back()->with('success_msg', 'Konfirmasi akan segera diproses!<br>Silakan cek email dan laman ini untuk pembaruan status pemesanan');
    }

    public function contact_send(Request $request)
    {
        //Email to contant us
        $admin_email = ['symphoniaofdark@gmail.com', 'prassaiyan@gmail.com', 'handband.handband@gmail.com'];
        $admin_name  = ['iLuminarie', 'Himeko', 'HB-chan'];
        Mail::send('html.mail.contact_us', ['request' => $request], function ($m) use ($request, $admin_email, $admin_name) {
                $m->from($request['contact_email'], $request['contact_name']);
                $m->to($admin_email, $admin_name)->subject('[Pesan Baru] '.$request['contact_subject'].' [ '.$request['contact_name'].' ]');
              });

        return redirect()->back()->with('success_msg', 'Pesan berhasil dikirim! <br>Kami akan segera mengirimkan balasan ke email Anda!');
    }

    //Return all invalid redirections
    // public function returning()
    // {
    //   return redirect('/')->with('success_msg', 'Silakan melakukan pemesanan!');
    // }

    //View template
    public function template_view()
    {
      return view('html.mail.order_add');
    }

    //View confirmation proof
    public function confirm_proof($id)
    {
      $proof_id = preg_replace("/[^0-9]/", "", base64_decode($id));
      echo $proof_id;
    }

    //Tracking cost
    public function tracking($destination=1)
    {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=23&destination=".$destination."&weight=1000&courier=jne",
        CURLOPT_HTTPHEADER => array(
          // "content-type: application/x-www-form-urlencoded",
          "key: 57fb1f3af1513838e1e9dbeb15920a56"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      $hasil = json_decode($response, TRUE);

      $results['cost'] = isset($hasil['rajaongkir']['results'][0]['costs'][1]['cost'][0]['value']) ? $hasil['rajaongkir']['results'][0]['costs'][1]['cost'][0]['value'] : 60000;
      $results['etd'] = isset($hasil['rajaongkir']['results'][0]['costs'][1]['cost'][0]['etd']) ? $hasil['rajaongkir']['results'][0]['costs'][1]['cost'][0]['etd'] : "3-7";      
      $results['city'] = isset($hasil['rajaongkir']['destination_details']['city_name']) ? $hasil['rajaongkir']['destination_details']['city_name'] : "Konoha";      

      return $results;
    }
}
