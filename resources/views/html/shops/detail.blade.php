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
                <th width="50%">Nama Pemesan </th>
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
                <td style="vertical-align: middle !important;">
                <a href="{{ URL('shops/detail/'.base64_encode($product['shops_id'].'shops').'/buyer/'.base64_encode($data['shops_detail_id'].'shopsdetailid'))}}">
                  {{ $data['shops_detail_buyer']}}
                </a>
                </td>
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
                    $status = "<label class='label label-success'>Lunas</label>";
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
                    <a data-toggle="modal" data-target="#confirmid{{ $data['shops_detail_id']}}" class="label label-info">Konfirmasi</a>
                  @elseif($data['confirmation']['status_penyetor'] == 'dikonfirm')
                    <a href="#" class="label label-success">Kirim Resi</a>
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

@foreach($detail as $data2)
<div class="modal inmodal" id="confirmid{{ $data2['shops_detail_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content animated flipInX">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h3>Konfirmasi Pembayaran</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="control-label">Nama Penyetor</label><br>
              {{ $data2['confirmation']['nama_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Bank</label><br>
              {{ $data2['confirmation']['bank_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Nomor Rekening</label><br>
              {{ $data2['confirmation']['norek_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Jumlah Transfer</label><br>
              {{ number_format($data2['confirmation']['jumlah_penyetor'])}} IDR
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="control-label">Tujuan Pembayaran</label><br>
              {{ $data2['confirmation']['tujuan_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Bukti Pembayaran</label><br>
              @if(isset($data2['confirmation']['gambar_penyetor']))
              @else
              @endif
              <a href="{{ URL('uploads/confirmation/'.$data2['shops_id'].'/'.$data2['confirmation']['gambar_penyetor'])}}" target="_blank">
                <i class="fa fa-paperclip"></i> Lihat bukti pembayaran
              </a>              
            </div>
          </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
              <button class="btn btn-info" data-toggle="modal" data-target="#approveid{{ $data2['shops_detail_id']}}">Konfirmasi</button>
            </center>
          </div>
      </div>
  </div>
</div>
@endforeach

@foreach($detail as $data3)
<div class="modal inmodal" id="approveid{{ $data3['shops_detail_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content animated flipInX">
        <form class="form-horizontal" role="form" method="post" action="{{ URL('shops/detail/approved')}}" accept-charset="utf-8" enctype="multipart/form-data">
        {{ csrf_field()}}
        <input type="hidden" name="shops_detail_id" value="{{ base64_encode('aprroved'.$data3['shops_detail_id'].'usershopsdetailid')}}">
        <input type="hidden" name="shops_id" value="{{ base64_encode('product'.$data3['shops_id'].'usershopsid')}}">
          <div class="modal-header">
            <h3>Konfirmasi Pembayaran</h3>
          </div>
          <div class="modal-body">
            <center>
              <h3>Apakah pembayarannya ini sudah diperiksa dan valid?</h3>
            </center>
          </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-white" data-dismiss="modal">Belum</button>
              <button class="btn btn-info" type="submit">Sudah</button>
            </center>
          </div>
        </form>
      </div>
  </div>
</div>
@endforeach

@endsection