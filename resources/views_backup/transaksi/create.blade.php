@extends('template')

@section('main')
	<div id="transaksi" class="panel panel-default">
		<div class="panel-heading"><b><h4>Tambah Transaksi</h4></b></div>
		<div class="panel-body">
		@include('_partial.flash_message')
		{!! Form::open(['id'=>'myform','url' => 'transaksi', 'files' => true]) !!}
		@include('transaksi.form', ['submitButtonText' => 'Simpan Transaksi'])
		{!! Form::close() !!}
		</div>
	</div>

	<!--JQuery-->
	<script type="text/javascript">
	$(document).ready(function(){
		<?php
			//Deteksi Admin / Karyawan
			//$idusernya = Auth::user()->id;
			//$namausernya = Auth::user()->name;
			//echo "var idusernya = '{$idusernya}'; var namausernya = '{$namausernya}';";

			//Deteksi kode transaksi
			if($transaksi->count() > 0){
			$kd = "TRX-".sprintf("%05s", $kodeakhir->id + 1);
			}
			else
			{
			$kd = "TRX-00001";
			}
			echo "var kd = '{$kd}';";
		?>
		
		//Memberikan value karyawan
		//$("#id_users > [value=" + idusernya + "]").attr("selected", "true");
		//$("#inputkaryawan").hide();
		//document.getElementById("txtkaryawan").innerHTML = "<b>Admin / Karyawan : </b><i>" + namausernya + "</i>";

		//Memberikan value kode transaksi
		document.getElementById("kodetransaksi").value = kd;
	});
	</script>
	<!--End JQuery-->
@stop

@section('footer')
	@include('footer')
@stop