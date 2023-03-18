<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Produk</title>
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
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
	  ?>
@if (count($daftarproduk) > 0)
	<table width="100%">
        @foreach($daftarproduk as $produk)
        <tr><td><b><?php echo strtoupper($produk->namaproduk); ?></b></td></tr>
        <tr><td><b>{{ rupiah($produk->hargajual) }}</b></td></tr>
        <tr>
        <td>
        <?php
		echo DNS1D::getBarcodeHTML($produk->kodeproduk, "C128",1.2,40);
		?>
        </td>
        </tr>
        <tr><td><b>{{ $produk->kodeproduk }}</b></td></tr>
        @endforeach
	</table>
@else
	<p>Tidak ada data produk.</p>
@endif
        <script type="text/javascript">
          print();
        </script>
        </body>
</html>