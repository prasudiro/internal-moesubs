@extends('themes.default')

@section('title')

Tambah Setoran Edit

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
	            <div class="col-md-6">
		        		<h5>Tambah Setoran Edit <small>(hanya untuk skrip yang selesai diterjemahkan).</small></h5>
				      </div>
				      <div class="col-md-6 text-right">
				        <a href="{{ URL('setoran/edit')}}" class="btn-sm btn-info">Kembali</a>
				      </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" role="form" method="post" action="{{ URL('setoran/edit/add')}}" accept-charset="utf-8" enctype="multipart/form-data">
                {{ csrf_field()}}
                <input type="hidden" name="setoran_type" value="0">
                <input type="hidden" name="user_id" value="{{ $user_info['id']}}">
                    <div class="form-group"><label class="col-sm-2 control-label">Judul Kartun</label>
	                    <div class="col-sm-10">
	                    <select class="form-control" name="setoran_category" required>
	                    		<option style="display:none" value="">Pilih Judul Kartun</option>
	                    	@foreach($kategori as $kat)
	                    		<option value="{{ $kat['id']}}">{{ $kat['judul']}}</option>
	                    	@endforeach
	                    </select>
	                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Tipe Media</label>
                      <div class="col-sm-10">
	                    <select class="form-control" name="setoran_media" required>
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

                        <div class="col-sm-10"><input type="number" placeholder="Nomor Episode" class="form-control" name="setoran_episode" required min="0"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-lg-2 control-label">Unggah Berkas</label>

                        <div class="col-lg-10">
                        <input type="file" class="form-control" name="setoran_file" accept=".zip,.rar,.7z,.ass,.srt" required
                        ></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-warning" type="reset">Ulang</button>
                            <button class="btn btn-danger" type="submit">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection