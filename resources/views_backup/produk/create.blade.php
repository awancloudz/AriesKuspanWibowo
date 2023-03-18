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
		{!! Form::open(['url' => 'produk', 'files' => true]) !!}
		@include('produk.form', ['submitButtonText' => 'Simpan Produk'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop