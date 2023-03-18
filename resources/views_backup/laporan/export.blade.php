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
        <tr align="center"><td colspan="7"><h3><?php echo strtoupper($toko->nama); ?></h3></td></tr>
        <tr align="center"><td colspan="7"><b>NPWP: 93.225.482.4-508.000</b></td></tr>
        <tr align="center"><td colspan="7">{{ $toko->alamat }}</td></tr>
        <tr align="center"><td colspan="7">{{ $toko->kota }} - {{ $toko->notelp }}</td></tr>
        @endforeach
        </table><br><hr>
        <h3 align="center">LAPORAN TRANSAKSI - <?php echo strtoupper($jenis); ?><br>
        Periode Transaksi ( {{ date('d-m-Y', strtotime($awalbulanini)) }} - {{ date('d-m-Y', strtotime($akhirbulanini)) }})
        </h3>
        @if (count($laporan) > 0)
        <table width="100%">
            <thead>
            <tr><td colspan="6"><hr></td></tr>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <!--<th>Jam</th>-->
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
            <tr><td colspan="6"><hr></td></tr>
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
                    <!--<td>{{ date('H:i:s', strtotime($transaksi->created_at))}}</td>-->
                    @if($jenis == 'semua')
                    <td><?php echo ucfirst($transaksi->jenis); ?></td>
                    @endif
                    <td>{{ rupiah($transaksi->totalbelanja) }}</td>
                    <td>{{ rupiah($transaksi->totaldiskon) }}</td>
                    @if($transaksi->status == 'belum')
                    <td>
                        <font color="red">
                        <?php echo ucfirst($transaksi->status); ?>
                        </font>
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
            <tr><td colspan="6"><hr></td></tr>
                @if($jenis == 'semua')
                <tr><td colspan="6" align="right"><b>Transaksi Pembelian</td><td><b> {{ rupiah($ttransbeli) }}</td></tr>
                <tr><td colspan="6" align="right"><b>Transaksi Retail</td><td><b> {{ rupiah($ttransretail) }}</td></tr>
                <tr><td colspan="6" align="right"><b>Transaksi Grosir</td><td><b> {{ rupiah($ttransgrosir) }}</td></tr>
                @else
                <tr>
                    <td colspan="2" align="right"><b>Total Transaksi</td>
                    <td><b>{{ rupiah($totalbelanja) }}</td>
                    <td><b>{{ rupiah($totaldiskon) }}</td>
                    <td></td>
                    <td><b>{{ rupiah($subtotal) }}</td>
                </tr>
                @endif
            </tbody>
        </table>
        @else
        <p align="center">Tidak ada data transaksi.</p>
        @endif
        </body>
</html>