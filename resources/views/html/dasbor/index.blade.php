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
          <div class="col-lg-9">
            <h2><b>Informasi</b></h2>
                    <div class="hr-line-dashed"></div>
            <ul class="list-group-item" style="border: none; line-height: 25px;">
              <li>Notifikasi email dapat diaktifkan/matikan melalui menu <a href="{{ URL('pengaturan')}}">Pengaturan</a> <small><i class="fa fa-arrow-right"></i></small> <a href="{{ URL('pengaturan/notifikasi')}}">Notifikasi</a></li>
              <li>Harap membuat <a href="{{ URL('kategori/add')}}">Kategori</a> baru bila judul kartun yang dipilih belum tersedia.</li>
            </ul>
          </div>
          <div class="col-lg-3">
            <i class="label label-danger pull-right">Sesi terakhir: {{ date("d M Y H:i", strtotime($user_info['last_login']))." WIB"}}</i>
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
                  <a data-toggle="modal" data-target="#belumada"><span class="label label-danger pull-right">Ekspor</span></a>
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
                  <a data-toggle="modal" data-target="#belumada"><span class="label label-danger pull-right">Ekspor</span></a>
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
                  <a data-toggle="modal" data-target="#belumada"><span class="label label-danger pull-right">Ekspor</span></a>
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
                  <a data-toggle="modal" data-target="#belumada"><span class="label label-danger pull-right">Ekspor</span></a>
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
                <h5>Riwayat Aktivitas</h5>
                <div class="ibox-tools">
                    <span class="label label-danger">Pribadi</span>
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
                              <i class="fa fa-newspaper-o"></i>
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
                              Membuka formulir untuk mengubah {{ $list['users_sessions_module']}} dengan judul <b><i>{{ $detail['name']}}</i></b> milik <b>{{ $detail['owner']}}</b>.<br>
                          </div>
                      </div>
                  </div>
                  @elseif($list['users_sessions_action'] == 'update')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 check-square">
                              <i class="fa fa-edit"></i>
                              {{ date("d M Y", strtotime($list['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $list['users_sessions_module']}}</strong> <span class="label label-success">perbarui</span></p>
                              Memperbarui {{ $list['users_sessions_module']}} dengan judul <b><i>{{ $detail['name']}}</i></b> milik <b>{{ $detail['owner']}}</b>.<br>
                          </div>
                      </div>
                  </div>
                  @elseif($list['users_sessions_action'] == 'add')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 date">
                              <i class="fa fa-book"></i>
                              {{ date("d M Y", strtotime($list['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $list['users_sessions_module']}}</strong> <span class="label label-primary">tambah</span></p>
                              Menambahkan {{ $list['users_sessions_module']}} baru dengan judul <b><i>{{ isset($detail['name']) ? $detail['name'] : $detail['name']}}</i></b>.<br>
                          </div>
                      </div>
                  </div>
                  @elseif($list['users_sessions_action'] == 'lapor')
                  <div class="timeline-item">
                      <div class="row">
                          <div class="col-xs-3 briefcase">
                              <i class="fa fa-edit"></i>
                              {{ date("d M Y", strtotime($list['users_sessions_time']))}}<br/>
                              <small class="text-navy">{{ date("H:i", strtotime($list['users_sessions_time']))}} WIB</small>
                          </div>
                          <div class="col-xs-9 content no-top-border">
                              <p class="m-b-xs"><strong>{{ $list['users_sessions_module']}}</strong> <span class="label label-primary">tambah</span></p>
                              Menambahkan {{ $list['users_sessions_module']}} baru dengan judul <b><i>{{ $detail['name']}}</i></b>.<br>
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
                              Menghapus setoran {{ $list['users_sessions_module']}} dengan judul <b><i>{{ $detail['name']}}</i></b> milik <b>{{ $detail['owner']}}</b>.<br>
                          </div>
                      </div>
                  </div>
                  @endif
                @endforeach
              @else
              <center><strong>Tidak ada data</strong></center>
              @endif
              <hr>
                <a data-toggle="modal" data-target="#belumada" class="btn btn-danger btn-block m-t"><i class="fa fa-arrow-down"></i> Tampilkan Semua</a>
              </div>
          </div>
        </div>

       <div class="col-lg-6">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Riwayat Aktivitas</h5>
                <div class="ibox-tools">
                    <span class="label label-danger">Umum</span>
                </div>
            </div>
            <div class="ibox-content">
              <div>
                <div class="feed-activity-list">
              @if(count($activity['activity']) > 0)
                @foreach($activity['public'] as $public)
                <?php
                  $detail = json_decode($public['users_sessions_detail'], TRUE);
                  $action = "entah melakukan apa";
                  $label  = "<span class='label label-default'><i class='fa fa-question'></i>";
                  if ($public['users_sessions_action'] == 'add') 
                  {
                    $action = "menambahkan data";
                    $label  = "<span class='label label-info'><i class='fa fa-plus'></i>";
                  }
                  elseif ($public['users_sessions_action'] == 'update')
                  {
                    $action = "memperbarui data";
                    $label  = "<span class='label label-warning'><i class='fa fa-check'></i>";
                  }
                  elseif ($public['users_sessions_action'] == 'delete')
                  {
                    $action = "menghapus data";
                    $label  = "<span class='label label-danger'><i class='fa fa-trash'></i>";
                  }
                  elseif ($public['users_sessions_action'] == 'lapor')
                  {
                    $action = "melaporkan pengecekan";
                    $label  = "<span class='label label-info'><i class='fa fa-briefcase'></i>";
                  }
                ?>
                  <div class="feed-element">
                      <a data-toggle="modal" data-target="#belumada" class="pull-left">
                          <img data-toggle="tooltip" title="Aktitivas dari {{ $public['name']}}" alt="image" class="img-circle" src="{{ URL($public['avatar'])}}">
                      </a>
                      <div class="media-body ">
                          <small class="pull-right">{!! $label !!} {{ $public['users_sessions_action']}}</span></small>
                          <strong>{{ $public['name']}}</strong> {{ $action}} di <strong>{{ $public['users_sessions_module']}}</strong>.<br>
                          <i class="fa fa-clock-o"></i> <small class="text-muted">{{ date("d M Y H:i", strtotime($public['users_sessions_time']))}}</small>
                          <div class="well">
                            @if($public['users_sessions_action'] == 'add')
                            Menambahkan {{ $public['users_sessions_module']}} baru dengan judul <b><i>{{ $detail['name']}}</i></b>.
                            @elseif($public['users_sessions_action'] == 'update')
                            Memperbarui {{ $public['users_sessions_module']}} dengan judul <b><i>{{ $detail['name']}}</i></b> milik <b>{{ $detail['owner']}}</b>.
                            @elseif($public['users_sessions_action'] == 'delete')
                            Menghapus {{ $public['users_sessions_module']}} dengan judul <b><i>{{ $detail['name']}}</i></b> milik <b>{{ $detail['owner']}}</b>.
                            @elseif($public['users_sessions_action'] == 'lapor')
                            Melaporkan {{ $public['users_sessions_module']}} dengan judul <b><i>{{ $detail['name']}}</i></b>.
                            @endif
                          </div>
                      </div>
                  </div>
                @endforeach
              @else
              <center><strong>Tidak ada data</strong></center>
              @endif
                </div>
                <a data-toggle="modal" data-target="#belumada" class="btn btn-danger btn-block m-t"><i class="fa fa-arrow-down"></i> Tampilkan Semua</a>
                </div>
            </div>
        </div>  
        </div>


     </div>
   </div>

</div>

@endsection