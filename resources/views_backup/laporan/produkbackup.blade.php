@extends('template')

@section('main')
<style>
.loader,
.loader:before,
.loader:after {
  background: #1b8ce0;
  -webkit-animation: load1 1s infinite ease-in-out;
  animation: load1 1s infinite ease-in-out;
  width: 1em;
  height: 4em;
}
.loader {
  color: #1b8ce0;
  text-indent: -9999em;
  margin: 88px auto;
  position: relative;
  font-size: 11px;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}
.loader:before,
.loader:after {
  position: absolute;
  top: 0;
  content: '';
}
.loader:before {
  left: -1.5em;
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}
.loader:after {
  left: 1.5em;
}
@-webkit-keyframes load1 {
  0%,
  80%,
  100% {
    box-shadow: 0 0;
    height: 4em;
  }
  40% {
    box-shadow: 0 -2em;
    height: 5em;
  }
}
@keyframes load1 {
  0%,
  80%,
  100% {
    box-shadow: 0 0;
    height: 4em;
  }
  40% {
    box-shadow: 0 -2em;
    height: 5em;
  }
}
</style>
<div id="laporan" class="panel panel-default">
	<div class="panel-heading"><b><h4>Laporan <?php echo ucfirst($jenis); ?></h4></b></div>
	<div class="panel-body">
	@include('laporan.form_pencarian_laporan')
	@if (count($koleksiproduk) > 0)
		<div class="loader">Loading...</div>
		<div id="tampilproduk"></div>
	@else
	<p>Tidak ada data produk terjual.</p>
	@endif
	</div>
</div>

<script>
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
	var out = "<table class='table'><thead><tr>"+
			"<th>Merk/Brand Produk</th>"+
			"<th>Nama Produk</th>"+
			"<th>Harga Beli</th>"+
			"<th>Harga Grosir</th>"+
			"<th>Harga Retail</th>"+
			"<th>Terjual</th>"+
			"<th>Omset</th>"+
			"<th>Total Beli</th>"+
			"<th>Profit</th>"+
			"<th>Sisa Stok</th>"+
			"</tr></thead><tbody>";

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

		out+="<td>"+ jumlahterjual +"</td>"+
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
	out+="<tr><td colspan='6' align='right'><b>TOTAL TRANSAKSI</td><td><b>"+ rupiah(totalomset) +"</td><td><b>"+ rupiah(totalbeli) +"</td><td><b>"+ rupiah(totalprofit) +"</td><td></td></tr>"
	"</tbody></table>";
	document.getElementById("tampilproduk").innerHTML = out;
	$(".loader").hide();
</script>
@stop

@section('footer')
	@include('footer')
@stop