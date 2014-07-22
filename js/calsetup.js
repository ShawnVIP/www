var txtLib=({
	cal_set:{cn:"目标设定",en:"Goal Settings"},
	cal_step:{cn:"每日行走步数:",en:"Daily Steps Goal:"},
	cal_steps:{cn:"步",en:"steps"},
	cal_dist:{cn:"每日行走距离:",en:"Daily Distance Goal:"},
	cal_km:{cn:"公里",en:"km"},
	cal_miles:{cn:"英里",en:"miles"},
	cal_cal:{cn:"每日卡路里消耗量:",en:"Daily Calories Goal:"},
	cal_cals:{cn:"卡",en:"cal"},
	cal_sub:{cn:"提交",en:"Submit"},
	cal_d:{cn:"传感器默认显示值",en:"Default Sensor Display"},
	cal_d1:{cn:"行走步数",en:"Steps"},
	cal_d2:{cn:"行走距离",en:"Distance"},
	cal_d3:{cn:"卡路里消耗",en:"Calories"}

});

function getText(textName){
	return eval('txtLib.'+textName+"."+LANG);
}

var myDate = new Date();
var myDate = new Date();
var my=myDate.getFullYear();
var mm=myDate.getMonth()+1;
var md=myDate.getDate()
var back_ucode=$.cookie('back_ucode');
var back_scode=$.cookie('back_scode');
var back_ecode=$.cookie('back_ecode');
	
var back_loginMode=$.cookie('back_loginMode');	

var mytime=my+"-"+mm+"-"+md+" "+myDate.toLocaleTimeString();  
$(function(){
	$('#PRO_bigTitle').text(getText('cal_set'));
	$('#G_tditle1').text(getText('cal_step'));
	$('#u1').text(getText('cal_steps'));
	$('#G_tditle2').text(getText('cal_dist'));
	$('#u2').text(getText('cal_km'));
	$('#G_tditle3').text(getText('cal_cal'));
	$('#u3').text(getText('cal_cals'));
	$('#G_tditle4').text(getText('cal_d'));
	$('#d1').text(getText('cal_d1'));
	$('#d2').text(getText('cal_d2'));
	$('#d3').text(getText('cal_d3'));

	
	
	changevalue(0);
	$('#PRO_submit').text(getText('cal_sub'));
	
	$(".PRO_senNameBack input").keypress(function(event) {
		var keyCode = event.which;
		if (keyCode == 46 || (keyCode >= 48 && keyCode <=57) ||keyCode == 8 ||keyCode == 127)
			return true;
		else
			return false;
		}).focus(function() {
			this.style.imeMode='disabled';
	});
	
	
	$("#s1").bind({
			focusout:function(){
				changevalue(0);
			}
	});
	$("#s2").bind({
			focusout:function(){changevalue(1);}
	});
	buildButton('PRO_submit');
	$('#PRO_submit').bind({
			click:function(){saveGoal()}
		});
		
	$('#mainFrame').show();

	$('#PRO_close').bind({
		click:function(event){hidethis();}
	});
	$('#mainFrame').show();
	getUserInfomation();
		
});
function hidethis(){
	parent.closeGoalSetup();
	
}

function getUserInfomation(){
	back_ecode=$.cookie('back_ecode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",cdate:mytime};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/getinfo.php',
        data:JSON.stringify(outData), 
        success: function (msg) {
			dealUserData(msg);
        }
    });
}	
function dealUserData(data){	
	
	if(data.status != 200){
		
		$.cookie('back_ucode', null);
		$.cookie('back_scode', null);
		$.cookie('back_ecode', null);
		$.cookie('back_loginMode', null);
		$.cookie('back_defaultgoal', null);
        $.cookie('back_caloriesgoal', null);
        $.cookie('back_distancegoal', null);
        $.cookie('back_stepgoal', null);
        $.cookie('back_unit', null);
        $.cookie('back_stepwidth', null);

		parent.showPop('popupReg');
		return;	
		
	}
	sensorList=data.sensorlist;
	back_ecode=data.ecode;
	$.cookie('back_ecode', back_ecode,{path:'/', expires:1000});
	$.cookie('back_gander', data.gander,{path:'/', expires:1000});
    $.cookie('back_unit', sensorList[0].unit,{path:'/', expires:1000});
    $.cookie('back_defaultgoal', sensorList[0].defaultgoal,{path:'/', expires:1000});
    $.cookie('back_caloriesgoal', sensorList[0].caloriesgoal,{path:'/', expires:1000});
    $.cookie('back_distancegoal', sensorList[0].distancegoal,{path:'/', expires:1000});
    $.cookie('back_stepgoal', sensorList[0].stepgoal,{path:'/', expires:1000});
    $.cookie('back_stepwidth', sensorList[0].stepwidth,{path:'/', expires:1000});
	if($.cookie('back_unit')=="Inch"){
		$('#u2').text(getText('cal_miles'));
		$('#rate').val("0.0000062137119223733");
	}else{
		$('#u2').text(getText('cal_km'));
		$('#rate').val("0.00001");
	}
	$('#s1').val($.cookie('back_stepgoal'));
	$('#s2').val($.cookie('back_distancegoal'));
	$('#s3').val($.cookie('back_caloriesgoal'));
	$('#stepwidth').val($.cookie('back_stepwidth'));
	$("input[name='defgoal'][value='"+$.cookie('back_defaultgoal')+"']").attr("checked",true); 
}

function saveGoal(){
	var caloriesgoal=$('#s3').val();
	var distancegoal=$('#s2').val();
	var stepgoal=$('#s1').val();
	back_ecode=$.cookie('back_ecode');
	back_ucode=$.cookie('back_ucode');
	back_scode=$.cookie('back_scode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",caloriesgoal:caloriesgoal,stepgoal:stepgoal,distancegoal:distancegoal,cdate:mytime,defaultgoal:$('input[name="defgoal"]:checked').val()};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/saveprofile.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				$.cookie('back_defaultgoal', $('input[name="defgoal"]:checked').val());
				$.cookie('back_caloriesgoal', $('#s3').val());
				$.cookie('back_distancegoal', $('#s2').val());
				$.cookie('back_stepgoal', $('#s1').val());
				$.cookie('back_ecode', msg.ecode);
				parent.closeGoalSetup();
				parent.updateGoalInfo(caloriesgoal,stepgoal,distancegoal);
        	}
    });
		
	
}


function changevalue(m){
     return;
	if(m==0){
	var v=$('#s1').val()*$('#stepwidth').val()*$('#rate').val()
	v=Math.floor(v*1000)/1000
	$('#s2').val(v);
	}else{
	var v=$('#s2').val()/($('#stepwidth').val()*$('#rate').val())
	v=Math.ceil(v)
	$('#s1').val(v);
	}
}
