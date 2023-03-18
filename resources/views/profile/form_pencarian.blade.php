<div id="pencarian">
	{!! Form::open(['url' => 'customer/cari', 'method' => 'GET', 'id' => 'form_pencarian']) !!}
<div class="row">
	<div class="col-md-8">
		<div class="input-group">
			{!! Form::text('kata_kunci',(!empty($kata_kunci)) ? $kata_kunci : null,['class'=>'form-control','id'=>'txt_cari','placeholder'=> 'Masukkan Nama Customer']) !!}
			<span class="input-group-btn">
				{!! Form::button('<i class="glyphicon glyphicon-search"></i>', ['class'=>'btn btn-default','id'=>'tb_cari','type'=>'submit']) !!}
			</span>
		</div>
	</div>
</div>
	{!! Form::close() !!}
</div>