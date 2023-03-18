@if (isset($profile))
{!! Form::hidden('id', $profile->id) !!}
@else
{!! Form::hidden('status', 'cabang') !!}
@endif

{{-- Nama --}}
@if($errors->any())
<div class="form-group {{ $errors->has('nama') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
	{!! Form::label('nama','Nama',['class' => 'control-label']) !!}
	{!! Form::text('nama', null,['class' => 'form-control']) !!}
	@if ($errors->has('nama'))
	<span class="help-block">{{ $errors->first('nama') }}</span>
	@endif
</div>

{{-- Alamat --}}
@if($errors->any())
<div class="form-group {{ $errors->has('alamat') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
	{!! Form::label('alamat','Alamat',['class' => 'control-label']) !!}
	{!! Form::text('alamat', null,['class' => 'form-control']) !!}
	@if ($errors->has('alamat'))
	<span class="help-block">{{ $errors->first('alamat') }}</span>
	@endif
</div>

{{-- Kota --}}
@if($errors->any())
<div class="form-group {{ $errors->has('kota') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
  {!! Form::label('kota','Kab / Kota',['class' => 'control-label']) !!}
  {!! Form::text('kota', null,['class' => 'form-control']) !!}
  @if ($errors->has('kota'))
  <span class="help-block">{{ $errors->first('kota') }}</span>
  @endif
</div>

{{-- NoTelp --}}
@if($errors->any())
<div class="form-group {{ $errors->has('notelp') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
	{!! Form::label('notelp','No.Telp',['class' => 'control-label']) !!}
	{!! Form::text('notelp', null,['class' => 'form-control']) !!}
	@if ($errors->has('notelp'))
	<span class="help-block">{{ $errors->first('notelp') }}</span>
	@endif
</div>

{{-- Promosi --}}
<div class="form-group">
  {!! Form::label('promosi','Promosi',['class' => 'control-label']) !!}
  {!! Form::textarea('promosi', null,['class' => 'form-control']) !!}
</div>
{{-- Submit button --}}
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			{!! Form::submit($submitButtonText,['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
</div>