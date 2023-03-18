<div id="pencarian">
	{!! Form::open(['url' => 'laporan/cari', 'method' => 'GET', 'id' => 'form_pencarian']) !!}
	<?php $nilaiawal = 0;  $profileawal = 1; ?>
	@if($jenis == 'retail' || $jenis == 'produk')
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_profile','&nbsp;&nbsp;Pilih Toko',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-4">
				@if(count($list_cabang) > 0)
				{!! Form::select('id_profile', $list_cabang, 1,['class' => 'form-control js-example-basic-single', 'id'=>'id_profile','placeholder'=>'Pilih Toko']) !!}
				@else
				<p>Tidak ada pilihan Cabang,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_pengguna','&nbsp;&nbsp;Pilih Kasir',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-4">
				@if(count($list_kasir) > 0)
				{!! Form::select('id_pengguna', $list_kasir, $nilaiawal,['class' => 'form-control js-example-basic-single', 'id'=>'id_pengguna','placeholder'=>'Semua Transaksi Kasir']) !!}
				@else
				<p>Tidak ada pilihan kasir,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
		</div>
	@elseif($jenis == 'semua')
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_profile','&nbsp;&nbsp;Pilih Toko',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-4">
				@if(count($list_cabang) > 0)
				{!! Form::select('id_profile', $list_cabang, 1,['class' => 'form-control js-example-basic-single', 'id'=>'id_profile','placeholder'=>'Pilih Toko']) !!}
				@else
				<p>Tidak ada pilihan Cabang,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
		</div>
		{!! Form::hidden('id_pengguna', $nilaiawal, ['id'=>'id_pengguna']) !!}
	@elseif($jenis == 'grosir')
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_pengguna','&nbsp;&nbsp;Pilih Kasir',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-4">
				@if(count($list_kasirgrosir) > 0)
				{!! Form::select('id_pengguna', $list_kasirgrosir, $nilaiawal,['class' => 'form-control js-example-basic-single', 'id'=>'id_pengguna','placeholder'=>'Semua Transaksi Kasir Grosir']) !!}
				@else
				<p>Tidak ada pilihan kasir grosir,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_customer','&nbsp;&nbsp;Pilih Pelanggan',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-4">
				@if(count($list_customer) > 0)
				{!! Form::select('id_customer', $list_customer, $nilaiawal,['class' => 'form-control js-example-basic-single', 'id'=>'id_pengguna','placeholder'=>'Semua Transaksi Pelanggan']) !!}
				@else
				<p>Tidak ada pilihan Pelanggan,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
		</div>
		{!! Form::hidden('id_profile', $profileawal, ['id'=>'id_profile']) !!}
	@elseif($jenis == 'pembelian')
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_pengguna','&nbsp;&nbsp;Pilih Distributor',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-4">
				@if(count($list_distributor) > 0)
				{!! Form::select('id_pengguna', $list_distributor, $nilaiawal,['class' => 'form-control js-example-basic-single', 'id'=>'id_pengguna','placeholder'=>'Semua Transaksi Distributor']) !!}
				@else
				<p>Tidak ada pilihan Distributor,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
		</div>
		{!! Form::hidden('id_profile', $profileawal, ['id'=>'id_profile']) !!}
	@else
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
				{!! Form::label('id_profile','&nbsp;&nbsp;Pilih Toko',['class' => 'control-label']) !!}
				</div>
				<div class="col-md-4">
				@if(count($list_cabang) > 0)
				{!! Form::select('id_profile', $list_cabang, 1,['class' => 'form-control js-example-basic-single', 'id'=>'id_profile','placeholder'=>'Pilih Toko']) !!}
				@else
				<p>Tidak ada pilihan Cabang,silahkan diisi dulu.</p>
				@endif
				</div>
			</div>
		</div>
	{!! Form::hidden('id_pengguna', $nilaiawal, ['id'=>'id_pengguna']) !!}
	@endif
<div class="row">
	<div class="col-md-6">
		<div class="input-group">
		<span class="input-group-addon">Tanggal Awal - Tanggal Akhir</span>
		<!--{!! Form::text('tanggaljurnal', null,['class' => 'form-control','id'=>'tanggaljurnal']) !!}-->
		<div id="tanggaljurnal" class="pull-right" style="background: #fff; cursor: pointer; padding: 6px 10px; border: 1px solid #ccc; width: 100%">
			<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
			<span></span> <b class="caret"></b>
		</div>
		{!! Form::hidden('tgl_awal', null,['id'=>'tgl_awal']) !!}
		{!! Form::hidden('tgl_akhir', null, ['id'=>'tgl_akhir']) !!}
		{!! Form::hidden('jenis', $jenis, ['id'=>'jenis']) !!}
		<span class="input-group-btn">
		{!! Form::button('<i class="glyphicon glyphicon-search"></i>', ['class'=>'btn btn-default','id'=>'tb_cari','type'=>'submit']) !!}
		</span>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box-button">
		<?php 
		$jns = ucfirst($jenis); 
		if (isset($_GET['tgl_awal'])) {
			$tgl_awal_cetak = $_GET['tgl_awal'];
			$tgl_akhir_cetak = $_GET['tgl_akhir'];
			$id_pengguna = $_GET['id_pengguna'];
			$id_profile = $_GET['id_profile'];
			if($id_pengguna == ''){
				$id_pengguna = 0;
			}
			if($jenis == 'grosir'){
				$id_customer = $_GET['id_customer'];
				if($id_customer == ''){
					$id_customer = 0;
				}
			}

		}
		else{
			$tanggal = date('Y-m-d');
			$tgl_awal_cetak = date('Y-m-01', strtotime($tanggal));
			$tgl_akhir_cetak = date('Y-m-t', strtotime($tanggal));
			$id_pengguna = 0;
			if($jenis == 'grosir'){
			$id_customer = 0;
			}
			$id_profile = 1;
		}
		?>
		@if($jenis == 'grosir')
		{{ link_to('laporan/cetakgrosir/' . $jenis . '/tgl_awal/' . $tgl_awal_cetak . '/tgl_akhir/' . $tgl_akhir_cetak . '/id_pengguna/' . $id_pengguna .'/id_profile/'. $id_profile .'/id_customer/'. $id_customer, 'Cetak Laporan&nbsp;' . $jns ,['class' => 'btn btn-primary','target'=>'_blank']) }}
		@else
		{{ link_to('laporan/cetak/' . $jenis . '/tgl_awal/' . $tgl_awal_cetak . '/tgl_akhir/' . $tgl_akhir_cetak . '/id_pengguna/' . $id_pengguna .'/id_profile/'. $id_profile, 'Cetak Laporan&nbsp;' . $jns ,['class' => 'btn btn-primary','target'=>'_blank']) }}
		@endif
		</div>
		<div class="box-button">
		{{ link_to('exportExcel/' . $jenis . '/tgl_awal/' . $tgl_awal_cetak . '/tgl_akhir/' . $tgl_akhir_cetak . '/id_pengguna/' . $id_pengguna .'/id_profile/'. $id_profile,'Download Excel&nbsp;' . $jenis ,['class' => 'btn btn-success','target'=>'_blank']) }}
		</div>
	</div>
</div>
	{!! Form::close() !!}
</div>
<script type="text/javascript">
$('.js-example-basic-single').select2();
$(function() {
	//Variabel Tanggal Awal
	var start = moment().startOf('month');
    var end = moment().endOf('month');

	//Jika klik daterange
    function cb(start, end) {
        $('#tanggaljurnal span').html(start.format('D MMMM') + ' - ' + end.format('D MMMM YYYY'));
		document.getElementById("tgl_awal").value = start.format('YYYY-MM-DD');
		document.getElementById("tgl_akhir").value = end.format('YYYY-MM-DD');
    }

    $('#tanggaljurnal').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Hari Ini': [moment(), moment()],
           'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
           '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
           'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
           'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});
</script>