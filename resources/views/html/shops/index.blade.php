@extends('themes.default')

@section('judul')

Shops

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-6">
	        <h5>Shops <small>(berisikan daftar penjualan dan pemesaran, serta konfirmasi pembayaran).</small></h5>
	      </div>
	      <div class="col-md-6 text-right">
	        <a href="{{ URL('shops/add')}}" class="btn-sm btn-danger"><i class="fa fa-plus"></i> Tambah Produk</a>
	      </div>
      </div>
      <div class="ibox-content">
	      
	     <table class="table table-striped table-bordered table-hover dataTables-shops" >
          <thead>
          <tr>
                <th width="50%">Produk Penjualan</th>
                <th width="8%">Status</th>
                <th width="5%">Total</th>
                <th width="5%">Proses</th>
                <th width="5%">Lunas</th>
                <th width="5%">Dikirim</th>
                <th width="55">Ditutup pada</th>
                <th width="8%">Pengaturan</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($product as $data) 
            <tr>
              <td style="vertical-align: middle !important;">
              <a href="{{ URL('shops/detail/'.base64_encode($data['shops_id'].'shops'))}}" data-toggle="tooltip" title="Lihat detail produk {{ $data['shops_product']}}">
              {{ $data['shops_product']}}
              </a>
              </td>
              <td class="text-center" style="vertical-align: middle !important;">{!! $data['shops_status'] == 0 ? '<label class="label label-info">Pre Order</label>' : '<label class="label label-success">Ready Stock</label>'!!}</td>
              <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_order']}}</td>
              <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_unpaid']}}</td>
              <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_paid']}}</td>
              <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_delivered']}}</td>
              <td style="vertical-align: middle !important;">{{ date("d M y H:i", strtotime($data['shops_closed']))}}</td>
              <td class="text-center" style="vertical-align: middle !important;">
                <a data-toggle="modal" data-target="#belumada"><i data-toggle="tooltip" title="Detail" class="fa fa-gamepad text-muted"></i></a>
                &nbsp;
                <a href="{{ URL('shops/edit/'.base64_encode($data['shops_id'].'shops'))}}"><i data-toggle="tooltip" title="Edit" class="fa fa-edit text-info" data-toggle="tooltip" title="Edit"></i></a>
                &nbsp;
                <a data-toggle="modal" data-target="#delete{{ $data['shops_id']}}" title="Hapus"><i class="fa fa-trash text-danger" data-toggle="tooltip" title="Hapus"></i></a>
              </td>
            </tr>
          @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th>Produk Penjualan</th>
                <th>Status</th>
                <th>Total</th>
                <th>Proses</th>
                <th>Lunas</th>
                <th>Dikirim</th>
                <th>Ditutup pada</th>
                <th>Pengaturan</th>
            </tr>
          </tfoot>
          </table>


      </div>
     </div>
   </div>
</div>

@foreach ($product as $data2) 
<div class="modal inmodal" id="delete{{ $data2['shops_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    <div class="modal-content animated bounceIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h1 class="text-danger"><b>PERINGATAN!!!</b></h1>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-info"><i class="fa fa-question" style="font-size:40px;"></i> <br><br>Anda yakin ingin menghapusnya?</h3>
                  <center>
                    {{ $data2['shops_product']}}
                  </center>
            </div>
            <div class="modal-footer">
              <div align="center">
                <a href="#" class="btn btn-primary" data-dismiss="modal">Tidak</a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#confirmdelete{{ $data2['shops_id']}}">Yakin</a>
              </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($product as $data3)
<div class="modal inmodal" id="confirmdelete{{ $data3['shops_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content animated bounceIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h1 class="text-danger"><b>Apa Anda benar-benar yakin?</b></h1>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" role="form" method="post" action="{{ URL('shops/delete')}}" accept-charset="utf-8" enctype="multipart/form-data">
              {{ csrf_field()}}
              <input name="shops_id" value="{{ $data3['shops_id']}}" type="hidden">
              <div align="center">
                <input class="form-control" name="product_delete" value="" type="text" placeholder="Ketik HAPUS pada kolom ini dan tekan ENTER"></div>
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