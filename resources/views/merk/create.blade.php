@extends('template')

@section('main')
	<div id="merk" class="panel panel-default">
		<div class="panel-heading"><b><h4>Tambah Merk/Brand Produk</h4></b></div>
		<div class="panel-body">
		{!! Form::open(['url' => 'merk','id'=>'formcreatemerk','onSubmit' => 'return ConfirmSimpanMerk()']) !!}
		@include('merk.form', ['submitButtonText' => 'Simpan Merk/Brand Produk'])
		{!! Form::close() !!}
		</div>
	</div>
	<script>
	<?php
		$csrf = json_encode(csrf_token());
		echo "var csrfToken ={$csrf}; ";
	?>
	//Prevent Submit
	var formcreatemerk = document.getElementById('formcreatemerk');
	formcreatemerk.addEventListener('submit', handleSubmit);
	var submitTimer;

	function handleSubmit(event) {
		console.log('submitTimer set');
		event.preventDefault();
		submitTimer = setTimeout(() => {
			this.submit();
			console.log('Submitted after 2 seconds');
		}, 2000);
	}

	function ConfirmSimpanMerk(){
		console.log("Simpan Server!");
		var a = document.getElementById("nama").value;
		var b = document.getElementById("keterangan").value;

		if(a != ""){
			var xmlhttp = new XMLHttpRequest();
		    var url = "http://arieskuspanwibowo.com/merksinkron";
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