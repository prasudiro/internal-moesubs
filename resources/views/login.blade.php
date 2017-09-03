<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Internal | [Moesubs] Jagonya Ngesub</title>

    <link href="{{ URL('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ URL('css/animate.css')}}" rel="stylesheet">
    <link href="{{ URL('css/style.css')}}" rel="stylesheet">

    <link rel="shortcut icon" type="image/icon" href="https://puu.sh/wbdmk.png" width="64">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
<center>
@if(Session::has('error_msg'))
    <div class="alert alert-danger"><h5>{!! Session::get('error_msg') !!}</h5></div>
@elseif(Session::has('success_msg'))
    <div class="alert alert-success"><h5>{!! Session::get('success_msg') !!}</h5></div>
@endif
</center>
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold text-cen">
                    <a href="{{ URL('/')}}" title="[Moesubs] Jagonya Ngesub"><img src="{{ URL('img/logo/Moev2.png')}}" alt="[Moesubs] Jagonya Ngesub" width="300"></a>
                </h2>


            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <h3><b>Halo, Produser!</b></h3>
                    <p>Bisa tunjukkan SIM dan STNK-nya?</p>
                    <form class="m-t" role="form" method="post" action="{{ URL('login')}}" accept-charset="utf-8">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <input type="name" class="form-control" placeholder="SIM" name="name" required="">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="STNK" name="password" required="">
                        </div>
                        <button type="submit" class="btn btn-danger block full-width m-b">Masuk</button>

                        <a href="#">
                            <small>Lupa SIM dan STNK?</small>
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <p class="m-t">
                <small>[Moesubs] Jagonya Ngesub &copy; 2010-{{ date('Y')}}</small>
            </p>
        </div>
    </div>

</body>

</html>
