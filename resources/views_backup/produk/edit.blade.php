@extends('template')

@section('main')
	<div id="produk" class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
			<div class="col-md-1">
				<a href="{{ URL::previous() }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a>
			</div>
			<div class="col-md-10">
				<b><h4 align="center">UBAH DATA PRODUK</h4></b>
			</div>
			</div>
		</div>
		<div class="panel-body">
		{!! Form::model($produk, ['method' => 'PATCH', 'action' => ['ProdukController@update', $produk->id],'files'=>true]) !!}
		@include('produk.form', ['submitButtonText' => 'Update Produk'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop