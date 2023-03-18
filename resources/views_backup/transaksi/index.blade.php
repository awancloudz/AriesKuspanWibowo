@extends('template')

@section('main')
<div id="transaksi" class="panel panel-default">
@if ($caritrans == 1)
<!-- Deteksi jenis transaksi -->
<script type="text/javascript">
<?php echo "var jenis = '{$jenis}';"; ?>
window.localStorage['jenistrans'] = jenis;
</script>

	<div class="panel-heading"><b><h4>Data Transaksi - <?php echo ucfirst($jenis); ?></h4></b></div>
@else
	<script type="text/javascript">window.localStorage['jenistrans'] = "semua";</script>
	<div class="panel-heading"><b><h4>Data Semua Transaksi</h4></b></div>
@endif
	<div class="panel-body">
	@include('_partial.flash_message')
	<div class="row">
		<div class="col-md-8">
	@include('transaksi.form_pencarian_barcode')
	@include('transaksi.form_pencarian')
		</div>
		<div class="col-md-4">
			@if($caritrans == 1 && Auth::user()->level != 'gudang')
			<a href="{{ url('transaksi/create/' . $jenis) }}" class="btn btn-primary btn-lg text-center" id="tb_tambah"><i class="glyphicon glyphicon-arrow-right"></i><br> Menu Transaksi</a>
				@if($jenis == 'retail')
				<a href="{{ url('transaksi/strukharian') }}" class="btn btn-success btn-lg text-center" id="tb_print" target="blank_"><i class="glyphicon glyphicon-print"></i><br> Cetak Struk Harian</a>
				@endif	
			@endif
		</div>
	</div>

	<br>
	<!-- Tampil Transaksi -->
	@if (count($transaksi_list) > 0)
	<table class="table">
		<thead>
			<tr>
				<th>Kode Transaksi</th>
				@if($jenis == 'pembelian')
				<th>No.Invoice</th>
				@endif
				<th>Tanggal</th>
				<th>Jam</th>
				@if (Auth::check())
					@if(Auth::user()->level == 'admin' && $jenis == 'retail')
					<th>Lokasi</th>
					@endif
				@endif
				<th>Total Belanja</th>
				<th>Diskon</th>
				<th>Sub Total</th>
				@if ($caritrans == 1)
				@if(Auth::user()->level == 'admin' && $jenis == 'pembelian')
				<th>Pembayaran</th>
				<th>Status</th>
				@elseif(Auth::user()->level == 'gudang' && $jenis == 'pembelian')
				<th>Status</th>
				@endif
				@endif
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			function rupiah($nilai, $pecahan = 0) {
			return "Rp. " . number_format($nilai, $pecahan, ',', '.');
			} 
			?>
			<?php $i=0; ?>
			<?php foreach($transaksi_list as $transaksi): ?>
			<tr>
				<td><font size="2">{{ $transaksi->kodepenjualan }}</font></td>
				@if($jenis == 'pembelian')
				<td><font size="2">{{ $transaksi->noinvoice }}</font></td>
				@endif
				<td>{{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</td>
				<td>{{ date('H:i:s', strtotime($transaksi->created_at))}}</td>
				@if (Auth::check())
					@if(Auth::user()->level == 'admin' && $jenis == 'retail')
						@if($transaksi->users->level != 'kasircabang')
						<td>Pusat</td>
						@else
						<td>Cabang</td>
						@endif
					@endif
				@endif
				<td>{{ rupiah($transaksi->totalbelanja) }}</td>
				<td>{{ rupiah($transaksi->totaldiskon) }}</td>
				<td>{{ rupiah($transaksi->subtotal) }}</td>
				@if (Auth::check())
				@if ($caritrans == 1)
					@if(Auth::user()->level == 'admin' && $jenis == 'pembelian')
					<td>
						@if($transaksi->status == 'belum')
						<font color="red">Belum Lunas</font>&nbsp;
						<div class="box-button"> 
						<a href="{{ url('transaksi/lunas/' . $transaksi->id) }}" class="btn btn-warning btn-sm" style="color:black;"><i class="glyphicon glyphicon-ok"></i><b> Bayar</b></a>
						</div>
						@else
						<font color="green">
						<?php echo ucfirst($transaksi->status); ?>
						</font>
						@endif
					</td>
					<td>
						@if($transaksi->statusorder == 'order')
						<font color="red">Order</font>
						@elseif($transaksi->statusorder == 'check')
						<font color="blue">Check</font>&nbsp;
						<div class="box-button"> 
						<a href="{{ url('transaksi/verifikasi/' . $transaksi->id) }}" class="btn btn-warning btn-sm" style="color:black;"><i class="glyphicon glyphicon-ok"></i><b> Verifikasi</b></a>
						</div>
						@else
						<font color="green">Verified</font>
						@endif
					</td>
					@elseif(Auth::user()->level == 'gudang' && $jenis == 'pembelian')
					<td>
						@if($transaksi->statusorder == 'order')
						<font color="red">Order</font>&nbsp;
						<div class="box-button"> 
						<a href="{{ url('transaksi/check/' . $transaksi->id) }}" class="btn btn-warning btn-sm" style="color:black;"><i class="glyphicon glyphicon-ok"></i><b> Konfirmasi</b></a>
						</div>
						@elseif($transaksi->statusorder == 'check')
						<font color="blue">Check</font>
						@else
						<font color="green">Verified</font>
						@endif
					</td>
					@endif
				@endif
				@endif
				<td>
					<div class="box-button"> 
					<a href="{{ url('transaksi/view/' . $transaksi->id) }}" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-search"></i> Detail</a>
					</div>
				@if (Auth::check())
					@if(Auth::user()->level == 'admin')
						@if($transaksi->users->level != 'kasircabang')
							<div class="box-button">
							{!! Form::open(['method' => 'DELETE', 'action' => ['TransaksiPenjualanController@destroy',$transaksi->id]]) !!}
							{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
							{!! Form::close()!!}
							</div>
						@else
							<div class="box-button">
							{!! Form::open(['method' => 'DELETE', 'action' => ['TransaksiPenjualanController@destroy2',$transaksi->id]]) !!}
							{!! Form::button('<i class="glyphicon glyphicon-remove"></i> Hapus', ['class'=>'btn btn-danger btn-sm','type'=>'submit']) !!}
							{!! Form::close()!!}
							</div>
						@endif
					@endif
				
					<div class="box-button">
					@if(($transaksi->jenis == 'retail') && (Auth::user()->level == 'kasir' || Auth::user()->level == 'kasircabang'))
					<a href="{{ url('transaksi/printstruk/' . $transaksi->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Struk</a>
					@elseif(Auth::user()->level == 'admin' || Auth::user()->level == 'grosir')
					<a href="{{ url('transaksi/print/' . $transaksi->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="glyphicon glyphicon-print"></i> Faktur</a>
					@endif
					</div>
				@endif
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	@else
	<p>Tidak ada data transaksi.</p>
	@endif
	<div class="table-nav">
	<div class="jumlah-data">
		<strong>Jumlah Transaksi : {{ $jumlah_transaksi}}</strong>
	</div>
	<div class="paging">
	{{ $transaksi_list->links() }}
	</div>
	</div>
	<!--Akhir Tampil Transaksi -->
	</div>
</div>
@stop

@section('footer')
	@include('footer')
@stop