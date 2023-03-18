@if (isset($produkcabang))
{!! Form::hidden('id', $produkcabang->id) !!}
@endif
<div class="row">
  <div class="col-md-6">
  	{{-- Nama --}}
	<div class="form-group">
		{!! Form::label('namaproduk','Nama Produk',['class' => 'control-label']) !!}
		<p>{{ $produkcabang->produk->namaproduk }}</p>
	</div>
	{{-- Stok --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('stok') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('stok','Stok Produk',['class' => 'control-label']) !!}
		{!! Form::text('stok', null,['class' => 'form-control']) !!}
		@if ($errors->has('stok'))
		<span class="help-block">{{ $errors->first('stok') }}</span>
		@endif
	</div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
	{{-- Harga Jual --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('hargajual') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('hargajual','Harga Jual',['class' => 'control-label']) !!}
		{!! Form::text('hargajual', null,['class' => 'form-control']) !!}
		@if ($errors->has('hargajual'))
		<span class="help-block">{{ $errors->first('hargajual') }}</span>
		@endif
	</div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
	{{-- Submit button --}}
	<div class="form-group">
		<!-- {!! Form::submit($submitButtonText,['class' => 'btn btn-primary form-control']) !!} -->
		{!! Form::button('<i class="glyphicon glyphicon-floppy-disk"></i> ' . $submitButtonText, ['class'=>'btn btn-success form-control','type'=>'submit']) !!}
	</div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>