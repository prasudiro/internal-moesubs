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
      $detail    = ShopsDetail::where('shops_id', '=', $product['shops_id'])->get()->toArray();
      $metadata  = Metadata::where('metadata_module', '=', 'shops')->where('metadata_module_id', '=', $get_id)->first();

      $meta_detail = json_decode($metadata['metadata_detail'], TRUE);

      foreach ($detail as $key => $value) 
      {        
        $confirmation = Metadata::where('metadata_module', '=', 'confirmation')
                                ->where('metadata_module_id', '=', $value['shops_id'])
                                ->where('user_id', '=', $value['shops_detail_id'])->first();

        $confirmation_detail  = json_decode($confirmation['metadata_detail'], TRUE);

        $detail[$key]['confirmation'] = $confirmation_detail;
      }

    	return view('html.shops.detail')
    						->with('product', $product)
                ->with('detail', $detail)
                ->with('meta_detail', $meta_detail)
                ->with('user_info', $user_info);

    }

    //Add new data
    public function add(Request $request)
    {      
      $user_info = Auth::user();

      return view('html.shops.add')
                ->with('user_info', $user_info);
    }

    //Save new data
    public function store(Request $request)
    { 
      $user_info = Auth::user();

      $product_data = array(
                            'shops_product'           => $request['shops_product'],
                            'shops_detail'            => $request['shops_detail'],
                            'shops_price'             => $request['shops_price'],
                            'shops_discount'          => $request['shops_discount'],
                            'shops_discount_percent'  => $request['shops_discount_percent'],
                            'shops_status'            => $request['shops_status'],
                            'shops_closed'            => $request['shops_closed'],
                            'user_id'                 => $request['user_id'],
                      );

      $product_save = Shops::create($product_data);

      if (!$product_save) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Produk gagal ditambahkan!<br>Silakan dicoba lagi!');
      }

      $path        = 'uploads/shops/'.$product_save->shops_id.'/';

      $file1       = $request['gambar1'];
      $file2       = $request['gambar2'];
      $file3       = $request['gambar3'];

      $filename1   = strtolower(str_replace(" ", "_", $request['shops_product'])).'_1.'.$file1->getClientOriginalExtension();
      $filename2   = strtolower(str_replace(" ", "_", $request['shops_product'])).'_2.'.$file2->getClientOriginalExtension();
      $filename3   = strtolower(str_replace(" ", "_", $request['shops_product'])).'_3.'.$file3->getClientOriginalExtension();

      $file1->move($path, $filename1);
      $file2->move($path, $filename2);
      $file3->move($path, $filename3);

      $metadata_detail  = array(
                                'bank'      => $request['bank'],
                                'gambar1'   => $filename1,
                                'gambar2'   => $filename2,
                                'gambar3'   => $filename3,
                          );

      $metadata   = array(
                          'metadata_module_id'    => $product_save->shops_id,
                          'metadata_module'       => 'shops',
                          'metadata_detail'       => json_encode($metadata_detail),
                          'user_id'               => $request['user_id'],
                          'created_at'            => date("y-m-d H:i:s"),
                          'updated_at'            => date("y-m-d H:i:s"),
                    );

      $metadata_save  = Metadata::insert($metadata);

      return redirect('shops')->with('success_msg', 'Produk berhasil ditambahkan!');
    }

    //Edit data
    public function edit($id, Request $request)
    {      
      $user_info = Auth::user();
      $get_id    = preg_replace("/[^0-9]/", "", base64_decode($id));
      $product   = Shops::where('shops_id', '=', $get_id)->first();
      $metadata  = Metadata::where('metadata_module', '=', 'shops')->where('metadata_module_id', '=', $get_id)->first();

      $meta_detail = json_decode($metadata['metadata_detail'], TRUE);

      return view('html.shops.edit')
                ->with('product', $product)
                ->with('meta_detail', $meta_detail)
                ->with('user_info', $user_info);
    }

    //Update data
    public function update(Request $request)
    { 
      $user_info = Auth::user();
      $product   = Shops::where('shops_id', '=', $request['shops_id'])->first();
      $metadata  = Metadata::where('metadata_module', '=', 'shops')->where('metadata_module_id', '=', $request['shops_id'])->first();

      $meta_detail = json_decode($metadata['metadata_detail'], TRUE);
      $path        = 'uploads/shops/'.$request['shops_id'].'/';

      if (!isset($request['gambar1'])) 
      {
        $filename1 = $meta_detail['gambar1'];
      }
      else
      {
        $file1       = $request['gambar1'];
        $filename1   = strtolower(str_replace(" ", "_", $request['shops_product'])).'_1.'.$file1->getClientOriginalExtension();
        $file1->move($path, $filename1);
      }

      if (!isset($request['gambar2'])) 
      {
        $filename2 = $meta_detail['gambar2'];
      }
      else
      {
        
        $file2       = $request['gambar2'];
        $filename2   = strtolower(str_replace(" ", "_", $request['shops_product'])).'_2.'.$file2->getClientOriginalExtension();
        $file2->move($path, $filename2);
      }

      if (!isset($request['gambar3'])) 
      {
        $filename3 = $meta_detail['gambar3'];;
      }
      else
      {
        
        $file3       = $request['gambar3'];
        $filename3   = strtolower(str_replace(" ", "_", $request['shops_product'])).'_3.'.$file3->getClientOriginalExtension();
        $file3->move($path, $filename3);
      }

      $shops_data = array(
                          'user_id'                 => $request['user_id'],
                          'shops_product'           => $request['shops_product'],
                          'shops_detail'            => $request['shops_detail'],
                          'shops_price'             => $request['shops_price'],
                          'shops_discount'          => $request['shops_discount'],
                          'shops_discount_percent'  => $request['shops_discount_percent'],
                          'shops_status'            => $request['shops_status'],
                          'shops_closed'            => $request['shops_closed'],

                    );

      $shops_update = Shops::where('shops_id', '=', $request['shops_id'])->update($shops_data);

      if (!$shops_update) 
      {
        return redirect()->back()->withInput()->with('error_msg', 'Produk gagal diperbarui!<br>Silakan dicoba lagi!');
      }

      $metadata_detail  = array(
                                'bank'    => $request['bank'],
                                'gambar1' => $filename1,
                                'gambar2' => $filename2,
                                'gambar3' => $filename3,
                          );

      $metadata   = array(
                          'metadata_detail'       => json_encode($metadata_detail),
                          'user_id'               => $request['user_id'],
                    );

      $metadata_save  = Metadata::where('metadata_module', '=', 'shops')->where('metadata_module_id', '=', $request['shops_id'])->update($metadata);

      return redirect('shops')->with('success_msg', 'Produk berhasil diperbaruii');
    }

    //Approving payment
    public function approve(Request $request)
    {
      $request['shops_detail_id']   = preg_replace("/[^0-9]/", "", base64_decode($request['shops_detail_id']));
      $request['shops_id']          = preg_replace("/[^0-9]/", "", base64_decode($request['shops_id']));

      $user_info      = Auth::user();
      $product        = Shops::where('shops_id', '=', $request['shops_id'])->first();
      $shops_detail   = ShopsDetail::where('shops_detail_id', '=', $request['shops_detail_id'])->first();
      $status_update  = ShopsDetail::where('shops_detail_id', '=', $request['shops_detail_id'])->update(array('shops_detail_status' => 1));
      $metadata       = Metadata::where('metadata_module_id', '=', $request['shops_id'])
                                ->where('metadata_module', '=', 'confirmation')
                                ->where('user_id', '=', $request['shops_detail_id'])
                                ->first();

      $meta_detail    = json_decode($metadata['metadata_detail'], TRUE);

      $meta_update    = array(
                              'shops_detail_id' => $meta_detail['shops_detail_id'],
                              'shops_id'        => $meta_detail['shops_id'],
                              'nama_penyetor'   => $meta_detail['nama_penyetor'],
                              'bank_penyetor'   => $meta_detail['bank_penyetor'],
                              'norek_penyetor'  => $meta_detail['norek_penyetor'],
                              'tujuan_penyetor'  => $meta_detail['tujuan_penyetor'],
                              'jumlah_penyetor' => $meta_detail['jumlah_penyetor'],
                              'gambar_penyetor' => $meta_detail['gambar_penyetor'],
                              'status_penyetor' => 'dikonfirm'
                        );

      $metadata_update= Metadata::where('metadata_module_id', '=', $request['shops_id'])
                                ->where('metadata_module', '=', 'confirmation')
                                ->where('user_id', '=', $request['shops_detail_id'])
                                ->update(array('metadata_detail' => json_encode($meta_update)));

      if (!$status_update OR !$metadata_update) 
      {
        return redirect()->back()->with('error_msg', 'Konfirmasi gagal!<br> Silakan dicoba lagi');
      }

      //Email to user
      Mail::send('html.mail.order_confirmed', ['request' => $request, 'user_info' => $user_info, 'product' => $product, 'shops_detail' => $shops_detail, 'meta_detail' => $meta_detail], function ($m) use ($shops_detail, $product) {
              $m->from('admin@moesubs.com', 'Moeshops');
              $m->to($shops_detail['shops_detail_email'], $shops_detail['shops_detail_buyer'])->subject('[Pre-Order] '.$product['shops_product'].' [Pembayaran Lunas]');
            });

      return redirect()->back()->with('success_msg', 'Konfirmasi berhasil!');

    }

    //Delete data
    public function delete(Request $request)
    {
      if ($request['product_delete'] != "HAPUS") 
      {
        return redirect()->back()->with('error_msg', 'Produk gagal dihapus!<br>Silakan dicoba lagi!');
      }

      $user_info      = Auth::user();
      $delete         = array('status' => '1');
      $product_delete = Shops::where('shops_id', '=', $request['shops_id'])->update($delete);
      $meta_delete    = Metadata::where('metadata_module', '=', 'shops')->where('metadata_module_id', '=', $request['shops_id'])->update($delete);

      if (!$product_delete) 
      {
        return redirect('shops')->with('error_msg', 'Produk gagal dihapus!<br>Silakan dicoba lagi!');
      }

      return redirect('shops')->with('success_msg', 'Produk berhasil dihapus!');
    }

}
