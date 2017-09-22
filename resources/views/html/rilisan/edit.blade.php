@extends('themes.default')

@section('judul')

Edit Rilisan

@endsection

@section('content')

<div class="row animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
              <div class="col-md-6">
                <h5>Edit Rilisan <small>(mengubah rilisan selesai garap yang telah dipublikasikan).</small></h5>
              </div>
              <div class="col-md-6 text-right">
                <a href="{{ URL('rilisan')}}" class="btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
              </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" role="form" method="post" action="{{ URL('rilisan/update')}}" accept-charset="utf-8" enctype="multipart/form-data">
                {{ csrf_field()}}
                <input type="hidden" name="user_id" value="{{ $user_info['id']}}">
                <input type="hidden" name="id_rilisan" value="{{ $rilisan['id_rilisan']}}">
                    <div class="form-group"><label class="col-sm-2 control-label">Judul</label>
                      <div class="col-sm-8">
                      <input type="text" placeholder="Judul Rilisan" class="form-control" name="judul_rilisan" value="{{ $rilisan['judul_rilisan']}}" required>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Gambar</label>
                      <div class="col-sm-8">
                        <img src="{{ $rilisan['gambar']}}" alt="{{ $rilisan['judul_rilisan']}}" width="100%">
                        <input type="text" placeholder="Gambar" class="form-control" name="gambar" value="{{ $rilisan['gambar']}}" required>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Kategori</label>
                      <div class="col-sm-8">
                      <select class="chosen-select" style="width:100%;" tabindex="2" name="tags_id" required>
                        @foreach($kategori as $kat)
                          <option value="{{ $kat['id']}}" {{ $kat['id'] == $rilisan['tags_id'] ? "selected" : ""}}>{{ $kat['judul']}}</option>
                        @endforeach
                      </select>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Musim</label>
                      <div class="col-sm-8">
                      <input type="text" placeholder="Musim" class="form-control" name="musim" value="{{ $rilisan['musim']}}" required>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Status</label>
                      <div class="col-sm-8">
                      <select class="chosen-select" style="width:100%;" tabindex="2" name="tayang" required>
                        <option value="0" {{ $rilisan['tayang'] == 0 ? "selected" : ""}}>Konsep</option>
                        <option value="1" {{ $rilisan['tayang'] == 1 ? "selected" : ""}}>Rilis</option>
                      </select>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Tipe Rilisan</label>
                      <div class="col-sm-8">
                      <select class="chosen-select" style="width:100%;" tabindex="2" name="sticky" required>
                        <option value="0" {{ $rilisan['sticky'] == 0 ? "selected" : ""}}>Serial TV</option>
                        <option value="1" {{ $rilisan['sticky'] == 1 ? "selected" : ""}}>DVD/BluRay</option>
                        <option value="2" {{ $rilisan['sticky'] == 2 ? "selected" : ""}}>Film/Kumpulan</option>
                      </select>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Rekomendasi</label>
                      <div class="col-sm-8">
                      <select class="chosen-select" style="width:100%;" tabindex="2" name="pinggir" required>
                        <option value="0" {{ $rilisan['pinggir'] == 0 ? "selected" : ""}}>Biasa</option>
                        <option value="1" {{ $rilisan['pinggir'] == 1 ? "selected" : ""}}>Bagus</option>
                        <option value="2" {{ $rilisan['pinggir'] == 2 ? "selected" : ""}}>Wajib</option>
                      </select>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Isi</label>
                        <div class="col-sm-8">
                        <div  style="border: 1px dashed #AAAAAA;">
                            <textarea class="summernote" name="isi">{{ $rilisan['isi'] }}</textarea>
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