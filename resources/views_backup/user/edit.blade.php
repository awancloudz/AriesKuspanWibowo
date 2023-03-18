@extends('template')

@section('main')
	<div id="user" class="panel panel-default">
		<div class="panel-heading"><b><h4>Edit Pengguna</h4></b></div>
		<div class="panel-body">
		{!! Form::model($user, ['method' => 'PATCH', 'action' => ['UserController@update', $user->id]]) !!}
		@include('user.form', ['submitButtonText' => 'Update Pengguna'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop