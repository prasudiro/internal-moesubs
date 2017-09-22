@extends('themes.default')

@section('judul')

Kategori

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-6">
	        <h5>Kategori <small>(seluruh judul kartun yang masuk pengerjaan proyek).</small></h5>
	      </div>
	      <div class="col-md-6 text-right">
	        <a href="{{ URL('kategori/add')}}" class="btn-sm btn-danger"><i class="fa fa-plus"></i> Tambah Kategori</a>
	      </div>
      </div>
      <div class="ibox-content">
	      
	      <table class="table table-striped table-bordered table-hover dataTables-kategori" >
          <thead>
          <tr>
              <th width="70%">Judul Kategori</th>
              <th width="15%">Alias</th>
              <th width="5%">Penerbit</th>
              {{-- <th>Diterbitkan pada</th> --}}
              <th width="15%">Pengaturan</th>
          </tr>
          </thead>
          <tbody>
          @foreach($kategori as $kat)
          <?php 
            $avatar = isset($kat['metadata']->avatar) ? $kat['metadata']->avatar : $user_default['avatar'];
            $name   = isset($kat['metadata']->name) ? $kat['metadata']->name : $user_default['name'];
          ?>
          @if($kat['metadata']['status'] == 0)
            <tr>
                <td style="vertical-align: middle !important;">{{ $kat['judul'] }}</td>
                <td style="vertical-align: middle !important;">{{ $kat['tags'] }}</td>
                <td style="vertical-align: middle !important;" class="text-center">
                <img src="{{ URL($avatar) }}" class="img-circle" width="32" data-toggle="tooltip" title="Penerbit {{ $name}}">
                </td>
                {{-- <td style="vertical-align: middle !important;">{{ $kat['tanggal'] }}</td> --}}
                <td class="text-center" style="vertical-align: middle !important;">
                  <a href="#" title="Detail"><i class="fa fa-gamepad text-info"></i></a>
                  &nbsp;
                  @if($user_info['level'] == 3)
                    <a href="#" title="Edit"><i class="fa fa-edit text-warning" data-toggle="tooltip" title="Edit"></i></a>
                  @elseif($user_info['level'] != 3 && isset($kat['metadata']->user_id) && $kat['metadata']->user_id == $user_info['id'])
                    <a href="#" title="Edit"><i class="fa fa-edit text-warning" data-toggle="tooltip" title="Edit"></i></a>
                  @else
                    <a href="#" title="Edit"><i class="fa fa-edit text-muted" data-toggle="tooltip" title="Ini bukan data milik Anda!"></i></a>
                  @endif
                  &nbsp;
                  @if($user_info['level'] == 3)
                    <a data-toggle="modal" data-target="#bolehadmin{{ $kat['id']}}"><i class="fa fa-trash text-danger" data-toggle="tooltip" title="Hapus"></i></a>
                  @elseif($user_info['level'] != 3 && isset($kat['metadata']->user_id) && $kat['metadata']->user_id == $user_info['id'])
                    <a data-toggle="modal" data-target="#bolehproduser{{ $kat['id']}}"><i class="fa fa-trash text-danger" data-toggle="tooltip" title="Hapus"></i></a>
                  @else
                    <a data-toggle="modal" data-target="#tidakboleh"><i class="fa fa-trash text-muted" data-toggle="tooltip" title="Ini bukan data milik Anda!"></i></a>
                  @endif  
                </td>
            </tr>
          @endif
          @endforeach
          </tbody>
          <tfoot>
          <tr>
              <th width="70%">Judul Kategori</th>
              <th width="15%">Alias</th>
              <th width="5%">Penerbit</th>
              {{-- <th>Diterbitkan pada</th> --}}
              <th width="15%">Pengaturan</th>
          </tr>
          </tfoot>
        </table>

      </div>
     </div>
   </div>
</div>

@endsection