@extends('template')

@section('main')
	<div id="kategoriproduk" class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
			<div class="col-md-1">
				<a href="{{ URL::previous() }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a>
			</div>
			<div class="col-md-10">
				<b><h4 align="center">UBAH KATEGORI PRODUK</h4></b>
			</div>
			</div>
		</div>
		<div class="panel-body">
		{!! Form::model($kategoriproduk,['method' => 'PATCH', 'action' => ['KategoriprodukController@update',$kategoriproduk->id],'id'=>'formeditkategori','onSubmit' => 'return ConfirmEditKategori()']) !!}
		@include('kategoriproduk.form',['submitButtonText' => 'Update Kategori Produk'])
		{!! Form::close() !!}
		</div>
	</div>
	<script>
	<?php
		$csrf = json_encode(csrf_token());
		echo "var csrfToken ={$csrf}; ";
	?>
	//Prevent Submit
	var formeditkategori = document.getElementById('formeditkategori');
	formeditkategori.addEventListener('submit', handleSubmit);
	var submitTimer;

	function handleSubmit(event) {
		console.log('submitTimer set');
		event.preventDefault();
		submitTimer = setTimeout(() => {
			this.submit();
			console.log('Submitted after 2 seconds');
		}, 2000);
	}

	function ConfirmEditKategori(){
		console.log("Simpan Server!");
		var id = parseInt(document.getElementById("id").value);
		var a = document.getElementById("nama").value;
		var b = document.getElementById("keterangan").value;

		if(a != ""){
			console.log(id);
			var xmlhttp = new XMLHttpRequest();
		    var url = "http://arieskuspanwibowo.com/editkategorisinkron";
		    xmlhttp.open("PUT", url, true);
		    xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
		    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.send("id="+escape(id)+"&nama="+escape(a)+"&keterangan="+escape(b));
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