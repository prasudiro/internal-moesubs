@extends('themes.default')

@section('title')

Setoran Edit

@section('content')

<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
	      <div class="col-md-6">
	        <h5>Daftar Setoran Edit <small>(hanya untuk skrip yang akan diedit).</small></h5>
	      </div>
	      <div class="col-md-6 text-right">
	        <a href="{{ URL('setoran/edit/add')}}" class="btn-sm btn-danger">Tambah Setoran</a>
	      </div>
      </div>
      <div class="ibox-content">
	      <div class="table-responsive">
	      	<table class="table table-hover">
	      		<tr>
	      			<td>ok</td>
	      			<td>ok</td>
	      		</tr>
	      	</table>
	      </div>
      </div>
     </div>
   </div>
</div>

@endsection