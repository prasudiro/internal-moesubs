@extends('themes.default')

@section('judul')

Rilisan

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-6">
	        <h5>Rilisan <small>(seluruh rilisan yang sudah selesai digarap dan dipublikasikan).</small></h5>
	      </div>
	      <div class="col-md-6 text-right">
	        <a href="{{ URL('rilisan/add')}}" class="btn-sm btn-danger"><i class="fa fa-plus"></i> Tambah Rilisan</a>
	      </div>
      </div>
      <div class="ibox-content">
	      
	     <table class="table table-striped table-bordered table-hover dataTables-rilisan" >
          <thead>
          <tr>
              <th width="60%">Judul Rilisan</th>
              <th width="10%">Musim</th>
              <th width="15%">Dirilis pada</th>
              <th width="7%">Status</th>
              <th width="15%">Pengaturan</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($rilisan as $rilis)
            <?php $date_order = strtotime($rilis['tanggal']) + strtotime($rilis['jam']); ?>
            <tr>
              <td style="vertical-align: middle !important;">
              <a href="http://moesubs.com/?hal=dlrilisan&id={{ $rilis['id_rilisan']}}" target="_blank" data-toggle="tooltip" title="Lihat postingan {{ $rilis['judul_rilisan']}}">
              {{ $rilis['judul_rilisan']}}
              </a>
              </td>
              <td style="vertical-align: middle !important;">{{ $rilis['musim']}}</td>
              <td style="vertical-align: middle !important;" data-order="{{ $date_order }}>{{ $rilis['tayang']}}">{{ date("d M y", strtotime($rilis['tanggal']))}} - {{ date("H:i", strtotime($rilis['jam']))}}</td>
              <td class="text-center" style="vertical-align: middle !important;">{!! $rilis['tayang'] == 1 ? '<small class="label label-primary">Rilis</small>' : '<small class="label label-danger">Konsep</small>' !!}</td>
              <td class="text-center" style="vertical-align: middle !important;">
                <a href="#" title="Detail"><i class="fa fa-gamepad text-info"></i></a>
                &nbsp;
                <a href="{{ URL('rilisan/edit/'.base64_encode($rilis['id_rilisan'].'rilisan'))}}" title="Edit"><i class="fa fa-edit text-warning" data-toggle="tooltip" title="Edit"></i></a>
                &nbsp;
                <a data-toggle="modal" data-target="#bolehadmin{{ $rilis['id_rilisan']}}"><i class="fa fa-trash text-danger" data-toggle="tooltip" title="Hapus"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
          </table>


      </div>
     </div>
   </div>
</div>

@endsection