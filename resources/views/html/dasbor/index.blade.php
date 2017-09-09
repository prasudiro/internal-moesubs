@extends('themes.default')

@section('judul')

Dasbor

@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInDown">
  <div class="col-lg-12">
    <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <a data-toggle="modal" data-target="#belumada"><span class="label label-danger pull-right">Export</span></a>
                                <h5>Setoran Edit</h5>
                            </div>
                            <div class="ibox-content">
                            	<div class="row">
			                          <div class="col-lg-6">Hari ini:</div>
			                          <div class="col-lg-6"><span class="badge badge-danger">{{ $edit['today']}}</span></div>
			                          <div class="col-lg-6">Bulan ini:</div>
			                          <div class="col-lg-6"><span class="badge badge-danger">{{ $edit['month']}}</span></div>
			                          <!--data-->
			                          <div class="col-lg-6">Minggu ini:</div>
			                          <div class="col-lg-6"><span class="badge badge-danger">{{ $edit['week']}}</span></div>
			                          <div class="col-lg-12"><hr></div>
			                          <div class="col-lg-6 text-center"><b>Keseluruhan</b></div>
			                          <div class="col-lg-6"><span class="badge badge-primary">{{ $edit['year']}}</span></div>
			                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <a data-toggle="modal" data-target="#belumada"><span class="label label-danger pull-right">Export</span></a>
                                <h5>Setoran QC</h5>
                            </div>
                            <div class="ibox-content">
                            	<div class="row">
			                          <div class="col-lg-6">Hari ini:</div>
			                          <div class="col-lg-6"><span class="badge badge-danger">{{ $qc['today']}}</span></div>
			                          <div class="col-lg-6">Bulan ini:</div>
			                          <div class="col-lg-6"><span class="badge badge-danger">{{ $qc['month']}}</span></div>
			                          <!--data-->
			                          <div class="col-lg-6">Minggu ini:</div>
			                          <div class="col-lg-6"><span class="badge badge-danger">{{ $qc['week']}}</span></div>
			                          <div class="col-lg-12"><hr></div>
			                          <div class="col-lg-6 text-center"><b>Keseluruhan</b></div>
			                          <div class="col-lg-6"><span class="badge badge-primary">{{ $qc['year']}}</span></div>
			                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <a data-toggle="modal" data-target="#belumada"><span class="label label-danger pull-right">Export</span></a>
                                <h5>Laporan</h5>
                            </div>
                            <div class="ibox-content">
                            	<div class="row">
			                          <div class="col-lg-6">Hari ini:</div>
			                          <div class="col-lg-6"><span class="badge badge-danger">{{ $laporan['today']}}</span></div>
			                          <div class="col-lg-6">Bulan ini:</div>
			                          <div class="col-lg-6"><span class="badge badge-danger">{{ $laporan['month']}}</span></div>
			                          <!--data-->
			                          <div class="col-lg-6">Minggu ini:</div>
			                          <div class="col-lg-6"><span class="badge badge-danger">{{ $laporan['week']}}</span></div>
			                          <div class="col-lg-12"><hr></div>
			                          <div class="col-lg-6 text-center"><b>Keseluruhan</b></div>
			                          <div class="col-lg-6"><span class="badge badge-primary">{{ $laporan['year']}}</span></div>
			                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                {{-- <a data-toggle="modal" data-target="#belumada"><span class="label label-danger pull-right">Export</span></a>
                                <h5>Laporan</h5> --}}
                            </div>
                            <div class="ibox-content">
                                {{-- <p>Hari ini: {{ $qc['today']}}</p>
                                <p>Minggu ini: {{ $qc['week']}}</p>
                                <p>Bulan ini: {{ $qc['month']}}</p>
                                <p>Keseluruhan: {{ $qc['year']}}</p> --}}
                            </div>
                        </div>
                    </div>
                   
        </div>
   </div>
</div>

<div class="modal inmodal" id="belumada" tabindex="-1" role="dialog" aria-hidden="true">
		    <div class="modal-dialog modal-sm">
		    <div class="modal-content animated bounceIn">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		                <h1><b>Export Data</b></h1>
		            </div>
		            <div class="modal-body">
		             		<h3 class="text-center text-danger"><i class="fa fa-warning" style="font-size:40px;"></i> <br><br>Saat ini fitur belum tersedia</h3>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
		            </div>
		        </div>
		    </div>
		</div>

@endsection