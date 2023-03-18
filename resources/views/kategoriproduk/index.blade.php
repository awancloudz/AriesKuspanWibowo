@extends('template')

@section('main')
<div id="kategoriproduk" class="panel panel-default">
	<div class="panel-heading"><b><h4>Data Kategori Produk</h4></b></div>
	<div class="panel-body">
	@include('_partial.flash_message')
	@include('kategoriproduk.form_pencarian')
	<div class="tombol-nav">
		<a href="kategoriproduk/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Kategori Produk</a>
	</div>
	@if (count($kategoriproduk_list) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Kategori</th>
				<th>Keterangan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; ?>
			<?php foreach($kategoriproduk_list as $kategoriproduk): ?>
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $kategoriproduk->nama }}</td>
				<td>{{ $kategoriproduk->keterangan }}</td>
				<td>
					<div class="box-button">
					<!-- {{ link_to('kategoriproduk/' . $kategoriproduk->id . '/edit', 'Ubah', ['class' => 'btn btn-warning btn-sm']) }} -->
					<a href="{{ url('kategoriproduk/' . $kategoriproduk->id . '/edit') }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
					</div>
					<div class="box-button">
					<!-- {!! Form::open(['method' => 'DELETE', 'action' => ['KategoriprodukController@destroy',$kategoriproduk->id], 'onSubmit' => 'return ConfirmDelete()']) !!}
					{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
					{!! Form::close()!!} -->
					<form method="POST" id="formhapuskategori_{{$i}}" action="{{ url('kategoriproduk/' . $kategoriproduk->id) }}">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="DELETE"> 
					<button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Item" onClick="return ConfirmDeleteKategori({{ $kategoriproduk->id }})"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
					</form>
					</div>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data kategori produk.</p>
	@endif
	<div class="table-nav">
	<div class="jumlah-data">
		<strong>Jumlah Kategori Produk : {{ $jumlah_kategoriproduk}}</strong>
	</div>
	<div class="paging">
	{{ $kategoriproduk_list->links() }}
	</div>
	</div>

	</div>
</div>
<script>
    <?php
        $csrf = json_encode(csrf_token());
        echo "var csrfToken ={$csrf}; ";
		$panjang = count($kategoriproduk_list);
		echo "var panjang ={$panjang}; ";
    ?>
	//Set variable handlesubmit
	var formhapus = [];
	for(var i = 1; i < panjang; ++i) {
		formhapus[i] =  document.getElementById('formhapuskategori_'+ i);
		formhapus[i].addEventListener('submit', handleSubmit);
	}
	var submitTimer;

	function handleSubmit(event) {
		console.log('submitTimer set');
		event.preventDefault();
		submitTimer = setTimeout(() => {
			this.submit();
			console.log('Submitted after 2 seconds');
		}, 2000);
	}

  	function ConfirmDeleteKategori(idkategori){
		var x = confirm("Yakin hapus data kategori?");
		if(x)
			hapusserverkategori(idkategori);
		else
			return false;
  	}

  	function hapusserverkategori(id){
		console.log(id);
		var xmlhttp = new XMLHttpRequest();
		var url = "http://arieskuspanwibowo.com/hapuskategorisinkron";
		xmlhttp.open("POST", url, true);
		xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+escape(id));
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var response = xmlhttp.responseText;
				console.log(response);
				return true;
			}
    	}
  	}
</script>
@stop

@section('footer')
	@include('footer')
@stop