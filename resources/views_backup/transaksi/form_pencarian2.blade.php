<div id="pencarian">
	{!! Form::open(['url' => 'transaksi/cari2', 'method' => 'GET', 'id' => 'form_pencarian']) !!}
	{!! Form::hidden('jenis', $jenis) !!}
<!-- <div class="row">
	<div class="col-md-8"> -->
		<div class="input-group">
			{!! Form::text('kata_kunci',(!empty($kata_kunci)) ? $kata_kunci : null,['class'=>'form-control','id'=>'txt_cari','placeholder'=> 'Masukkan Nama Produk']) !!}
			<span class="input-group-btn">
				{!! Form::button('<i class="glyphicon glyphicon-search"></i>', ['class'=>'btn btn-default','id'=>'tb_cari','type'=>'submit']) !!}
			</span>
		</div>
	<!-- </div>
</div> -->
	{!! Form::close() !!}
</div>