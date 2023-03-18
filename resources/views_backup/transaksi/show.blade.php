@extends('template')
@section('main')
<div id="transaksi">
<div class="panel panel-default">
<div class="panel-heading"><b><h4>DETAIL TRANSAKSI</h4></b>
<a href="{{ URL::previous() }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a>
@if (Auth::check())
	@if(Auth::user()->level == 'admin')
		@if($transaksi->users->level != 'kasircabang')
			<div class="box-button">
			{!! Form::open(['method' => 'DELETE', 'action' => ['TransaksiPenjualanController@destroy',$transaksi->id]]) !!}
			{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
			{!! Form::close()!!}
			</div>
		@else
			<div class="box-button">
			{!! Form::open(['method' => 'DELETE', 'action' => ['TransaksiPenjualanController@destroy2',$transaksi->id]]) !!}
			{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
			{!! Form::close()!!}
			</div>
		@endif
	@endif

	<div class="box-button">
	@if(($transaksi->jenis == 'retail') && (Auth::user()->level == 'kasir' || Auth::user()->level == 'kasircabang'))
		<a href="{{ url('transaksi/printstruk/' . $transaksi->id) }}" class="btn btn-primary btn-sm text-center" target="_blank"><i class="glyphicon glyphicon-print"></i> <b>Cetak Struk</b></a>
	@elseif(Auth::user()->level == 'admin' || Auth::user()->level == 'grosir')
		{{ link_to('transaksi/print/' . $transaksi->id,'Cetak Faktur',['class' => 'btn btn-primary btn-sm','target'=>'_blank']) }}
	@endif
	</div>

	@if(Auth::user()->level == 'admin' && $transaksi->jenis == 'pembelian')
		@if($transaksi->status == 'belum')
		<div class="box-button">
		<a href="{{ url('transaksi/lunas/' . $transaksi->id) }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-ok"></i> Bayar</a>
		</div>
		@endif
		<br><br><div class="box-button">
		@if($transaksi->statusorder == 'order')
		<font color="red">[ Sedang dalam Proses Order ]</font>
		@elseif($transaksi->statusorder == 'check')
		<font color="blue">[ Sudah dicek gudang ]</font>&nbsp;
		<a href="{{ url('transaksi/verifikasi/' . $transaksi->id) }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-ok"></i> Verifikasi</a>
		@else
		<font color="green">[ Order selesai, stok sudah diverifikasi Admin ]</font>
		@endif
		<div>
	@elseif(Auth::user()->level == 'gudang' && $transaksi->jenis == 'pembelian')
		<br><br><div class="box-button">
		@if($transaksi->statusorder == 'order')
		<font color="red">[ Sedang dalam Proses Order ]</font>&nbsp;
		<a href="{{ url('transaksi/check/' . $transaksi->id) }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-ok"></i> Konfirmasi Order</a>
		@elseif($transaksi->statusorder == 'check')
		<font color="blue">[ Sudah dicek gudang ]</font>
		@else
		<font color="green">[ Order selesai, stok sudah diverifikasi Admin ]</font>
		@endif
		<div>
	@endif
	</div>
@endif

</div>
<div class="panel-body">
<?php 
	function rupiah($nilai, $pecahan = 0) {
	return "Rp. " . number_format($nilai, $pecahan, ',', '.');
	} 
	$diskonrpall = 0; 
  $diskonperall = 0; 
?>
<table class="table">
<h4>A. DATA FAKTUR PENJUALAN</h4>
@if($transaksi->jenis == 'pembelian')
<tr><th>Kode Transaksi<br><br><br>No.Invoice</th><td>{{ $transaksi->kodepenjualan }}
	<?php
		echo DNS1D::getBarcodeHTML($transaksi->kodepenjualan, "C128");
	?><br>{{ $transaksi->noinvoice }}
</td><th>Nama Distributor</th><td>{{ $transaksi->customer->nama }}</td></tr>
<tr><th>Jenis Transaksi</th><td><?php echo ucfirst($transaksi->jenis); ?></td><th>Alamat</th><td>{{ $transaksi->customer->alamat }}</td></tr>
<tr><th>Tanggal Transaksi</th><td>{{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td><th>No.Telepon</th><td>{{ $transaksi->customer->notelp }}</td></tr>
<tr><th>Jam Transaksi</th><td>{{ date('H:i:s', strtotime($transaksi->created_at))}}</td><td colspan="2"></td></tr>
<tr><th>Kasir</th><td>{{ $transaksi->users->name }}</td><td colspan="2"></td></tr>
@elseif($transaksi->jenis == 'kirimcabang')
<tr><th>Kode Transaksi</th><td>{{ $transaksi->kodepenjualan }}
	<?php
		echo DNS1D::getBarcodeHTML($transaksi->kodepenjualan, "C128");
	?>
@foreach($transaksi->pengiriman as $kirim)
</td><th>Nama Cabang</th><td>{{ $kirim->profile->nama }}</td></tr>
<tr><th>Jenis Transaksi</th><td><?php echo ucfirst($transaksi->jenis); ?></td><th>Alamat</th><td>{{ $kirim->profile->alamat }}</td></tr>
<tr><th>Tanggal Transaksi</th><td>{{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td><th>No.Telepon</th><td>{{ $kirim->profile->notelp }}</td></tr>
<tr><th>Jam Transaksi</th><td>{{ date('H:i:s', strtotime($transaksi->created_at))}}</td><td colspan="2"></td></tr>
<tr><th>Kasir</th><td>{{ $transaksi->users->name }}</td><td colspan="2"></td></tr>
@endforeach
@else
<tr><th>Kode Transaksi</th><td>{{ $transaksi->kodepenjualan }}
	<?php
		echo DNS1D::getBarcodeHTML($transaksi->kodepenjualan, "C128");
	?>
</td><th>Nama Customer</th><td>{{ $transaksi->customer->nama }}</td></tr>
<tr><th>Jenis Transaksi</th><td><?php echo ucfirst($transaksi->jenis); ?></td><th>Alamat</th><td>{{ $transaksi->customer->alamat }}</td></tr>
<tr><th>Tanggal Transaksi</th><td>{{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td><th>No.Telepon</th><td>{{ $transaksi->customer->notelp }}</td></tr>
<tr><th>Jam Transaksi</th><td>{{ date('H:i:s', strtotime($transaksi->created_at))}}</td><td colspan="2"></td></tr>
<tr><th>Kasir</th><td>{{ $transaksi->users->name }}</td><td colspan="2"></td></tr>
@endif
</table>
<h4>B. DAFTAR PRODUK YANG DIBELI</h4>
<table class="table table-striped">
<tr><th>Kode</th><th>Nama Produk</th><th>Harga</th><th>Jumlah</th><th>Diskon 1 (Rp)</th><th>Diskon 2 (%)</th><th>Total</th></tr>
@foreach($transaksi->detailpenjualan->sortBy('id_produk') as $item)
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
<tr><td>{{ $item->produk->kodeproduk }}</td><td>{{ $item->produk->namaproduk }} ({{ $item->produk->merk->nama }})</td>
@if($transaksi->jenis == 'pembelian')
<td>{{ rupiah($item->produk->hargadistributor) }}</td>
@elseif($transaksi->jenis == 'retail')
	@if($transaksi->statustoko == 'cabang')
	<td>{{ rupiah($hargacabang) }}</td>
	@else
	<td>{{ rupiah($item->produk->hargajual) }}</td>
	@endif
@elseif($transaksi->jenis == 'grosir')
<td>{{ rupiah($item->produk->hargagrosir) }}</td>
@elseif($transaksi->jenis == 'kirimcabang')
<td>{{ rupiah($item->produk->hargagrosir) }}</td>
@endif
	<td>{{ $item->jumlah }}</td><td>{{ rupiah($item->diskonrp) }}</td><td>{{ $item->diskon }} %</td><td>{{ rupiah($totalbeli) }}</td></tr>
@endforeach
<tr><td colspan="4"></td><td><b>{{ rupiah($diskonrpall) }}</td><td><b>{{ $diskonperall }} %</td></tr>
<tr><td colspan="5"></td><th>Total Belanja</th><th>{{ rupiah($transaksi->totalbelanja) }}</th></td></tr>
<tr><td colspan="5"></td><th>Total Diskon</th><th>{{ rupiah($transaksi->totaldiskon) }}</th></tr>
<tr><td colspan="5"></td><th>Sub Total</th><th>{{ rupiah($transaksi->subtotal) }}</th></tr>
</table>
</div>
</div>
@if(($transaksi->jenis == 'retail') && (Auth::user()->level == 'kasir' || Auth::user()->level == 'kasircabang'))
<embed id="pdfDocument01" src="printstruk/{{ $transaksi->id }}" type="application/pdf" width="100%" height="100%" />
</embed>
@else
<embed id="pdfDocument01" src="print/{{ $transaksi->id }}" type="application/pdf" width="100%" height="100%" />
</embed>
@endif
</div>
<script>
<?php
echo "var jenis = '{$transaksi->jenis}'; ";
?>
if(jenis == 'retail'){
	// 	printDocument(pdfDocument01);
	setTimeout(function(){
		afterPrintFunc();
    }, 15000);
}
if(jenis == 'grosir'){
	setTimeout(function(){
		afterPrintFunc();
    }, 30000);
}
if(jenis == 'kirimcabang'){
	setTimeout(function(){
		afterPrintFunc();
    }, 30000);
}
// function printDocument(pdfDocument01) { 
//     if (typeof document.getElementById(pdfDocument01).print == 'undefined') {
//         setTimeout(function(){
// 			printDocument(pdfDocument01);
// 		}, 1000);

//     } else {
//         var x = document.getElementById(pdfDocument01);
//         x.print();
//     }
// }
var root = document.location.hostname;
function afterPrintFunc(){
	if(jenis == 'retail'){
		location.replace("http://"+ root +":8000/transaksi/create/retail");
	}
	if(jenis == 'grosir'){
		location.replace("http://"+ root +":8000/transaksi/create/grosir");
	}
	if(jenis == 'kirimcabang'){
		location.replace("http://"+ root +":8000/transaksi/create/kirimcabang");
	}
    console.log("keluar");
}
// var div1 = document.getElementsByTagName("BODY")[0];
// div1.onafterprint = function(){
//     location.replace("http://localhost:8000/transaksi/create/retail");
//     console.log("keluar");
// };

// window.matchMedia('print').addListener(function(mql) {
//     if (!mql.matches) {
//         afterPrintFunc();
//         }
//     });
// window.onafterprint = afterPrintFunc;

</script>
@stop

@section('footer')
@include('footer')
@stop