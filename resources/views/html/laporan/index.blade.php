@extends('themes.default')

@section('judul')

Laporan

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-6">
	        <h5>Daftar Laporan QC <small>(hanya untuk melapor hasil skrip yang sudah dicek).</small></h5>
	      </div>
	      <div class="col-md-6 text-right">
	        <a href="{{ URL('laporan/add')}}" class="btn-sm btn-danger"><i class="fa fa-plus"></i> Laporan Baru</a>
	      </div>
      </div>
      <div class="ibox-content">
	      
	      <table class="table table-striped table-bordered table-hover dataTables-laporan" >
          <thead>
          <tr>
              <th width="50%">Nama Laporan</th>
              <th width="20%">Pelapor</th>
              <th width="20%">Terakhir dilapor pada</th>
          </tr>
          </thead>
          <tbody>
          @foreach($laporan as $lapor)
          <tr>
          	<td style="vertical-align: middle !important;">{{ $lapor['laporan_name']}}</th>
            <td style="vertical-align: middle !important;">
            	@foreach($laporan_isi as $isi)
            		@if($isi['laporan_id'] != $lapor['laporan_id'])
            		@else
            			<a data-toggle="modal" data-target="#myModal{{ $isi['laporan_isi_id']}}"><img src="{{ URL($isi['avatar']) }}" class="img-circle" width="32" data-toggle="tooltip" title="Laporan dari {{ $isi['name']}}"></a>&nbsp;
            		@endif
            	@endforeach
            </th>
            <td style="vertical-align: middle !important;" data-order="{{ strtotime($lapor['updated_at'])}}">{{ date("d M Y - H:i", strtotime($lapor["updated_at"]))}}</th>
          </tr>
          @endforeach
          </tbody>
          <tfoot>
          <tr>
              <th>Nama Setoran</th>
              <th>Penyetor</th>
              <th>Terakhir dilapor pada</th>
          </tr>
          </tfoot>
        </table>

      </div>
     </div>
   </div>
</div>
@foreach($laporan as $lapor)
@foreach($laporan_isi as $isi)      
		<div class="modal inmodal" id="myModal{{ $isi['laporan_isi_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
		    <div class="modal-dialog modal-lg">
		    <div class="modal-content animated bounceInRight">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		                <img src="{{ URL($isi['avatar']) }}" class="img-circle" width="96" alt="Laporan dari {{ $isi['name']}}">
		                <h3>Laporan QC dari <b>{{ $isi['name']}}</b></h3>
		                	{{ $isi['laporan_name']}} <a href="{{ URL('laporan/edit/'.base64_encode('laporan'.$isi['laporan_isi_id'].'qc'))}}" data-toggle="tooltip" title="Edit laporan {{ $isi['name']}}"><i class="fa fa-edit text-danger"></i></a>
		            </div>
		            <div class="modal-body">
		                {!! base64_decode($isi['laporan_isi_detail']) !!}
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
		            </div>
		        </div>
		    </div>
		</div>
@endforeach
@endforeach

@endsection