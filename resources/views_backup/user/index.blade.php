@extends('template')

@section('main')
<div id="user" class="panel panel-default">
	<div class="panel-heading"><b><h4>Data Pengguna</h4></b></div>
	<div class="panel-body">
	@include('_partial.flash_message')
	<div class="tombol-nav">
		<a href="user/create" class="btn btn-primary">Tambah User</a>
	</div>
	@if (count($user_list) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Username</th>
				<th>Level</th>
				<th>Lokasi</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; ?>
			<?php foreach($user_list as $user): ?>
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->username }}</td>
				@if($user->level == 'admin')
				<td>Admin Pusat</td>
				@elseif($user->level == 'grosir')
				<td>Grosir Pusat</td>
				@elseif($user->level == 'kasir')
				<td>Kasir Pusat</td>
				@elseif($user->level == 'kasircabang')
				<td>Kasir Cabang</td>
				@elseif($user->level == 'gudang')
				<td>Gudang</td>
				@endif
				<td>{{ $user->profile->nama }}</td>
				<td>
					<div class="box-button">
					{{ link_to('user/' . $user->id . '/edit', 'Edit', ['class' => 'btn btn-warning btn-sm']) }}
					</div>
					<div class="box-button">
					{!! Form::open(['method' => 'DELETE', 'action' => ['UserController@destroy', $user->id]]) !!}
					{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm'])!!}
					{!! Form::close()!!}
					</div>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data user.</p>
	@endif
</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop