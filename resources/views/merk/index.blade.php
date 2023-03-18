@extends('template')

@section('main')
<div id="merk" class="panel panel-default">
	<div class="panel-heading"><b><h4>Merk/Brand Produk</h4></b></div>
	<div class="panel-body">
	@include('_partial.flash_message')
	@include('merk.form_pencarian')
	<div class="tombol-nav">
		<a href="merk/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Merk/Brand Produk</a>
	</div>
	@if (count($merk_list) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Merk/Brand</th>
				<th>Keterangan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; ?>
			<?php foreach($merk_list as $merk): ?>
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $merk->nama }}</td>
				<td>{{ $merk->keterangan }}</td>
				<td>
					<div class="box-button">
					<a href="{{ url('merk/' . $merk->id . '/edit') }}" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
					</div>
					<div class="box-button">
					<!-- {!! Form::open(['method' => 'DELETE', 'action' => ['MerkController@destroy',$merk->id], 'onSubmit' => 'return ConfirmDelete()']) !!}
					{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
					{!! Form::close()!!} -->
					<form method="POST" id="formhapusmerk_{{$i}}" action="{{ url('merk/' . $merk->id) }}">
					{{ csrf_field() }}
					<input type="hidden" name="_method" value="DELETE"> 
					<button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Item" onClick="return ConfirmDeleteMerk({{ $merk->id }})"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
					</form>
					</div>
					<a href="{{ url('merk/cetakharga/' . $merk->id) }}" class="btn btn-success btn-sm" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Harga</a>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data merk produk.</p>
	@endif
	<div class="table-nav">
	<div class="jumlah-data">
		<strong>Jumlah Merk/Brand Produk : {{ $jumlah_merk}}</strong>
	</div>
	<div class="paging">
	{{ $merk_list->links() }}
	</div>
	</div>

	</div>
</div>
<script>
    <?php
        $csrf = json_encode(csrf_token());
        echo "var csrfToken ={$csrf}; ";
		$panjang = count($merk_list);
		echo "var panjang ={$panjang}; ";
    ?>
	//Set variable handlesubmit
	var formhapus = [];
	for(var i = 1; i < panjang; ++i) {
		formhapus[i] =  document.getElementById('formhapusmerk_'+ i);
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

  	function ConfirmDeleteMerk(idmerk){
		var x = confirm("Yakin hapus data merk?");
		if(x)
			hapusservermerk(idmerk);
		else
			return false;
  	}

  	function hapusservermerk(id){
		console.log(id);
		var xmlhttp = new XMLHttpRequest();
		var url = "http://arieskuspanwibowo.com/hapusmerksinkron";
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