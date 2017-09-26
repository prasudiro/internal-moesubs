@extends('themes.default')

@section('judul')

Tambah Produk Baru

@endsection

@section('content')

<div class="row animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
	            <div class="col-md-6">
		        		<h5>Tambah Produk Baru <small>(menambahkan produk siap jual atau untuk pesanan baru)</small></h5>
				      </div>
				      <div class="col-md-6 text-right">
				        <a href="{{ URL('shops')}}" class="btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
				      </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" role="form" method="post" action="{{ URL('shops/add')}}" accept-charset="utf-8" enctype="multipart/form-data">
                {{ csrf_field()}}
                <input type="hidden" value="{{ $user_info['id']}}" name="user_id">
                <div class="form-group"><label class="col-sm-2 control-label">Nama Produk</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" value="" placeholder="Isikan nama produk" name="shops_product" required>
                  </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group"><label class="col-sm-2 control-label">Produk Detail</label>
                  <div class="col-sm-8">
                    <div style="border: 1px dashed #AAAAAA;">
                      <textarea class="summernote" name="shops_detail" rows="5"></textarea>
                    </div>
                  </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group"><label class="col-sm-2 control-label">Harga Produk</label>
                  <div class="col-sm-3">
                  <div class="input-group m-b"><input type="number" class="form-control" value="" placeholder="Isi harga produk" name="shops_price" required min="0"> <span class="input-group-addon">IDR</span> </div>
                  </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group"><label class="col-sm-2 control-label">Promo Diskon</label>
                  <div class="col-sm-3">
                  <select class="form-control" name="shops_discount" required>
                    <option value="1">Ya</option>
                    <option value="0" selected>Tidak</option>
                  </select>
                  </div>
                  <div class="col-sm-5" style="margin-top:10px;"><span class="text-danger"><i>* Jika "Ya", isi potongan harga dalam persen (%)</i></span></div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">Potongan Harga</label>
                  <div class="col-sm-3">
                  <div class="input-group m-b"><input type="number" class="form-control" value="0" placeholder="Diskon dalam persen (%)" name="shops_discount_percent" min="0" max="99"> <span class="input-group-addon">%</span> </div>
                  </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group"><label class="col-sm-2 control-label">Status Produk</label>
                  <div class="col-sm-3">
                  <select class="form-control" name="shops_status" required>
                    <option value="0">Pre-Order</option>
                    <option value="1">Ready Stock</option>
                  </select>
                  </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group" id="data_1"><label class="col-sm-2 control-label">Tanggal Penutupan</label>
                  <div class="col-sm-3">
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="shops_closed" value="{{ date('Y-m-d')}}">
                    </div>
                  </div>
                  <div class="col-sm-5" style="margin-top:10px;"><span class="text-danger"><i>* Hanya berpengaruh saat pilihan produk "Pre-Order"</i></span></div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group"><label class="col-sm-2 control-label">Nomor Rekening Pembayaran</label>
                  <div class="col-sm-8">
                    <div style="border: 1px dashed #AAAAAA;">
                      <textarea class="summernote" name="bank" rows="5"></textarea>
                    </div>
                  </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group"><label class="col-sm-2 control-label">Gambar Produk</label>
                  <div class="col-sm-8">
                    <div class="input-group m-b"><span class="input-group-addon text-danger"><b>Gambar #1</b></span> <input type="file" class="form-control" name="gambar1" required></div>
                    <div class="input-group m-b"><span class="input-group-addon text-danger"><b>Gambar #2</b></span> <input type="file" class="form-control" name="gambar2" required></div>
                    <div class="input-group m-b"><span class="input-group-addon text-danger"><b>Gambar #3</b></span> <input type="file" class="form-control" name="gambar3" required></div>
                  </div>
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