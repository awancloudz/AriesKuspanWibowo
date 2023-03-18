@extends('template')

@section('main')
<div id="produk" class="panel panel-default">
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" style="margin-top:100px;">
<div class="modal-dialog">
	<!-- Modal Produk-->
	<div class="modal-content">
		<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div><b>Impor Excel</b></div>
        </div>
        <div class="modal-body">
        	<form style="border: 2px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
				<input type="file" name="import_file" /><br>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<button class="btn btn-success">Import File Excel</button>
			</form>
		</div>
	</div>
</div>
</div>
<!-- End Modal -->
<!-- Nama Kategori -->
	<div class="panel-heading">
	@include('_partial.flash_message')
		<div class="row">
			<div class="col-md-8">
			<b><h4>Data Stok Produk Cabang</h4></b>
			</div>
		</div>
	</div>
	<div class="panel-body">
	@if (count($produk_list) > 0)
	<table id="tabelproduk" class="table display compact">
		<thead>
			<tr>
				<th>Kode Produk</th>
				<th>Nama Produk</th>
				<th>Merk/Brand</th>
				<th>Harga Beli</th>
				<!-- <th>Harga Grosir</th> -->
				<th>Harga Retail</th>
				<th>Diskon</th>
				<th>Stok</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; ?>
			<?php 
			function rupiah($nilai, $pecahan = 0) {
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
			?>
			@foreach($produk_list as $produk)
			<tr>
				<td>{{ $produk->kodeproduk }}</td>
				<td>{{ $produk->namaproduk }}</td>
				<td>{{ $produk->produk->merk->nama }}</td>
				<!-- <td>{{ rupiah($produk->hargadistributor) }}</td> -->
				<td>{{ rupiah($produk->hargagrosir) }}</td>
				<td>{{ rupiah($produk->hargajual) }}</td>
				<td>{{ rupiah($produk->diskon) }}</td>
				@if($produk->stok <= 5)
				<td><font color="red"><b>{{ $produk->stok }}</font></td>
				@else
				<td>{{ $produk->stok }}</td>
				@endif
				<td>
					<div class="box-button">
					<a href="{{ url('cabang/'. $produk->id_profile .'/produk/' . $produk->id . '/edit') }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i> Ubah Stok</a>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@else
	<p>Tidak ada data produk.</p>
	@endif
	</div>
</div>
<script>
$(document).ready(function(){
	$("#cmd_import").click(function(){
		$("#myModal").modal({backdrop: "static"});
	});
	//Data Tabel CSS
	$('#tabelproduk').DataTable({
		"oLanguage": {
		"sSearch": "",
		"sSearchPlaceholder": "Pencarian Nama Produk / Merk",
		},
		"pageLength": 50,
		"lengthChange": false,
	});
	$('.dataTables_filter').addClass('pull-left input-group');
	$('.dataTables_filter input[type=search]').addClass('form-control');
	$('.dataTables_filter input[type="search"]').css(
     {'width':'818px','border-radius':'5px','margin-left':'1px'}
  	);
	$('.dataTables_length').addClass('pull-right');
});
</script>
@stop

@section('footer')
	@include('footer')
@stop