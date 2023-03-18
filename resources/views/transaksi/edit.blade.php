@extends('template')

@section('main')
	<div id="transaksi" class="panel panel-default">
		<div class="panel-heading"><b><h4>Ubah Transaksi</h4></b></div>
		<div class="panel-body">
		@include('_partial.flash_message')
		{!! Form::model($transaksi, ['method' => 'PATCH','id'=>'myform', 'action' => ['TransaksiController@update', $transaksi->id],'files'=>true]) !!}
		@include('transaksi.form', ['submitButtonText' => 'Simpan Transaksi'])
		{!! Form::close() !!}
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
		//Memberikan value karyawan	
		//$("#inputkaryawan").hide();
		//var txtkaryawanawal = document.getElementById("id_users").value;
		//var txtkaryawanext = $("#id_users option[value='"+ txtkaryawanawal +"']").text();
		//document.getElementById("txtkaryawan").innerHTML = "<b>Admin / Karyawan : </b><i>" + txtkaryawanext + "</i>";
	});
	</script>
@stop

@section('footer')
	@include('footer')
@stop