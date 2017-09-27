@extends('themes.default')

@section('judul')

Shops "{{ $product['shops_product']}}"

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-10">
	        <h5>{{ $product['shops_product']}} <small>(Detail daftar pemesanan produk {{ $product['shops_product']}}).</small></h5>
	      </div>
	      <div class="col-md-2 text-right">
	        <a data-toggle="modal" data-target="#belumada"  class="btn-sm btn-danger"><i class="fa fa-plus"></i> Tambah Pemesan</a>
	      </div>
      </div>
      <div class="ibox-content">
      <center>
	      <div class="lightBoxGallery">
        @for ($i=1; $i <= 3; $i++)
          <a href="{{ URL('uploads/shops/'.$product['shops_id'])}}/{{ $meta_detail['gambar'.$i]}}" title="{{ $product['shops_product']}} - {{ $i}}" data-gallery="">
            <img src="{{ URL('uploads/shops/'.$product['shops_id'])}}/{{ $meta_detail['gambar'.$i]}}" width="200" height="150">
          </a>
        @endfor
      </div>
      </center>
      <p><br></p>
	     <table class="table table-striped table-bordered table-hover dataTables-shopsdetail" >
          <thead>
          <tr>
                <th width="50%">Nama Pemesan</th>
                <th width="5%">Jumlah</th>
                <th width="8%">Total</th>
                <th width="7%">Status</th>
                <th width="20%">Tanggal Pesan</th>
                <th width="8%">Pengaturan</th>
          </tr>
          </thead>
          <tbody>
            @foreach($detail as $data)
              <tr>
                <td style="vertical-align: middle !important;">{{ $data['shops_detail_buyer']}}</td>
                <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_detail_quantity']}}</td>
                <td class="text-right" style="vertical-align: middle !important;">{{ number_format($data['shops_detail_quantity'] * $product['shops_price'])}}</td>
                <td class="text-center" style="vertical-align: middle !important;">
                  <?php
                  if ($data['shops_detail_status'] == 0) 
                  {
                    if ($data['confirmation']['status_penyetor'] == 'diterima') 
                    {
                      $status = "<label class='label label-info'>Dibayar</label>";
                    }
                    else
                    {
                      $status = "<label class='label label-danger'>Proses</label>";
                    }
                  } 
                  elseif ($data['shops_detail_status'] == 1) 
                  {
                    $status = "<label class='label label-primary'>Lunas</label>";
                  }
                  elseif($data['shops_detail_status'] == 2) 
                  {
                    $status = "<label class='label label-muted'>Dikirim</label>";
                  }
                  ?>
                {!! $status!!}
                </td>
                <td data-order="{{ strtotime($data['created_at'])}}" style="vertical-align: middle !important;">{{ date("d F Y - H:i", strtotime($data['created_at']))}}</td>
                <td class="text-center" style="vertical-align: middle !important;">
                  @if($data['confirmation']['status_penyetor'] == 'diterima')
                    <a href="#" class="label label-info">Konfirmasi</a>
                  @elseif($data['confirmation']['status_penyetor'] == 'dikonfirm')
                    Sudah dikonfirm
                  @elseif($data['confirmation']['status_penyetor'] == 'dikirim')
                    Sudah dikirim
                  @else
                    Menunggu
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th>Nama Pemesan</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal Pesan</th>
                <th>Pengaturan</th>
            </tr>
          </tfoot>
          </table>


      </div>
     </div>
   </div>
</div>

<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
@endsection