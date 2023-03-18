@extends('template')

@section('main')
	<div id="produk" class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
			<div class="col-md-1">
				<a href="{{ URL::previous() }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a>
			</div>
			<div class="col-md-10">
				<b><h4 align="center">TAMBAH DATA PRODUK</h4></b>
			</div>
			</div>
		</div>
		<div class="panel-body">
		{!! Form::open(['url' => 'produk', 'files' => true, 'id'=>'formcreateproduk', 'onSubmit' => 'return ConfirmSimpanProduk()']) !!}
		@include('produk.form2', ['submitButtonText' => 'Simpan Produk'])
		{!! Form::close() !!}
		</div>
	</div>
	<script>
	<?php
		$csrf = json_encode(csrf_token());
		echo "var csrfToken ={$csrf}; ";
	?>

	//Prevent Submit
	var formcreateproduk = document.getElementById('formcreateproduk');
	formcreateproduk.addEventListener('submit', handleSubmit);
	var submitTimer;

	function handleSubmit(event) {
		console.log('submitTimer set');
		event.preventDefault();
		submitTimer = setTimeout(() => {
			this.submit();
			console.log('Submitted after 2 seconds');
		}, 2000);
	}

	function ConfirmSimpanProduk(){
		var a = document.getElementById("kodeproduk").value;
		var b = parseInt(document.getElementById("hargajual").value);
		var c = document.getElementById("namaproduk").value;
		var d = parseInt(document.getElementById("hargagrosir").value);
		var e = parseInt(document.getElementById("hargadistributor").value);
		var f = parseInt(document.getElementById("id_kategoriproduk").value);
		var g = parseInt(document.getElementById("id_merk").value);
		var h = parseInt(document.getElementById("diskon").value);
		var i = parseInt(document.getElementById("stok").value);

		if(a != "" && b != null && c != "" && d != null && e != null && f != null && g != null && h != null && i != null){
			console.log("Isi");
			var xmlhttp = new XMLHttpRequest();
		    var url = "http://arieskuspanwibowo.com/produksinkron";
		    xmlhttp.open("POST", url, true);
		    xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
		    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.send("kodeproduk="+escape(a)+"&hargajual="+escape(b)+"&namaproduk="+escape(c)+"&hargagrosir="+escape(d)+"&hargadistributor="+escape(e)+"&id_kategoriproduk="+escape(f)+"&id_merk="+escape(g)+"&diskon="+escape(h)+"&stok="+escape(i));
		    xmlhttp.onreadystatechange=function() {
		      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		      	var response = xmlhttp.responseText;
		        console.log(response);
		        return true;
		      }
		    }
		}
		else{
			console.log("Kosong");
			return false;
		}
	}
	</script>
@stop

@section('footer')
	@include('footer')
@stop