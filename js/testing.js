
var back_ucode=$.cookie('back_ucode');
var back_scode=$.cookie('back_scode');
var back_ecode=$.cookie('back_ecode');
	
$(function(){
	$('#submitmessage').button();
	$('#submitmessage').click(function() {sendmessage();});
	$('#getmessage').button();
	$('#getmessage').click(function() {getmessage();});
});
function sendmessage(){
	var myDate = new Date();
	var my=myDate.getFullYear();
	var mm=myDate.getMonth()+1;
	var md=myDate.getDate();	
	var mytime=my+"-"+mm+"-"+md+" "+myDate.toLocaleTimeString();  

	back_ecode=$.cookie('back_ecode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",fcode:$('#fcode').val(),message:$('#message').val(),cdate:mytime};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'res/sendmessage.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				$('#returnmessage').text(JSON.stringify(msg));
        	}
    	});
}

function getmessage(){
		back_ecode=$.cookie('back_ecode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",numberPerPage:$('#numberPerPage').val(),pageNumber:$('#pageNumber').val(),mode:$("input[name='readMode']:checked").val()};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'res/getmessage.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				$('#returnget').text(JSON.stringify(msg));
        	}
    	});
}	