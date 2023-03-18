@if (isset($kategoriproduk))
{!! Form::hidden('id', $kategoriproduk->id,['id'=>'id']) !!}
@endif

{{-- Nama --}}
@if($errors->any())
<div class="form-group {{ $errors->has('nama') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
	{!! Form::label('nama','Nama Kategori',['class' => 'control-label']) !!}
	{!! Form::text('nama', null,['class' => 'form-control','id'=>'nama']) !!}
	@if ($errors->has('nama'))
	<span class="help-block">{{ $errors->first('nama') }}</span>
	@endif
</div>

{{-- Keterangan --}}
<div class="form-group">
	{!! Form::label('keterangan','Keterangan',['class' => 'control-label']) !!}
	{!! Form::text('keterangan', null,['class' => 'form-control','id'=>'keterangan']) !!}
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