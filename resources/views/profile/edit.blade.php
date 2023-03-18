@extends('template')

@section('main')
	<div id="profile" class="panel panel-default">
		<div class="panel-heading"><b><h4>Profile Toko</h4></b></div>
		<div class="panel-body">
		@include('_partial.flash_message')
		{!! Form::model($profile, ['method' => 'PATCH', 'action' => ['ProfileController@update', $profile->id]]) !!}
		@include('profile.form', ['submitButtonText' => 'Update Profile'])
		{!! Form::close() !!}
		</div>
	</div>
@stop

@section('footer')
	@include('footer')
@stop