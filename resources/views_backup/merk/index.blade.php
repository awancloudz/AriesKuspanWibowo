@extends('template')

@section('main')
<div id="merk" class="panel panel-default">
	<div class="panel-heading"><b><h4>Merk/Brand Produk</h4></b></div>
	<div class="panel-body">
	@include('_partial.flash_message')
	@include('merk.form_pencarian')
	<div class="tombol-nav">
		<a href="merk/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Merk/Brand Produk</a>
	</div>
	@if (count($merk_list) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Merk/Brand</th>
				<th>Keterangan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; ?>
			<?php foreach($merk_list as $merk): ?>
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $merk->nama }}</td>
				<td>{{ $merk->keterangan }}</td>
				<td>
					<div class="box-button">
					<a href="{{ url('merk/' . $merk->id . '/edit') }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
					</div>
					<div class="box-button">
					{!! Form::open(['method' => 'DELETE', 'action' => ['MerkController@destroy',$merk->id]]) !!}
					{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
					{!! Form::close()!!}
					</div>
					<a href="{{ url('merk/cetakharga/' . $merk->id) }}" class="btn btn-success btn-sm" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Harga</a>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data merk produk.</p>
	@endif
	<div class="table-nav">
	<div class="jumlah-data">
		<strong>Jumlah Merk/Brand Produk : {{ $jumlah_merk}}</strong>
	</div>
	<div class="paging">
	{{ $merk_list->links() }}
	</div>
	</div>

	</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop