@extends('template')
@section('main')
<div id="transaksi">
<div class="panel panel-default">
<div class="panel-heading"><b><h4>DETAIL TRANSAKSI</h4></b>
<!-- <a href="{{ URL::previous() }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a> -->
<a href="{{ url('jenistransaksi/'.$transaksi->jenis) }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a>
@if (Auth::check())
	@if(Auth::user()->level == 'admin')
		@if($transaksi->users->level != 'kasircabang')
			@if(($transaksi->statusorder == 'order' && $transaksi->jenis == 'pembelian') || ($transaksi->statusorder == 'check' && $transaksi->jenis == 'pembelian'))
				<div class="box-button">
				{!! Form::open(['method' => 'DELETE', 'action' => ['TransaksiPenjualanController@bataltransaksi',$transaksi->id], 'onSubmit' => 'return ConfirmCancel()']) !!}
				{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Batal', ['class'=>'btn btn-warning btn-sm','type'=>'submit']) !!}
				{!! Form::close()!!}
				</div>
			@else
				<div class="box-button">
				<form method="POST" id="formhapus" action="{{ url('transaksi/' . $transaksi->id) }}">
				{{ csrf_field() }}
				<input type="hidden" name="_method" value="DELETE"> 
				<button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Item" onClick="return ConfirmDeleteTransaction({{ $transaksi->id }})"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
				</form>
				</div>
			@endif
		@else
			<div class="box-button">
			{!! Form::open(['method' => 'DELETE', 'action' => ['TransaksiPenjualanController@destroy2',$transaksi->id], 'onSubmit' => 'return ConfirmDelete()']) !!}
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
		<a onClick="return ConfirmPayment()" href="{{ url('transaksi/lunas/' . $transaksi->id) }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-ok"></i> Bayar</a>
		</div>
		@endif
		<div class="box-button">
		<a href="{{ url('transaksi/history/'.$transaksi->id) }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-right"></i> <b>History</b></a>
		</div>
		<br><br><div class="box-button">
		@if($transaksi->statusorder == 'order')
		<font color="red">[ Sedang dalam Proses Order ]</font>
		@elseif($transaksi->statusorder == 'check')
		<font color="blue">[ Sudah dicek gudang ]</font>&nbsp;
		<a id="tblverif" onClick="return ConfirmVerification({{$transaksi->id}})" href="#" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-ok"></i> Verifikasi Stok</a>
		@else
		<font color="green">[ Order selesai, stok sudah diverifikasi Admin ]</font>
		@endif
		<div>		
	@elseif(Auth::user()->level == 'gudang' && $transaksi->jenis == 'pembelian')
		<br><br><div class="box-button">
		@if($transaksi->statusorder == 'order')
		<font color="red">[ Sedang dalam Proses Order ]</font>&nbsp;
		<a onClick="return ConfirmTransaction()" href="{{ url('transaksi/check/' . $transaksi->id) }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-ok"></i> Konfirmasi Order</a>
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
	@if(Auth::user()->level == 'admin' && $transaksi->jenis == 'pembelian')
		<div class="row">
			{!! Form::open(['url' => 'transaksi/editinvoice','name' => 'formtransinvoice']) !!}
			{!! Form::hidden('id', $transaksi->id) !!}			
			<div class="col-md-6">{!! Form::text('noinvoice', null,['class' => 'form-control']) !!}</div>
			<div class="col-md-6">{!! Form::button('Ubah No.Invoice <i class="glyphicon glyphicon-chevron-right"></i>', ['class'=>'btn btn-success btn-sm form-control','type'=>'submit','id'=>'ubahinvoice']) !!}</div>
			{!! Form::close() !!}
		</div>
	@endif
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
<tr><th>Kode</th><th>Nama Produk</th><th>Harga</th><th>Jumlah</th><th>Diskon 1 (Rp)</th><th>Diskon 2 (%)</th><th>Total</th>
@if(Auth::user()->level == 'gudang' && $transaksi->jenis == 'pembelian')
<th>Status</th>
<th>Checklist</th>
@elseif(Auth::user()->level == 'admin' && $transaksi->jenis == 'pembelian')
<th>Status</th>
@endif
</tr>
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
@if($item->status == 'ready' || $item->status == 'order')
<tr>
@else
<tr style="color:red;"> 
@endif
<td>{{ $item->produk->kodeproduk }}</td><td>{{ $item->produk->namaproduk }} ({{ $item->produk->merk->nama }})</td>
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
@if(Auth::user()->level == 'gudang' && $transaksi->jenis == 'pembelian' && $transaksi->statusorder == 'order')
<td><input type="text" value="{{ $item->jumlah }}" id="jumlahcart_{{ $item->id }}" size="4" style="text-align:center;">
<a onClick="ketikJumlah({{ $item->id }})" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-ok"></i></a>
</td>
@else
<td>{{ $item->jumlah }}</td>
@endif
<td>{{ rupiah($item->diskonrp) }}</td><td>{{ $item->diskon }} %</td><td>{{ rupiah($totalbeli) }}</td>
@if(Auth::user()->level == 'gudang' && $transaksi->jenis == 'pembelian')
<td>{{ $item->status }}</td>
@if($transaksi->statusorder == 'order')
<td>
<a onClick="return ConfirmReady()" href="{{ url('transaksi/ready/' . $item->id . '/status/ready') }}" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-ok"></i></a>
<a onClick="return ConfirmReady()" href="{{ url('transaksi/ready/' . $item->id) . '/status/kosong' }}" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></a>
</td>
@else
<td>check</td>
@endif
@elseif(Auth::user()->level == 'admin' && $transaksi->jenis == 'pembelian')
<td>{{ $item->status }}</td>
@endif
</tr>
@endforeach
<tr><td colspan="4"></td><td><b>{{ rupiah($diskonrpall) }}</td><td><b>{{ $diskonperall }} %</td></tr>
<tr><td colspan="5"></td><th>Total Belanja</th><th>{{ rupiah($transaksi->totalbelanja) }}</th></td></tr>
<tr><td colspan="5"></td><th>Total Diskon</th><th>{{ rupiah($transaksi->totaldiskon) }}</th></tr>
<tr><td colspan="5"></td><th>Sub Total</th><th>{{ rupiah($transaksi->subtotal) }}</th></tr>
<tr><td colspan="5"></td><th>Bayar</th><th>{{ rupiah($transaksi->bayar) }}</th></tr>
<tr><td colspan="5"></td><th>Kembali</th><th>{{ rupiah($transaksi->kembali) }}</th></tr>
</table>
</div>
</div>
</div>
<script>
<?php
$csrf = json_encode(csrf_token());
echo "var csrfToken ={$csrf}; ";
?>

	//Prevent Submit
	var formhapus = document.getElementById('formhapus');
	formhapus.addEventListener('submit', handleSubmit);
	var submitTimer;

	function handleSubmit(event) {
		console.log('submitTimer set');
		event.preventDefault();
		submitTimer = setTimeout(() => {
			this.submit();
			console.log('Submitted after 2 seconds');
		}, 2000)
	};

 	///Confirm Verification
	function ConfirmVerification(idtransaksi){
		var x = confirm("Yakin verifikasi pembelian? Cek daftar order terlebih dahulu, jika sudah klik OK!");
		if(x)
			viewdetailverifikasi(idtransaksi);
		else
			return false;
	}

	function viewdetailverifikasi(idtransaksi){
		console.log("ID Transaksi : " + idtransaksi);
		var xmlhttpget = new XMLHttpRequest();
		var urlget = "../verifikasijson/"+idtransaksi;
		xmlhttpget.open("GET", urlget, true);
		xmlhttpget.send();
		xmlhttpget.onreadystatechange=function() {
			if (xmlhttpget.readyState == 4 && xmlhttpget.status == 200) {
			var detailtransaksi = xmlhttpget.responseText;
			updateverifikasiserver(idtransaksi, detailtransaksi);
			}
		}
	}

	function updateverifikasiserver(idtransaksi, detailtransaksi){
		console.log("Update Server : " + detailtransaksi);
		var xmlhttp = new XMLHttpRequest();
		var url = "http://arieskuspanwibowo.com/verifikasisinkron";
		xmlhttp.open("POST", url, true);
		xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
		xmlhttp.setRequestHeader("Content-type","application/json;charset=UTF-8");
		xmlhttp.send(detailtransaksi);
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var response = xmlhttp.responseText;
				console.log("Respon Server : " + response);
				window.location = "http://"+window.location.host +"/transaksi/verifikasi/"+idtransaksi;
				return true;
			}
		}
	}
  	///End Confirm Verification

  	///Confirm Delete Transaction
	function ConfirmDeleteTransaction(idtransaksi){
		console.log(idtransaksi);
		var x = confirm("Yakin hapus data transaksi?");
		if (x)
			viewdetailhapus(idtransaksi);
		else
			return false;
	}

	function viewdetailhapus(idtransaksi){
		console.log("ID Transaksi : " + idtransaksi);
		var xmlhttpget = new XMLHttpRequest();
		var urlget = "../verifikasitransaksijson/"+idtransaksi;
		xmlhttpget.open("GET", urlget, true);
		xmlhttpget.send();
		xmlhttpget.onreadystatechange=function() {
			if (xmlhttpget.readyState == 4 && xmlhttpget.status == 200) {
			var detailtransaksi = xmlhttpget.responseText;
			hapustransaksiserver(detailtransaksi);
			}
		}
	}

	function hapustransaksiserver(idtransaksi){
		console.log(idtransaksi);
		var xmlhttp = new XMLHttpRequest();
		var url = "http://arieskuspanwibowo.com/hapustransaksisinkron";
		xmlhttp.open("POST", url, true);
		xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
		xmlhttp.setRequestHeader("Content-type","application/json;charset=UTF-8");
		xmlhttp.send(idtransaksi);
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var response = xmlhttp.responseText;
				console.log("Respon Server : " + response);
				return true;
			}
		}
	}
  	///End Confirm Delete Transaction
	
function ketikJumlah(i){
	var c = parseInt(document.getElementById("jumlahcart_" + i).value);
	c = c ? c : 0;
	if((c != 0) || (c != '')) {
		updatejumlah(i,c);
	}
	document.getElementById("jumlahcart_" + i).value = c;
}
function updatejumlah(id,jml){
	//Simpan QTY baru
	var xmlhttp = new XMLHttpRequest();
    var url = "../view/updatepembelian";
    xmlhttp.open("PUT", url, true);
    xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("id="+escape(id)+"&jumlah="+escape(jml));
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        console.log("Simpan OK");
		location.reload();
      }
    }
}
</script>
@stop

@section('footer')
@include('footer')
@stop