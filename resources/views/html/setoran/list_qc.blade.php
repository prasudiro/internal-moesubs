@extends('themes.default')

@section('judul')

Setoran QC

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-6">
	        <h5>Daftar Setoran QC <small>(hanya untuk skrip yang akan dicek).</small></h5>
	      </div>
	      <div class="col-md-6 text-right">
	        <a href="{{ URL('setoran/qc/add')}}" class="btn-sm btn-danger"><i class="fa fa-plus"></i> Tambah Setoran</a>
	      </div>
      </div>
      <div class="ibox-content">
	      
	      <table class="table table-striped table-bordered table-hover dataTables-setoran" >
          <thead>
          <tr>
              <th width="65%">Nama Setoran</th>
              <th width="10%">Penyetor</th>
              <th width="15%">Disetor pada</th>
              <th width="15%">Pengaturan</th>
          </tr>
          </thead>
          <tbody>
          @foreach($setoran as $setor)
          <?php
	          $episode_detail = "Episode";
	          if ($setor["setoran_media"] == 1) 
	          {
	          	$episode_detail = "Film Layar Lebar";
	          }
	          elseif ($setor["setoran_media"] == 2) 
	          {
	          	$episode_detail = "OVA";
	          }
	          elseif ($setor["setoran_media"] == 3) 
	          {
	          	$episode_detail = "SP";
	          }
          ?>
          <tr>
              <td style="vertical-align: middle !important;">
              <a href="{{ URL('setoran/download/'.base64_encode($setor['setoran_name']))}}" title="Unduh skrip {{ $setor['judul']}} - {{ $episode_detail}} {{ $setor["setoran_media"] != 1 ? $setor["setoran_episode"] < 10 ? "0".$setor["setoran_episode"] : $setor["setoran_episode"] :  ""}}">
              <b><i class="fa fa-paperclip text-danger"></i> </b>
              {{ $setor['judul']}} - {{ $episode_detail}} {{ $setor["setoran_media"] != 1 ? $setor["setoran_episode"] < 10 ? "0".$setor["setoran_episode"] : $setor["setoran_episode"] :  ""}}</td>
              <td align="center" style="vertical-align: middle !important;">
              <img src="{{ URL($setor['avatar']) }}" class="img-circle" width="32" data-toggle="tooltip" title="Setoran dari {{ $setor['name']}}">
              </td>
              <td data-order="{{ strtotime($setor['tanggal'])}}" style="vertical-align: middle !important;">{{ date("d M Y - H:i", strtotime($setor["tanggal"]))}}</td>
              <td align="center" style="vertical-align: middle !important;">
              	<a href="#" title="Detail"><i class="fa fa-gamepad text-info"></i></a>
              	&nbsp;
              	<a href="#" title="Edit"><i class="fa fa-edit text-warning"></i></a>
              	&nbsp;
              	<a href="#" title="Hapus"><i class="fa fa-trash text-danger"></i></a>
              </td>
          </tr>
          @endforeach
          </tbody>
          <tfoot>
          <tr>
              <th>Nama Setoran</th>
              <th>Penyetor</th>
              <th>Disetor pada</th>
              <th>Pengaturan</th>
          </tr>
          </tfoot>
        </table>

      </div>
     </div>
   </div>
</div>

@endsection