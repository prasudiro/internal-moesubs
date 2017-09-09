@extends('themes.default')

@section('judul')

Edit Laporan QC

@endsection

@section('content')

<div class="row animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
	            <div class="col-md-6">
		        		<h5>Edit Laporan QC <small>(hanya untuk memperbarui laporan QC).</small></h5>
				      </div>
				      <div class="col-md-6 text-right">
				        <a href="{{ URL('laporan')}}" class="btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
				      </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" role="form" method="post" action="{{ URL('laporan/update')}}" accept-charset="utf-8" enctype="multipart/form-data">
                {{ csrf_field()}}
                <input type="hidden" name="laporan_isi_id" value="{{ $laporan_isi['laporan_isi_id']}}">
                    <div class="form-group"><label class="col-sm-2 control-label">Judul Kartun</label>
	                    <div class="col-sm-8">
	                       <input value="{{ $laporan_isi['laporan_name']}}" class="form-control" disabled>
	                    </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Isi Laporan</label>
                        <div class="col-sm-8">
                        <div  style="border: 1px dashed #AAAAAA;">
                            <textarea class="summernote" name="laporan_isi_detail">{{ base64_decode($laporan_isi['laporan_isi_detail'])}}</textarea>
                        </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-warning" type="reset">Ulang</button>
                            <button class="btn btn-danger" type="submit">Perbarui</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection