// JavaScript Document
document.write("<script type='text/javascript' src='../js/reglogin.js'></"+"script>"); 
$(function(){
	$('#mac').click(function(){
		window.open("../download/senseu_"+LANG+".pkg.zip");
	});
	$('#pc').click(function(){
		window.open("../download/senseu_"+LANG+".zip");
	});
});