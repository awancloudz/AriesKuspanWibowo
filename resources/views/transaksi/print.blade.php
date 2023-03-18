<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Transaksi</title>
        <style>
        @page { margin-top:30px;margin-bottom:15px;margin-right:15px;margin-left:15px;}
        body{
            font-family: helvetica;
            font-size: 10;
        }
        </style>
    </head>
        <body>  
    <?php 
    function rupiah($nilai, $pecahan = 0) {
    return "Rp. " . number_format($nilai, $pecahan, ',', '.');
    }
    $diskonrpall = 0; 
    $diskonperall = 0; 
    ?>
<table width="100%">
@foreach($profiletoko as $toko)
<tr><td width="40%" style="font-size: 20;"><b><?php echo strtoupper($toko->nama); ?></b></td><td width="10%"><b>
@if($transaksi->jenis == 'pembelian')
Distributor
@elseif($transaksi->jenis == 'kirimcabang')
<?php
foreach($transaksi->pengiriman as $kirim){
    $namacabang = $kirim->profile->nama;
    $alamatcabang = $kirim->profile->alamat;
    $telpcabang = $kirim->profile->notelp;
}
?>
Cabang
@else
Customer
@endif
</td>
@if($transaksi->jenis == 'kirimcabang')
<td  width="20%">: {{ $namacabang }}</td>
@else
<td  width="20%">: {{ $transaksi->customer->nama }}</td>
@endif

<td><b>Transaksi</td><td width="20%">: <?php echo ucfirst($transaksi->jenis); ?></td></tr>
<tr><td><b>NPWP: 93.225.482.4-508.000</td><td><b></td><td></td>
<tr><td><b>{{ $toko->alamat }}</td><td><b>Alamat</td>

@if($transaksi->jenis == 'kirimcabang')
<td  width="20%">: {{ $alamatcabang }}</td>
@else
<td>: {{ $transaksi->customer->alamat }}</td>
@endif

<td><b>Tanggal</td><td>: {{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td></tr>
<tr><td><b>{{ $toko->kota }} - {{ $toko->notelp }}</td><td><b>No.Telepon</td>

@if($transaksi->jenis == 'kirimcabang')
<td  width="20%">: {{ $telpcabang }}</td>
@else
<td>: {{ $transaksi->customer->notelp }}</td>
@endif

<td><b>Jam</td><td>: {{ date('H:i:s', strtotime($transaksi->created_at))}}</td>
</tr>
<tr><td colspan="3"></td><th>Kasir</th><td>: {{ $transaksi->users->name }}</td></tr>
@endforeach
</table><br>
<h3 align="center">FAKTUR PENJUALAN</h3>
<hr>
<!-- <table width="100%">
<tr><th>Kode Transaksi</th><td>{{ $transaksi->kodepenjualan }}
    /*<?php
        echo DNS1D::getBarcodeHTML($transaksi->kodepenjualan, "C128");
    ?>
</td></tr>
</table><br> -->
<h4 align="center"><u>DAFTAR PRODUK YANG DIBELI</u></h4>
<table width="100%">
@if($transaksi->statusdiskon == 'ya')
<tr><th>Kode</th><th>Nama Produk</th><th>Merk</th><th>Harga</th><th>Qty</th><th>Disc(Rp)</th><th>Disc(%)</th><th>Total</th></tr>
@elseif($transaksi->statusdiskon == 'tidak')
<tr><th>Kode</th><td colspan="2"><b>Nama Produk</td><td colspan="2"><b>Merk</td><th>Harga</th><th>Qty</th><th>Total</th></tr>
@endif
<tr><td colspan="8"><hr></td></tr>
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
$nominal1 = $item->diskonrp;
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
else if($transaksi->jenis == 'kirimcabang'){
$nominal2 = ($item->diskon / 100) * $item->produk->hargagrosir;
$nominal = $nominal1 + $nominal2;   
$totalbeli =  ($item->produk->hargagrosir * $item->jumlah) - ($item->jumlah * $nominal);
}
$diskonrpall = $diskonrpall + $nominal1;
$diskonperall = $diskonperall + $item->diskon;
?>
@if($transaksi->statusdiskon == 'ya')
<tr valign="top"><td width="15%">{{ $item->produk->kodeproduk }}</td><td width="25%">{{ $item->produk->namaproduk }}</td><td>{{ $item->produk->merk->nama }}</td>
    @if($transaksi->jenis == 'pembelian')
    <td width="10%">{{ rupiah($item->produk->hargadistributor) }}</td>
    @elseif($transaksi->jenis == 'retail')
        @if($transaksi->statustoko == 'cabang')
        <td width="10%">{{ rupiah($hargacabang) }}</td>
        @else
        <td width="10%">{{ rupiah($item->produk->hargajual) }}</td>
        @endif
    @elseif($transaksi->jenis == 'grosir')
    <td width="10%">{{ rupiah($item->produk->hargagrosir) }}</td>
    @elseif($transaksi->jenis == 'kirimcabang')
    <td width="10%">{{ rupiah($item->produk->hargagrosir) }}</td>
    @endif
    <td>{{ $item->jumlah }}</td><td width="10%">{{ rupiah($item->diskonrp) }}</td><td>{{ $item->diskon }} %</td><td width="15%">{{ rupiah($totalbeli) }}</td></tr>
@elseif($transaksi->statusdiskon == 'tidak')
<tr valign="top"><td width="15%">{{ $item->produk->kodeproduk }}</td><td width="35%" colspan="2">{{ $item->produk->namaproduk }}</td><td colspan="2">{{ $item->produk->merk->nama }}</td>
    <td width="10%">{{ rupiah($totalbeli/$item->jumlah) }}</td>
    <td>{{ $item->jumlah }}</td><td width="15%">{{ rupiah($totalbeli) }}</td></tr>
@endif

@endforeach

<tr><td colspan="8"><hr></td></tr>
@if($transaksi->statusdiskon == 'ya')
<tr><td colspan="5"></td><td><b>{{ rupiah($diskonrpall) }}</td><td><b>{{ $diskonperall }} %</td><td><b>{{ rupiah($transaksi->subtotal) }}</td></tr>
@elseif($transaksi->statusdiskon == 'tidak')
<tr><td colspan="7"></td><td><b>{{ rupiah($transaksi->subtotal) }}</td></tr>
@endif
<tr><td colspan="8"><hr></td></tr>
<!-- <tr><td colspan="5"></td><td colspan="2"><b>Total Belanja</td><th>{{ rupiah($transaksi->totalbelanja) }}</th></td> -->
<tr><td colspan="5"></td><td colspan="2"><b>Diskon</td><th>{{ rupiah($transaksi->totaldiskon) }}</th></tr>
<!-- <tr><td colspan="5"></td><td colspan="2"><b>PPn</td><th>{{ rupiah(0) }}</th></tr> -->
<tr><td colspan="5"></td><td colspan="2"><b>Sub Total</td><th>{{ rupiah($transaksi->subtotal) }}</th></tr>
<tr>
<td><br><br><b>Tanda Terima
<br><br><br><br><br><hr></b></td>
<td></td>
@if($transaksi->jenis == 'grosir')
<td colspan="2"><br><br><b>Supir
<br><br><br><br><br><hr></b></td>
<td colspan="2"></td>
@elseif($transaksi->jenis == 'kirimcabang')
<td colspan="2"><br><br><b>Supir
<br><br><br><br><br><hr></b></td>
<td colspan="2"></td>
@else
<td colspan="4"></td>
@endif
<td colspan="2" align="center">
@foreach($profiletoko as $toko)
<br><br><b>{{ $toko->kota }}, {{ date('d-m-Y', strtotime($transaksi->tanggal)) }}<br>Hormat Kami
<br><br><br><br><br><hr>{{ $toko->nama }}</b>
@endforeach
</td></tr>
<tr><td colspan="8">- Harga sudah termasuk PPn 11%<br>- Barang yang sudah dibeli tidak bisa dikembalikan</td></tr>
</table>
</div>
</div>
</div>
        <script type="text/javascript">
          print();
        </script>
        </body>
</html>