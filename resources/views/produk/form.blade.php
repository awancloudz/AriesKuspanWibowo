@if (isset($produk))
{!! Form::hidden('id', $produk->id,['id'=>'id']) !!}
@endif
<div class="row">
  <div class="col-md-6">
	{{-- Kode --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('kodeproduk') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('kodeproduk','Kode Produk',['class' => 'control-label']) !!}
		{!! Form::text('kodeproduk', null,['class' => 'form-control','autofocus'=>'autofocus', 'id'=>'kodeproduk']) !!}
		@if ($errors->has('kodeproduk'))
		<span class="help-block">{{ $errors->first('kodeproduk') }}</span>
		@endif
	</div>
  </div>
  <div class="col-md-6">
	{{-- Harga jual --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('hargajual') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('hargajual','Harga Jual',['class' => 'control-label']) !!}
		{!! Form::text('hargajual', null,['class' => 'form-control', 'id'=>'hargajual']) !!}
		@if ($errors->has('hargajual'))
		<span class="help-block">{{ $errors->first('hargajual') }}</span>
		@endif
	</div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
	{{-- Nama --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('namaproduk') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('namaproduk','Nama Produk',['class' => 'control-label']) !!}
		{!! Form::text('namaproduk', null,['class' => 'form-control', 'id'=>'namaproduk']) !!}
		@if ($errors->has('namaproduk'))
		<span class="help-block">{{ $errors->first('namaproduk') }}</span>
		@endif
	</div>
  </div>
  <div class="col-md-6">
	{{-- Harga Grosir --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('hargagrosir') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('hargagrosir','Harga Grosir',['class' => 'control-label']) !!}
		{!! Form::text('hargagrosir', null,['class' => 'form-control', 'id'=>'hargagrosir']) !!}
		@if ($errors->has('hargagrosir'))
		<span class="help-block">{{ $errors->first('hargagrosir') }}</span>
		@endif
	</div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
	{{--  Kategori --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('id_kategoriproduk') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('id_kategoriproduk','Kategori Produk',['class' => 'control-label']) !!}
		@if(count($list_kategoriproduk) > 0)
		{!! Form::select('id_kategoriproduk', $list_kategoriproduk, null,['class' => 'form-control js-example-basic-single', 'id'=>'id_kategoriproduk','placeholder'=>'Pilih Kategori Produk']) !!}
		@else
		<p>Tidak ada pilihan kategori produk,silahkan buat dulu.</p>
		@endif
		@if ($errors->has('id_kategoriproduk'))
		<span class="help-block">{{ $errors->first('id_kategoriproduk') }}</span>
		@endif
	</div>
  </div>
  <div class="col-md-6">
	{{-- Harga Distributor --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('hargadistributor') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('hargadistributor','Harga Beli',['class' => 'control-label']) !!}
		{!! Form::text('hargadistributor', null,['class' => 'form-control', 'id'=>'hargadistributor']) !!}
		@if ($errors->has('hargadistributor'))
		<span class="help-block">{{ $errors->first('hargadistributor') }}</span>
		@endif
	</div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
	{{--  Merk --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('id_merk') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('id_merk','Merk/Brand Produk',['class' => 'control-label']) !!}
		@if(count($list_merk) > 0)
		{!! Form::select('id_merk', $list_merk, null,['class' => 'form-control js-example-basic-single', 'id'=>'id_merk','placeholder'=>'Pilih Merk/Brand Produk']) !!}
		@else
		<p>Tidak ada pilihan merk/brand produk,silahkan buat dulu.</p>
		@endif
		@if ($errors->has('id_merk'))
		<span class="help-block">{{ $errors->first('id_merk') }}</span>
		@endif
	</div>
  </div>
  <div class="col-md-6">
	{{-- Diskon --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('diskon') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('diskon','Diskon',['class' => 'control-label']) !!}
		{!! Form::text('diskon', null,['class' => 'form-control','id'=>'diskon']) !!}
		@if ($errors->has('diskon'))
		<span class="help-block">{{ $errors->first('diskon') }}</span>
		@endif
	</div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
	{{-- Foto --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('foto') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('foto','Foto') !!}
		{!! Form::file('foto') !!}
		@if ($errors->has('foto'))
		<span class="help-block">{{ $errors->first('foto') }}</span>
		@endif
	</div>
  </div>
  <div class="col-md-6">
	{{-- Stok --}}
	@if($errors->any())
	<div class="form-group {{ $errors->has('stok') ? 'has-error' : 'has-success' }}">
	@else
	<div class="form-group">
	@endif
		{!! Form::label('stok','Stok Produk',['class' => 'control-label']) !!}
		{!! Form::text('stok', null,['class' => 'form-control','id'=>'stok']) !!}
		@if ($errors->has('stok'))
		<span class="help-block">{{ $errors->first('stok') }}</span>
		@endif
	</div>
  </div>
</div>
@if (isset($produk))
<div class="row">
  <div class="col-md-6">
	{{-- Catatan Update --}}
	<div class="form-group">
		{!! Form::label('catatan','Catatan/Alasan Edit Produk ',['class' => 'control-label']) !!}
		{!! Form::text('catatan', null,['class' => 'form-control','id'=>'catatan']) !!}
	</div>
  </div>
</div>
@endif
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