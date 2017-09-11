@extends('themes.default')

@section('judul')

Setoran Edit

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-6">
	        <h5>Daftar Setoran Edit <small>(hanya untuk skrip yang akan diedit).</small></h5>
	      </div>
	      <div class="col-md-6 text-right">
	        <a href="{{ URL('setoran/edit/add')}}" class="btn-sm btn-danger"><i class="fa fa-plus"></i> Tambah Setoran</a>
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
                @if($user_info['level'] == 3)
                  <a href="#" title="Edit"><i class="fa fa-edit text-warning" data-toggle="tooltip" title="Edit"></i></a>
                @elseif($user_info['level'] != 3 && $setor["user_id"] == $user_info['id'])
                  <a href="#" title="Edit"><i class="fa fa-edit text-warning" data-toggle="tooltip" title="Edit"></i></a>
                @else
                  <a href="#" title="Edit"><i class="fa fa-edit text-muted" data-toggle="tooltip" title="Ini bukan data milik Anda!"></i></a>
                @endif
              	&nbsp;
                @if($user_info['level'] == 3)
                  <a data-toggle="modal" data-target="#bolehadmin{{ $setor['setoran_id']}}"><i class="fa fa-trash text-danger" data-toggle="tooltip" title="Hapus"></i></a>
                @elseif($user_info['level'] != 3 && $setor["user_id"] == $user_info['id'])
                  <a data-toggle="modal" data-target="#bolehproduser{{ $setor['setoran_id']}}"><i class="fa fa-trash text-danger" data-toggle="tooltip" title="Hapus"></i></a>
                @else
                  <a data-toggle="modal" data-target="#tidakboleh"><i class="fa fa-trash text-muted" data-toggle="tooltip" title="Ini bukan data milik Anda!"></i></a>
                @endif
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

<div class="modal inmodal" id="tidakboleh" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    <div class="modal-content animated bounceIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h1 class="text-danger"><b>PERINGATAN!!!</b></h1>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-danger"><i class="fa fa-warning" style="font-size:40px;"></i> <br><br>Ini bukan data milik Anda!!!</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@foreach($setoran as $setor2)
@if($user_info['level'])
<div class="modal inmodal" id="bolehadmin{{ $setor2['setoran_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
@else
<div class="modal inmodal" id="bolehproduser{{ $setor2['setoran_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
@endif
    <div class="modal-dialog modal-sm">
    <div class="modal-content animated bounceIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h1 class="text-danger"><b>PERINGATAN!!!</b></h1>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-info"><i class="fa fa-question" style="font-size:40px;"></i> <br><br>Anda yakin ingin menghapusnya?</h3>
                  <center>
                    {{ $setor2['judul']}} - {{ $episode_detail}} {{ $setor2["setoran_media"] != 1 ? $setor2["setoran_episode"] < 10 ? "0".$setor2["setoran_episode"] : $setor2["setoran_episode"] :  ""}}
                  </center>
            </div>
            <div class="modal-footer">
              <div align="center">
                <a href="#" class="btn btn-primary" data-dismiss="modal">Tidak</a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#hapus{{ $setor2['setoran_id']}}">Yakin</a>
              </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($setoran as $setor3)
<div class="modal inmodal" id="hapus{{ $setor3['setoran_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content animated bounceIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h1 class="text-danger"><b>Apa Anda benar-benar yakin?</b></h1>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" role="form" method="post" action="{{ URL('setoran/delete')}}" accept-charset="utf-8" enctype="multipart/form-data">
              {{ csrf_field()}}
              <input name="setoran_id" value="{{ $setor3['setoran_id']}}" type="hidden">
              <input name="setoran_type" value="edit" type="hidden">
              <div align="center">
                <input class="form-control" name="hapus_setoran" value="" type="text" placeholder="Ketik HAPUS pada kolom ini dan tekan ENTER"></div>
            </form>
            </div>
            <div class="modal-footer">
              <div align="center">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
              </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection