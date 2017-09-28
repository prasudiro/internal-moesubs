@extends('themes.default')

@section('judul')

Detail Pemesan

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-8">
	        <h5>Nama Pemesan <small>(Detail informasi pembeli).</small></h5>
	      </div>
	      <div class="col-md-4 text-right">
          <a href="{{ URL('shops/detail/'.base64_encode($detail['shops_id'].'shops'))}}" class="btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
	        <a data-toggle="modal" data-target="#belumada"  class="btn-sm btn-warning"><i class="fa fa-edit"></i> Edit Pemesan</a>
	      </div>
      </div>
      <div class="ibox-content">
        <div class="row">
          <div class="col-md-3 text-center">
            <h3>Bukti Foto Pembayaran</h3>
            @if(isset($detail['confirmation']['gambar_penyetor']))
            <img src="{{ URL('uploads/confirmation/'.$detail['shops_id'].'/'.$detail['confirmation']['gambar_penyetor'])}}" width="100%" alt="Bukti Pembayaran">
            @else
              Tidak mengunggah <br>bukti pembayaran
            @endif
          </div>
          <div class="col-md-6">
            <h3><center>Informasi Lengkap</center></h3>
            <div class="hr-line-dashed"></div>
              <div class="row">
                <div class="col-sm-3">
                  <p><label class="control-label">Nama Lengkap</label></p>
                  <p><label class="control-label">Alamat</label></p>
                </div>
                <div class="col-sm-9">
                  <p>{{ $detail['shops_detail_buyer']}}</p>
                  <p>{{ $detail['information']['alamat']}}<br>{{ $detail['information']['kabkota']}}, {{ $detail['information']['kecamatan']}}<br>{{ $detail['information']['provinsi']}} {{ $detail['information']['kodepos']}}</p>
                </div>
                <div class="col-sm-3">
                  <p><label class="control-label">Email</label></p>
                  <p><label class="control-label">No. HP</label></p>
                </div>
                <div class="col-sm-9">
                  <p>{{ $detail['shops_detail_email']}}</p>
                  <p>{{ $detail['information']['nohp']}}</p>
                </div>
              </div>
            <div class="hr-line-dashed"></div><div class="row">
                <div class="col-sm-6">
                  <p>
                    <label class="control-label">Jumlah Pesanan</label><br>
                    {{ $detail['shops_detail_quantity']}} buah <i>{{ $product['shops_product']}}</i>
                  </p>
                  <p>
                    <label class="control-label">Status Pembayaran</label><br>
                    <?php
                      if ($detail['shops_detail_status'] == 0) 
                      {
                        if ($detail['confirmation']['status_penyetor'] == 'diterima') 
                        {
                          $status = "<label class='label label-info'>Dibayar</label>";
                        }
                        else
                        {
                          $status = "<label class='label label-danger'>Proses</label>";
                        }
                      } 
                      elseif ($detail['shops_detail_status'] == 1) 
                      {
                        $status = "<label class='label label-success'>Lunas</label>";
                      }
                      elseif($detail['shops_detail_status'] == 2) 
                      {
                        $status = "<label class='label label-muted'>Dikirim</label>";
                      }
                    ?>
                  {!! $status!!}
                  </p>
                </div>
                <div class="col-sm-6">
                  <p>
                    <label class="control-label">Total Pembayaran</label><br>
                    {{ number_format($detail['shops_detail_quantity']*$product['shops_price'])}} IDR
                  </p>
                  <p>
                    <label class="control-label">Status Pesanan</label><br>
                    @if($detail['confirmation']['status_penyetor'] == 'diterima')
                      <span class="label label-info">Menunggu Konfirmasi</span>
                    @elseif($detail['confirmation']['status_penyetor'] == 'dikonfirm')
                      <a href="#" class="label label-success">Kirim Resi</a>
                    @elseif($detail['confirmation']['status_penyetor'] == 'dikirim')
                      Sudah dikirim
                    @else
                      Menunggu
                    @endif
                  </p>
                </div>
              </div>
          </div>
          <div class="col-md-3">
            <h3><center>Bukti Tertulis Pembayaran</center></h3>
            <div class="form-group">
              <label class="control-label">Nama Penyetor</label><br>
              {{ $detail['confirmation']['nama_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Bank</label><br>
              {{ $detail['confirmation']['bank_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Nomor Rekening</label><br>
              {{ $detail['confirmation']['norek_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Jumlah Transfer</label><br>
              {{ number_format($detail['confirmation']['jumlah_penyetor'])}} IDR
            </div>
            <div class="form-group">
              <label class="control-label">Tujuan Pembayaran</label><br>
              {{ $detail['confirmation']['tujuan_penyetor']}}
            </div>
            <br>
              @if($detail['confirmation']['status_penyetor'] == 'diterima')
                <center>
                  <a data-toggle="modal" data-target="#confirmid{{ $detail['shops_detail_id']}}" class="btn-lg btn-info">Konfirmasi</a>
                </center>
              @endif
          </div>         
        </div>
      </div>
     </div>
   </div>
</div>

<div class="modal inmodal" id="confirmid{{ $detail['shops_detail_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content animated flipInX">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h3>Konfirmasi Pembayaran</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="control-label">Nama Penyetor</label><br>
              {{ $detail['confirmation']['nama_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Bank</label><br>
              {{ $detail['confirmation']['bank_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Nomor Rekening</label><br>
              {{ $detail['confirmation']['norek_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Jumlah Transfer</label><br>
              {{ number_format($detail['confirmation']['jumlah_penyetor'])}} IDR
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="control-label">Tujuan Pembayaran</label><br>
              {{ $detail['confirmation']['tujuan_penyetor']}}
            </div>
            <div class="form-group">
              <label class="control-label">Bukti Pembayaran</label><br>
              @if(isset($detail['confirmation']['gambar_penyetor']))
              @else
              @endif
              <a href="{{ URL('uploads/confirmation/'.$detail['shops_id'].'/'.$detail['confirmation']['gambar_penyetor'])}}" target="_blank">
                <i class="fa fa-paperclip"></i> Lihat bukti pembayaran
              </a>              
            </div>
          </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
              <button class="btn btn-info" data-toggle="modal" data-target="#approveid{{ $detail['shops_detail_id']}}">Konfirmasi</button>
            </center>
          </div>
      </div>
  </div>
</div>

<div class="modal inmodal" id="approveid{{ $detail['shops_detail_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content animated flipInX">
        <form class="form-horizontal" role="form" method="post" action="{{ URL('shops/detail/approved')}}" accept-charset="utf-8" enctype="multipart/form-data">
        {{ csrf_field()}}
        <input type="hidden" name="shops_detail_id" value="{{ base64_encode('aprroved'.$detail['shops_detail_id'].'usershopsdetailid')}}">
        <input type="hidden" name="shops_id" value="{{ base64_encode('product'.$detail['shops_id'].'usershopsid')}}">
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

@endsection