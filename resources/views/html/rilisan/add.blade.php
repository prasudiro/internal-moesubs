@extends('themes.default')

@section('judul')

Tambah Rilisan

@endsection

@section('content')

<div class="row animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
              <div class="col-md-6">
                <h5>Tambah Rilisan <small>(menambah rilisan selesai garap yang akan dipublikasikan).</small></h5>
              </div>
              <div class="col-md-6 text-right">
                <a href="{{ URL('rilisan')}}" class="btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
              </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" role="form" method="post" action="{{ URL('rilisan/add')}}" accept-charset="utf-8" enctype="multipart/form-data">
                {{ csrf_field()}}
                <input type="hidden" name="user_id" value="{{ $user_info['id']}}">
                    <div class="form-group"><label class="col-sm-2 control-label">Judul</label>
                      <div class="col-sm-8">
                      <input type="text" placeholder="Judul Rilisan" class="form-control" name="judul_rilisan" required>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Kategori</label>
                      <div class="col-sm-8">
                      <select class="chosen-select" style="width:100%;" tabindex="2" name="tags_id" required>
                          <option style="display:none" value="">Pilih Judul Kartun</option>
                        @foreach($kategori as $kat)
                          <option value="{{ $kat['id']}}">{{ $kat['judul']}}</option>
                        @endforeach
                      </select>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Gambar</label>
                      <div class="col-sm-8">
                        <input type="text" placeholder="Isi dengan URL langsung (Contoh: http://web.com/image.jpg)" class="form-control" name="gambar" required>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Musim</label>
                      <div class="col-sm-8">
                      <input type="text" placeholder="Musim (Contoh: Summer 2017)" class="form-control" name="musim" required>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Status</label>
                      <div class="col-sm-8">
                      <select class="chosen-select" style="width:100%;" tabindex="2" name="tayang" required>
                        <option style="display:none" value="">Pilih Status Rilis</option>
                        <option value="0">Konsep</option>
                        <option value="1">Rilis</option>
                      </select>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Tipe Rilisan</label>
                      <div class="col-sm-8">
                      <select class="chosen-select" style="width:100%;" tabindex="2" name="sticky" required>
                        <option style="display:none" value="">Pilih Tipe Rilisan</option>
                        <option value="0">Serial TV</option>
                        <option value="1">DVD/BluRay</option>
                        <option value="2">Film/Kumpulan</option>
                      </select>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Rekomendasi</label>
                      <div class="col-sm-8">
                      <select class="chosen-select" style="width:100%;" tabindex="2" name="pinggir" required>
                        <option style="display:none" value="">Pilih Rekomendasi Rilis</option>
                        <option value="0">Biasa</option>
                        <option value="1">Bagus</option>
                        <option value="2">Wajib</option>
                      </select>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Isi</label>
                        <div class="col-sm-8">
                        <div  style="border: 1px dashed #AAAAAA;">
                            <textarea class="summernote" name="isi"></textarea>
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