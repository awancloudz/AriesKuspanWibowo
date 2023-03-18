<nav class="navbar navbar-default">
<div class="container-fluid">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" 
				data-toggle="collapse"
				data-target="#bs-example-navbar-collapse-1"
				aria-expanded="false">
			<span class="sr-only">Toggle Navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		@if (Auth::check())
		<a class="navbar-brand" href="{{ url('/')}}"><i class="glyphicon glyphicon-home"></i>&nbsp;<b>{{ Auth::user()->profile->nama }}</b></a>
		@endif
	</div>
	<div class="collapse navbar-collapse"
		 id="bs-example-navbar-collapse-1">
	@if (Auth::check())
		@if(Auth::user()->level == 'admin')
		 <ul class="nav navbar-nav">
		 	<li class="dropdown">
		 		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Data Master</a>
		 		<ul class="dropdown-menu" role="menu">
			 		@if (!empty($halaman) && $halaman == 'customer')
				 	<li class="active"><a href="{{ url('customer') }}">Pelanggan</a>
				 	<span class="sr-only">(current)</span></li>
				 	@else
				 	<li><a href="{{ url('customer') }}">Pelanggan</a></li>
				 	@endif

				 	@if (!empty($halaman) && $halaman == 'distributor')
				 	<li class="active"><a href="{{ url('distributor') }}">Distributor</a>
				 	<span class="sr-only">(current)</span></li>
				 	@else
				 	<li><a href="{{ url('distributor') }}">Distributor</a></li>
				 	@endif

				 	@if (!empty($halaman) && $halaman == 'kategoriproduk')
				 	<li class="active"><a href="{{ url('kategoriproduk') }}">Kategori Produk</a>
				 	<span class="sr-only">(current)</span></li>
				 	@else
				 	<li><a href="{{ url('kategoriproduk') }}">Kategori Produk</a></li>
				 	@endif

					@if (!empty($halaman) && $halaman == 'merk')
				 	<li class="active"><a href="{{ url('merk') }}">Merk / Brand</a>
				 	<span class="sr-only">(current)</span></li>
				 	@else
				 	<li><a href="{{ url('merk') }}">Merk / Brand</a></li>
				 	@endif
				</ul>
		 	</li>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Data Produk</a>
				<ul class="dropdown-menu" role="menu">
					@if (!empty($halaman) && $halaman == 'produk')
					<li class="active"><a href="{{ url('produk') }}">Semua Produk</a>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{{ url('produk') }}">Semua Produk</a></li>
					@endif

					@if(count($list_kategori) > 0)
						@foreach($list_kategori as $key => $value)
						<li><a href="{!! route('kategori', ['cat'=>$key]) !!}">&nbsp;&nbsp;{{ $key }}. {{ $value }}</a></li>
						@endforeach
					@endif
				</ul>
			</li>

			<li class="dropdown">
		 		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Data Transaksi</a>
		 		<ul class="dropdown-menu" role="menu">
				 	
				 	@if (!empty($halaman) && $halaman == 'pembelian')
					<li class="active"><a href="{!! route('jenistransaksi', ['jenis'=>'pembelian']) !!}">Pembelian</a>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenistransaksi', ['jenis'=>'pembelian']) !!}">Pembelian</a></li>
					@endif

		 			@if (!empty($halaman) && $halaman == 'retail')
					<li class="active"><a href="{!! route('jenistransaksi', ['jenis'=>'retail']) !!}">Retail</a>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenistransaksi', ['jenis'=>'retail']) !!}">Retail</a></li>
					@endif

					@if (!empty($halaman) && $halaman == 'grosir')
					<li class="active"><a href="{!! route('jenistransaksi', ['jenis'=>'grosir']) !!}">Grosir</a>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenistransaksi', ['jenis'=>'grosir']) !!}">Grosir</a></li>
					@endif

					@if (!empty($halaman) && $halaman == 'kirimcabang')
					<li class="active"><a href="{!! route('jenistransaksi', ['jenis'=>'kirimcabang']) !!}">Update Stok Cabang</a>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenistransaksi', ['jenis'=>'kirimcabang']) !!}">Update Stok Cabang</a></li>
					@endif
		 		</ul>
		 	</li>
			@if (!empty($halaman) && $halaman == 'profile')
			<li class="active"><a href="{{ url('profile') }}">Data Cabang</a>
			<span class="sr-only">(current)</span></li>
			@else
			<li><a href="{{ url('profile') }}">Data Cabang</a></li>
			@endif
		 	<li class="dropdown">
		 		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Laporan</a>
		 		<ul class="dropdown-menu" role="menu">
				 	@if (!empty($halaman) && $halaman == 'semua')
				 	<li class="active"><a href="{!! route('jenislaporan', ['jenis'=>'semua']) !!}">Semua Transaksi</a></li>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenislaporan', ['jenis'=>'semua']) !!}">Semua Transaksi</a></li>
					@endif

					@if (!empty($halaman) && $halaman == 'pembelian')
					<li class="active"><a href="{!! route('jenislaporan', ['jenis'=>'pembelian']) !!}">Laporan Pembelian</a></li>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenislaporan', ['jenis'=>'pembelian']) !!}">Laporan Pembelian</a></li>
					@endif

					@if (!empty($halaman) && $halaman == 'retail')
					<li class="active"><a href="{!! route('jenislaporan', ['jenis'=>'retail']) !!}">Laporan Retail</a></li>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenislaporan', ['jenis'=>'retail']) !!}">Laporan Retail</a></li>
					@endif

					@if (!empty($halaman) && $halaman == 'grosir')
					<li class="active"><a href="{!! route('jenislaporan', ['jenis'=>'grosir']) !!}">Laporan Grosir</a></li>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenislaporan', ['jenis'=>'grosir']) !!}">Laporan Grosir</a></li>
					@endif
					
					@if (!empty($halaman) && $halaman == 'produk')
					<li class="active"><a href="{!! route('jenislaporan', ['jenis'=>'produk']) !!}">Laporan Produk Terjual</a></li>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenislaporan', ['jenis'=>'produk']) !!}">Laporan Produk Terjual</a></li>
					@endif

					@if (!empty($halaman) && $halaman == 'labarugi')
					<li class="active"><a href="{!! route('jenislaporan', ['jenis'=>'labarugi']) !!}">Laporan Laba/Rugi</a></li>
					<span class="sr-only">(current)</span></li>
					@else
					<li><a href="{!! route('jenislaporan', ['jenis'=>'labarugi']) !!}">Laporan Laba/Rugi</a></li>
					@endif
					
				</ul>
		 	</li>
		 	<li class="dropdown">
		 		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pengaturan</a>
		 		<ul class="dropdown-menu" role="menu">
				 	@if (!empty($halaman) && $halaman == 'user')
					<li class="active"><a href="{{ url('user') }}">Data Pengguna</a>
				 	<span class="sr-only">(current)</span></li>
				 	@else
				 	<li><a href="{{ url('user') }}">Data Pengguna</a></li>
				 	@endif
				 	@if (!empty($halaman) && $halaman == 'profile')
					<li class="active"><a href="{{ url('profile/1/edit') }}">Profile Toko</a>
				 	<span class="sr-only">(current)</span></li>
				 	@else
				 	<li><a href="{{ url('profile/1/edit') }}">Profile Toko</a></li>
				 	@endif
		 		</ul>
		 	</li>
		 </ul>
		@elseif(Auth::user()->level == 'grosir')
		<ul class="nav navbar-nav">
			<li>
				<a href="{{ url('jenistransaksi/grosir') }}"><i class="glyphicon glyphicon-tags"></i>&nbsp; Data Transaksi</a>
			</li>
		</ul>
		<ul class="nav navbar-nav">
			<li><a href="{{ url('transaksi/create/grosir') }}"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp; Transaksi Grosir</a>
		</ul>
		@elseif(Auth::user()->level == 'gudang')
		<ul class="nav navbar-nav">
			<li>
				<a href="{{ url('produk') }}"><i class="glyphicon glyphicon-briefcase"></i>&nbsp; Stok Produk</a>
			</li>
		</ul>
		<ul class="nav navbar-nav">
			<li>
				<a href="{{ url('jenistransaksi/pembelian') }}"><i class="glyphicon glyphicon-tags"></i>&nbsp; Data Pembelian</a>
			</li>
		</ul>
		@elseif(Auth::user()->level == 'kasir' || Auth::user()->level == 'kasircabang')
		<ul class="nav navbar-nav">
			<li>
				<a href="{{ url('jenistransaksi/retail') }}"><i class="glyphicon glyphicon-tags"></i>&nbsp; Data Transaksi</a>
			</li>
		</ul>
		<ul class="nav navbar-nav">
			<li><a href="{{ url('transaksi/create/retail') }}"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp; Transaksi Retail</a>
		</ul>
		<!-- <ul class="nav navbar-nav">
			<li><a href="{{ url('transaksi/create/grosir') }}"><i class="glyphicon glyphicon-briefcase"></i>&nbsp; Transaksi Grosir</a>
		</ul> -->
		@endif
		 <ul class="nav navbar-nav navbar-right">
		 	<li><a href="{{ url('logout') }}"><i class="glyphicon glyphicon-log-out"></i> Keluar</a></li>
		 </ul>
	@endif
	</div>
</div>
</nav>

