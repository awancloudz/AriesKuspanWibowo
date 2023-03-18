<?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=laporan_produk.xls");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Penjualan Produk</title>
        <style>
        @page { margin-top:15px;margin-left:10px;margin-right:5px;}
        body{
            font-family: helvetica;
            font-size: 9;
        }
        </style>
		<script type="text/javascript">
		$(document).ready(function() {
			
		//FORMAT RUPIAH
		function rupiah(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1))
		{
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return "Rp. " + x1 + x2;
		}
			<?php
				echo "var daftarproduk = '{$koleksiproduk}';";
				echo "var daftarjual = '{$koleksijual}';";
			?>
			//variable hitung
			var hargajual = 0;
			var jumlahterjual = 0;
			var jumlahharga = 0;
			var jumlahdiskon = 0;
			var jumlahbeli = 0;
			var omset = 0;
			var profit = 0;
			var kulakan = 0;
			var totalomset = 0;
			var totalbeli = 0;
			var totalprofit = 0;

			var arr1 = JSON.parse(daftarproduk);
			var arr2 = JSON.parse(daftarjual);
			var i=0;
			var j=0;
			var panjang1 = arr1.length;
			var panjang2 = arr2.length;
			var out = "<table class='table' width='100%'><thead><tr>"+
					"<tr><td colspan='10'><hr></td></tr>"+
					"<th>Merk/Brand</th>"+
					"<th>Nama Produk</th>"+
					"<th>Harga Beli</th>"+
					"<th>Harga Grosir</th>"+
					"<th>Harga Retail</th>"+
					"<th>Terjual</th>"+
					"<th>Omset</th>"+
					"<th>Total Beli</th>"+
					"<th>Profit</th>"+
					"<th>Sisa Stok</th></tr>"+
					"<tr><td colspan='10'><hr></td></tr>"+
					"</thead><tbody>";

			for(i=0; i < panjang1; i++){
				out+="<tr>"+
				"<td>"+ arr1[i].merk +"</td>"+
				"<td>"+ arr1[i].namaproduk +"</td>"+
				"<td>"+ rupiah(arr1[i].hargadistributor) +"</td>"+
				"<td>"+ rupiah(arr1[i].hargagrosir) +"</td>"+
				"<td>"+ rupiah(arr1[i].hargajual) +"</td>";

				for(j=0; j < panjang2; j++){
					if(arr1[i].id_produk == arr2[j].id_produk){
						jumlahterjual = jumlahterjual + arr2[j].jumlah;
						if(arr2[j].jenis == 'retail'){
							hargajual = arr1[i].hargajual;
						}
						else if(arr2[j].jenis == 'grosir'){
							hargajual = arr1[i].hargagrosir;
						}
						jumlahharga = jumlahharga + (arr2[j].jumlah * hargajual);
					}
				}

				jumlahdiskon = arr1[i].diskon;
				jumlahbeli =  arr1[i].hargadistributor;
				omset = jumlahharga - jumlahdiskon;
				kulakan = jumlahterjual * jumlahbeli;
				profit = omset - kulakan;

				out+="<td align='center'>"+ jumlahterjual +"</td>"+
					"<td>"+ rupiah(omset) +"</td>"+
					"<td>"+ rupiah(kulakan) +"</td>"+
					"<td>"+ rupiah(profit) +"</td>"+
					"<td>"+ arr1[i].stok +"</td>"+
					"</tr>";

				totalomset =totalomset + omset;
				totalbeli = totalbeli + kulakan;
				totalprofit = totalprofit + profit;
				jumlahterjual = 0; 
				jumlahharga = 0; 
				jumlahdiskon = 0; 
				jumlahbeli = 0; 
				omset = 0; 
				profit = 0; 
				hargajual = 0;
				kulakan = 0;
			}
			out+= "<tr><td colspan='10'><hr></td></tr>"+
			"<tr><td colspan='6' align='right'><b>TOTAL TRANSAKSI</td><td><b>"+ rupiah(totalomset) +"</td><td><b>"+ rupiah(totalbeli) +"</td><td><b>"+ rupiah(totalprofit) +"</td><td></td></tr>"+
			"</tbody></table>";
			document.getElementById("tampilproduk").innerHTML = out;
		});
		</script>
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
    <h3 align="center">LAPORAN PENJUALAN PRODUK PERIODE <br>
    Periode Transaksi ( {{ date('d-m-Y', strtotime($awalbulanini)) }} - {{ date('d-m-Y', strtotime($akhirbulanini)) }})
    </h3>
	@if (count($koleksiproduk) > 0)
	<div id="tampilproduk"></div>
	@else
	<p align="center">Tidak ada data produk terjual.</p>
	@endif
    </body>
</html>
