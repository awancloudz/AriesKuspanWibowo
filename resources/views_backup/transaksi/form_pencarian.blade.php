<div id="pencarian">
	{!! Form::open(['url' => 'transaksi/cari', 'method' => 'POST', 'id' => 'form_pencarian']) !!}
<!-- <div class="row">
	<div class="col-md-8"> -->
		<div class="input-group">
			<input type="hidden" name="jenis" value="{{ $jenis }}">
			{!! Form::text('kata_kunci',(!empty($kata_kunci)) ? $kata_kunci : null,['class'=>'form-control','id'=>'txt_cari','placeholder'=> 'Masukan Kode Transaksi / No.Invoice']) !!}
			<span class="input-group-btn">
				{!! Form::button('<i class="glyphicon glyphicon-search"></i>', ['class'=>'btn btn-default','id'=>'tb_cari','type'=>'submit']) !!}
			</span>
		</div>
	<!-- </div>
</div> -->
	{!! Form::close() !!}
</div>
