<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Status {{ $product['shops_status'] == 0 ? "Pre-Order " : "Pemesanan "}}{{ $product['shops_product']}} | [Moeshops] Jagonya Ngehobi</title>

    <link href="{{ URL('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ URL('css/animate.css')}}" rel="stylesheet">
    <link href="{{ URL('css/style.css')}}" rel="stylesheet">

    <!-- Datapicker -->
    <link href="{{ URL('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

		<!-- Toastr style -->
		<link href="{{ URL('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content">
  <div class="row">
      <div class="col-md-6 col-md-push-3">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h3 style="margin-top:0px;"><center><b>{{ $product['shops_status'] == 0 ? "Pre-Order " : "Pemesanan "}}{{ $product['shops_product']}}</b></center></h3>
                  <div class="ibox-tools" style="margin-top:-30px;">
                      <a class="collapse-link">
                          <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
              </div>
              <div class="ibox-content">
                <div class="carousel slide" id="gachi-logo-moe">
                      <div class="carousel-inner">
                          <div class="item active">
                              <img alt="image" class="img-responsive" src="{{ URL('uploads/shops/'.$product['shops_id'])}}/{{ $meta_detail['gambar1']}}">
                          </div>
                          @for ($i=2; $i <= 3; $i++) 
                          <div class="item">
                              <img alt="image" class="img-responsive" src="{{ URL('uploads/shops/'.$product['shops_id'])}}/{{ $meta_detail['gambar'.$i]}}">
                          </div>
                          @endfor

                      </div>
                      <a data-slide="prev" href="#gachi-logo-moe" class="left carousel-control">
                          <span class="icon-prev"></span>
                      </a>
                      <a data-slide="next" href="#gachi-logo-moe" class="right carousel-control">
                          <span class="icon-next"></span>
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="row">
      <div class="col-md-6 col-md-push-3">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h3 style="margin-top:0px;"><center><b>Informasi dan Status</b></center></h3>
                  <div class="ibox-tools" style="margin-top:-30px;">
                      <a class="collapse-link">
                          <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
              </div>
              <div class="ibox-content">
                <h3><b>Alamat Tujuan Pemesan</b></h3>
                <hr>
                <b>{{ $order_detail['shops_detail_buyer']}}</b><br>
                {{ $order_info['alamat']}}<br>
                {{ $order_info['kecamatan']}}, {{ $order_info['kabkota']}}<br>
                {{ $order_info['provinsi']}} {{ $order_info['kodepos']}}<br>
                <b>Nomor HP: {{ $order_info['nohp']}}</b>

                <!-- confirmation --><hr>

                <h3><b>Detail Transaksi</b></h3>
                <hr>
                <div class="row">
                  <div class="col-md-6">
                    <p>
                      <b>Jumlah Pesanan</b><br>
                      {{ $order_detail['shops_detail_quantity']}} buah <i>{{ $product['shops_product']}}</i>
                    </p>
                    <p>
                      <b>Pengiriman via</b><br>
                      JNE REG
                    </p>
                  </div>
                  <div class="col-md-6">
                    <p>
                      <b>Harga barang (satuan)</b><br>
                      {{ number_format($product['shops_price'])}} IDR
                    </p>
                    <p>
                      <b>Total Pembayaran</b><br>
                      {{ number_format($order_detail['shops_detail_quantity']*$product['shops_price'])}} IDR
                    </p>
                  </div>
                  <div class="col-md-6">
                    <b>Status Pembayaran</b><br>
                    <?php 
                      if ($order_detail['shops_detail_status'] == 0) 
                      {
                        if ($confirmation_detail['status_penyetor'] == 'diterima') 
                        {
                          echo "<label class='label label-warning'>PROSES KONFIRMASI</label>";
                        }
                        else
                        {
                          echo "<label class='label label-danger'>BELUM LUNAS</label>";
                        }
                      }
                      elseif ($order_detail['shops_detail_status'] == 1) 
                      {
                        echo "<label class='label label-info'>LUNAS</label>";
                      }
                      else
                      {
                        echo "<label class='label label-success'>DIKIRIM</label>";
                      }
                    ?>
                  </div>
                  <div class="col-md-6">
                  @if($confirmation_detail['status_penyetor'] == 'diterima')
                    <b>Status Pemesanan</b>
                    <a data-toggle="modal" data-target="#cekkonfirmasi{{ $order_detail['shops_detail_id']}}" class="label label-success"><br>
                    Menunggu konfirmasi admin (klik di sini)</a>
                  @elseif($confirmation_detail['status_penyetor'] == 'dikonfirm')
                    <b>Resi Pengiriman</b><br>
                    <label class="label label-info">Pemaketan sedang diproses</label>
                  @elseif($confirmation_detail['status_penyetor'] == 'dikirim')

                  @else
                    <a data-toggle="modal" data-target="#konfirmasi{{ $order_detail['shops_detail_id']}}" class="btn btn-primary">Konfirmasikan Pembayaran</a>
                  @endif
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="modal inmodal" id="cekkonfirmasi{{ $order_detail['shops_detail_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content animated flipInX">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h3>Bukti Pembayaran Anda</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <b>Nama Penyetor:</b><br>
              {{ $confirmation_detail['nama_penyetor']}}
            </div>
            <div class="form-group">
              <b>Bank:</b><br>
              {{ $confirmation_detail['bank_penyetor']}}
            </div>
            <div class="form-group">
              <b>Nomor Rekening:</b><br>
              {{ $confirmation_detail['norek_penyetor']}}
            </div>
            <div class="form-group">
              <b>Dibayar Kepada:</b><br>
              {{ $confirmation_detail['tujuan_penyetor']}}
            </div>
            <div class="form-group">
              <b>Jumlah Pembayaran:</b><br>
              {{ number_format($confirmation_detail['jumlah_penyetor'])}} IDR
            </div>
            <div class="form-group">
              <b>Status Pembayaran:</b><br>
              Menunggu dikonfirmasi Admin
            </div>
            <div class="form-group">
              <b>Bukti Pembayaran:</b><br>
              @if(isset($confirmation_detail['gambar_penyetor']))
                <i class="fa fa-paperclip"></i> <a href="{{ URL('uploads/confirmation/'.$order_detail['shops_id'].'/'.$confirmation_detail['gambar_penyetor'])}}" target="_blank">Lihat bukti pembayaran</a>
              @else
                Tidak ada
              @endif
            </div>
          </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </center>
          </div>
          </form>
      </div>
  </div>
</div>

<div class="modal inmodal" id="konfirmasi{{ $order_detail['shops_detail_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content animated flipInX">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h3>Bukti Pembayaran</h3>
          </div>
          <div class="modal-body">
          <form class="form-horizontal" role="form" method="post" action="{{ URL('order/confirm/add')}}" accept-charset="utf-8" enctype="multipart/form-data">
          {{ csrf_field()}}
          <input type="hidden" value="{{ base64_encode('confirmpayment'.$order_detail['shops_detail_id'].'userdetailorderid')}}" name="shops_detail_id">
          <input type="hidden" value="{{ base64_encode('confirmpayment'.$order_detail['shops_id'].'userdetailorderid')}}" name="shops_id">
            <div class="form-group">
              <label class="control-label">Nama Penyetor</label> <span class="text-danger">*</span>
              <input type="text" class="form-control" name="nama_penyetor" placeholder="Nama Sesuai Tabungan" required>
            </div>
            <div class="form-group">
              <label class="control-label">Bank</label> <span class="text-danger">*</span>
              <input type="text" class="form-control" name="bank_penyetor" placeholder="Bank" required>
            </div>
            <div class="form-group">
              <label class="control-label">Nomor Rekening</label> <span class="text-danger">*</span>
              <input type="text" class="form-control" name="norek_penyetor" placeholder="Nomor Rekening" required>
            </div>
            {{-- <div class="form-group" id="data_1">
              <label class="control-label">Waktu Pembayaran</label>
              <div class="input-group date">
                <span class="input-group-addon"><i class="fa fa-calendar"></i> </span><input type="text" class="form-control" name="tanggal_penyetor" value="{{ date('Y-m-d H:i')}}">
              </div>
            </div> --}}
            <div class="form-group">
              <label class="control-label">Dibayar Kepada</label> <span class="text-danger">*</span>
              <input type="text" class="form-control" name="tujuan_penyetor" placeholder="(contoh: BCA Heru Wibisono)" required>
            </div>
            <div class="form-group">
              <label class="control-label">Jumlah Dibayarkan</label> <span class="text-danger">*</span>
              <div class="input-group m-b">
              <input type="number" class="form-control" name="jumlah_penyetor" placeholder="Sesuai Pembayaran" required><span class="input-group-addon">IDR </span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Unggah Bukti (opsional)</label>
               <input type="file" class="form-control" name="gambar_penyetor">
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Konfirmasi</button>
          </div>
          </form>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-md-push-3">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
        <b>
        <center>Copyright &copy;{{ date("Y")}} <a href="https://shop.moesubs.com/" class="text-muted">Moeshops - Jagonya Ngehobi</a></center>
        </b>
        </div>
    </div>
  </div>
</div>

  <!-- Mainly scripts -->
  <script src="{{ URL('js/jquery-2.1.1.js')}}"></script>
  <script src="{{ URL('js/bootstrap.min.js')}}"></script>
  <script src="{{ URL('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
  <script src="{{ URL('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

  <!-- Custom and plugin javascript -->
  <script src="{{ URL('js/inspinia.js')}}"></script>
  <script src="{{ URL('js/plugins/pace/pace.min.js')}}"></script>

  <!-- Datapicker -->
  <script src="{{ URL('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

	<!-- Toastr -->
	<script src="{{ URL('js/plugins/toastr/toastr.min.js')}}"></script>

	<script>
		$(document).ready(function() {
			@if(Session::has('error_msg'))
				setTimeout(function() {
						toastr.options = {
							closeButton: true,
							progressBar: true,
							showMethod: 'slideDown',
							timeOut: 4000,
						};
						toastr.error('{!! Session::get("error_msg") !!}');

					}, 500);
			@elseif(Session::has('success_msg'))
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
					toastr.success('{!! Session::get("success_msg") !!}');

				}, 500);
			@endif
		});
	</script>
</body>

</html>
