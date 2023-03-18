@extends('template')

@section('main')
	<div id="user" class="panel panel-default">
		<div class="panel-heading"><b><h4>Tambah Pengguna</h4></b></div>
		<div class="panel-body">
		{!! Form::open(['url' => 'user']) !!}
		@include('user.form', ['submitButtonText' => 'Simpan Pengguna'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop