@extends('template')

@section('main')
<div id="produk" class="panel panel-default">
<?php
function rupiah($nilai, $pecahan = 0) {
	return "Rp. " . number_format($nilai, $pecahan, ',', '.');
} 
$tanggal = date('Y-m-d');
?>
<style>
#id_customer{
 width:500px;   
}
#id_cabang{
 width:500px;   
}
</style>
{!! Form::open(['url' => 'transaksi','name' => 'formtrans']) !!}
{!! Form::hidden('jenis', $jenis) !!}
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" style="margin-top:100px;">
<div class="modal-dialog modal-lg">
	<!-- Modal Produk-->
	<div class="modal-content">
		<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div align="center"><b>DAFTAR BELANJA</b></div>
        </div>
		@if (count($keranjang) > 0)
        <div class="modal-body">
			@if($jenis == 'pembelian')
			<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_customer','&nbsp;&nbsp;Pilih Distributor',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-8">
				@if(count($list_customer) > 0)
				{!! Form::select('id_customer', $list_distributor, null,['class' => 'form-control js-example-basic-single', 'id'=>'id_customer','placeholder'=>'Pilih Distributor']) !!}
				@else
				<p>Tidak ada pilihan distributor,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('noinvoice','&nbsp;&nbsp;No.Invoice',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-8">
				{!! Form::text('noinvoice', null,['class' => 'form-control']) !!}
				</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('status','&nbsp;&nbsp;Status Bayar',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-8">
					<label>
					{!! Form::radio('status','lunas',['checked']) !!} Lunas
					</label>&nbsp;
					<label>
					{!! Form::radio('status','belum') !!} Belum Lunas
					</label>
				</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('statusdiskon','&nbsp;&nbsp;Tampil Diskon',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-8">
					<label>
					{!! Form::radio('statusdiskon','ya',['checked']) !!} Ya
					</label>&nbsp;
					<label>
					{!! Form::radio('statusdiskon','tidak') !!} Tidak
					</label>
				</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('tanggal','&nbsp;&nbsp;Pilih Tanggal',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-8">
				{!! Form::date('tanggal', $tanggal) !!}
				</div>
			</div>
			</div>
			@elseif($jenis == 'grosir')
			<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_customer','&nbsp;&nbsp;Pilih Pelanggan',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-8">
				@if(count($list_customer) > 0)
				{!! Form::select('id_customer', $list_customer, null,['class' => 'form-control js-example-basic-single', 'id'=>'id_customer','placeholder'=>'Pilih Pelanggan']) !!}
				@else
				<p>Tidak ada pilihan pelanggan,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('statusdiskon','&nbsp;&nbsp;Tampil Diskon',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-8">
					<label>
					{!! Form::radio('statusdiskon','ya',['checked']) !!} Ya
					</label>&nbsp;
					<label>
					{!! Form::radio('statusdiskon','tidak') !!} Tidak
					</label>
				</div>
			</div>
			</div>
			{!! Form::hidden('tanggal', $tanggal) !!}
			{!! Form::hidden('status', 'lunas') !!}
			@elseif($jenis == 'kirimcabang')
			<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_cabang','&nbsp;&nbsp;Pilih Cabang',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-8">
				@if(count($list_cabang) > 0)
				{!! Form::select('id_cabang', $list_cabang, null,['class' => 'form-control js-example-basic-single', 'id'=>'id_cabang','placeholder'=>'Pilih Cabang']) !!}
				@else
				<p>Tidak ada pilihan cabang,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('statusdiskon','&nbsp;&nbsp;Tampil Diskon',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-8">
					<label>
					{!! Form::radio('statusdiskon','ya',['checked']) !!} Ya
					</label>&nbsp;
					<label>
					{!! Form::radio('statusdiskon','tidak') !!} Tidak
					</label>
				</div>
			</div>
			</div>
			{!! Form::hidden('id_customer', 1) !!}
			{!! Form::hidden('tanggal', $tanggal) !!}
			{!! Form::hidden('status', 'lunas') !!}
			@elseif($jenis == 'retail')
			{!! Form::hidden('id_customer', 1) !!}
			{!! Form::hidden('tanggal', $tanggal) !!}
			{!! Form::hidden('status', 'lunas') !!}
			{!! Form::hidden('statusdiskon', 'ya') !!}
			@endif
		<table class="table">
		<thead>
			<tr>
				<th>Kode</th>
				<th>Nama</th>
				<th>Harga</th>
				<td align="center"><b>Jumlah</td>
				<th>Diskon 1 (Rp)</th>
				<th>Diskon 2 (%)</th>
				<th>Total</th>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<?php 
			$totalbelanja = 0;
			$totaldiskon = 0;
			$subtotal = 0;
			$iduser = "";
			if(Auth::check()){
				$iduser = Auth::user()->id;
				settype($iduser, "integer");
				$idtoko = Auth::user()->id_profile;
        		$level = Auth::user()->level;
			}
			?>
			{!! Form::hidden('id_users', $iduser) !!}
			{!! Form::hidden('id_profile', $idtoko) !!}
			@if($level != 'kasircabang')
				{!! Form::hidden('statustoko', 'pusat') !!}
			@else
				{!! Form::hidden('statustoko', 'cabang') !!}
			@endif
			
			@foreach($keranjang as $cart)
			<tr id="baris_{{ $cart->id }}">
				<td>{{ $cart->produk->kodeproduk }}</td>
				<td>{{ $cart->produk->namaproduk }}</td>
				@if($jenis == 'pembelian')
				<td>{{ rupiah($cart->produk->hargadistributor) }}</td>
				@elseif($jenis == 'retail')
					@if($cabang == 0)
					<td>{{ rupiah($cart->produk->hargajual) }}</td>
					@elseif($cabang == 1)
						@foreach($produk_list as $produk)
							@if($produk->id == $cart->produk->id)
							<td>{{ rupiah($produk->hargajual) }}</td>
							@endif
						@endforeach
					@endif
				@elseif($jenis == 'grosir')
				<td>{{ rupiah($cart->produk->hargagrosir) }}</td>
				@elseif($jenis == 'kirimcabang')
				<td>{{ rupiah($cart->produk->hargagrosir) }}</td>
				@endif
				<td><span class="glyphicon glyphicon-minus" id="dec" onclick="decNumber({{ $cart->id }})"></span>
				&nbsp;
				<input type="text" value="{{ $cart->jumlah }}" id="jumlahcart_{{ $cart->id }}" size="4" style="text-align:center;" onkeyup="ketikJumlah({{ $cart->id }})">
				&nbsp;
				<span class="glyphicon glyphicon-plus" id="inc" onclick="incNumber({{ $cart->id }})"></span>
				</td>
				<?php
				if($jenis == 'pembelian'){
					if($cart->diskon != 0){
					$nominaldiskon = ($cart->diskon / 100) * $cart->produk->hargadistributor;
					}
					else{
					$nominaldiskon = 0;	
					}
					$hargaperbaris = $cart->produk->hargadistributor * $cart->jumlah;
				}
				else if($jenis == 'retail'){
					if($cabang == 0){
						if($cart->diskon != 0){
							$nominaldiskon = ($cart->diskon / 100) * $cart->produk->hargajual;
						}
						else{
							$nominaldiskon = 0;	
						}
						$hargaperbaris = $cart->produk->hargajual * $cart->jumlah;
					}
					elseif($cabang == 1){
						foreach($produk_list as $produk){
							if($produk->id == $cart->produk->id){
								if($cart->diskon != 0){
									$nominaldiskon = ($cart->diskon / 100) * $produk->hargajual;
								}
								else{
									$nominaldiskon = 0;	
								}
								$hargaperbaris = $produk->hargajual * $cart->jumlah;
							}
						}
					}	
				}
				else if($jenis == 'grosir'){
					if($cart->diskon != 0){
					$nominaldiskon = ($cart->diskon / 100) * $cart->produk->hargagrosir;
					}
					else{
					$nominaldiskon = 0;	
					}
					$hargaperbaris = $cart->produk->hargagrosir * $cart->jumlah;
				}
				else if($jenis == 'kirimcabang'){
					if($cart->diskon != 0){
					$nominaldiskon = ($cart->diskon / 100) * $cart->produk->hargagrosir;
					}
					else{
					$nominaldiskon = 0;	
					}
					$hargaperbaris = $cart->produk->hargagrosir * $cart->jumlah;
				}
				//Diskon persen
				$diskonperbaris = $cart->jumlah * $cart->diskonrp;
				$diskonperbaris2 =  $cart->jumlah * $nominaldiskon;
				$diskonplus = $diskonperbaris + $diskonperbaris2;
				$totalbeli =  $hargaperbaris - $diskonplus;
				?>
				<td><input type="text" value="{{ $cart->diskonrp }}" class="diskon_{{ $cart->id }}" id="diskon_{{ $cart->id }}" size="10" onkeyup="ketikRupiah({{ $cart->id }})">
				<!-- <span id="txtdiskon_{{ $cart->id }}" class="txtdiskon_{{ $cart->id }}">{{ rupiah($diskonperbaris) }}</span> -->
				</td>
				<td><input type="text" value="{{ $cart->diskon }}" id="diskoncart_{{ $cart->id }}" size="4" style="text-align:center;" onkeyup="ketikDiskon({{ $cart->id }})"> %</td>
				<td><span id="txttotalbeli_{{ $cart->id }}" class="txttotalbeli_{{ $cart->id }}">{{ rupiah($totalbeli) }}</span></td>
				<td><button id="dec" onclick="hapusitem({{ $cart->id }})" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Item">
				<span class="glyphicon glyphicon-remove"></span></button></td>
			</tr>
			@if($jenis == 'pembelian')
			<input type="hidden" value="{{ $cart->produk->hargadistributor }}" id="harga_{{ $cart->id }}">
			@elseif($jenis == 'retail')
				@if($cabang == 0)
				<input type="hidden" value="{{ $cart->produk->hargajual }}" id="harga_{{ $cart->id }}">
				@elseif($cabang == 1)
					@foreach($produk_list as $produk)
						@if($produk->id == $cart->produk->id)
						<input type="hidden" value="{{ $produk->hargajual }}" id="harga_{{ $cart->id }}">
						@endif
					@endforeach
				@endif
			@elseif($jenis == 'grosir')
			<input type="hidden" value="{{ $cart->produk->hargagrosir }}" id="harga_{{ $cart->id }}">
			@elseif($jenis == 'kirimcabang')
			<input type="hidden" value="{{ $cart->produk->hargagrosir }}" id="harga_{{ $cart->id }}">
			@endif
			<input type="hidden" value="{{ $nominaldiskon }}" id="diskon2_{{ $cart->id }}">
			@if($cabang == 0)
			<input type="hidden" value="{{ $cart->produk->stok }}" id="stokawal_{{ $cart->id }}">
			@elseif($cabang == 1)
				@foreach($produk_list as $produk)
					@if($produk->id == $cart->produk->id)
					<input type="hidden" value="{{ $produk->stok }}" id="stokawal_{{ $cart->id }}">
					@endif
				@endforeach
			@endif
			<input type="hidden" value="{{ $diskonplus }}" id="valdiskon_{{ $cart->id }}">
			<input type="hidden" value="{{ $totalbeli }}" id="valtotalbeli_{{ $cart->id }}">
			<?php
			$totalbelanja = $totalbelanja + $hargaperbaris;
			$totaldiskon = $totaldiskon + $diskonplus;
			?>
			@endforeach
			<?php $subtotal = $totalbelanja - $totaldiskon; ?>
			<tr><td colspan="5" align="right"><b>Total Belanja</td><td colspan="2"><span id="txttotalbelanja">{{ rupiah($totalbelanja) }}</span></td></tr>
			<tr><td colspan="5" align="right"><b>Total Diskon</td><td colspan="2"><span id="txttotaldiskon">{{ rupiah($totaldiskon) }}</span></td></tr>
			<tr><td colspan="5" align="right"><b>Sub Total</td><td colspan="2"><span id="txtsubtotal">{{ rupiah($subtotal) }}</span></td></tr>
			<tr><td colspan="5" align="right"><b>Bayar</td>
				<td colspan="5">
				<input type="text" value="" id="txtbayarcash" onkeyup="ketikBayar()">
				</td>
			</tr>
			<tr><td colspan="5" align="right"><b>Kembali</td><td colspan="2"><span id="txtkembali">{{ rupiah(0) }}</span></td></tr>
			{!! Form::hidden('totaldiskon', $totaldiskon, ['id'=>'totaldiskon']) !!}
			{!! Form::hidden('totalbelanja', $totalbelanja, ['id'=>'totalbelanja']) !!}
			{!! Form::hidden('subtotal', $subtotal, ['id'=>'subtotal']) !!}
			{!! Form::hidden('bayar', null, ['id'=>'bayar']) !!}
			{!! Form::hidden('kembali', null, ['id'=>'kembali']) !!}
		</tbody>
		</table>
		</div>
		<div class="modal-footer">
		<div class="row">
			<div class="col-md-8"></div>
			<div class="col-md-4">
			@if($jenis == 'pembelian')
			{!! Form::button('SIMPAN <i class="glyphicon glyphicon-chevron-right"></i>', ['class'=>'btn btn-success btn-md form-control','type'=>'submit','id'=>'tombolbayar']) !!}
			@elseif($jenis == 'kirimcabang')
			{!! Form::button('UPDATE STOK <i class="glyphicon glyphicon-chevron-right"></i>', ['class'=>'btn btn-success btn-md form-control','type'=>'submit','id'=>'tombolbayar']) !!}
			@else
			{!! Form::button('BAYAR <i class="glyphicon glyphicon-chevron-right"></i>', ['class'=>'btn btn-success btn-md form-control','type'=>'submit','id'=>'tombolbayar']) !!}
			@endif
			</div>
		</div>
		</div>
		@else
		<div class="modal-body">
		<p align="center">[ DAFTAR Belanja Kosong ]</p>
		</div>
		@endif
		
	</div>
</div>
</div>
<!-- End Modal -->
{!! Form::close() !!}
<!-- Nama Kategori -->
	<div class="panel-heading">
	@include('_partial.flash_message')
		<div class="row">
			<div class="col-md-8">
			<b><h4>Input Data Transaksi - <?php echo ucfirst($jenis); ?></h4></b>
			@include('transaksi.form_pencarian_barcode2')
			</div>
			<div class="col-md-4">
			<button type="button" class="btn btn-danger btn-lg text-center" id="cmd_keranjang">
			<span class="glyphicon glyphicon-shopping-cart"></span><br>Daftar Belanja <span class="badge">{{ $jumlahkeranjang }}</span>
			</button>
			@if (count($keranjang) > 0)
				@if($jenis == 'pembelian')
					<button type="button" class="btn btn-success btn-lg text-center" id="cmd_bayar">
					<span class="glyphicon glyphicon-floppy-disk"></span><br>Simpan Pembelian
					</button>
				@elseif($jenis == 'kirimcabang')
					<button type="button" class="btn btn-success btn-lg text-center" id="cmd_bayar">
					<span class="glyphicon glyphicon-transfer"></span><br>Update Stok
					</button>
				@else
					<button type="button" class="btn btn-success btn-lg text-center" id="cmd_bayar">
					<span class="glyphicon glyphicon-print"></span><br>Proses Pembayaran
					</button>
				@endif
			@endif
			</div>
		</div>
	</div>
	<div class="panel-body">
	@if (count($produk_list) > 0)
	<table id="tabelproduk" class="display compact">
		<thead>
			<tr>
				<th>Kode Produk</th>
				<th>Nama Produk</th>
				<th>Merk</th>
				<th>Harga</th>
				<th>Diskon</th>
				<th>Stok</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php $i=0; ?>
		@foreach($produk_list as $produk)
			<tr>
				<td>{{ $produk->kodeproduk }}</td>
				<td>{{ $produk->namaproduk }}</td>
				@if($cabang == 0)
				<td>{{ $produk->merk->nama }}</td>
				@elseif($cabang == 1)
				<td>{{ $produk->produk->merk->nama }}</td>
				@endif
				@if($jenis == 'pembelian')
				<td>{{ rupiah($produk->hargadistributor) }}</td>
				@elseif($jenis == 'retail')
				<td>{{ rupiah($produk->hargajual) }}</td>
				@elseif($jenis == 'grosir')
				<td>{{ rupiah($produk->hargagrosir) }}</td>
				@elseif($jenis == 'kirimcabang')
				<td>{{ rupiah($produk->hargagrosir) }}</td>
				@endif
				<td>{{ rupiah($produk->diskon) }}</td>
				@if($produk->stok <= 5)
				<td><font color="red"><b>{{ $produk->stok }}</font></td>
				@else
				<td>{{ $produk->stok }}</td>
				@endif
				@if($produk->stok > 0)
				<td>
					<div class="box-button"> 
					<a href="{{ url('transaksi/item/' . $produk->id . '/jenis/' . $jenis) }}" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-check"></i> Pilih</a>
					</div>
				</td>
				@else
				<td>
					@if($jenis == 'pembelian')
					<div class="box-button"> 
					<a href="{{ url('transaksi/item2/' . $produk->id . '/jenis/' . $jenis) }}" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-check"></i> Pilih</a>
					</div>
					@else
					<div class="box-button"> 
					<a href="{{ url('#') }}" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i> Kosong</a>
					</div>
					@endif
				</td>
				@endif
			</tr>
		@endforeach
		</tbody>
	</table>
	@else
	<p>Tidak ada data produk.</p>
	@endif
	</div>
</div>

<script>
<?php
$panjang = count($keranjang);
$csrf = json_encode(csrf_token());
echo "var csrfToken ={$csrf}; ";
echo "var keranjang ={$keranjang}; ";
echo "var panjang ={$panjang}; ";
echo "var jenis ='$jenis'; ";
?>
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
     {'width':'818px','border-radius':'5px','margin-left':'1px'}
  	);
	$('.dataTables_length').addClass('pull-right');

	$('.js-example-basic-single').select2();
	$("#cmd_keranjang").click(function(){
		$("#myModal").modal();
	});
	$("#cmd_bayar").click(function(){
		document.getElementById("tombolbayar").click();
	});
	$('[data-toggle="tooltip"]').tooltip(); 
});

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
//Tombol jumlah + -
function incNumber(i){
	var stokawal = parseInt(document.getElementById("stokawal_" + i).value);
	var c = parseInt(document.getElementById("jumlahcart_" + i).value);
	
	if(jenis != 'pembelian'){
		if((stokawal != 0) && (stokawal > c)){
		c++;
		updatejumlah(i,c);
		document.getElementById("jumlahcart_" + i).value = c;
		}
		else{
			alert("Stok Tidak Mencukupi,stok maksimum adalah : " + stokawal);
			document.getElementById("jumlahcart_" + i).value = stokawal;
		}
	}
	else{
		c++;
		updatejumlah(i,c);
		document.getElementById("jumlahcart_" + i).value = c;
	}	
}
function decNumber(i){
	var stokawal = parseInt(document.getElementById("stokawal_" + i).value);
	var c = parseInt(document.getElementById("jumlahcart_" + i).value);
	if(c > 1){
	c--;
	updatejumlah(i,c);
	}
	document.getElementById("jumlahcart_" + i).value = c;
}
function ketikJumlah(i){
	var c = parseInt(document.getElementById("jumlahcart_" + i).value);
	var stokawal = parseInt(document.getElementById("stokawal_" + i).value);
	c = c ? c : 0;

	if(jenis != 'pembelian'){
		if((stokawal != 0) && (c <= stokawal)){
			if((c != 0) || (c != '')) {
			updatejumlah(i,c);
			}
			document.getElementById("jumlahcart_" + i).value = c;
		}
		else{
			alert("Stok Tidak Mencukupi,stok maksimum adalah : " + stokawal);
			document.getElementById("jumlahcart_" + i).value = stokawal;
			ketikJumlah(i);
		}
	}
	else{
		if((c != 0) || (c != '')) {
			updatejumlah(i,c);
		}
		document.getElementById("jumlahcart_" + i).value = c;
	}
}
function ketikRupiah(i){
	var j = parseInt(document.getElementById("jumlahcart_" + i).value);
	var r = parseInt(document.getElementById("diskon_" + i).value);
	r = r ? r : 0;
	//if((d != 0) || (d != '')) {
	updaterupiah(i,r,j);
	//}
	document.getElementById("diskon_" + i).value = r;
}
function ketikDiskon(i){
	var j = parseInt(document.getElementById("jumlahcart_" + i).value);
	var d = parseInt(document.getElementById("diskoncart_" + i).value);
	d = d ? d : 0;
	//if((d != 0) || (d != '')) {
	updatediskon(i,d,j);
	//}
	document.getElementById("diskoncart_" + i).value = d;
}
function ketikBayar(){
	var subtotal = parseInt(document.getElementById("subtotal").value);
	var bayar = parseInt(document.getElementById("txtbayarcash").value);
	var kembalian = 0;
	bayar = bayar ? bayar : 0;
	if((bayar != 0) || (bayar != '') || (bayar >= subtotal)) {
		kembalian = bayar - subtotal;
		if(kembalian >= 0){
			document.getElementById("txtkembali").innerHTML = rupiah(kembalian);
			document.getElementById("bayar").value = bayar;
			document.getElementById("kembali").value = kembalian;
		}
		else{
			document.getElementById("txtkembali").innerHTML = rupiah(0);	
			document.getElementById("bayar").value = 0;
			document.getElementById("kembali").value = 0;
		}
	}
}
function updatejumlah(id,jml){
	//Simpan QTY baru
	var xmlhttp = new XMLHttpRequest();
    var url = "../keranjang";
    xmlhttp.open("PUT", url, true);
    xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+escape(id)+"&jumlah="+escape(jml));
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        console.log("Simpan OK");
      }
    }
	//Variabel Hitung
	var harga = parseInt(document.getElementById("harga_" + id).value);
	var diskon1 = parseInt(document.getElementById("diskon_" + id).value);
	var diskon2 = parseInt(document.getElementById("diskon2_" + id).value);
	var diskon = diskon1 + diskon2;
	//Penghitungan
	var hargaperbaris = jml * harga;
	var diskonperbaris = jml * diskon;
	var diskonperbaris1 = jml * diskon1;
	var totalbeli = hargaperbaris - diskonperbaris;
	//Value baru
	//document.getElementById("txtdiskon_" + id).innerHTML = rupiah(diskonperbaris1);
	document.getElementById("txttotalbeli_" + id).innerHTML = rupiah(totalbeli);
	document.getElementById("valdiskon_" + id).value = diskonperbaris;
	document.getElementById("valtotalbeli_" + id).value = totalbeli;
	hitungtotal();
}
function updaterupiah(id,jmld,jml){
	//Simpan Persen Diskon baru
	var xmlhttp = new XMLHttpRequest();
    var url = "../keranjang";
    xmlhttp.open("PUT", url, true);
    xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+escape(id)+"&diskonrp="+escape(jmld));
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        console.log("Simpan OK");
      }
  	}
	//Variabel Hitung
	var harga = parseInt(document.getElementById("harga_" + id).value);
	var diskon1 = parseInt(jmld);
	var jmlpersen = parseInt(document.getElementById("diskoncart_" + id).value);
	console.log(jmlpersen);
	if(jmlpersen != 0){
	var diskon2 = (parseInt(jmlpersen) / 100) * harga;
	}
	else{
	var diskon2 = 0;	
	}
	var diskon = diskon1 + diskon2;
	//Penghitungan
	var hargaperbaris = jml * harga;
	var diskonperbaris = jml * diskon;
	var diskonperbaris1 = jml * diskon1;
	var totalbeli = hargaperbaris - diskonperbaris;
	//Value baru
	document.getElementById("diskon2_" + id).value = diskon2;
	document.getElementById("txttotalbeli_" + id).innerHTML = rupiah(totalbeli);
	document.getElementById("valdiskon_" + id).value = diskonperbaris;
	document.getElementById("valtotalbeli_" + id).value = totalbeli;
	hitungtotal();
}
function updatediskon(id,jmld,jml){
	//Simpan Persen Diskon baru
	var xmlhttp = new XMLHttpRequest();
    var url = "../keranjang";
    xmlhttp.open("PUT", url, true);
    xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+escape(id)+"&diskon="+escape(jmld));
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        console.log("Simpan OK");
      }
  	}
	//Variabel Hitung
	var harga = parseInt(document.getElementById("harga_" + id).value);
	var diskon1 = parseInt(document.getElementById("diskon_" + id).value);
	if(jmld != 0){
	var diskon2 = (parseInt(jmld) / 100) * harga;
	}
	else{
	var diskon2 = 0;	
	}
	var diskon = diskon1 + diskon2;
	//Penghitungan
	var hargaperbaris = jml * harga;
	var diskonperbaris = jml * diskon;
	var diskonperbaris1 = jml * diskon1;
	var totalbeli = hargaperbaris - diskonperbaris;
	//Value baru
	document.getElementById("diskon2_" + id).value = diskon2;
	document.getElementById("txttotalbeli_" + id).innerHTML = rupiah(totalbeli);
	document.getElementById("valdiskon_" + id).value = diskonperbaris;
	document.getElementById("valtotalbeli_" + id).value = totalbeli;
	hitungtotal();
}
function hapusitem(id){
	var xmlhttp2 = new XMLHttpRequest();
	var url2 = "../keranjang/" + id;
	xmlhttp2.open("DELETE", url2, true);
    xmlhttp2.setRequestHeader('x-csrf-token', csrfToken);
    xmlhttp2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp2.send();
    xmlhttp2.onreadystatechange=function() {
      if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
        console.log("Hapus OK");
		$("#baris_" + id).remove();
		location.reload();
      }
    }
}
function hitungtotal(){
	//Total semua
	var totalbelanja = 0;
	var totaldiskon = 0;
	var subtotal = 0;
  var i=0;

	Object.keys(keranjang).forEach(function(i){
    $("#valdiskon_" + keranjang[i].id).each(function() {
      totaldiskon += +$(this).val()||0;
    }); 
		$("#valtotalbeli_" + keranjang[i].id).each(function() {
      subtotal += +$(this).val()||0;
    }); 
	});

	totalbelanja = subtotal + totaldiskon;
	document.getElementById("txttotalbelanja").innerHTML = rupiah(totalbelanja);
	document.getElementById("txttotaldiskon").innerHTML = rupiah(totaldiskon);
	document.getElementById("txtsubtotal").innerHTML = rupiah(subtotal);
	document.getElementById("totalbelanja").value = totalbelanja;
	document.getElementById("totaldiskon").value = totaldiskon;
	document.getElementById("subtotal").value = subtotal;
}
</script>
@stop

@section('footer')
	@include('footer')
@stop