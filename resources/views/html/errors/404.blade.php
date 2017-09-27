<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>404 - Halaman Tidak Ditemukan | [Moesubs] Jagonya Ngesub</title>

    <link href="{{ URL('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ URL('css/animate.css')}}" rel="stylesheet">
    <link href="{{ URL('css/style.css')}}" rel="stylesheet">

		<!-- Toastr style -->
		<link href="{{ URL('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

</head>

<body class="black-bg">

<div class="wrapper wrapper-content">
  <div class="row">
      <div class="col-md-8 col-md-push-2">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h2 style="margin-top:-5px;"><center><b>[404] Halaman mungkin hilang bersama kenangan masa lalu</b></center></h2>
              </div>
              <div class="ibox-content">
              <img src="https://pbs.twimg.com/media/CmaIHtLXEAAoPvZ.jpg" width="100%">
              </div>                  
          </div>
	    </div>
  </div><div class="row">
      <div class="col-md-8 col-md-push-2">
          <div class="ibox float-e-margins">
              <div class="ibox-content text-center">
                <b>
                  <a href="{{ URL('/')}}"><i class="fa fa-repeat"></i> Kembali ke halaman utama</a>
                </b>
              </div>                  
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
