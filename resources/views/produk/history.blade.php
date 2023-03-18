@extends('template')

@section('main')
<div id="transaksi" class="panel panel-default">
<div class="panel-heading"><b><h4>DATA HISTORY</h4></b></div>
	<div class="panel-body">
	<a href="{{ URL::previous() }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a>
	<br>
	<!-- Tampil Transaksi -->
	@if (count($history_list) > 0)
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
			@foreach($history_list as $history)
			<tr>
				<td><?php echo $i; $i++;?></td>
				<td>{{ date('d-m-Y', strtotime($history->tanggal)) }}</td>
				<td>{{ date('H:i:s', strtotime($history->created_at))}}</td>
				<td>{{ $history->deskripsi }}</td>
				<td>{{ $history->namauser }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@else
	<p>Tidak ada data history.</p>
	@endif
	</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop