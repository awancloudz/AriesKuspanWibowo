@extends('template')

@section('main')
<div id="transaksi" class="panel panel-default">
@if ($caritrans == 1)
<!-- Deteksi jenis transaksi -->
<script type="text/javascript">
<?php echo "var jenis = '{$jenis}';"; ?>
window.localStorage['jenistrans'] = jenis;
</script>

	<div class="panel-heading"><b><h4>Data Transaksi - <?php echo ucfirst($jenis); ?></h4></b></div>
@else
	<script type="text/javascript">window.localStorage['jenistrans'] = "semua";</script>
	<div class="panel-heading"><b><h4>Data Semua Transaksi</h4></b></div>
@endif
	<div class="panel-body">
	@include('_partial.flash_message')
	<div class="row">
		<div class="col-md-8">
	@include('transaksi.form_pencarian_barcode')
	@include('transaksi.form_pencarian')
		</div>
		<div class="col-md-4">
			@if($caritrans == 1 && Auth::user()->level != 'gudang')
			<a href="{{ url('transaksi/create/' . $jenis) }}" class="btn btn-primary btn-lg text-center" id="tb_tambah"><i class="glyphicon glyphicon-arrow-right"></i><br> Menu Transaksi</a>
				@if($jenis == 'retail')
				<a href="{{ url('transaksi/strukharian') }}" class="btn btn-success btn-lg text-center" id="tb_print" target="blank_"><i class="glyphicon glyphicon-print"></i><br> Cetak Struk Harian</a>
				@endif	
			@endif
		</div>
	</div>

	<br>
	<!-- Tampil Transaksi -->
	@if (count($transaksi_list) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>Kode Transaksi</th>
				@if($jenis == 'pembelian')
				<th>No.Invoice</th>
				@endif
				<th>Tanggal</th>
				<th>Jam</th>
				@if (Auth::check())
					@if(Auth::user()->level == 'admin' && $jenis == 'retail')
					<th>Lokasi</th>
					@endif
				@endif
				<th>Total Belanja</th>
				<th>Diskon</th>
				<th>Sub Total</th>
				@if ($caritrans == 1)
				@if(Auth::user()->level == 'admin' && $jenis == 'pembelian')
				<th>Pembayaran</th>
				<th>Status</th>
				@elseif(Auth::user()->level == 'gudang' && $jenis == 'pembelian')
				<th>Status</th>
				@endif
				@endif
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			function rupiah($nilai, $pecahan = 0) {
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
			?>
			<?php $i=0; ?>
			<?php foreach($transaksi_list as $transaksi): ?>
			<tr>
				<td><font size="2">{{ $transaksi->kodepenjualan }}</font></td>
				@if($jenis == 'pembelian')
				<td><font size="2">{{ $transaksi->noinvoice }}</font></td>
				@endif
				<td>{{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td>
				<td>{{ date('H:i:s', strtotime($transaksi->created_at))}}</td>
				@if (Auth::check())
					@if(Auth::user()->level == 'admin' && $jenis == 'retail')
						@if($transaksi->users->level != 'kasircabang')
						<td>Pusat</td>
						@else
						<td>Cabang</td>
						@endif
					@endif
				@endif
				<td>{{ rupiah($transaksi->totalbelanja) }}</td>
				<td>{{ rupiah($transaksi->totaldiskon) }}</td>
				<td>{{ rupiah($transaksi->subtotal) }}</td>
				@if (Auth::check())
				@if ($caritrans == 1)
					@if(Auth::user()->level == 'admin' && $jenis == 'pembelian')
					<td>
						@if($transaksi->status == 'belum')
						<font color="red">Belum Lunas</font>&nbsp;
						<div class="box-button"> 
						<a onClick="return ConfirmPayment()" href="{{ url('transaksi/lunas/' . $transaksi->id) }}" class="btn btn-warning btn-sm" style="color:black;"><i class="glyphicon glyphicon-ok"></i><b> Bayar</b></a>
						</div>
						@else
						<font color="green">
						<?php echo ucfirst($transaksi->status); ?>
						</font>
						@endif
					</td>
					<td>
						@if($transaksi->statusorder == 'order')
						<font color="red">Order</font>
						@elseif($transaksi->statusorder == 'check')
						<font color="blue">Check</font>&nbsp;
						<div class="box-button"> 
						<a id="tblverif" onClick="return ConfirmVerification({{$transaksi->id}})" href="#" class="btn btn-warning btn-sm" style="color:black;"><i class="glyphicon glyphicon-ok"></i><b> Verifikasi</b></a>
						</div>
						@else
						<font color="green">Verified</font>
						@endif
					</td>
					@elseif(Auth::user()->level == 'gudang' && $jenis == 'pembelian')
					<td>
						@if($transaksi->statusorder == 'order')
						<font color="red">Order</font>&nbsp;
						<div class="box-button"> 
						<a onClick="return ConfirmTransaction()" href="{{ url('transaksi/check/' . $transaksi->id) }}" class="btn btn-warning btn-sm" style="color:black;"><i class="glyphicon glyphicon-ok"></i><b> Konfirmasi</b></a>
						</div>
						@elseif($transaksi->statusorder == 'check')
						<font color="blue">Check</font>
						@else
						<font color="green">Verified</font>
						@endif
					</td>
					@endif
				@endif
				@endif
				<td>
					<div class="box-button"> 
					<a href="{{ url('transaksi/view/' . $transaksi->id) }}" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-search"></i> Detail</a>
					</div>
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
							<form method="POST" id="formhapus_{{$i}}" action="{{ url('transaksi/' . $transaksi->id) }}">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="DELETE"> 
							<button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Item" onClick="return ConfirmDeleteTransaction({{ $transaksi->id }})"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
							</form>
							</div>
							@endif
						@else
							<div class="box-button">
							{!! Form::open(['method' => 'DELETE', 'action' => ['TransaksiPenjualanController@destroy2',$transaksi->id], 'onSubmit' => 'return ConfirmDeleteTransaction()']) !!}
							{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
							{!! Form::close()!!}
							</div>
						@endif
					@endif
				
					<div class="box-button">
					@if(($transaksi->jenis == 'retail') && (Auth::user()->level == 'kasir' || Auth::user()->level == 'kasircabang'))
					<a href="{{ url('transaksi/printstruk/' . $transaksi->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Struk</a>
					@elseif(Auth::user()->level == 'admin' || Auth::user()->level == 'grosir')
					<a href="{{ url('transaksi/print/' . $transaksi->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-print"></i> Faktur</a>
					@endif
					</div>
				@endif
				</td>
			</tr>
			<?php $i++; ?>
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data transaksi.</p>
	@endif
	<div class="table-nav">
	<div class="jumlah-data">
		<strong>Jumlah Transaksi : {{ $jumlah_transaksi}}</strong>
	</div>
	<div class="paging">
	{{ $transaksi_list->links() }}
	</div>
	</div>
	<!--Akhir Tampil Transaksi -->
	</div>
</div>
<script>
	<?php
	$csrf = json_encode(csrf_token());
	echo "var csrfToken ={$csrf}; ";
	$panjang = count($transaksi_list);
	echo "var panjang ={$panjang}; ";
	?>

	//Set variable handlesubmit
	var formhapus = [];
	for(var i = 0; i < panjang; ++i) {
		formhapus[i] =  document.getElementById('formhapus_'+ i);
		formhapus[i].addEventListener('submit', handleSubmit);
	}
	var submitTimer;

	function handleSubmit(event) {
		event.preventDefault();
		console.log('submitTimer set');
		submitTimer = setTimeout(() => {
			this.submit();
			console.log('Submitted after 2 seconds');
		}, 2000);
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
		var urlget = "../transaksi/verifikasijson/"+idtransaksi;
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
		var urlget = "../transaksi/verifikasitransaksijson/"+idtransaksi;
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
</script>
@stop

@section('footer')
	@include('footer')
@stop