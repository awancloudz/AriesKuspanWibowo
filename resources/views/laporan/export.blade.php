<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_transaksi.xls");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Transaksi</title>
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
            <tr align="center"><td colspan="5"><h3><?php echo strtoupper($toko->nama); ?></h3></td></tr>
            <tr align="center"><td colspan="5"><b>NPWP: 93.225.482.4-508.000</b></td></tr>
            <tr align="center"><td colspan="5">{{ $toko->alamat }}</td></tr>
            <tr align="center"><td colspan="5">{{ $toko->kota }} - {{ $toko->notelp }}</td></tr>
            <tr align="center" style="border-bottom: 1px solid black;"><td colspan="5"></td></tr>
            @endforeach
            <tr align="center"><td colspan="5"><h3 align="center">LAPORAN TRANSAKSI - <?php echo strtoupper($jenis); ?></h3></td></tr>
            <tr align="center"><td colspan="5"><h3 align="center"> Periode Transaksi ( {{ date('d-m-Y', strtotime($awalbulanini)) }} - {{ date('d-m-Y', strtotime($akhirbulanini)) }})</h3></td></tr>
            <tr align="center" style="border-bottom: 1px solid black;"><td colspan="5"></td></tr>
            <tr><td colspan="5"></td></tr>
        </table>
       
        @if (count($laporan) > 0)
        <table width="100%" border>
            <tbody>
                <?php 
                function rupiah($nilai, $pecahan = 0) {
                return "Rp. " . number_format($nilai, $pecahan, ',', '.');
                } 
                ?>
                <?php 
                $i=0;
                $no=1; 
                $totalbelanja = 0;
                $totaldiskon = 0;
                $subtotal = 0;
                $ttransbeli = 0;
                $ttransretail = 0;
                $ttransgrosir = 0;
                ?>
                @foreach($laporan as $transaksi)
                <tr style="vertical-align: middle;text-align:center;font-weight: bold;">
                <?php 
                $baris = count($transaksi->detailpenjualan) + 5;
                ?>
                <td rowspan="{{ $baris }}">{{ $no }}</td>
                <td colspan="2">Kode Transaksi: {{ $transaksi->kodepenjualan }}</td>
                <td>Tanggal: {{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td>
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
                </tr>
                <tr style="text-align:center;font-weight: bold;"><td>Nama Produk</td><td>Jumlah</td><td>Harga</td><td>Total</td></tr>
                @foreach($transaksi->detailpenjualan->sortBy('id_produk') as $item)
                    <tr><td>{{$item->produk->namaproduk}}</td><td align="center">{{$item->jumlah}}</td>
                    <!-- CATATAN HARGA FIX (Harga saat transaksi), perlu sinkron semua data
                    DATA YANG HARUS DIUBAH :
                    - Detail/Show Transaksi
                    - Cetak Faktur / Struk
                    - Export Excel-->
                    @if($transaksi->jenis == 'retail')
                    <td>{{rupiah($item->hargajual)}}</td>
                    <td>{{rupiah($item->hargajual * $item->jumlah)}}</td>
                    @elseif($transaksi->jenis == 'grosir')
                    <td>{{rupiah($item->hargagrosir)}}</td>
                    <td>{{rupiah($item->hargagrosir * $item->jumlah)}}</td>
                    @elseif($transaksi->jenis == 'pembelian')
                    <td>{{rupiah($item->hargadistributor)}}</td>
                    <td>{{rupiah($item->hargadistributor * $item->jumlah)}}</td>
                    @endif
                @endforeach
                <tr style="font-weight: bold;"><td colspan="3">Total Belanja</td><td>{{ rupiah($transaksi->totalbelanja) }}</td></tr>
                <tr style="font-weight: bold;"><td colspan="3">Total Diskon</td><td>{{ rupiah($transaksi->totaldiskon) }}</td></tr>
                <tr style="font-weight: bold;"><td colspan="3">Sub Total</td><td>{{ rupiah($transaksi->subtotal) }}</td></tr>
                <tr height="3"><td colspan="5"></td></tr>
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
                <?php $no++; ?>
                @endforeach
                <tr><td colspan="5"></td></tr>
                @if($jenis == 'semua')
                <tr><td colspan="4"><b>Transaksi Pembelian</td><td><b> {{ rupiah($ttransbeli) }}</td></tr>
                <tr><td colspan="4"><b>Transaksi Retail</td><td><b> {{ rupiah($ttransretail) }}</td></tr>
                <tr><td colspan="4"><b>Transaksi Grosir</td><td><b> {{ rupiah($ttransgrosir) }}</td></tr>
                @else
                <tr style="font-weight: bold;">
                    <td colspan="4">Total Transaksi Belanja</td>
                    <td>{{ rupiah($totalbelanja) }}</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td colspan="4">Total Diskon Transaksi</td> 
                    <td>{{ rupiah($totaldiskon) }}</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td colspan="4">Sub Total Semua Transaksi</td> 
                    <td>{{ rupiah($subtotal) }}</td>
                </tr>
                @endif
            </tbody>
        </table>
        @else
        <p align="center">Tidak ada data transaksi.</p>
        @endif
        </body>
</html>