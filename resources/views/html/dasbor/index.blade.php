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
                                      <div class="col-lg-6">Minggu ini:</div>
			                                <div class="col-lg-6"><span class="badge badge-success">{{ $edit['week']}}</span></div>
                                      <div class="col-lg-6">Bulan ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-info">{{ $edit['month']}}</span></div>
                                      <div class="col-lg-6">Tahun ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-warning">{{ $edit['year']}}</span></div>
                                      <div class="col-lg-12"><hr></div>
                                      <div class="col-lg-6 text-center"><b>Keseluruhan</b></div>
                                      <div class="col-lg-6"><span class="badge badge-primary">{{ $edit['total']}}</span></div>
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
                                      <div class="col-lg-6">Minggu ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-success">{{ $qc['week']}}</span></div>
                                      <div class="col-lg-6">Bulan ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-info">{{ $qc['month']}}</span></div>
                                      <div class="col-lg-6">Tahun ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-warning">{{ $qc['year']}}</span></div>
                                      <div class="col-lg-12"><hr></div>
                                      <div class="col-lg-6 text-center"><b>Keseluruhan</b></div>
                                      <div class="col-lg-6"><span class="badge badge-primary">{{ $qc['total']}}</span></div>
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
                                      <div class="col-lg-6">Minggu ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-success">{{ $laporan['week']}}</span></div>
                                      <div class="col-lg-6">Bulan ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-info">{{ $laporan['month']}}</span></div>
                                      <div class="col-lg-6">Tahun ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-warning">{{ $laporan['year']}}</span></div>
                                      <div class="col-lg-12"><hr></div>
                                      <div class="col-lg-6 text-center"><b>Keseluruhan</b></div>
                                      <div class="col-lg-6"><span class="badge badge-primary">{{ $laporan['total']}}</span></div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <a data-toggle="modal" data-target="#belumada"><span class="label label-danger pull-right">Export</span></a>
                                <h5>Rilisan</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                      <div class="col-lg-6">Hari ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-danger">{{ $rilisan['today']}}</span></div>
                                      <div class="col-lg-6">Minggu ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-success">{{ $rilisan['week']}}</span></div>
                                      <div class="col-lg-6">Bulan ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-info">{{ $rilisan['month']}}</span></div>
                                      <div class="col-lg-6">Tahun ini:</div>
                                      <div class="col-lg-6"><span class="badge badge-warning">{{ $rilisan['year']}}</span></div>
                                      <div class="col-lg-12"><hr></div>
                                      <div class="col-lg-6 text-center"><b>Keseluruhan</b></div>
                                      <div class="col-lg-6"><span class="badge badge-primary">{{ $rilisan['total']}}</span></div>
                                    </div>
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