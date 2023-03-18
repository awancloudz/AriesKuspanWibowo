@extends('template')
@section('main')
<div id="produk" class="panel panel-default">
	<div class="panel-heading"><b><h4>Data Produk</h4></b> 
		<div class="box-button">
			{{ link_to('produk/' . $produk->id . '/edit', 'Ubah', ['class' => 'btn btn-warning btn-sm']) }}
		</div>
		<div class="box-button">
			<!-- {!! Form::open(['method' => 'DELETE', 'action' => ['ProdukController@destroy',$produk->id], 'onSubmit' => 'return ConfirmDelete()']) !!}
			{!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-sm'])!!}
			{!! Form::close()!!} -->
			<form method="POST" action="{{ url('produk/' . $produk->id) }}" onSubmit="return ConfirmDelete({{ $produk->id }})">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="DELETE"> 
			<button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Item"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
			</form>
		</div>
		<div class="box-button">
			<a href="{{ url('produk/history/'.$produk->id) }}" class="btn btn-primary btn-sm text-center"><i class="glyphicon glyphicon-chevron-right"></i> <b>History</b></a>
		</div>
		<!-- <div class="box-button"> 
			{{ link_to('produk/print/' . $produk->id,'Cetak',['class' => 'btn btn-primary btn-sm','target'=>'_blank']) }}
		</div> -->
	</div>
	<div class="panel-body">
		<table class="table table-striped">
		<?php 
			function rupiah($nilai, $pecahan = 0) {
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
		?>
		<tr><th>Kode Produk</th><td>{{ $produk->kodeproduk }}
		<?php
			echo DNS1D::getBarcodeHTML($produk->kodeproduk, "C128");
		?><br><a href="{{ url('produk/cetakbarcode/' . $produk->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-qrcode"></i> Cetak Barcode</a>
		</td></tr>
		<tr><th>Foto</th>
			<td>
				@if(isset($produk->foto))
				<img width="200" height="200" src="{{ asset('fotoupload/' . $produk->foto) }}">
				@else	
				<img width="200" height="200" src="{{ asset('fotoupload/noimage.png') }}">
				@endif
			</td>
		</tr>
		<tr><th>Nama Produk</th><td>{{ $produk->namaproduk }}</td></tr>
		<tr><th>Kategori</th><td>{{ $produk->kategoriproduk->nama }}</td></tr>
		<tr><th>Merk/Brand</th><td>{{ $produk->merk->nama }}</td></tr>
		<tr><th>Harga Retail</th><td>{{ rupiah($produk->hargajual) }}</td></tr>
		<tr><th>Harga Grosir</th><td>{{ rupiah($produk->hargagrosir) }}</td></tr>
		<tr><th>Harga Beli</th><td>{{ rupiah($produk->hargadistributor) }}</td></tr>
		<tr><th>Diskon</th><td>{{ rupiah($produk->diskon) }}</td></tr>
		<tr><th>Stok</th><td>{{ $produk->stok }}</td></tr>
		</table>
	</div>
	</div>
</div>
@stop

@section('footer')
@include('footer')
@stop