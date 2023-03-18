@extends('template')

@section('main')
<div id="transaksi" class="panel panel-default">
	<div class="panel-heading"><b><h4>Data Transaksi Cabang</h4></b></div>
	<div class="panel-body">
	@include('_partial.flash_message')
	<br>
	<!-- Tampil Transaksi -->
	@if (count($transaksi_list) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>Kode Transaksi</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Total Belanja</th>
				<th>Diskon</th>
				<th>Sub Total</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			function rupiah($nilai, $pecahan = 0) {
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
			?>
			<?php $i=0; ?>
			<?php foreach($transaksi_list as $transaksi): ?>
			<tr>
				<td>{{ $transaksi->kodepenjualan }}</td>
				<td>{{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td>
				<td>{{ date('H:i:s', strtotime($transaksi->created_at))}}</td>
				<td>{{ rupiah($transaksi->totalbelanja) }}</td>
				<td>{{ rupiah($transaksi->totaldiskon) }}</td>
				<td>{{ rupiah($transaksi->subtotal) }}</td>
				<td>
					<div class="box-button"> 
					<a href="{{ url('transaksi/view/' . $transaksi->id) }}" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-search"></i> Detail</a>
					</div>
					<div class="box-button">
						{!! Form::open(['method' => 'DELETE', 'action' => ['TransaksiPenjualanController@destroy2',$transaksi->id], 'onSubmit' => 'return ConfirmDelete()']) !!}
						{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
						{!! Form::close()!!}
					</div>
					<div class="box-button">
					<a href="{{ url('transaksi/print/' . $transaksi->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Faktur</a>
					</div>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data transaksi.</p>
	@endif
	<div class="table-nav">
	<div class="jumlah-data">
		<strong>Jumlah Transaksi : {{ $jumlah_transaksi}}</strong>
	</div>
	<div class="paging">
	{{ $transaksi_list->links() }}
	</div>
	</div>
	<!--Akhir Tampil Transaksi -->
	</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop