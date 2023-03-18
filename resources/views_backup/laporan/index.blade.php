@extends('template')

@section('main')
<div id="laporan" class="panel panel-default">
	<div class="panel-heading"><b><h4>Laporan <?php echo ucfirst($jenis); ?></h4></b></div>
	<div class="panel-body">
	@include('laporan.form_pencarian_laporan')
	@if (count($laporan) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>Kode Transaksi</th>
				<th>Tanggal</th>
				<th>Jam</th>
				@if($jenis == 'semua')
				<th>Jenis Transaksi</th>
				@endif
				<th>Total Belanja</th>
				<th>Diskon</th>
				<th>Status Bayar</th>
				<th>Sub Total</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			function rupiah($nilai, $pecahan = 0) {
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
			?>
			<?php 
			$i=0; 
			$totalbelanja = 0;
			$totaldiskon = 0;
			$subtotal = 0;
			$ttransbeli = 0;
			$ttransretail = 0;
			$ttransgrosir = 0;
			?>
			@foreach($laporan as $transaksi)
			<tr>
				<td>{{ $transaksi->kodepenjualan }}</td>
				<td>{{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td>
				<td>{{ date('H:i:s', strtotime($transaksi->created_at))}}</td>
				@if($jenis == 'semua')
				<td><?php echo ucfirst($transaksi->jenis); ?></td>
				@endif
				<td>{{ rupiah($transaksi->totalbelanja) }}</td>
				<td>{{ rupiah($transaksi->totaldiskon) }}</td>
				@if($transaksi->status == 'belum')
				<td>
					<font color="red">Belum Lunas</font>
				</td>
				<td>{{ rupiah(0) }}</td>
				@else
				<td>
					<font color="green">
					<?php echo ucfirst($transaksi->status); ?>
					</font>
				</td>
				<td>{{ rupiah($transaksi->subtotal) }}</td>
				@endif
			</tr>
			<?php
			$totalbelanja = $totalbelanja + $transaksi->totalbelanja;
			$totaldiskon = $totaldiskon + $transaksi->totaldiskon;

			if($transaksi->status == 'lunas'){
			$subtotal = $subtotal + $transaksi->subtotal;
				if($transaksi->jenis == 'pembelian'){
					$ttransbeli = $ttransbeli + $transaksi->subtotal;
				}
				else if($transaksi->jenis == 'retail'){
					$ttransretail = $ttransretail + $transaksi->subtotal;
				}
				else if($transaksi->jenis == 'grosir'){
					$ttransgrosir = $ttransgrosir + $transaksi->subtotal;
				}
			}
			?>
			@endforeach

			@if($jenis == 'semua')
			<tr><td colspan="6" align="right"><b>TRANSAKSI PEMBELIAN</td><td><b> {{ rupiah($ttransbeli) }}</td></tr>
			<tr><td colspan="6" align="right"><b>TRANSAKSI RETAIL</td><td><b> {{ rupiah($ttransretail) }}</td></tr>
			<tr><td colspan="6" align="right"><b>TRANSAKSI GROSIR</td><td><b> {{ rupiah($ttransgrosir) }}</td></tr>
			@else
			<tr>
				<td colspan="3" align="right"><b>TOTAL TRANSAKSI</td>
				<td><b>{{ rupiah($totalbelanja) }}</td>
				<td><b>{{ rupiah($totaldiskon) }}</td>
				<td></td>
				<td><b>{{ rupiah($subtotal) }}</td>
			</tr>
			@endif
		</tbody>
	</table>
	@else
	<p>Tidak ada data transaksi.</p>
	@endif
	<!--Akhir Tampil Transaksi -->
	</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop