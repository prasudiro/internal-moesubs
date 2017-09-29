<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>(Closed) Pre-Order Gantungan Kunci Logo Moesubs | [Moeshops] Jagonya Ngehobi</title>

    <link href="{{ URL('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ URL('css/animate.css')}}" rel="stylesheet">
    <link href="{{ URL('css/style.css')}}" rel="stylesheet">

		<!-- Toastr style -->
		<link href="{{ URL('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- External -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">

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
      <div class="col-md-12">
          <h1><center>Pemesanan Sudah Ditutup!</center></h1>
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
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

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
