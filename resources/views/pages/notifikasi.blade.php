@extends('template')

@section('main')
<div id="transaksi" class="panel panel-default">
<div class="panel-heading"><b><h4>Notifikasi</h4></b></div>
	<div class="panel-body">
	<!-- Tampil Transaksi -->
	@if (count($notifikasi_list) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Deskripsi</th>
				<th>User</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=1; ?>
			@foreach($notifikasi_list as $notifikasi)
			<tr>
				<td><?php echo $i; $i++;?></td>
				<td>{{ date('d-m-Y', strtotime($notifikasi->tanggal)) }}</td>
				<td>{{ date('H:i:s', strtotime($notifikasi->created_at))}}</td>
				<td>{{ $notifikasi->deskripsi }}</td>
				<td>{{ $notifikasi->namauser }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@else
	<p>Tidak ada data notifikasi.</p>
	@endif
    <div class="table-nav">
	<div class="jumlah-data">
		<strong>Jumlah Notifikasi : {{ $jumlah_notifikasi}}</strong>
	</div>
	<div class="paging">
	{{ $notifikasi_list->links() }}
	</div>

	</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop