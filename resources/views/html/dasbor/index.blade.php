@extends('themes.default')

@section('judul')

Dasbor

@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInDown">

  <div class="col-lg-12">
    <div class="row">
    <div class="col-lg-12">
    <div class="ibox float-e-margins">
    <div class="ibox-content">
      <div class="row">
        <div class="col-lg-12">
          <div class="col-lg-6">
            <i class="label label-danger">Sesi terakhir: {{ date("d M Y H:i", strtotime($user_info['last_login']))." WIB"}}</i>
            {{-- {{ base64_decode($activity['last']['users_sessions_detail'])}} --}}
          </div>
          <div class="col-lg-6">
            <h3><b class="pull-right">{{ date("d M 'y - H:i")}}</b></h3>
          </div>
        </div>
      </div>    
      </div>
    </div>
    </div>
    </div>
  </div>

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

   <div class="col-lg-12">
     <div class="row">
       <div class="col-lg-6">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h5>Riwayat</h5>
                  <span class="label label-danger">Aktivitas</span>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                          <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
              </div>
              <div class="ibox-content inspinia-timeline">
              @if(count($activity['activity']) > 0)
                @foreach($activity['activity'] as $list)
                  <?php $detail = json_decode($list['users_sessions_detail'], TRUE); ?>
                  @if($list['users_sessions_action'] == 'form')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 date">
                              <i class="fa fa-edit"></i>
                              {{ date("d M Y", strtotime($list['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $list['users_sessions_module']}}</strong> <span class="label label-info">form</span></p>
                              Membuka formulir untuk menambahkan {{ $list['users_sessions_module']}} baru.<br>
                          </div>
                      </div>
                  </div>
                  @elseif($list['users_sessions_action'] == 'edit')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 date">
                              <i class="fa fa-edit"></i>
                              {{ date("d M Y", strtotime($list['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $list['users_sessions_module']}}</strong> <span class="label label-warning">edit</span></p>
                              Membuka formulir untuk mengubah {{ $list['users_sessions_module']}} dengan judul <b><i>{{ $detail['laporan_isi']['laporan_name']}}</i></b> milik <b>{{ $detail['laporan_isi']['laporan_owner']}}</b>.<br>
                          </div>
                      </div>
                  </div>
                  @elseif($list['users_sessions_action'] == 'update')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 date">
                              <i class="fa fa-edit"></i>
                              {{ date("d M Y", strtotime($list['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $list['users_sessions_module']}}</strong> <span class="label label-success">perbarui</span></p>
                              Memperbarui {{ $list['users_sessions_module']}} dengan judul <b><i>{{ $detail['laporan_isi']['laporan_name']}}</i></b> milik <b>{{ $detail['laporan_isi']['laporan_owner']}}</b>.<br>
                          </div>
                      </div>
                  </div>
                  @elseif($list['users_sessions_action'] == 'add')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 date">
                              <i class="fa fa-edit"></i>
                              {{ date("d M Y", strtotime($list['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $list['users_sessions_module']}}</strong> <span class="label label-primary">tambah</span></p>
                              Menambahkan {{ $list['users_sessions_module']}} baru dengan judul <b><i>{{ $detail['setoran_name']}}</i></b> milik <b>{{ $detail['setoran_type']}}</b>.<br>
                          </div>
                      </div>
                  </div>
                  @elseif($list['users_sessions_action'] == 'lapor')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 date">
                              <i class="fa fa-edit"></i>
                              {{ date("d M Y", strtotime($list['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $list['users_sessions_module']}}</strong> <span class="label label-primary">tambah</span></p>
                              Menambahkan {{ $list['users_sessions_module']}} baru dengan judul <b><i>{{ $detail['laporan_name']}}</i></b>.<br>
                          </div>
                      </div>
                  </div>
                  @elseif($list['users_sessions_action'] == 'delete')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 date">
                              <i class="fa fa-edit"></i>
                              {{ date("d M Y", strtotime($list['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $list['users_sessions_module']}}</strong> <span class="label label-danger">hapus</span></p>
                              Menghapus setoran {{ $list['users_sessions_module']}} dengan judul <b><i>{{ $detail['setoran_name']}}</i></b> milik <b>{{ $detail['setoran_owner']}}</b>.<br>
                          </div>
                      </div>
                  </div>
                  @endif
                @endforeach
              @else
              <center><strong>Tidak ada data</strong></center>
              @endif
              </div>
          </div>
        </div>

       <div class="col-lg-6">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                  <h5>Riwayat</h5>
                  <span class="label label-danger">Kunjungan</span>
                  <div class="ibox-tools">
                      <a class="collapse-link">
                          <i class="fa fa-chevron-up"></i>
                      </a>
                  </div>
              </div>
              <div class="ibox-content inspinia-timeline">
                @if(count($activity['visit']) > 0)
                @foreach($activity['visit'] as $visit)
                  <?php $detail = json_decode($list['users_sessions_detail'], TRUE); ?>
                  @if($visit['users_sessions_action'] == 'visit')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 date">
                              <i class="fa fa-flag"></i>
                              {{ date("d M Y", strtotime($visit['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $visit['users_sessions_module']}}</strong></p>
                              Mengunjungi laman {{ $visit['users_sessions_module']}}.<br>
                          </div>
                      </div>
                  </div>
                  @endif
                @endforeach
                @endif
              </div>
          </div>
        </div>


     </div>
   </div>

</div>

@endsection