<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>@yield('judul') Internal | [Moesubs] Jagonya Ngesub</title>

	<link href="{{ URL('css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ URL('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

	<!-- Toastr style -->
	<link href="{{ URL('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

	<!-- Chosen -->
	<link href="{{ URL('css/plugins/chosen/chosen.css')}}" rel="stylesheet">

	<!-- Gritter -->
	<link href="{{ URL('js/plugins/gritter/jquery.gritter.css')}}" rel="stylesheet">

	<!-- Data Tables -->
	<link href="{{ URL('css/plugins/dataTables/dataTables.bootstrap.css')}}" rel="stylesheet">
	<link href="{{ URL('css/plugins/dataTables/dataTables.responsive.css')}}" rel="stylesheet">
	<link href="{{ URL('css/plugins/dataTables/dataTables.tableTools.min.css')}}" rel="stylesheet">

	<!-- Summernote -->
	<link href="{{ URL('css/plugins/summernote/summernote.css')}}" rel="stylesheet">
	<link href="{{ URL('css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">

	<!-- iChecks -->
	<link href="{{ URL('css/plugins/iCheck/custom.css')}}" rel="stylesheet">

	<!-- Datapicker -->
	<link href="{{ URL('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

	<!-- Gallery -->
  <link href="{{ URL('css/plugins/blueimp/css/blueimp-gallery.min.css')}}" rel="stylesheet">

	<link href="{{ URL('css/animate.css')}}" rel="stylesheet">
	<link href="{{ URL('css/style.css')}}" rel="stylesheet">

	<style type="text/css">
		.modal-dialog {
		  position: relative;
		  width: auto;
		  max-width: 600px;
		  margin: 10px;
		}
		.modal-sm {
		  max-width: 300px;
		}
		.modal-lg {
		  max-width: 900px;
		}
		@media (min-width: 768px) {
		  .modal-dialog {
			margin: 30px auto;
		  }
		}
		@media (min-width: 320px) {
		  .modal-sm {
			margin-right: auto;
			margin-left: auto;
		  }
		}
		@media (min-width: 620px) {
		  .modal-dialog {
			margin-right: auto;
			margin-left: auto;
		  }
		  .modal-lg {
			margin-right: 10px;
			margin-left: 10px;
		  }
		}
		@media (min-width: 920px) {
		  .modal-lg {
			margin-right: auto;
			margin-left: auto;
		  }
		}
	</style>

</head>

<body>
	<div id="wrapper">
		
		@include('themes.default.sidebar')

		<div id="page-wrapper" class="gray-bg dashbard-1">
		<div class="row border-bottom">
		<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<a class="navbar-minimalize minimalize-styl-2 btn btn-danger " href="#"><i class="fa fa-bars"></i> </a>
			<form role="search" class="navbar-form-custom" method="get" action="{{ URL('/')}}">
				<div class="form-group">
					<input type="text" placeholder="Cari sesuatu?" class="form-control" name="pencarian_global" id="pencarian_global">
				</div>
			</form>
		</div>
			<ul class="nav navbar-top-links navbar-right">
				<li>
					<span class="m-r-sm text-muted welcome-message">[Moesubs] Jagonya Ngesub</span>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
						<i class="fa fa-envelope"></i>  
						{{-- <span class="label label-warning">16</span> --}}
					</a>
					<ul class="dropdown-menu dropdown-messages">
						<li>
							<div class="dropdown-messages-box">
								<center>
								<strong>Tidak ada pesan baru.</strong>
								</center>
							</div>
						</li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
						<i class="fa fa-bell"></i>
						@if($total_pemberitahuan > 0)
							<span class="label label-danger">{{ $total_pemberitahuan}}</span>
						@endif
					</a>
					<ul class="dropdown-menu dropdown-alerts">
					  @if($setoran_edit > 0)
							<li>
								<a href="{{ URL('setoran/edit')}}">
									<div>
										<i class="fa fa-book fa-fw"></i> {{ $setoran_edit}} setoran edit baru
										<span class="pull-right text-muted small">Hari ini {{ date("H:i", strtotime($tanggal_edit['created_at']))}}</span>
									</div>
								</a>
							</li>
							<li class="divider"></li>
					  @endif
					  @if($setoran_qc > 0)
							<li>
								<a href="{{ URL('setoran/qc')}}">
									<div>
										<i class="fa fa-book fa-fw"></i> {{ $setoran_qc}} setoran QC baru
										<span class="pull-right text-muted small">Hari ini {{ date("H:i", strtotime($tanggal_qc['created_at']))}}</span>
									</div>
								</a>
							</li>
							<li class="divider"></li>
					  @endif
					  @if($laporan_qc > 0)
							<li>
								<a href="{{ URL('laporan')}}">
									<div>
										<i class="fa fa-desktop fa-fw"></i> {{ $laporan_qc}} laporan QC baru
										<span class="pull-right text-muted small">Hari ini {{ date("H:i", strtotime($tanggal_laporan['created_at']))}}</span>
									</div>
								</a>
							</li>
							<li class="divider"></li>
					  @endif
					  @if($total_pemberitahuan > 0)
						  <li>
                <div class="text-center link-block">
                  <a data-toggle="modal" data-target="#belumada">
                      <strong>Lihat semua pemberitahuan</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
                </div>
	            </li>
	          @else
	          <li>
                <div class="text-center link-block">
                  <i class="fa fa-info-circle"></i> <strong>Tidak ada pemberitahuan baru</strong>
                </div>
	            </li>
            @endif
					</ul>
				</li>


				<li>
					<a href="{{ URL('logout')}}">
						<i class="fa fa-sign-out"></i> Keluar
					</a>
				</li>
			</ul>

		</nav>
		</div>

			@yield('content')

					<div class="footer">
			<div class="pull-right">
				Diperkawaii oleh <strong>Inspinia</strong>.
			</div>
			<div>
				<strong>Copyright</strong> [Moesubs] Jagonya Ngesub &copy; 2010-{{ date('Y')}}
			</div>
		</div>                

	</div>
  </div>

<!-- Modal for future feature -->  
<div class="modal inmodal" id="belumada" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
	<div class="modal-content animated bounceIn">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h1><b>Lapak Kosong</b></h1>
			</div>
			<div class="modal-body">
					<h3 class="text-center text-danger"><i class="fa fa-warning" style="font-size:40px;"></i> <br><br>Saat ini fitur belum tersedia</h3>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal" id="tidakboleh" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    <div class="modal-content animated bounceIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h1 class="text-danger"><b>PERINGATAN!!!</b></h1>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-danger"><i class="fa fa-warning" style="font-size:40px;"></i> <br><br>Ini bukan data milik Anda!!!</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

	<!-- Mainly scripts -->
	<script src="{{ URL('js/jquery-2.1.1.js')}}"></script>
	<script src="{{ URL('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
	<script src="{{ URL('js/bootstrap.min.js')}}"></script>
	<script src="{{ URL('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
	<script src="{{ URL('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

	<!-- Flot -->
	<script src="{{ URL('js/plugins/flot/jquery.flot.js')}}"></script>
	<script src="{{ URL('js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
	<script src="{{ URL('js/plugins/flot/jquery.flot.spline.js')}}"></script>
	<script src="{{ URL('js/plugins/flot/jquery.flot.resize.js')}}"></script>
	<script src="{{ URL('js/plugins/flot/jquery.flot.pie.js')}}"></script>

	<!-- Peity -->
	<script src="{{ URL('js/plugins/peity/jquery.peity.min.js')}}"></script>
	<script src="{{ URL('js/demo/peity-demo.js')}}"></script>

	<!-- Custom and plugin javascript -->
	<script src="{{ URL('js/inspinia.js')}}"></script>
	<script src="{{ URL('js/plugins/pace/pace.min.js')}}"></script>

	<!-- GITTER -->
	<script src="{{ URL('js/plugins/gritter/jquery.gritter.min.js')}}"></script>

	<!-- Sparkline -->
	<script src="{{ URL('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Sparkline demo data  -->
	<script src="{{ URL('js/demo/sparkline-demo.js')}}"></script>

	<!-- ChartJS-->
	<script src="{{ URL('js/plugins/chartJs/Chart.min.js')}}"></script>

	<!-- Toastr -->
	<script src="{{ URL('js/plugins/toastr/toastr.min.js')}}"></script>

	<!-- Chosen -->
	<script src="{{ URL('js/plugins/chosen/chosen.jquery.js')}}"></script>

	<!-- Data Tables -->
	<script src="{{ URL('js/plugins/dataTables/jquery.dataTables.js')}}"></script>
	<script src="{{ URL('js/plugins/dataTables/dataTables.bootstrap.js')}}"></script>
	<script src="{{ URL('js/plugins/dataTables/dataTables.responsive.js')}}"></script>
	<script src="{{ URL('js/plugins/dataTables/dataTables.tableTools.min.js')}}"></script>

	<!-- SUMMERNOTE -->
	<script src="{{ URL('js/plugins/summernote/summernote.min.js')}}"></script>

	<!-- iCheck -->
  <script src="{{ URL('js/plugins/iCheck/icheck.min.js')}}"></script>

  <!-- Datapicker -->
 	<script src="{{ URL('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

  <!-- blueimp gallery -->
  <script src="{{ URL('js/plugins/blueimp/jquery.blueimp-gallery.min.js')}}"></script>

	<script>
	

			$('[data-toggle="tooltip"]').tooltip();
		$(document).ready(function() {
			@if(Session::has('error_msg'))
				setTimeout(function() {
						toastr.options = {
							closeButton: true,
							progressBar: true,
							showMethod: 'slideDown',
							timeOut: 4000,
						};
						toastr.warning('{!! Session::get("error_msg") !!}');

					}, 500);
			@elseif(Session::has('success_msg'))
				setTimeout(function() {
					toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000
					};
					toastr.error('{!! Session::get("success_msg") !!}');

				}, 500);
			@endif

			$('.dataTables-setoran').dataTable({
				responsive: true,
				"order": [[ 2, "desc" ]],
				"columnDefs": [
				  { "targets": [3], "orderable": false }
				],
				"language": {
					"zeroRecords": "<center><h3><b>Tidak ada data</b></h3><center>",
					"paginate": {
						"first":    'Pertama',
						"previous": 'Mundur',
						"next":     'Maju',
						"last":     'Terakhir'
					},
					"search": "",
					"searchPlaceholder": "Pencarian",
					"lengthMenu": '<select class=form-control>'+
					  '<option value="10">10</option>'+
					  '<option value="30">30</option>'+
					  '<option value="50">50</option>'+
					  '<option value="100">100</option>'+
					  '<option value="-1">Semua</option>'+
					  '</select>&nbsp;&nbsp;data per halaman',
					"info": "Total _TOTAL_ data",
					"infoEmpty": "",
					"infoFiltered": ""
				}
			});   

			$('.dataTables-laporan').dataTable({
				responsive: true,
				"order": [[ 2, "desc" ]],
				"language": {
					"zeroRecords": "<center><h3><b>Tidak ada data</b></h3><center>",
					"paginate": {
						"first":    'Pertama',
						"previous": 'Mundur',
						"next":     'Maju',
						"last":     'Terakhir'
					},
					"search": "",
					"searchPlaceholder": "Pencarian",
					"lengthMenu": '<select class=form-control>'+
					  '<option value="10">10</option>'+
					  '<option value="30">30</option>'+
					  '<option value="50">50</option>'+
					  '<option value="100">100</option>'+
					  '<option value="-1">Semua</option>'+
					  '</select>&nbsp;&nbsp;data per halaman',
					"info": "Total _TOTAL_ data",
					"infoEmpty": "",
					"infoFiltered": ""
				}

			});

			$('.dataTables-kategori').dataTable({
				responsive: true,
				// "order": [[ 3, "desc" ]],
				"columnDefs": [
				  { "targets": [2], "orderable": false },
				  { "targets": [3], "orderable": false }
				],
				"language": {
					"zeroRecords": "<center><h3><b>Tidak ada data</b></h3><center>",
					"paginate": {
						"first":    'Pertama',
						"previous": 'Mundur',
						"next":     'Maju',
						"last":     'Terakhir'
					},
					"search": "",
					"searchPlaceholder": "Pencarian",
					"lengthMenu": '<select class=form-control>'+
					  '<option value="10">10</option>'+
					  '<option value="30">30</option>'+
					  '<option value="50">50</option>'+
					  '<option value="100">100</option>'+
					  '<option value="-1">Semua</option>'+
					  '</select>&nbsp;&nbsp;data per halaman',
					"info": "Total _TOTAL_ data",
					"infoEmpty": "",
					"infoFiltered": ""
				}
			});  

			$('.dataTables-rilisan').dataTable({
				responsive: true,
				"order": [[ 2, "desc" ]],
				"columnDefs": [
				  { "targets": [4], "orderable": false }
				],
				"language": {
					"zeroRecords": "<center><h3><b>Tidak ada data</b></h3><center>",
					"paginate": {
						"first":    'Pertama',
						"previous": 'Mundur',
						"next":     'Maju',
						"last":     'Terakhir'
					},
					"search": "",
					"searchPlaceholder": "Pencarian",
					"lengthMenu": '<select class=form-control>'+
					  '<option value="10">10</option>'+
					  '<option value="30">30</option>'+
					  '<option value="50">50</option>'+
					  '<option value="100">100</option>'+
					  '<option value="-1">Semua</option>'+
					  '</select>&nbsp;&nbsp;data per halaman',
					"info": "Total _TOTAL_ data",
					"infoEmpty": "",
					"infoFiltered": ""
				}
			});  

			$('.dataTables-shops').dataTable({
				responsive: true,
				"order": [[ 6, "desc" ]],
				"columnDefs": [
				  { "targets": [2], "orderable": false },
				  { "targets": [3], "orderable": false },
				  { "targets": [4], "orderable": false },
				  { "targets": [5], "orderable": false },
				  { "targets": [7], "orderable": false }
				],
				"language": {
					"zeroRecords": "<center><h3><b>Tidak ada data</b></h3><center>",
					"paginate": {
						"first":    'Pertama',
						"previous": 'Mundur',
						"next":     'Maju',
						"last":     'Terakhir'
					},
					"search": "",
					"searchPlaceholder": "Pencarian",
					"lengthMenu": '<select class=form-control>'+
					  '<option value="10">10</option>'+
					  '<option value="30">30</option>'+
					  '<option value="50">50</option>'+
					  '<option value="100">100</option>'+
					  '<option value="-1">Semua</option>'+
					  '</select>&nbsp;&nbsp;data per halaman',
					"info": "Total _TOTAL_ data",
					"infoEmpty": "",
					"infoFiltered": ""
				}

			});

			$('.dataTables-shopsdetail').dataTable({
				responsive: true,
				"order": [[ 5, "desc" ]],
				"columnDefs": [
				  { "targets": [2], "orderable": false },
				  { "targets": [3], "orderable": false },
				  { "targets": [6], "orderable": false },
				],
				"language": {
					"zeroRecords": "<center><h3><b>Tidak ada data</b></h3><center>",
					"paginate": {
						"first":    'Pertama',
						"previous": 'Mundur',
						"next":     'Maju',
						"last":     'Terakhir'
					},
					"search": "",
					"searchPlaceholder": "Pencarian",
					"lengthMenu": '<select class=form-control>'+
					  '<option value="10">10</option>'+
					  '<option value="30">30</option>'+
					  '<option value="50">50</option>'+
					  '<option value="100">100</option>'+
					  '<option value="-1">Semua</option>'+
					  '</select>&nbsp;&nbsp;data per halaman',
					"info": "Total _TOTAL_ data",
					"infoEmpty": "",
					"infoFiltered": ""
				}

			});

			$('.summernote').summernote();

			$('.i-checks').iCheck({
			              checkboxClass: 'icheckbox_square-green',
			              radioClass: 'iradio_square-green',
			         });

			$('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
               	format: 'yyyy-mm-dd',
            });

			var data1 = [
				[0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
			];
			var data2 = [
				[0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
			];
			$("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
				data1, data2
			],
					{
						series: {
							lines: {
								show: false,
								fill: true
							},
							splines: {
								show: true,
								tension: 0.4,
								lineWidth: 1,
								fill: 0.4
							},
							points: {
								radius: 0,
								show: true
							},
							shadowSize: 2
						},
						grid: {
							hoverable: true,
							clickable: true,
							tickColor: "#d5d5d5",
							borderWidth: 1,
							color: '#d5d5d5'
						},
						colors: ["#1ab394", "#464f88"],
						xaxis:{
						},
						yaxis: {
							ticks: 4
						},
						tooltip: false
					}
			);

		});

			var config = {
				'.chosen-select'           : {},
				'.chosen-select-deselect'  : {allow_single_deselect:true},
				'.chosen-select-no-single' : {disable_search_threshold:10},
				'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
				'.chosen-select-width'     : {width:"95%"}
			}
			for (var selector in config) {
				$(selector).chosen(config[selector]);
			}
	</script>

</body>
</html>
