@extends('themes.default')

@section('judul')

Pengaturan Notifikasi

@endsection

@section('content')

<div class="row animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
	            <div class="col-md-6">
		        		<h5>Pengaturan Notifikasi <small>(mengatur notifikasi apa saja yang boleh dikirim via email).</small></h5>
				      </div>
				      <div class="col-md-6 text-right">
				        <a href="{{ URL('pengaturan')}}" class="btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
				      </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" role="form" method="post" action="{{ URL('pengaturan/notifikasi')}}" accept-charset="utf-8" enctype="multipart/form-data">
                {{ csrf_field()}}
                <input type="hidden" name="user_id" value="{{ $user_info['id']}}">
                    <div class="form-group"><label class="col-sm-2 control-label">Rilisan</label>
	                    <div class="col-sm-8">
	                    	<div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['rilisan'] == 1 ? "checked" : ""}} value="1" name="rilisan"> <i></i> Aktifkan</label></div>
                        <div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['rilisan'] == 0 ? "checked" : ""}} value="0" name="rilisan"> <i></i> Matikan</label></div>
	                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Proyek</label>
	                    <div class="col-sm-8">
	                    	<div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['proyek'] == 1 ? "checked" : ""}} value="1" name="proyek"> <i></i> Aktifkan</label></div>
                        <div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['proyek'] == 0 ? "checked" : ""}} value="0" name="proyek"> <i></i> Matikan</label></div>
	                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Kategori</label>
	                    <div class="col-sm-8">
	                    	<div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['kategori'] == 1 ? "checked" : ""}} value="1" name="kategori"> <i></i> Aktifkan</label></div>
                        <div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['kategori'] == 0 ? "checked" : ""}} value="0" name="kategori"> <i></i> Matikan</label></div>
	                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Setoran Siap Edit</label>
	                    <div class="col-sm-8">
	                    	<div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['setoran_edit'] == 1 ? "checked" : ""}} value="1" name="setoran_edit"> <i></i> Aktifkan</label></div>
                        <div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['setoran_edit'] == 0 ? "checked" : ""}} value="0" name="setoran_edit"> <i></i> Matikan</label></div>
	                    </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Siap QC</label>
	                    <div class="col-sm-8">
	                   	  <input type="radio" value="1" name="setoran_qc" style="display:none;">
	                    	<div class="radio i-checks"><label> <input type="radio" disabled checked> <i></i> Aktifkan</label></div>
                        <div class="radio i-checks"><label> <input type="radio" disabled> <i></i> Matikan <small class="text-danger">(wajib diaktifkan!)</small></label></div>
	                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Laporan QC</label>
	                    <div class="col-sm-8">
	                    	<div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['laporan_qc'] == 1 ? "checked" : ""}} value="1" name="laporan_qc"> <i></i> Aktifkan</label></div>
                        <div class="radio i-checks"><label> <input type="radio" {{ $notifikasi['laporan_qc'] == 0 ? "checked" : ""}} value="0" name="laporan_qc"> <i></i> Matikan</label></div>
	                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-warning" type="reset">Ulang</button>
                            <button class="btn btn-danger" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection