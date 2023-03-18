@extends('template')

@section('main')
<div id="customer" class="panel panel-default">
	<div class="panel-heading"><b><h4>Data Cabang</h4></b></div>
	<div class="panel-body">
	@include('_partial.flash_message')
	<!-- @include('customer.form_pencarian') -->
	<div class="tombol-nav">
		<a href="profile/create" class="btn btn-primary">Tambah Cabang</a>
	</div>
	@if (count($daftar_cabang) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>No.Telp</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; ?>
			<?php foreach($daftar_cabang as $profile): ?>
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $profile->nama }}</td>
				<td>{{ $profile->alamat }}</td>
				<td>{{ $profile->notelp }}</td>
				<td>
					<div class="box-button">
					{{ link_to('profile/' . $profile->id . '/edit', 'Edit', ['class' => 'btn btn-warning btn-sm']) }}
					</div>
					<div class="box-button">
					{!! Form::open(['method' => 'DELETE', 'action' => ['ProfileController@destroy',$profile->id], 'onSubmit' => 'return ConfirmDelete()']) !!}
					{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm'])!!}
					{!! Form::close()!!}
					</div>
					<div class="box-button">
					{{ link_to('cabang/produk/'. $profile->id , 'Stok Produk', ['class' => 'btn btn-primary btn-sm']) }}
					</div>
					<div class="box-button">
					{{ link_to('cabang/transaksi/'. $profile->id , 'Transaksi', ['class' => 'btn btn-success btn-sm']) }}
					</div>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data cabang.</p>
	@endif
	<div class="table-nav">
	<div class="jumlah-data">
		<strong>Jumlah Cabang : {{ $jumlah_cabang}}</strong>
	</div>
	<div class="paging">
	{{ $daftar_cabang->links() }}
	</div>
	</div>

	</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop