@extends('template')

@section('main')
	<div id="profile" class="panel panel-default">
		<div class="panel-heading"><b><h4>Tambah Cabang</h4></b></div>
		<div class="panel-body">
		{!! Form::open(['url' => 'profile']) !!}
		@include('profile.form', ['submitButtonText' => 'Tambah Cabang'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop