@extends('themes.default')

@section('judul')

Tambah Laporan QC

@endsection

@section('content')

<div class="row animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
	            <div class="col-md-6">
		        		<h5>Tambah Laporan Edit <small>(hanya untuk melapor hasil skrip yang sudah dicek).</small></h5>
				      </div>
				      <div class="col-md-6 text-right">
				        <a href="{{ URL('laporan')}}" class="btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
				      </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" role="form" method="post" action="{{ URL('laporan/add')}}" accept-charset="utf-8" enctype="multipart/form-data">
                {{ csrf_field()}}
                <input type="hidden" name="user_id" value="{{ $user_info['id']}}">
                    <div class="form-group"><label class="col-sm-2 control-label">Judul Kartun</label>
	                    <div class="col-sm-8">
	                    <select class="chosen-select" style="width:100%;" tabindex="2" name="laporan_category" required>
	                    		<option style="display:none" value="">Pilih Judul Kartun</option>
	                    	@foreach($kategori as $kat)
	                    		<option value="{{ $kat['id']}}">{{ $kat['judul']}}</option>
	                    	@endforeach
	                    </select>
	                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Tipe Media</label>
                      <div class="col-sm-8">
	                    <select class="chosen-select" style="width:100%;" tabindex="2" name="laporan_media" required>
                    		<option style="display:none" value="">Pilih Tipe Media Tayang</option>
                    		<option value="0">TV/WEB</option>
                    		<option value="1">Film Layar Lebar</option>
                    		<option value="2">OVA/OAD</option>
                    		<option value="3">SP (Spesial)</option>
	                    </select>
	                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Episode</label>

                        <div class="col-sm-8"><input type="number" placeholder="Nomor Episode" class="form-control" name="laporan_episode" required min="0" max="99"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Isi Laporan</label>
                        <div class="col-sm-8">
                        <div  style="border: 1px dashed #AAAAAA;">
                            <textarea class="summernote" name="laporan_isi"></textarea>
                        </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-warning" type="reset">Ulang</button>
                            <button class="btn btn-danger" type="submit">Lapor</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
