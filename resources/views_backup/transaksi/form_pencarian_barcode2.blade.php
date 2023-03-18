<div id="pencarian_barcode">
	{!! Form::open(['url' => 'transaksi/caribarcode2', 'method' => 'GET', 'id' => 'form_pencarian_barcode']) !!}
    {!! Form::hidden('jenis', $jenis) !!}
<!-- <div class="row">
	<div class="col-md-8"> -->
		<div class="input-group" id="frcari">
			{!! Form::text('kata_kunci_barcode',(!empty($kata_kunci_barcode)) ? $kata_kunci_barcode : null,['class'=>'form-control','id'=>'txt_cari_barcode','placeholder'=> 'Scan Barcode (Letakkan cursor mouse disini)','autofocus'=>'autofocus']) !!}
			<span class="input-group-btn">
				{!! Form::button('<i class="glyphicon glyphicon-search"></i>', ['class'=>'btn btn-default','id'=>'tb_cari_barcode','type'=>'submit']) !!}
			</span>
		</div>
	<!-- </div>
</div> -->
	{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function() {
    //$("#frcari").hide();
    var pressed = false; 
    var chars = []; 

    $(window).keypress(function(e) {
        if ($("#txt_cari_barcode").is(":focus")) {
        //if (e.which >= 48 && e.which <= 57) {
        chars.push(String.fromCharCode(e.which));
        //}
        //console.log(e.which + ":" + chars.join("|"));
        if (pressed == false) {
            setTimeout(function(){
                //if (chars.length >= 5) {
                var barcode = chars.join("");
                //console.log("Barcode Scanned: " + barcode);
                $("#txt_cari_barcode").val(barcode);
                tb_cari_barcode.click();
                //}
                chars = [];
                pressed = false;
            },3000);
        }
        pressed = true;
        }
    });
});
/*$("#txt_cari").keypress(function(e){
    if ( e.which === 13 ) {
        console.log("Prevent form submit.");
        e.preventDefault();
    }
});*/
</script>
</div>