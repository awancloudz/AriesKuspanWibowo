<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_labarugi.xls");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Laba / Rugi</title>
        <style>
        @page { margin-top:15px;}
        body{
            font-family: helvetica;
            font-size: 10;
        }
        </style>
    </head>
    <body>  
    <table width="100%">
    @foreach($profiletoko as $toko)
    <tr align="center"><td colspan="7"><h3><?php echo strtoupper($toko->nama); ?></h3></td></tr>
	<tr align="center"><td colspan="7"><b>NPWP: 93.225.482.4-508.000</b></td></tr>
    <tr align="center"><td colspan="7">{{ $toko->alamat }}</td></tr>
    <tr align="center"><td colspan="7">{{ $toko->kota }} - {{ $toko->notelp }}</td></tr>
    @endforeach
    </table><br><hr>
    <h3 align="center">LAPORAN LABA/RUGI PERIODE <br>
    Periode Transaksi ( {{ date('d-m-Y', strtotime($awalbulanini)) }} - {{ date('d-m-Y', strtotime($akhirbulanini)) }})
    </h3>
    @if (count($laporan) > 0)
	<table width="100%">
		<thead>
            <tr><td colspan="7"><hr></td></tr>
			<tr>
				<th>Kode Transaksi</th>
				<th>Tanggal</th>
				<th>Pengeluaran</th>
				<th>Penerimaan</th>
				<th>Diskon</th>
				<th>Status Bayar</th>
				<th>Saldo Akhir</th>
			</tr>
            <tr><td colspan="7"><hr></td></tr>
		</thead>
		<tbody>
			<?php 
			function rupiah($nilai, $pecahan = 0) {
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
			?>
			<?php 
			$i=0; 
			//Hitung Omset
			$pengeluaran = 0;
			$penerimaan = 0;
			$discpengeluaran = 0;
			$discpenerimaan = 0;
			$saldoakhir = 0;
			
			//Hitung Profit
			$hargabeli = 0;
			$hargajual = 0;
			$totalbeli = 0;
			$totaljual = 0;
			
			$profit = 0;
			$profittotal = 0 ;
			?>
			@foreach($laporan as $transaksi)
				@foreach($transaksi->detailpenjualan as $detail)
				<!-- BAGIAN PROFIT -->
				<?php
				$hargabeli = 0;
				$hargajual = 0;
				$profit = 0;
				?>
					@if($detail->transaksipenjualan->jenis == 'retail')
					<?php 
					$hargabeli = $detail->jumlah * ($detail->produk->hargadistributor - $detail->produk->diskon); 
					$hargajual = $detail->jumlah * ($detail->produk->hargajual - $detail->produk->diskon);
					$profit = $hargajual - $hargabeli;
					?>
					@elseif($detail->transaksipenjualan->jenis == 'grosir')
					<?php 
					$hargabeli = $detail->jumlah * ($detail->produk->hargadistributor - $detail->produk->diskon); 
					$hargajual = $detail->jumlah * ($detail->produk->hargagrosir - $detail->produk->diskon);
					$profit = $hargajual - $hargabeli;
					?>
					@endif
					<?php $profittotal = $profittotal + $profit; ?>
				@endforeach

				<!-- BAGIAN OMSET -->
				<tr>
				<td>{{ $transaksi->kodepenjualan }}</td>
				<td>{{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td>
				@if($transaksi->jenis == 'pembelian')
				<td>{{ rupiah($transaksi->totalbelanja) }}</td><td></td><td>{{ rupiah($transaksi->totaldiskon) }}</td>
					@if($transaksi->status == 'lunas')
					<?php
					$saldoakhir = $saldoakhir - ($transaksi->totalbelanja - $transaksi->totaldiskon);
					$pengeluaran = $pengeluaran + $transaksi->totalbelanja;
					$discpengeluaran = $discpengeluaran + $transaksi->totaldiskon;
					?>
					@endif
				@else
				<td></td><td>{{ rupiah($transaksi->totalbelanja) }}</td><td>{{ rupiah($transaksi->totaldiskon) }}</td>
					<?php
					$saldoakhir = $saldoakhir + ($transaksi->totalbelanja - $transaksi->totaldiskon);
					$penerimaan = $penerimaan + $transaksi->totalbelanja;
					$discpenerimaan = $discpenerimaan + $transaksi->totaldiskon;
					?>
				@endif
				@if($transaksi->status == 'belum')
				<td>
					<font color="red">
					<?php echo ucfirst($transaksi->status); ?>
					</font>
				</td>
				@else
				<td>
					<font color="green">
					<?php echo ucfirst($transaksi->status); ?>
					</font>
				</td>
				@endif
				<td>{{ rupiah($saldoakhir) }}</td>
				</tr>
			@endforeach
			<?php $omset = $penerimaan - $pengeluaran; ?>
            <tr><td colspan="7"><hr></td></tr>
			<tr><td colspan="6" align="right"><b>PENGELUARAN</td><td><b>{{ rupiah($pengeluaran) }}</td></tr>
			<tr><td colspan="6" align="right"><b>TOTAL PENGELUARAN</b> <i>(Pengeluaran - Diskon)</i></td><td><b>{{ rupiah($pengeluaran - $discpengeluaran) }}</td></tr>
			<tr><td colspan="6" align="right"><b>PENERIMAAN</td><td><b>{{ rupiah($penerimaan) }}</td></tr>
			<tr><td colspan="6" align="right"><b>TOTAL OMZET</b> <i>(Penerimaan - Diskon)</i></td><td><b>{{ rupiah($penerimaan - $discpenerimaan) }}</td></tr>
			<tr><td colspan="6" align="right"><b>TOTAL PROFIT</b> <i>(Penghasilan Bersih)</i></td><td><b>{{ rupiah($profittotal) }}</td></tr>
		</tbody
	</table>
	@else
	<p align="center">Tidak ada data transaksi.</p>
	@endif
    <script type="text/javascript">
        print();
    </script>
    </body>
</html>