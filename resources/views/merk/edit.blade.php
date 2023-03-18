@extends('template')

@section('main')
	<div id="merk" class="panel panel-default">
		<div class="panel-heading"><b><h4>Ubah Merk/Brand Produk</h4></b></div>
		<div class="panel-body">
		{!! Form::model($merk,['method' => 'PATCH', 'action' => ['MerkController@update',$merk->id],'id'=>'formeditmerk','onSubmit' => 'return ConfirmEditMerk()']) !!}
		@include('merk.form',['submitButtonText' => 'Update Merk/Brand Produk'])
		{!! Form::close() !!}
		</div>
	</div>
	<script>
	<?php
		$csrf = json_encode(csrf_token());
		echo "var csrfToken ={$csrf}; ";
	?>
	//Prevent Submit
	var formeditmerk = document.getElementById('formeditmerk');
	formeditmerk.addEventListener('submit', handleSubmit);
	var submitTimer;

	function handleSubmit(event) {
		console.log('submitTimer set');
		event.preventDefault();
		submitTimer = setTimeout(() => {
			this.submit();
			console.log('Submitted after 2 seconds');
		}, 2000);
	}

	function ConfirmEditMerk(){
		console.log("Simpan Server!");
		var id = parseInt(document.getElementById("id").value);
		var a = document.getElementById("nama").value;
		var b = document.getElementById("keterangan").value;

		if(a != ""){
			console.log(id);
			var xmlhttp = new XMLHttpRequest();
		    var url = "http://arieskuspanwibowo.com/editmerksinkron";
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