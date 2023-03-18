@extends('template')

@section('main')
	<div id="merk" class="panel panel-default">
		<div class="panel-heading"><b><h4>Ubah Merk/Brand Produk</h4></b></div>
		<div class="panel-body">
		{!! Form::model($merk,['method' => 'PATCH', 'action' => ['MerkController@update',$merk->id]]) !!}
		@include('merk.form',['submitButtonText' => 'Update Merk/Brand Produk'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop