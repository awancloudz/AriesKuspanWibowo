@extends('template')

@section('main')
	<div id="produkcabang" class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
			<div class="col-md-1">
				<a href="{{ URL::previous() }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a>
			</div>
			<div class="col-md-10">
				<b><h4 align="center">UBAH STOK PRODUK</h4></b>
			</div>
			</div>
		</div>
		<div class="panel-body">
		{!! Form::model($produkcabang, ['method' => 'PATCH', 'action' => ['CabangController@update', $produkcabang->id],'files'=>true]) !!}
		@include('cabang.form', ['submitButtonText' => 'Update Stok'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop