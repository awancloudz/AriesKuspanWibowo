<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Produk</title>
        <style>
        @page { margin-top:15px;}
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
	  ?>
  @if (count($daftarproduk) > 0)
  <table width="100%">
  @foreach($profiletoko as $toko)
  <tr align="center"><td><h3><?php echo strtoupper($toko->nama); ?></h3></td></tr>
  <tr align="center"><td>{{ $toko->alamat }}</td></tr>
  <tr align="center"><td>{{ $toko->kota }} - {{ $toko->notelp }}</td></tr>
  @endforeach
  </table><br><hr>
	<table width="100%">
		<tbody>
      <tr><td colspan="5" align="center"><h3>DAFTAR HARGA PER TANGGAL 
        <?php 
        $hariini = date("Y-m-d");
        echo date('d-m-Y', strtotime($hariini)); 
        ?></h3>
      </td></tr>
			@foreach($daftarmerk as $merk)
        <tr><td colspan="5" align="center"><b><?php echo strtoupper($merk->merk->nama); ?></b></td></tr>
        <tr><td colspan="5"><hr></td></tr>
        <tr>
          <th>Kode</th>
          <th>Nama Produk</th>
          <!-- <th>Harga Beli</th> -->
          <th>Harga Grosir</th>
          <th>Harga Retail</th>
          <th>Diskon</th>
        </tr>
        <tr><td colspan="5"><hr></td></tr>
        @foreach($daftarproduk as $produk)
          @if($merk->merk->id == $produk->id_merk)
          <tr>
          <td>{{ $produk->kodeproduk }}</td>
          <td>{{ $produk->namaproduk }}</td>
          <!-- <td>{{ rupiah($produk->hargadistributor) }}</td> -->
          <td>{{ rupiah($produk->hargagrosir) }}</td>
          <td>{{ rupiah($produk->hargajual) }}</td>
          <td>{{ rupiah($produk->diskon) }}</td>
          </tr>
          @endif
        @endforeach
        <tr><td colspan="5"><hr><br></td></tr>
		  @endforeach
		</tbody>
	</table>
	@else
	<p>Tidak ada data produk.</p>
	@endif
        
        <script type="text/javascript">
          print();
        </script>
        </body>
</html>