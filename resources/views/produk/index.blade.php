@extends('template')

@section('main')
@if (Auth::check())
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
			<b><h4>Data Produk</h4></b>
			@if(Auth::user()->level == 'admin')
			@include('produk.form_pencarian_barcode')
			@endif
			</div>
			<div class="col-md-4">
			@if(Auth::user()->level == 'admin')
			<a href="{{ url('produk/create/') }}" class="btn btn-primary btn-lg text-center"><i class="glyphicon glyphicon-briefcase"></i><br>Tambah Produk</a>
			<a href="{{ url('produk/cetakharga/') }}" class="btn btn-success btn-lg text-center" target="_blank"><i class="glyphicon glyphicon-print"></i><br>Cetak Harga</a>
			@endif
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
				@if(Auth::user()->level == 'admin')
				<th>Harga Beli</th>
				<th>Harga Grosir</th>
				@endif
				<th>Harga Retail</th>
				<th>Diskon</th>
				<th>Stok</th>
				@if(Auth::user()->level == 'admin')
				<th>Action</th>
				@endif
			</tr>
		</thead>
		<tbody>
			<?php $i=0; ?>
			<?php 
			function rupiah($nilai, $pecahan = 0) {
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
			?>
			<?php foreach($produk_list as $produk): ?>
			<tr>
				<td>{{ $produk->kodeproduk }}</td>
				<td>{{ $produk->namaproduk }}</td>
				<td>{{ $produk->merk->nama }}</td>
				@if(Auth::user()->level == 'admin')
				<td>{{ rupiah($produk->hargadistributor) }}</td>
				<td>{{ rupiah($produk->hargagrosir) }}</td>
				@endif
				<td>{{ rupiah($produk->hargajual) }}</td>
				<td>{{ rupiah($produk->diskon) }}</td>
				@if($produk->stok <= 5)
				<td><font color="red"><b>{{ $produk->stok }}</font></td>
				@else
				<td>{{ $produk->stok }}</td>
				@endif
				@if(Auth::user()->level == 'admin')
				<td>
					<div class="box-button"> 
					<!-- {{ link_to('produk/' . $produk->id,'Detail',['class' => 'btn btn-success btn-sm']) }} -->
					<a href="{{ url('produk/' . $produk->id) }}" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-search"></i> Detail</a>
					</div>
					<div class="box-button">
					<!-- {{ link_to('produk/' . $produk->id . '/edit', 'Ubah', ['class' => 'btn btn-warning btn-sm']) }} -->
					<a href="{{ url('produk/' . $produk->id . '/edit') }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
					</div>
					<div class="box-button">
					<!-- {!! Form::open(['method' => 'DELETE', 'action' => ['ProdukController@destroy',$produk->id], 'onSubmit'=>'ConfirmDelete()']) !!}
					{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
					{!! Form::close()!!} -->
					<form method="POST" action="{{ url('produk/' . $produk->id) }}" onSubmit="return ConfirmDeleteProduk({{ $produk->id }})">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="DELETE"> 
					<button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Item"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
					</form>
					</div>
					<div class="box-button"> 
					<a href="{{ url('produk/cetakbarcode/' . $produk->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-qrcode"></i> Barcode</a>
					<!-- {{ link_to('produk/print/' . $produk->id,'Cetak',['class' => 'btn btn-primary btn-sm','target'=>'_blank']) }} 
					<a href="{{ url('produk/print/' . $produk->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>-->
					</div>
				</td>
				@endif
			</tr>
		<?php endforeach ?>
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
@endif
@stop

@section('footer')
	@include('footer')
@stop