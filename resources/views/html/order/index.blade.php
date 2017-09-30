<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pre-Order Gantungan Kunci Logo Moesubs | [Moeshops] Jagonya Ngehobi</title>

    <link href="{{ URL('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ URL('css/animate.css')}}" rel="stylesheet">
    <link href="{{ URL('css/style.css')}}" rel="stylesheet">

		<!-- Toastr style -->
		<link href="{{ URL('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- External -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">

    <!-- Chosen -->
    <link href="{{ URL('css/plugins/chosen/chosen.css')}}" rel="stylesheet">

    <style type="text/css">
      .note-editor{
             border: none !important;
            }
    </style>

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content">
  <div class="row">
      <div class="col-md-6 col-md-push-3">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h3 style="margin-top:0px;"><center><b>Gantungan Kunci Logo Moesubs</b></center></h3>
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
                              <img alt="image" class="img-responsive" src="{{ URL('uploads/shops/'.$gachi['shops_id'])}}/{{ $meta_detail['gambar1']}}" width="100%">
                          </div>
											    @for ($i=2; $i <= 3; $i++) 
                          <div class="item">
                              <img alt="image" class="img-responsive" src="{{ URL('uploads/shops/'.$gachi['shops_id'])}}/{{ $meta_detail['gambar'.$i]}}" width="100%">
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
                <div class="hr-line-dashed"></div>
                {!! $gachi['shops_detail']!!}
                <div class="text-right">
                  <label class="label label-danger"><i>(PO hanya sampai {{ date("d F Y", strtotime($gachi['shops_closed']))}})</i></label>
                </div>
                <div class="hr-line-dashed"></div>
              <h2><center><b>{{ number_format($gachi['shops_price']) }} IDR</b></center></h2>
              </div>
              </div>
          </div>
      </div>
	</div>

	<div class="row">
      <div class="col-md-6 col-md-push-3">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h2 style="margin-top:-5px;"><center><b>Formulir Pemesanan</b></center></h2>
              </div>
              <div class="ibox-content">
              <div class="row">
              <div class="col-md-10 col-md-push-1">
              <form class="form-horizontal" role="form" method="post" action="{{ URL('order/add')}}" accept-charset="utf-8" enctype="multipart/form-data">
                {{ csrf_field()}}
              <input type="hidden" value="{{ $gachi['shops_id']}}" name="shops_id">
              <input type="hidden" value="{{ base64_encode($gachi['shops_price'])}}" name="shops_price">
              <label class="label label-danger"><i>Semua harus diisi lengkap dan sebenar-benarnya</i></label>
                <div class="hr-line-dashed"></div>
              	<div class="form-group">
              		<input type="text" class="form-control" name="fullname" Placeholder="Nama Lengkap" value="" required>
              	</div>
                <div class="hr-line-dashed"></div>
              	<div class="form-group">
              		<textarea class="form-control" name="alamat" Placeholder="Alamat Lengkap" rows="3" required></textarea>
              	</div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" name="kecamatan" Placeholder="Kecamatan" value="" required>
                    </div>
                  </div>
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      <select required class="chosen-select" style="width:100%" tabindex="2"  name="kabkota" required>
                        <option value="" style="display: none;">Kabupaten/Kotamadya</option>
                        @foreach($city as $kota)
                          <option value="{{ $kota['city_id']}}">{{ $kota['city_name']}} {{ $kota['type'] == 'Kota' ? '(Kota)' : ''}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" name="provinsi" Placeholder="Provinsi" value="" required>
                    </div>
                  </div>
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      <input type="number" class="form-control" name="kodepos" Placeholder="Kode Pos" value="" required>
                    </div>
                  </div>
                </div>
                <div class="hr-line-dashed"></div>
              	<div class="form-group">
              		<input type="text" class="form-control" name="hp" Placeholder="Nomor HP" value="" required>
              	</div>
                <div class="hr-line-dashed"></div>
              	<div class="form-group">
              		<input type="email" class="form-control" name="email" Placeholder="Email" value="" required>
              	</div>
                <div class="hr-line-dashed"></div>
              	<div class="form-group">
              		<input type="number" class="form-control" name="pesanan" Placeholder="Jumlah Pesanan" value="" required min="0">
              	</div>
              	<div class="hr-line-dashed"></div>
                    <div class="form-group">
                      <button class="btn btn-warning" type="reset">Ulang</button>
                      <button class="btn btn-danger" type="submit">Pesan</button>
                      <span class="pull-right text-right"><a data-toggle="modal" data-target="#contactus" title="Kontak Personal">Tidak dapat memesan atau ada pertanyaan? <br>Hubungi kami.</a></span>
                    </div>
                </form>
              </div>
              </div>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="modal inmodal" id="contactus" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content animated flipInX">
        <form class="form-horizontal" role="form" method="post" action="{{ URL('contact/send')}}" accept-charset="utf-8" enctype="multipart/form-data">
        {{ csrf_field()}}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h3>Hubungi Kami</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Nama Lengkap" name="contact_name" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Email" name="contact_email" required>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Subjek" name="contact_subject" required>
            </div>
            <div class="form-group" style="border:0px;">
              <textarea class="form-control" name="contact_body" placeholder="Isi pertanyaan Anda" rows="5" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
              <button class="btn btn-danger" type="submit">Kirim</button>
            </center>
          </div>
        </form>
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

  <!-- Toastr -->
  <script src="{{ URL('js/plugins/toastr/toastr.min.js')}}"></script>

  <!-- Summernote -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

  <!-- Chosen -->
  <script src="{{ URL('js/plugins/chosen/chosen.jquery.js')}}"></script>

  <script>
    $(document).ready(function() {
        $('#summernote').summernote({
          toolbar: [
            // [groupName, [list of button]]
            // ['style', ['bold', 'italic', 'underline', 'clear']],
            // ['font', ['strikethrough', 'superscript', 'subscript']],
            // ['fontsize', ['fontsize']],
            // ['color', ['color']],
            // ['para', ['ul', 'ol', 'paragraph']],
            // ['height', ['height']]
          ]
        });
    });
  </script>

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

    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"95%"}
      }
      for (var selector in config) {
        $(selector).chosen(config[selector]);
      }
	</script>
</body>

</html>
