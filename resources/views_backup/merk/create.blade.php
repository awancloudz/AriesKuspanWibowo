@extends('template')

@section('main')
	<div id="merk" class="panel panel-default">
		<div class="panel-heading"><b><h4>Tambah Merk/Brand Produk</h4></b></div>
		<div class="panel-body">
		{!! Form::open(['url' => 'merk']) !!}
		@include('merk.form', ['submitButtonText' => 'Simpan Merk/Brand Produk'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop