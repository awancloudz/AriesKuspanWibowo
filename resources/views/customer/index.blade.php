@extends('template')

@section('main')
<div id="customer" class="panel panel-default">
	<div class="panel-heading"><b><h4>Data Pelanggan</h4></b></div>
	<div class="panel-body">
	@include('_partial.flash_message')
	@include('customer.form_pencarian')
	<div class="tombol-nav">
		<a href="customer/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Pelanggan</a>
	</div>
	@if (count($customer_list) > 0)
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
			<?php foreach($customer_list as $customer): ?>
			@if ($customer->nama != '-')
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $customer->nama }}</td>
				<td>{{ $customer->alamat }}</td>
				<td>{{ $customer->notelp }}</td>
				<td>
					<div class="box-button">
					<!-- {{ link_to('customer/' . $customer->id . '/edit', 'Ubah', ['class' => 'btn btn-warning btn-sm']) }} -->
					<a href="{{ url('customer/' . $customer->id . '/edit') }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
					</div>
					<div class="box-button">
					{!! Form::open(['method' => 'DELETE', 'action' => ['CustomerController@destroy',$customer->id], 'onSubmit' => 'return ConfirmDelete()']) !!}
					<!-- {!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-sm'])!!} -->
					{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
					{!! Form::close()!!}
					</div>
				</td>
			</tr>
			@endif
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data pelanggan.</p>
	@endif
	<div class="table-nav">
	<div class="jumlah-data">
		<strong>Jumlah Pelanggan : {{ $jumlah_customer}}</strong>
	</div>
	<div class="paging">
	{{ $customer_list->links() }}
	</div>
	</div>

	</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop