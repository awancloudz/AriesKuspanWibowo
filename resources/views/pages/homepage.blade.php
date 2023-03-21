@extends('template')
@section('main')
<div id="homepage" class="panel panel-default">
	<div class="panel-heading" align="center"><h3>SISTEM INFORMASI PENJUALAN</h3></div>
	<div class="panel-body" align="center">
	<img src="{{ url('fotoupload/icon.png') }}" width="600">
	</div>
</div>
@stop

@section('footer')
@include('footer')
@stop