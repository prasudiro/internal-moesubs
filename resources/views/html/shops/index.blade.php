@extends('themes.default')

@section('judul')

Shops

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-6">
	        <h5>Shops <small>(berisikan daftar penjualan dan pemesaran, serta konfirmasi pembayaran).</small></h5>
	      </div>
	      <div class="col-md-6 text-right">
	        <a data-toggle="modal" data-target="#belumada"  class="btn-sm btn-danger"><i class="fa fa-plus"></i> Tambah Produk</a>
	      </div>
      </div>
      <div class="ibox-content">
	      
	     <table class="table table-striped table-bordered table-hover dataTables-shops" >
          <thead>
          <tr>
                <th width="50%">Produk Penjualan</th>
                <th width="8%">Status</th>
                <th width="5%">Total</th>
                <th width="5%">Proses</th>
                <th width="5%">Lunas</th>
                <th width="5%">Dikirim</th>
                <th width="55">Ditutup pada</th>
                <th width="8%">Pengaturan</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($product as $data) 
            <tr>
              <td style="vertical-align: middle !important;">
              <a href="{{ URL('shops/detail/'.base64_encode($data['shops_id'].'shops'))}}" data-toggle="tooltip" title="Lihat detail produk {{ $data['shops_product']}}">
              {{ $data['shops_product']}}
              </a>
              </td>
              <td class="text-center" style="vertical-align: middle !important;">{!! $data['shops_status'] == 0 ? '<label class="label label-info">Pre Order</label>' : '<label class="label label-success">Ready Stock</label>'!!}</td>
              <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_order']}}</td>
              <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_order']}}</td>
              <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_order']}}</td>
              <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_order']}}</td>
              <td style="vertical-align: middle !important;">{{ date("d M y H:i", strtotime($data['shops_closed']))}}</td>
              <td class="text-center" style="vertical-align: middle !important;">
                <a data-toggle="modal" data-target="#belumada" title="Detail"><i class="fa fa-gamepad text-danger"></i></a>
                &nbsp;
                <a data-toggle="modal" data-target="#belumada" title="Edit"><i class="fa fa-edit text-danger" data-toggle="tooltip" title="Edit"></i></a>
                &nbsp;
                <a data-toggle="modal" data-target="#belumada" title="Hapus"><i class="fa fa-trash text-danger" data-toggle="tooltip" title="Hapus"></i></a>
              </td>
            </tr>
          @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th>Produk Penjualan</th>
                <th>Status</th>
                <th>Total</th>
                <th>Proses</th>
                <th>Lunas</th>
                <th>Dikirim</th>
                <th>Ditutup pada</th>
                <th>Pengaturan</th>
            </tr>
          </tfoot>
          </table>


      </div>
     </div>
   </div>
</div>

@endsection