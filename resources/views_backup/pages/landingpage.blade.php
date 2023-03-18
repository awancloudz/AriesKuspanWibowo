<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistem Informasi Penjualan</title>
<script src="{{ asset ('js/moment.min.js')}}"></script>
<link href="{{ asset ('bootstrap_3_3_6/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset ('css/style.css')}}" rel="stylesheet">
<script src="{{ asset ('js/jquery_2_2_1.min.js')}}"></script>
<script src="{{ asset ('js/accounting.js')}}"></script>
<link href="{{ asset ('select2/select2.min.css')}}" rel="stylesheet">
<script src="{{ asset ('select2/select2.min.js')}}"></script>
<link href="{{ asset ('css/jquery.dataTables.min.css')}}" rel="stylesheet">
<script src="{{ asset ('js/jquery.dataTables.min.js')}}"></script>
<!-- [if lt IE 9]>
<script src="{{ asset ('http://laravelapp.dev/js/htmlshiv_3_7_2.min.js')}}"></script>
<script src="{{ asset ('http://laravelapp.dev/js/respond_1_4_2.min.js')}}"></script>
-->
</head>
<body>
<br>
<div id="homepage" class="panel panel-default">
	<div class="panel-heading" align="center">
	<h3>CV.ARIES KUSPAN WIBOWO</h3>
	<h5>Jl. Kanal No. 638 D, Lamper Lor, Semarang Selatan<br>
	(024) 8416242 / (024) 76443647 081214332881 / 081325607121
	</h5>
	</div>
	<div class="panel-body">
	@if (count($produk_list) > 0)
	<table id="tabelproduk" class="table display compact">
		<thead>
			<tr>
				<th>Kode Produk</th>
				<th>Nama Produk</th>
				<th>Merk/Brand</th>
				<th>Harga</th>
				<th>Stok</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; ?>
			<?php 
			function rupiah($nilai, $pecahan = 0) {
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
			?>
			<?php foreach($produk_list as $produk): ?>
			<tr>
				<td>{{ $produk->kodeproduk }}</td>
				<td>{{ $produk->namaproduk }}</td>
				<td>{{ $produk->merk->nama }}</td>
				<td>{{ rupiah($produk->hargajual) }}</td>
				@if($produk->stok <= 5)
				<td><font color="red"><b>{{ $produk->stok }}</font></td>
				@else
				<td>{{ $produk->stok }}</td>
				@endif
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data produk.</p>
	@endif
	</div>
</div>
<script>
$(document).ready(function(){
	//Data Tabel CSS
	$('#tabelproduk').DataTable({
		"oLanguage": {
		"sSearch": "",
		"sSearchPlaceholder": "Pencarian Nama Produk / Merk",
		},
		"pageLength": 50,
		"lengthChange": false,
	});
	$('.dataTables_filter').addClass('pull-left input-group');
	$('.dataTables_filter input[type=search]').addClass('form-control');
	$('.dataTables_filter input[type="search"]').css(
     {'width':'400px','border-radius':'5px','margin-left':'1px'}
  	);
	$('.dataTables_length').addClass('pull-right');
});
</script>
<script src="{{ asset ('js/daterangepicker.js')}}"></script>
<link href="{{ asset ('css/daterangepicker.css')}}" rel="stylesheet"></script>
<script src="{{ asset ('bootstrap_3_3_6/js/bootstrap.min.js')}}"></script>
<script src="{{ asset ('js/laravelapp.js')}}"></script>
</body>
</html>
