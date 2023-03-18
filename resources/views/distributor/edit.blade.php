@extends('template')

@section('main')
	<div id="distributor" class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
			<div class="col-md-1">
				<a href="{{ URL::previous() }}" class="btn btn-success btn-sm text-center"><i class="glyphicon glyphicon-chevron-left"></i> <b>Kembali</b></a>
			</div>
			<div class="col-md-10">
				<b><h4 align="center">UBAH DATA DISTRIBUTOR</h4></b>
			</div>
			</div>
		</div>
		<div class="panel-body">
		{!! Form::model($distributor, ['method' => 'PATCH', 'action' => ['DistributorController@update', $distributor->id]]) !!}
		@include('distributor.form', ['submitButtonText' => 'Update Distributor'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop