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
      <div class="col-md-6 col-md-push-3">
          <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h2 style="margin-top:-5px;"><center><b>Gantungan Kunci Logo Moesubs</b></center></h2>
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
                              <img alt="image" class="img-responsive" src="{{ URL('img/store/'.$gachi['shops_id'].'/1.jpg')}}">
                          </div>
											    @for ($i=2; $i <= 5; $i++) 
                          <div class="item">
                              <img alt="image" class="img-responsive" src="{{ URL('img/store/'.$gachi['shops_id'].'/'.$i.'.jpg')}}">
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
                  <h2 style="margin-top:-5px;"><center><b>Formulir Pemesanan</b></center></h2>
              </div>
              <div class="ibox-content">
              <label class="label label-danger"><i>Semua harus diisi lengkap dan sebenar-benarnya</i></label>
                <div class="hr-line-dashed"></div>
              	<div class="form-group">
              		<input type="text" class="form-control" name="fullname" Placeholder="Nama Lengkap" value="" required>
              	</div>
                <div class="hr-line-dashed"></div>
              	<div class="form-group">
              		<textarea class="form-control" name="alamat" Placeholder="Alamat Lengkap" rows="5" required></textarea>
              	</div>
                <div class="hr-line-dashed"></div>
              	<div class="form-group">
              		<input type="text" class="form-control" name="hp" Placeholder="Nomor HP" value="" required>
              	</div>
                <div class="hr-line-dashed"></div>
              	<div class="form-group">
              		<input type="number" class="form-control" name="pesanan" Placeholder="Jumlah Pesanan" value="" required min="0">
              	</div>
              	<div class="hr-line-dashed"></div>
                    <div class="form-group">
                            <button class="btn btn-warning" type="reset">Ulang</button>
                            <button class="btn btn-danger" type="submit">Pesan</button>
              							<label class="label label-info pull-right"><i>(PO sampai {{ date("d F Y", strtotime($gachi['shops_closed']))}})</i></label>
                        </div>
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
