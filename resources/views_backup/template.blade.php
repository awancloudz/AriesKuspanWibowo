<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="witdh=device-witdh, initial-scale=1">
	<title>Sistem Informasi Penjualan</title>
<script src="{{ asset ('js/moment.min.js')}}"></script>
<link href="{{ asset ('bootstrap_3_3_6/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset ('css/style.css')}}" rel="stylesheet">
<script src="{{ asset ('js/jquery_2_2_1.min.js')}}"></script>
<script src="{{ asset ('js/accounting.js')}}"></script>
<link href="{{ asset ('select2/select2.min.css')}}" rel="stylesheet">
<script src="{{ asset ('select2/select2.min.js')}}"></script>
<link href="{{ asset ('css/jquery.dataTables.min.css')}}" rel="stylesheet">
<script src="{{ asset ('js/jquery.dataTables.min.js')}}"></script>
<!-- [if lt IE 9]>
<script src="{{ asset ('http://laravelapp.dev/js/htmlshiv_3_7_2.min.js')}}"></script>
<script src="{{ asset ('http://laravelapp.dev/js/respond_1_4_2.min.js')}}"></script>
-->
</head>
<body>
@include ('navbar')
@yield ('main')
@yield ('footer')
<script src="{{ asset ('js/daterangepicker.js')}}"></script>
<link href="{{ asset ('css/daterangepicker.css')}}" rel="stylesheet"></script>
<script src="{{ asset ('bootstrap_3_3_6/js/bootstrap.min.js')}}"></script>
<script src="{{ asset ('js/laravelapp.js')}}"></script>
</body>
</html>