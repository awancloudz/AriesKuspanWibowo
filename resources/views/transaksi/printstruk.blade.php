<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Transaksi</title>
        <style>
        @page { margin-top:4px;margin-left:0.5px;margin-right:1px;}
        body{
            font-family: helvetica;
            font-size: 7;
        }
        </style>
    </head>
        <body>  
        <?php 
            function rupiah($nilai, $pecahan = 0) {
            return number_format($nilai, $pecahan, ',', '.');
            } 
            $i=1;
        ?>
<table width="100%">
@foreach($profiletoko as $toko)
<tr><td><b><?php echo strtoupper($toko->nama); ?></b></td></tr>
<tr><td><b>NPWP: 93.225.482.4-508.000</b></td></tr>
<tr><td>{{ $toko->alamat }}</td></tr>
<tr><td><b>{{ $toko->notelp }}</b></td></tr>
@endforeach
<tr><td>-------------------------------------------------</td></tr>
</table>

<table width="100%">
<tr><td><b>Tanggal</td><td>: {{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td></tr>
<tr><td><b>Jam</td><td>: {{ date('H:i:s', strtotime($transaksi->created_at))}}</td></tr>
<tr><td><b>Kasir</td><td>: {{ $transaksi->users->name }}</td></tr>
<tr><td colspan="2">-------------------------------------------------</td></tr>
</table>
<table width="100%">
<tr><th>Nama</th><th>Harga</th><td align="center"><b>Total</td></tr>
@foreach($transaksi->detailpenjualan as $item)
    @if($transaksi->statustoko == 'cabang')
	@foreach($item->produk->produkcabang as $cabang)
		<?php 
		if($transaksi->profile->id == $cabang->profile->id){
			$hargacabang = $cabang->hargajual;
		}
		?>
	@endforeach
	@else
		<?php
			$hargacabang = 0;
		?>
	@endif
<?php
$nominal1 = $item->diskon;
if($transaksi->jenis == 'pembelian'){
$nominal2 = ($item->diskon / 100) * $item->produk->hargadistributor;
$nominal = $nominal1 + $nominal2;
$totalbeli =  ($item->produk->hargadistributor * $item->jumlah) - ($item->jumlah * $nominal);
}
else if($transaksi->jenis == 'retail'){
    if($transaksi->statustoko == 'cabang'){
		$nominal2 = ($item->diskon / 100) * $hargacabang;
		$nominal = $nominal1 + $nominal2;
		$totalbeli =  ($hargacabang * $item->jumlah) - ($item->jumlah * $nominal);
	}
	else{
		$nominal2 = ($item->diskon / 100) * $item->produk->hargajual;
		$nominal = $nominal1 + $nominal2;
		$totalbeli =  ($item->produk->hargajual * $item->jumlah) - ($item->jumlah * $nominal);
	}
}
else if($transaksi->jenis == 'grosir'){
$nominal2 = ($item->diskon / 100) * $item->produk->hargagrosir;
$nominal = $nominal1 + $nominal2;	
$totalbeli =  ($item->produk->hargagrosir * $item->jumlah) - ($item->jumlah * $nominal);
}
?>
<tr style="font-size: 6;" valign="top"><td width="30%">{{ $item->produk->namaproduk }}</td>
@if($transaksi->jenis == 'pembelian')
<td>{{ rupiah($item->produk->hargadistributor) }}</td>
@elseif($transaksi->jenis == 'retail')
<td width="30%">
@if($transaksi->statustoko == 'cabang')
{{ $item->jumlah }} X {{ rupiah($hargacabang) }}
@else
{{ $item->jumlah }} X {{ rupiah($item->produk->hargajual) }}
@endif
    @if($item->diskonrp != 0)
    <br>- Diskon 1
    @endif
    @if($nominal2 != 0)
    <br>- Diskon 2
    @endif
</td>
@elseif($transaksi->jenis == 'grosir')
<td>{{ rupiah($item->produk->hargagrosir) }}</td>
@endif
	<td width="30%" align="right">{{ rupiah($totalbeli) }}<br>
    @if($item->diskonrp != 0)
    ({{ rupiah($item->jumlah * $item->diskonrp) }})<br>
    @endif
    @if($nominal2 != 0)
    ({{ rupiah($item->jumlah * $nominal2) }})
    @endif
    </td></tr>
    <?php $i++; ?>
@endforeach
<tr><td colspan="3">-------------------------------------------------</td></tr>
<tr><td align="right" width="30%"><b>Total Belanja</td><td align="right" colspan="2">{{ rupiah($transaksi->totalbelanja) }}</td>
<tr><td align="right" width="30%"><b>Total Diskon</td><td align="right" colspan="2">{{ rupiah($transaksi->totaldiskon) }}</td></tr>
<tr><td align="right" width="30%"><b>Sub Total</td><td align="right" colspan="2">{{ rupiah($transaksi->subtotal) }}</td></tr>
<tr><td align="right" width="30%"><b>Bayar</td><td align="right" colspan="2">{{ rupiah($transaksi->bayar) }}</td></tr>
<tr><td align="right" width="30%"><b>Kembali</td><td align="right" colspan="2">{{ rupiah($transaksi->kembali) }}</td></tr>
<tr><td align="left" width="30%" colspan="3"><hr>- Harga sudah termasuk PPN 11%<br>- Barang yang sudah dibeli tidak bisa dikembalikan.</td></tr>
</table>
</div>
</div>
</div>
        <script type="text/javascript">
           print();
        </script>
        </body>
</html>