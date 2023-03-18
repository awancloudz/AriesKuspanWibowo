@if (isset($transaksi))
{!! Form::hidden('id', $transaksi->id) !!}
<script type="text/javascript">
<?php echo "var id_trans = '{$transaksi->id}';"; ?>
</script>
@else
<script type="text/javascript">
<?php echo "var id_trans = '';"; ?>
</script>
@endif
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" style="margin-top:100px;">
<div class="modal-dialog">
	<!-- Modal Produk-->
	<div class="modal-content">
		<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div><b>Tambah Produk</b></div>
        </div>
        <div class="modal-body">
        	<div class="row" align="center">
				<div class="col-md-1"></div>
				<div class="col-md-1"></div>
				<div class="col-md-2"><b>Kode</b></div>
				<div class="col-md-2"><b>Nama</b></div>
				<div class="col-md-2"><b>Harga</b></div>
				<!--<div class="col-md-2"><b>Diskon</b></div>-->
				<div class="col-md-2"><b>Stok</b></div>
			</div><hr>
  			@if(count($list_produk) > 0)
				@foreach($list_produk as $key => $value)
				<div class="row" align="center">
					<div class="col-md-1">
						<div class="form-group">
							<div class="checkbox">
							<label>{!! Form::checkbox('detailtransaksi[]', $key, null,['id'=>'detailtransaksi'.$key]) !!}</label>
							</div>
						</div>
					</div>
					<div class="col-md-1"><div id="gambar{{ $key }}"></div></div>
					<div class="col-md-2"><div id="kode{{ $key }}"></div></div>
					<div class="col-md-2"><div id="nama{{ $key }}"></div></div>
					<div class="col-md-2"><div id="harga{{ $key }}"></div></div>
					<!--<div class="col-md-2"><div id="diskon{{ $key }}"></div></div>-->
					<div class="col-md-2"><div id="stok{{ $key }}"></div></div>
				</div><hr>
				@endforeach
				{!! Form::submit('Update keranjang belanja',['class' => 'btn btn-success form-control','id'=>'tbkeranjang']) !!}
			@else
			</p>Pilihan produk kosong.</p>
			@endif
		</div>
	</div>
</div>
</div>
<!-- End Modal -->

{{-- Jenis Transaksi --}}
@if($errors->any())
<div class="form-group {{ $errors->has('jenistransaksi') ? 'has-error' : 'has-success' }}"></div>
@else
<div class="form-group" id="tampiltrans">
@endif
{!! Form::label('jenistransaksi','Jenis Transaksi',['class' => 'control-label']) !!} <i><font color="red">*</font></i>
	<div class="radio">
	<label>
	{!! Form::radio('jenistransaksi','pembelian') !!} Pembelian
	</label>&nbsp;
	<label>{!! Form::radio('jenistransaksi','retail') !!} Retail
	</label>&nbsp;
	<label>{!! Form::radio('jenistransaksi','grosir') !!} Grosir
	</label>
	</div>
	@if ($errors->has('jenistransaksi'))
	<span class="help-block">{{ $errors->first('jenistransaksi') }}</span>
	@endif
</div>

<div class="row">
  <div class="col-md-6">
	{{-- Kode --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('kodetransaksi') ? 'has-error' : 'has-success' }}"></div>
	@else
	<div class="form-group">
	@endif
		{!! Form::label('kodetransaksi','Kode Transaksi',['class' => 'control-label']) !!} <i><font color="red">*</font></i>
		{!! Form::text('kodetransaksi', null,['class' => 'form-control','id'=>'kodetransaksi','readonly']) !!}
		@if ($errors->has('kodetransaksi'))
		<span class="help-block">{{ $errors->first('kodetransaksi') }}</span>
		@endif
	</div>
  </div>
  <div class="col-md-6">
	{{--  Dokter --}}
	<div class="form-group" id="tampildokter">
		{!! Form::label('id_dokter','Nama Dokter',['class' => 'control-label']) !!}
		@if(count($list_dokter) > 0)
		{!! Form::select('id_dokter', $list_dokter, null,['class' => 'form-control', 'id'=>'id_dokter']) !!}
		@else
		<p>Tidak ada pilihan dokter,silahkan buat dulu.</p>
		@endif
		@if ($errors->has('id_dokter'))
		<span class="help-block">{{ $errors->first('id_dokter') }}</span>
		@endif
	</div>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
	{{-- Tanggal Transaksi --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('tanggaltransaksi') ? 'has-error' : 'has-success' }}"></div>
	@else
	<div class="form-group">
	@endif
		{!! Form::label('tanggaltransaksi','Tanggal Transaksi',['class' => 'control-label']) !!} <i><font color="red">*</font></i>
		{!! Form::date('tanggaltransaksi', null,['class' => 'form-control']) !!}
		@if ($errors->has('tanggaltransaksi'))
		<span class="help-block">{{ $errors->first('tanggaltransaksi') }}</span>
		@endif
	</div>
  </div>
  <div class="col-md-3">
  	<div class="form-group">
  		{!! Form::label('jamtransaksi','Jam',['class' => 'control-label']) !!}
		{!! Form::time('jamtransaksi', null,['class' => 'form-control']) !!}
  	</div>
  </div>
  <div class="col-md-6">
	{{--  Instansi --}}
	<div class="form-group" id="tampilinstansi">
		{!! Form::label('id_instansi','Instansi',['class' => 'control-label']) !!}
		@if(count($list_instansi) > 0)
		{!! Form::select('id_instansi', $list_instansi, null,['class' => 'form-control', 'id'=>'id_instansi']) !!}
		@else
		<p>Tidak ada pilihan instansi,silahkan buat dulu.</p>
		@endif
		@if ($errors->has('id_instansi'))
		<span class="help-block">{{ $errors->first('id_instansi') }}</span>
		@endif
	</div>
  </div>
</div>

<div class="row">
  <div class="col-md-3" id="tampiltglselesai">
	{{-- Tanggal Selesai --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('tanggalselesai') ? 'has-error' : 'has-success' }}"></div>
	@else
	<div class="form-group">
	@endif
		{!! Form::label('tanggalselesai','Tanggal Selesai',['class' => 'control-label']) !!}
		{!! Form::date('tanggalselesai', null,['class' => 'form-control']) !!}
		@if ($errors->has('tanggalselesai'))
		<span class="help-block">{{ $errors->first('tanggalselesai') }}</span>
		@endif
	</div>
  </div>
  <div class="col-md-3" id="tampiljamselesai">
  	<div class="form-group">
  		{!! Form::label('jamselesai','Jam',['class' => 'control-label']) !!}
		{!! Form::time('jamselesai', null,['class' => 'form-control']) !!}
  	</div>
  </div>
  <div class="col-md-6">
	{{--  Karyawan --}}
	<div class="form-group" id="inputkaryawan">
		{!! Form::label('id_users','Admin / Karyawan',['class' => 'control-label']) !!}
		@if(count($list_user) > 0)
		{!! Form::select('id_users', $list_user, null,['class' => 'form-control', 'id'=>'id_users']) !!}
		@else
		<p>Tidak ada pilihan admin/karyawan,silahkan buat dulu.</p>
		@endif
		@if ($errors->has('id_users'))
		<span class="help-block">{{ $errors->first('id_users') }}</span>
		@endif
	</div>
	{{-- Tampil Karyawan --}}
	<div class="form-group" id="txtkaryawan"></div>  	
  </div>
</div>

<div class="row">
  <div class="col-md-4" id="tampilcustomer">
	{{--  Customer --}}
	<div class="form-group">
		{!! Form::label('id_customer','Nama Customer',['class' => 'control-label']) !!}
		@if(count($list_customer) > 0)
		{!! Form::select('id_customer', $list_customer, null,['class' => 'form-control', 'id'=>'id_customer']) !!}
		@else
		<p>Tidak ada pilihan customer,silahkan buat dulu.</p>
		@endif
		@if ($errors->has('id_customer'))
		<span class="help-block">{{ $errors->first('id_customer') }}</span>
		@endif
	</div>
  </div>
  <div class="col-md-1" id="tampiltbcustomer"><br>
  	<a href="{{ url('customer/create/') }}" class="btn btn-success btn-block" role="button" target="_blank"><span class="glyphicon glyphicon-user"></span> Tambah</a>
  </div>
  <div class="col-md-1" id="resepnya">
  </div>
  <div class="col-md-6">
  	{{-- Catatan --}}
	<div class="form-group">
		{!! Form::label('catatan','Catatan',['class' => 'control-label']) !!}
		{!! Form::text('catatan', null,['class' => 'form-control']) !!}
	</div>
  </div>
</div>

<div class="form-group">
<i>Field bertanda (<font color="red"> * </font>) Wajib Diisi</i>
</div>
{{-- TOMBOL PILIH PRODUK --}}
<div class="form-group">
<button type="button" class="btn btn-primary btn-md" id="cmd_tambah"><span class="glyphicon glyphicon-plus"></span> Pilih Produk</button>
</div>
<hr>
{!! Form::text('cekbarcode', null,['id'=>'cekbarcode']) !!}

{{-- DETAIL PRODUK YANG DIBELI --}}
<div class="row" align="center">
	<div class="col-md-1"></div>
	<div class="col-md-1"><b>Kode</b></div>
	<div class="col-md-2"><b>Nama</b></div>
	<div class="col-md-2"><b>Harga</b></div>
	<div class="col-md-1"><b>Jumlah</b></div>
	<div class="col-md-2"><b>Diskon</b></div>
	<div class="col-md-2"><b>Total</b></div>
	<div class="col-md-1"><b>Action</b></div>
</div><hr>
<?php
$totaldiskon = 0;
$subtotal = 0;
?>
<!-- ()->orderBy('created_at', 'desc')->get() -->
@foreach($transaksi->produk as $item)
<?php
//$nominal = ($item->diskon / 100) * $item->hargajual;
$nominal = $item->pivot->diskon;
$totalbeli =  ($item->hargajual * $item->pivot->jumlahbeli) - ($item->pivot->jumlahbeli * $nominal);
$totaldiskon = $totaldiskon + ($nominal * $item->pivot->jumlahbeli);
$subtotal = $subtotal + $totalbeli;
$jmlbeli = $item->pivot->jumlahbeli;
if( $jmlbeli == 0){
$jmlbeli = 1;
}
?>
<div class="row" align="center">
	<div class="col-md-1">
	@if(isset($item->foto))
	<img width="50" class="img-circle" height="50" src="{{ asset('fotoupload/' . $item->foto) }}">
	@else	
	<img width="50" class="img-circle" height="50" src="{{ asset('fotoupload/noimage.png') }}">
	@endif</div>
	<div class="col-md-1">{{ $item->kodeproduk }}</div>
	<div class="col-md-2">{{ $item->namaproduk }}</div>
	<div class="col-md-2">{!! Form::text('hargajual[]', $item->hargajual, ['class' => 'form-control','readonly']) !!}</div>
	<div class="col-md-1">{!! Form::text('jumlahbeli[]', $jmlbeli, ['class' => 'form-control']) !!}</div>
	<div class="col-md-2">{!! Form::text('diskon[]', $nominal, ['class' => 'form-control']) !!}</div>
	<div class="col-md-2">{!! Form::text('totalbeli[]', $totalbeli, ['class' => 'form-control','readonly']) !!}</div>
	<div class="col-md-1">{!! Form::submit('Hapus',['class' => 'btn btn-danger form-control','id'=>'hapusitem'.$item->id]) !!}</div>
</div>
<!-- INISIASI STOK -->
{!! Form::hidden('stok_awal[]', $item->stok) !!}
{!! Form::hidden('stok_sekarang[]', $item->pivot->jumlahbeli) !!}
{!! Form::hidden('kodeproduk[]', $item->id) !!}
{!! Form::hidden('stok[]', $item->stok) !!}
<hr>
@endforeach
<div class="row">
	<div class="col-md-7"></div>
	<div class="col-md-2" align="right"><b>Total Belanja</b></div>
	<div class="col-md-2" align="center">{!! Form::text('totalbelanja', null, ['class' => 'form-control','readonly']) !!}</div>
	<div class="col-md-1"></div>
</div><hr>
<div class="row">
	<div class="col-md-7"></div>
	<div class="col-md-2" align="right"><b>Total Diskon</b></div>
	<div class="col-md-2" align="center">{!! Form::text('totaldiskon', null, ['class' => 'form-control','id'=>'totaldiskon']) !!}</div>
	<div class="col-md-1"></div>
</div><br>
<div class="row">
	<div class="col-md-7"></div>
	<div class="col-md-2" align="right"><b>Asuransi</b></div>	
	<div class="col-md-2"  align="center">{!! Form::text('asuransi', null, ['class' => 'form-control','readonly']) !!}</div>
	<div class="col-md-1"></div>
</div><hr>
<div class="row">
	<div class="col-md-7"></div>
	<div class="col-md-2" align="right"><b>Sub Total</b></div>	
	<div class="col-md-2" align="center">{!! Form::text('total', null, ['class' => 'form-control','readonly']) !!}</div>
	<div class="col-md-1"></div>
</div><br>
<div class="row">
	<div class="col-md-7"></div>
	<div class="col-md-2" align="right"><b>Bayar / DP</b></div>	
	<div class="col-md-2" align="center">{!! Form::text('bayar', null, ['class' => 'form-control','id'=>'bayar']) !!}</div>
	<div class="col-md-1"></div>
</div><br>
<div class="row">
	<div class="col-md-7"></div>
	<div class="col-md-2" align="right"><b>Kekurangan</b></div>	
	<div class="col-md-2" align="center">{!! Form::text('sisa', null, ['class' => 'form-control','readonly']) !!}</div>
	<div class="col-md-1"></div>
</div><br>
<!--{!! Form::hidden('cekhitung') !!}-->
{{-- Submit button --}}
<div class="row" align="center">
<div class="form-group">
	<div class="col-md-4"></div>
	<div class="col-md-2">
	{!! Form::submit($submitButtonText,['class' => 'btn btn-success btn-block form-control','id'=>'tbsimpan']) !!}
	<!--<button type="button" class="btn btn-block btn-success" id="tbsimpan" name="tbsimpan"> Simpan Transaksi</button>-->
	</div>
	<div class="col-md-2" id="tampilstruk">
	<!--<a href="{{ url('transaksi/print/' . $transaksi->id) }}" class="btn btn-warning btn-block" role="button" target="_blank">Cetak Struk</a>-->
	</div>
	<div class="col-md-2" id="tampilresep">
	<!--<a href="{{ url('transaksi/printresep/' . $transaksi->id) }}" class="btn btn-primary btn-block" role="button" target="_blank">Cetak Resep</a>-->	
	</div>
	<div class="col-md-2">
	<a href="{{ url('transaksi') }}" class="btn btn-info btn-block" role="button">Selesai Transaksi</a>
	</div>
</div>
</div>
<!-- JQuery -->
<script>
$(document).ready(function(){
	//var rupiahkan = accounting.formatMoney(100000);
	//alert(rupiahkan);
	//var nominalkan = accounting.unformat(rupiahkan, ",");
	//alert(nominalkan);
	
	//TANGGAL HARI INI
	function getDefaultDate(){
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    return today;
	}

	//JAM SEKARANG
	function getDefaultTime(){
	var now = new Date();
	var curr_hour = now.getHours();
	var curr_min = now.getMinutes();
	curr_min = curr_min + "";
	if (curr_min.length == 1) {
	    curr_min = "0" + curr_min;
	}
	var jamsekarang = curr_hour + ":" + curr_min;
	return jamsekarang;
	}
	
	//SET TANGGAL SEKARANG
    $("#tanggaltransaksi").val( getDefaultDate()); 
    $("#tanggalselesai").val( getDefaultDate()); 
    //SET JAM SEKARANG
    $("#jamtransaksi").val( getDefaultTime()); 
    $("#jamselesai").val( getDefaultTime()); 

	//TAMPIL STOK PRODUK
	<?php
	echo "var daftar_produk ={$daftar_produk}; ";
	echo "var daftar_instansi ={$daftar_instansi}; ";
	echo "var produk_detail ={$transaksi->produk}; ";
	?>
	for(i=0; i < daftar_produk.length; i++){
	document.getElementById("gambar"+ daftar_produk[i].id).innerHTML = "<img width='50' height='50' class='img-circle' src='../../fotoupload/"+ daftar_produk[i].foto +"'>";
	document.getElementById("kode"+ daftar_produk[i].id).innerHTML = daftar_produk[i].kodeproduk;
	document.getElementById("nama"+ daftar_produk[i].id).innerHTML = daftar_produk[i].namaproduk;
	document.getElementById("harga"+ daftar_produk[i].id).innerHTML = daftar_produk[i].hargajual;
	//document.getElementById("diskon"+ daftar_produk[i].id).innerHTML = daftar_produk[i].diskon + " % ";
	document.getElementById("stok"+ daftar_produk[i].id).innerHTML = daftar_produk[i].stok;

	}

	//TOMBOL PILIH PRODUK
	$("#cmd_tambah").click(function(){
		$("#myModal").modal({backdrop: "static"});
	});
	
	//CEK JENIS TRANSAKSI
	var cektrans = window.localStorage['jenistrans'];
	if (cektrans == 'semua'){
		if(id_trans != ''){
			document.getElementById('tampilstruk').innerHTML = "<a href='../print/"+ id_trans + "' class='btn btn-warning btn-block' role='button' target='_blank'>Cetak Struk</a>";
			document.getElementById('tampilresep').innerHTML = "<a href='../printresep/"+ id_trans + "' class='btn btn-primary btn-block' role='button' target='_blank'>Cetak Resep</a>";
		}
		else{
			$("#tampilstruk").hide();
			$("#tampilresep").hide();
		}
	}
	else{
		$("input[name=jenistransaksi][value="+cektrans+"]").attr('checked', true);
		$("#tampiltrans").hide();
			if(cektrans == 'pesan'){
				if(id_trans != ''){
				document.getElementById('tampilstruk').innerHTML = "<a href='../print/"+ id_trans + "' class='btn btn-warning btn-block' role='button' target='_blank'>Cetak Struk</a>";
				document.getElementById('tampilresep').innerHTML = "<a href='../printresep/"+ id_trans + "' class='btn btn-primary btn-block' role='button' target='_blank'>Cetak Resep</a>";
				}
				else{
				$("#tampilstruk").hide();
				$("#tampilresep").hide();
				}
			}
			else if((cektrans == 'retail') || (cektrans == 'grosir')){
				$("#tampiltglselesai").hide();
				$("#tampiljamselesai").hide();
				$("#tampildokter").hide();
				$("#tampilinstansi").hide();
				$("#tampilcustomer").hide();
				$("#tampiltbcustomer").hide();
				$("#resepnya").hide();
				if(id_trans != ''){
				document.getElementById('tampilstruk').innerHTML = "<a href='../print2/"+ id_trans + "' class='btn btn-warning btn-block' role='button' target='_blank'>Cetak Struk</a>";
				//document.getElementById('tampilresep').innerHTML = "<a href='../printresep/"+ id_trans + "' class='btn btn-primary btn-block' role='button' target='_blank'>Cetak Resep</a>";
				$("#tampilresep").hide();
				}
				else{
				$("#tampilstruk").hide();
				$("#tampilresep").hide();
				}
			}
	}

	//INSTANSI CHANGE
	$("#id_instansi").change(function(){
		var id_inst = document.getElementById("id_instansi").value;
		for(ii=0; ii < daftar_instansi.length; ii++){
			if(daftar_instansi[ii].id == id_inst){
				document.getElementsByName("asuransi")[0].value = daftar_instansi[ii].harga;
				hitung();			
			}
		}
	});
	//CUSTOMER CHANGE
	var id_cust = document.getElementById("id_customer").value;
	document.getElementById('resepnya').innerHTML = "<br><a href='../../customer/"+ id_cust +"' class='btn btn-warning btn-block' role='button' target='_blank'><span class='glyphicon glyphicon-list-alt'></span> Resep</a>";

	$("#id_customer").change(function(){
		var id_cust = document.getElementById("id_customer").value;
		document.getElementById('resepnya').innerHTML = "<br><a href='../../customer/"+ id_cust +"' class='btn btn-warning btn-block' role='button' target='_blank'><span class='glyphicon glyphicon-list-alt'></span> Resep</a>";
	});

	//VARIABEL AWAL
	var jumlahbeli = document.getElementsByName("jumlahbeli[]");
	var jumlahbeli_array = Array.prototype.slice.call(jumlahbeli);
	var diskon = document.getElementsByName("diskon[]");
	var diskon_array = Array.prototype.slice.call(diskon);
	//KEYUP EVENT HANDLER JUMLAH BELI
	for(var i=0; i < jumlahbeli_array.length; i++){
	    jumlahbeli_array[i].addEventListener("keyup", hitung);
	}
	//KEYUP EVENT HANDLER DISKON
	for(var ii=0; ii < diskon_array.length; ii++){
	    diskon_array[ii].addEventListener("keyup", hitung);
	}
	//FUNCTION HITUNG
	function hitung(){
		//VARIABLE FIELD	
		var asuransi = document.getElementsByName("asuransi")[0].value;
		var hargajual = document.getElementsByName("hargajual[]");
		var diskon = document.getElementsByName("diskon[]");
		var totalbeli = document.getElementsByName("totalbeli[]");
		var hargajual_array = Array.prototype.slice.call(hargajual);
		var diskon_array = Array.prototype.slice.call(diskon);
		var total_array = Array.prototype.slice.call(totalbeli);
		//CEK STOK
		var stokakhir = 0;
		var maksstok = 0;
		var stok_awal = document.getElementsByName("stok_awal[]");
		var stok_sekarang = document.getElementsByName("stok_sekarang[]");
		var stok_akhir = document.getElementsByName("stok[]");
		var stok_awal_array = Array.prototype.slice.call(stok_awal);
		var stok_sekarang_array = Array.prototype.slice.call(stok_sekarang);
		var stok_akhir_array = Array.prototype.slice.call(stok_akhir);
		//VARIABEL HITUNGAN
		var diskonnya = 0;
		var totaldiskon = 0;
		var belanja = 0;
	    var totalbelanja = 0;
	    var totalnya = 0;
	    var total = 0;
	   	var totalakhir = 0;
	   	var kurang1 = 0;
	    for(var i=0; i < jumlahbeli_array.length; i++){
	    	//CEK STOK
	    	var jml1 = parseInt(jumlahbeli_array[i].value);
	    	var stok1 = parseInt(stok_awal_array[i].value);
	    	var stok2 = parseInt(stok_sekarang_array[i].value);
	    	maksstok = stok1 + stok2;
	    	if(jml1 > maksstok){
	    		alert("Stok Tidak mencukupi");
	    		jumlahbeli_array[i].value = stok_sekarang_array[i].value;
	    		stok_akhir_array[i].value = stok_awal_array[i].value;
	    	}
	    	else if(stok1 == 0){
	    		alert("Stok Kosong");
	    	}
	    	else if((jumlahbeli_array[i].value == "") || (jumlahbeli_array[i].value == 0)) {
	    	//Jika jumlah kosong	
	    	}	   	
	    	else{
	    		if(jml1 > stok2){
	    			stokakhir = stok1 - (jml1 - stok2);
	    			stok_akhir_array[i].value = stokakhir;
	  	    	}
	    		else if(jml1 < stok2){
	    			stokakhir = stok1 + (stok2 - jml1);
	    			stok_akhir_array[i].value = stokakhir;
	    		}	    
	    		else if(jml1 == stok2){
	    			stokakhir = stok1;
	    			stok_akhir_array[i].value = stokakhir;
	    		}	
	    	}
	    	//HITUNG DISKON
	    	diskonnya = parseInt(diskon_array[i].value) * parseInt(jumlahbeli_array[i].value);
	    	if (isNaN(diskonnya)) diskonnya = diskonnya || 0 ;
	    	totaldiskon = totaldiskon + diskonnya;
	    	//HITUNG BELANJA
	    	belanja = parseInt(jumlahbeli_array[i].value) * parseInt(hargajual_array[i].value);
	    	if (isNaN(belanja)) belanja = belanja || 0 ;
	    	totalbelanja = totalbelanja + belanja;
	    	//HITUNG SUB TOTAL
	    	totalnya = (parseInt(hargajual_array[i].value) - parseInt(diskon_array[i].value)) * parseInt(jumlahbeli_array[i].value);
	    	if (isNaN(totalnya)) totalnya = totalnya || 0 ;
	    	total_array[i].value = totalnya;
	    	total = total + totalnya;
	    }
	    totalakhir = total - asuransi;
	    document.getElementsByName("totalbelanja")[0].value = totalbelanja;
	    document.getElementsByName("totaldiskon")[0].value = totaldiskon;
	   	document.getElementsByName("total")[0].value = totalakhir;
	   	var bayar1 = document.getElementsByName("bayar")[0].value;	
	   	kurang1 = parseInt(totalakhir) - parseInt(bayar1);
	   	if (isNaN(kurang1)) kurang1 = kurang1 || 0 ;
		document.getElementsByName("sisa")[0].value = kurang1;	
	}

	//HAPUS ITEM
	var stokakhir1 = 0;
	var stok_akhir1 = document.getElementsByName("stok[]");
	var stok_akhir_array1 = Array.prototype.slice.call(stok_akhir1);
	var jumlahbeli1 = document.getElementsByName("jumlahbeli[]");
	var jumlahbeli_array1 = Array.prototype.slice.call(jumlahbeli1);
	var bb = 0;
    for (bb = 0; bb < produk_detail.length; bb++) {
    var jml2 = parseInt(jumlahbeli_array1[bb].value);
	var stok2 = parseInt(stok_akhir_array1[bb].value);
	stokakhir1 = stok2 + jml2;
    (function(bb) {
        $("#hapusitem" + produk_detail[bb].id).click(function() {
        	window.localStorage['cekhitung'] = '1';
        	stok_akhir_array1[bb].value = stokakhir1;
        	document.getElementById("detailtransaksi"+produk_detail[bb].id).checked = false;
        });
      })(bb);
    }

	//HITUNG AWAL
	$('#tbsimpan').click(function(){
		window.localStorage['cekhitung'] = '0';
	});
	$('#tbkeranjang').click(function(){
		window.localStorage['cekhitung'] = '1';
	});
    $(window).load(function () {
	    window.localStorage['cekhitung'] = '0';
    });
    var cekhitung1 = window.localStorage['cekhitung'];
    if (cekhitung1 == 1){
    hitung();
    $('#tbsimpan').trigger('click');
    window.localStorage['cekhitung'] = '0';
    }

    //BAYAR CHANGE
	$("#bayar").keyup(function(){
		var bayar = document.getElementsByName("bayar")[0].value;
		var subtotal = document.getElementsByName("total")[0].value;
		var kurang = 0; 
		if(parseInt(bayar) < parseInt(subtotal)){
			kurang = parseInt(subtotal) - parseInt(bayar);
			if (isNaN(kurang)) kurang = kurang || 0 ;
		}
		else{
			kurang = 0;
		}
		document.getElementsByName("sisa")[0].value = kurang;
	});

	//DISKON CHANGE
	$("#totaldiskon").keyup(function(){
		var totalbelanja1 = document.getElementsByName("totalbelanja")[0].value;
		var totaldiskon1 = document.getElementsByName("totaldiskon")[0].value;
		var asuransi1 = document.getElementsByName("asuransi")[0].value;
		var bayar1 = document.getElementsByName("bayar")[0].value;
		var subtotal1 = 0; 
		var kurang1 = 0;
		subtotal1 = parseInt(totalbelanja1) - parseInt(totaldiskon1) - parseInt(asuransi1);
		kurang1 = parseInt(subtotal1) - parseInt(bayar1);
		if (isNaN(subtotal1)) subtotal1 = subtotal1 || 0 ;
		document.getElementsByName("total")[0].value = subtotal1;
		if (isNaN(kurang1)) kurang1 = kurang1 || 0 ;
		document.getElementsByName("sisa")[0].value = kurang1;
	});

	//SCAN BARCODE
	$("#cekbarcode").hide();
	var pressed = false; 
    var chars = []; 
    $(window).keypress(function(e) {
        //if (e.which >= 48 && e.which <= 57) {
        chars.push(String.fromCharCode(e.which));
        //}
        //console.log(e.which + ":" + chars.join("|"));
        if (pressed == false) {
            setTimeout(function(){
                //if (chars.length >= 5) {
                var barcode = chars.join("");
                //console.log("Barcode Scanned: " + barcode);
                $("#cekbarcode").val(barcode);
                pilihbarcode();
                //}
                chars = [];
                pressed = false;
            },500);
        }
        pressed = true;
    });
    //FUNGSI PILIH PRODUK LWT BARCODE
    function pilihbarcode(){
    	var barcodenya = document.getElementById('cekbarcode').value;
	    for(i2=0; i2 < daftar_produk.length; i2++){
	    	if(daftar_produk[i2].kodeproduk == barcodenya){
	    		document.getElementById("detailtransaksi"+daftar_produk[i2].id).checked = true;
	    		tbkeranjang.click();
	    	}
	    }	
    }
    
});
</script>
<!-- End JQuery -->