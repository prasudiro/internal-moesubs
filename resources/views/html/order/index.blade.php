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

    <link rel="shortcut icon" type="image/icon" href="https://puu.sh/wbdmk.png" width="64">

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content">
  <div class="row">
      <div class="col-md-4 col-md-push-4">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h3><center><b>Gantungan Kunci Logo Moesubs</b></center></h3>
              </div>
              <div class="ibox-content">
                  <div class="carousel slide" id="carousel1">
                      <div class="carousel-inner">
                          <div class="item active">
                              <img alt="image" class="img-responsive" src="{{ URL('img/store/'.$gachi['shops_id'].'/1.jpg')}}">
                          </div>
											    @for ($i=2; $i <= 5; $i++) 
                          <div class="item">
                              <img alt="image" class="img-responsive" src="{{ URL('img/store/'.$gachi['shops_id'].'/'.$i.'.jpg')}}">
                          </div>
											    @endfor

                      </div>
                      <a data-slide="prev" href="#carousel1" class="left carousel-control">
                          <span class="icon-prev"></span>
                      </a>
                      <a data-slide="next" href="#carousel1" class="right carousel-control">
                          <span class="icon-next"></span>
                      </a>
                  </div>
              </div>
          </div>
      </div>
	</div>
</div>	

  <!-- Mainly scripts -->
  <script src="js/jquery-2.1.1.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
  <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

  <!-- Custom and plugin javascript -->
  <script src="js/inspinia.js"></script>
  <script src="js/plugins/pace/pace.min.js"></script>

</body>

</html>
