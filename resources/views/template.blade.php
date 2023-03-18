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
<script>
  function ConfirmDelete(){
    var x = confirm("Yakin hapus data?");
    if (x)
      return true;
    else
      return false;
  }

  ///Confirm Produk
  function ConfirmDeleteProduk(idproduk){
    var x = confirm("Yakin hapus data produk?");
    if (x)
      hapusserver(idproduk);
    else
      return false;
  }

  function hapusserver(id){
      <?php
        $csrf = json_encode(csrf_token());
        echo "var csrfToken ={$csrf}; ";
      ?>
      console.log(id);
      var xmlhttp = new XMLHttpRequest();
      var url = "http://arieskuspanwibowo.com/hapusproduksinkron";
      xmlhttp.open("POST", url, true);
      xmlhttp.setRequestHeader('x-csrf-token', csrfToken);
      xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xmlhttp.send("id="+escape(id));
      xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          var response = xmlhttp.responseText;
          console.log(response);
          return true;
        }
      }
  }
  ///End Confirm Produk
  
  function ConfirmCancel(){
    var x = confirm("Yakin batalkan transaksi?");
    if (x)
      return true;
    else
      return false;
  }

  function ConfirmReady(){
    var x = confirm("Konfirmasi Produk!");
    if (x)
      return true;
    else
      return false;
  }

  function ConfirmTransaction(){
    var x = confirm("Yakin konfirmasi order? Cek daftar order terlebih dahulu, jika sudah klik OK!");
    if (x)
      return true;
    else
      return false;
  }

  function ConfirmPayment(){
    var x = confirm("Konfirmasi Pembayaran!");
    if (x)
      return true;
    else
      return false;
  }
</script>
<!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "0f61b99f-8a8d-4d52-a835-3e2acea95f06",
      notifyButton: {
        enable: true,
      },
      subdomainName: "kuspan",
    });
  });
</script> -->
</body>
</html>