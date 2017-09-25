@extends('themes.default')

@section('judul')

Shops "{{ $product['shops_product']}}"

@endsection

@section('content')

<div class="row animated fadeInDown">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-6">
	        <h5>{{ $product['shops_product']}} <small>({{ $product['shops_detail']}}).</small></h5>
	      </div>
	      <div class="col-md-6 text-right">
	        <a data-toggle="modal" data-target="#belumada"  class="btn-sm btn-danger"><i class="fa fa-plus"></i> Tambah Pemesan</a>
	      </div>
      </div>
      <div class="ibox-content">
	      
	     <table class="table table-striped table-bordered table-hover dataTables-shopsdetail" >
          <thead>
          <tr>
                <th width="50%">Nama Pemesan</th>
                <th width="5%">Jumlah</th>
                <th width="8%">Total</th>
                <th width="7%">Status</th>
                <th width="16%">Tanggal Pesan</th>
                <th width="8%">Pengaturan</th>
          </tr>
          </thead>
          <tbody>
          @if(count($detail) > 0)
            @foreach($detail as $data)
              <tr>
                <td style="vertical-align: middle !important;">{{ $data['shops_detail_buyer']}}</td>
                <td class="text-center" style="vertical-align: middle !important;">{{ $data['shops_detail_quantity']}}</td>
                <td class="text-right" style="vertical-align: middle !important;">{{ number_format($data['shops_detail_quantity'] * $product['shops_price'])}}</td>
                <td class="text-center" style="vertical-align: middle !important;">
                  <?php 
                    $status = "<label class='label label-danger'>Proses</label>";
                  if ($data['shops_detail_status'] == 1) 
                  {
                    $status = "<label class='label label-primary'>Lunas</label>";
                  }
                  elseif($data['shops_detail_status'] == 2) 
                  {
                    $status = "<label class='label label-muted'>Dikirim</label>";
                  }
                  ?>
                {!! $status!!}
                </td>
                <td data-order="{{ strtotime($data['created_at'])}}" style="vertical-align: middle !important;">{{ date("d F y - H:i", strtotime($data['created_at']))}}</td>
                <td style="vertical-align: middle !important;">
                </td>
              </tr>
            @endforeach
          @else
              <tr>
                <td colspan="5" class="text-center"><h3><b>Tidak ada data</b></h3></td>
              </tr>
          @endif
          </tbody>
          <tfoot>
            <tr>
                <th>Nama Pemesan</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal Pesan</th>
                <th>Pengaturan</th>
            </tr>
          </tfoot>
          </table>


      </div>
     </div>
   </div>
</div>

@endsection