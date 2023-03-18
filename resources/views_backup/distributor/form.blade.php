@if (isset($distributor))
{!! Form::hidden('id', $distributor->id) !!}
@endif

{!! Form::hidden('jenis', 'distributor') !!}
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

{{-- Submit button --}}
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<!-- {!! Form::submit($submitButtonText,['class' => 'btn btn-primary form-control']) !!} -->
			{!! Form::button('<i class="glyphicon glyphicon-floppy-disk"></i> ' . $submitButtonText, ['class'=>'btn btn-success form-control','type'=>'submit']) !!}
		</div>
	</div>
</div>