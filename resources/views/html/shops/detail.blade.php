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
                <th width="5%">Total</th>
                <th width="8%">Status</th>
                <th width="8%">Pengaturan</th>
          </tr>
          </thead>
          <tbody>
          @if(count($detail) > 0)
            @foreach($detail as $data)
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <th>Pengaturan</th>
            </tr>
          </tfoot>
          </table>


      </div>
     </div>
   </div>
</div>

@endsection