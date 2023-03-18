$(document).ready(function(){
//Slide alert
$('div.alert').not('.alert-important').delay(3000).slideUp(300);

//Hapus select dengan empty value dari URL
$("#form_pencarian").submit(function(){
	$("#id_kelas option[value='']").attr("disabled","disabled");
	$("#jenis_kelamin option[value='']").attr("disabled","disabled");
	return true;
});
});
