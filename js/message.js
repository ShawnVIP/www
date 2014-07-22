
var back_ucode=$.cookie('back_ucode');
var back_scode=$.cookie('back_scode');
var back_ecode=$.cookie('back_ecode');
var msgID=0;
var msgList=new Array();

var txtLib=({
	m_accept:{cn:"接受",en:"Accept"},
	m_dec:{cn:"拒绝",en:"Decline"},
	
});
function getText(textName){
	return eval('txtLib.'+textName+"."+LANG);
}

$(function(){
	$('#accept').text(getText('m_accept'));
	$('#decline').text(getText('m_dec'));
	buildButton("accept",{Width:92,Size:"small",Color:"g"});
	buildButton("decline",{Width:92,Size:"small",Color:"w"});
	$('#accept').click(function() {deal('accept');});
	$('#decline').click(function() {deal('decline');});
	getMsg();
	
	
});
function getMsg(){
	back_ecode=$.cookie('back_ecode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",lang:LANG};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/getrequest.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				addWarning(msg);
        	}
    	});
}
function addWarning(r){
	if(r.status != 200){return;}
	msgList=r.msglist;
	rebuildList();
}
function rebuildList(){
	var obj=msgList[msgID]
	
	$('#msg_text').text(obj.message);
	$('#msg_head').html('<img src="../upload/'+obj.head+'" width=75 height=75>');
	$('#msg_name').text(obj.nickname+" ("+obj.relation+")")
	$('#mainContent').fadeIn();
}
function deal(action){

	back_ecode=$.cookie('back_ecode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",action:action,reqcode:msgList[msgID].scode};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/dealrequest.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				reDeal(msg);
        	}
    });
	
}

function reDeal(r){
	if(r.status != 200){return;}
	var temp=msgList.splice(msgID,1);
	if(msgList.length>0){
		rebuildList();
	}
	parent.showMessage(msgList.length);
}