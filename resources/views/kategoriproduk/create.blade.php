@extends('template')

@section('main')
	<div id="kategoriproduk" class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
			<div class="col-md-1">
				<a href="{{ URL::previous() }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a>
			</div>
			<div class="col-md-10">
				<b><h4 align="center">TAMBAH KATEGORI PRODUK</h4></b>
			</div>
			</div>
		</div>
		<div class="panel-body">
		{!! Form::open(['url' => 'kategoriproduk','id'=>'formcreatekategori','onSubmit' => 'return ConfirmSimpanKategori()']) !!}
		@include('kategoriproduk.form', ['submitButtonText' => 'Simpan Kategori Produk'])
		{!! Form::close() !!}
		</div>
	</div>
	<script>
	<?php
		$csrf = json_encode(csrf_token());
		echo "var csrfToken ={$csrf}; ";
	?>
	//Prevent Submit
	var formcreatekategori = document.getElementById('formcreatekategori');
	formcreatekategori.addEventListener('submit', handleSubmit);
	var submitTimer;

	function handleSubmit(event) {
		console.log('submitTimer set');
		event.preventDefault();
		submitTimer = setTimeout(() => {
			this.submit();
			console.log('Submitted after 2 seconds');
		}, 2000);
	}

	function ConfirmSimpanKategori(){
		console.log("Simpan Server!");
		var a = document.getElementById("nama").value;
		var b = document.getElementById("keterangan").value;

		if(a != ""){
			var xmlhttp = new XMLHttpRequest();
		    var url = "http://arieskuspanwibowo.com/kategorisinkron";
		    xmlhttp.open("POST", url, true);
		    xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
		    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("nama="+escape(a)+"&hargketerangan="+escape(b));
		    xmlhttp.onreadystatechange=function() {
		      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		      	var response = xmlhttp.responseText;
		        console.log(response);
		        return true;
		      }
		    }
		}
		else{
			return false;
		}
	}
	</script>
@stop

@section('footer')
	@include('footer')
@stop