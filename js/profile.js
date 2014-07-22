
var txtLib=({
	pro_my:{cn:"我的档案",en:"MY PROFILE"},
	pro_as:{cn:"账户设置",en:"Account Settings"},
	pro_changpic:{cn:"更换头像",en:"Change Image"},
	pro_changpas:{cn:"更改密码",en:"Change Password"},
	pro_info:{cn:"个人信息",en:"Personal Info"},
	pro_name:{cn:"姓名",en:"Name:"},
	pro_male:{cn:"男",en:"Male"},
	pro_female:{cn:"女",en:"Female"},
	pro_height:{cn:"高度:",en:"Height:"},
	pro_cm:{cn:"厘米",en:"cm"},
	pro_inche:{cn:"英寸",en:"inches"},
	pro_foot:{cn:"英尺",en:"foot"},
	pro_weight:{cn:"重量:",en:"Weight:"},
	pro_kg:{cn:"公斤",en:"kg"},
	pro_kgb:{cn:"公斤",en:"Kg"},
	pro_lbb:{cn:"磅",en:"Pounds"},
	pro_lb:{cn:"磅",en:"lb"},
	pro_dob:{cn:"出生日期:",en:"Brthday:"},
	pro_month:{cn:"月",en:"Month"},
	pro_day:{cn:"日",en:"Day"},
	pro_year:{cn:"年",en:"Year"},
	pro_step:{cn:"步长:",en:"Step Width:"},
	pro_timezone:{cn:"时区:",en:"Timezone:"},
	pro_sensorset:{cn:"传感器设置",en:"Sensor Settings"},
	pro_cpass:{cn:"当前密码:",en:"Current Password:"},
	pro_npass:{cn:"新密码:",en:"New Password:"},
	pro_rpass:{cn:"再次输入新密码:",en:"Retype New Password:"},
	pro_submit:{cn:"提交",en:"Submit"},
	pro_entercpass:{cn:"请输入当前密码",en:"Please enter current password"},
	pro_enternpass:{cn:"请输入新密码",en:"Please enter new password"},
	pro_passSorter:{cn:"密码长度需不少于6个字符.",en:"Password length could not less than 6"},
	pro_reenter:{cn:"再次输入新密码",en:"Please retype new password"},
	pro_diffpass:{cn:"两次输入密码不一致",en:"This does not match the password entered above"},
	pro_needdiff:{cn:"新密码需与原密码不同",en:"New password needs to be different from current"},
	pro_wrongpass:{cn:"当前密码不正确",en:"Your current password was incorrect"},
	pro_passchanged:{cn:"密码已修改",en:"Password changed"},
	pro_noname:{cn:"请输入您的姓名.",en:"Please type in your username"},
	pro_noheight:{cn:"请输入您的身高",en:"Please input your height"},
	pro_noweight:{cn:"请输入您的体重",en:"Please input your weight"},
	pro_nodob:{cn:"请选择您的生日",en:"Please select your birthday"},
	pro_nostep:{cn:"请输入您的步距",en:"Please input your step width"},
	pro_prochanged:{cn:"信息已修改",en:"Profile updated"},

});

function getText(textName){
	return eval('txtLib.'+textName+"."+LANG);
}
var INFO_popupValue=[{name:"PRO_timeZone",posx:93,posy:320,width:318,rowNumber:4,value:[
	{id:'-11:00,0',text_en:'(-11:00) Midway Island, Samoa',text_cn:'中途岛，萨摩亚群岛'},
	{id:'-10:00,0',text_en:'(-10:00) Hawaii',text_cn:'夏威夷'},
	{id:'-09:00,1',text_en:'(-09:00) Alaska',text_cn:'阿拉斯加'},
	{id:'-08:00,1',text_en:'(-08:00) Pacific Time (US & Canada)',text_cn:'太平洋时间（美国和加拿大）'},
	{id:'-07:00,0',text_en:'(-07:00) Arizona',text_cn:'亚利桑那'},
	{id:'-07:00,1',text_en:'(-07:00) Mountain Time (US & Canada)',text_cn:'山地时间（美国和加拿大）'},
	{id:'-06:00,0',text_en:'(-06:00) Central America, Saskatchewan',text_cn:'中美洲，萨斯喀彻温省'},
	{id:'-06:00,1',text_en:'(-06:00) Central Time (US & Canada), Guadalajara, Mexico city',text_cn:'中部时间（美国和加拿大），瓜达拉哈拉，墨西哥城'},
	{id:'-05:00,0',text_en:'(-05:00) Indiana, Bogota, Lima, Quito, Rio Branco',text_cn:'印第安纳州，波哥大，利马，基多，里奥布朗库'},
	{id:'-05:00,1',text_en:'(-05:00) Eastern time (US & Canada)',text_cn:'东部时间（美国和加拿大）'},
	{id:'-04:00,1',text_en:'(-04:00) Atlantic time (Canada), Manaus, Santiago',text_cn:'大西洋时间（加拿大），马瑙斯，圣地亚哥'},
	{id:'-04:00,0',text_en:'(-04:00) Caracas, La Paz',text_cn:'加拉加斯，拉巴斯'},
	{id:'-03:30,1',text_en:'(-03:30) Newfoundland',text_cn:'纽芬兰'},
	{id:'-03:00,1',text_en:'(-03:00) Greenland, Brasilia, Montevideo',text_cn:'格陵兰，巴西利亚，蒙得维的亚'},
	{id:'-03:00,0',text_en:'(-03:00) Buenos Aires, Georgetown',text_cn:'布宜诺斯艾利斯，乔治敦'},
	{id:'-02:00,1',text_en:'(-02:00) Mid-Atlantic',text_cn:'大西洋中部'},
	{id:'-01:00,1',text_en:'(-01:00) Azores',text_cn:'亚速尔群岛'},
	{id:'-01:00,0',text_en:'(-01:00) Cape Verde Is.',text_cn:'佛得角'},
	{id:'00:00,0',text_en:'(00:00) Casablanca, Monrovia, Reykjavik',text_cn:'卡萨布兰卡，蒙罗维亚，雷克雅未克'},
	{id:'00:00,1',text_en:'(00:00) GMT: Dublin, Edinburgh, Lisbon, London',text_cn:'格林威治标准时间：都柏林，爱丁堡，里斯本，伦敦'},
	{id:'+01:00,1',text_en:'(+01:00) Amsterdam, Berlin, Rome, Vienna, Prague, Brussels',text_cn:'阿姆斯特丹，柏林，罗马，维也纳，布拉格，布鲁塞尔'},
	{id:'+01:00,0',text_en:'(+01:00) West Central Africa',text_cn:'西中非'},
	{id:'+02:00,1',text_en:'(+02:00) Amman, Athens, Istanbul, Beirut, Cairo, Jerusalem',text_cn:'安曼，雅典，伊斯坦布尔，贝鲁特，开罗，耶路撒冷'},
	{id:'+02:00,0',text_en:'(+02:00) Harare, Pretoria',text_cn:'哈拉雷，比勒陀利亚'},
	{id:'+03:00,1',text_en:'(+03:00) Baghdad, Moscow, St. Petersburg, Volgograd',text_cn:'巴格达，莫斯科，圣彼得堡，伏尔加格勒'},
	{id:'+03:00,0',text_en:'(+03:00) Kuwait, Riyadh, Nairobi, Tbilisi',text_cn:'科威特，利雅得，内罗毕，第比利斯'},
	{id:'+03:30,0',text_en:'(+03:30) Tehran',text_cn:'德黑兰'},
	{id:'+04:00,0',text_en:'(+04:00) Abu Dhadi, Muscat',text_cn:'阿布扎比，马斯喀特'},
	{id:'+04:00,1',text_en:'(+04:00) Baku, Yerevan',text_cn:'巴库，埃里温'},
	{id:'+04:30,0',text_en:'(+04:30) Kabul',text_cn:'喀布尔'},
	{id:'+05:00,1',text_en:'(+05:00) Ekaterinburg',text_cn:'叶卡捷琳堡'},
	{id:'+05:00,0',text_en:'(+05:00) Islamabad, Karachi, Tashkent',text_cn:'伊斯兰堡，卡拉奇，塔什干'},
	{id:'+05:30,0',text_en:'(+05:30) Chennai, Kolkata, Mumbai, New Delhi, Sri Jayawardenepura',text_cn:'金奈，加尔各答，孟买，新德里，斯里兰卡'},
	{id:'+05:45,0',text_en:'(+05:45) Kathmandu',text_cn:'加德满都'},
	{id:'+06:00,0',text_en:'(+06:00) Astana, Dhaka',text_cn:'阿斯塔纳，达卡'},
	{id:'+06:00,1',text_en:'(+06:00) Almaty, Nonosibirsk',text_cn:'阿拉木图，新西伯利亚'},
	{id:'+06:30,0',text_en:'(+06:30) Yangon (Rangoon)',text_cn:'仰光'},
	{id:'+07:00,1',text_en:'(+07:00) Krasnoyarsk',text_cn:'克拉斯诺亚尔斯克'},
	{id:'+07:00,0',text_en:'(+07:00) Bangkok, Hanoi, Jakarta',text_cn:'曼谷，河内，雅加达'},
	{id:'+08:00,0',text_en:'(+08:00) Beijing, Hong Kong, Singapore, Taipei',text_cn:'北京，香港，新加坡，台北'},
	{id:'+08:00,1',text_en:'(+08:00) Irkutsk, Ulaan Bataar, Perth',text_cn:'伊尔库茨克，乌兰巴托，珀斯'},
	{id:'+09:00,1',text_en:'(+09:00) Yakutsk',text_cn:'雅库茨克'},
	{id:'+09:00,0',text_en:'(+09:00) Seoul, Osaka, Sapporo, Tokyo',text_cn:'首尔，大阪，札幌，东京'},
	{id:'+09:30,0',text_en:'(+09:30) Darwin',text_cn:'达尔文'},
	{id:'+09:30,1',text_en:'(+09:30) Adelaide',text_cn:'阿德莱德'},
	{id:'+10:00,0',text_en:'(+10:00) Brisbane, Guam, Port Moresby',text_cn:'布里斯班，关岛，莫尔兹比港'},
	{id:'+10:00,1',text_en:'(+10:00) Canberra, Melbourne, Sydney, Hobart, Vladivostok',text_cn:'堪培拉，墨尔本，悉尼，霍巴特，符拉迪沃斯托克'},
	{id:'+11:00,0',text_en:'(+11:00) Magadan, Solomon Is., New Caledonia',text_cn:'马加丹，所罗门群岛，新喀里多尼亚'},
	{id:'+12:00,1',text_en:'(+12:00) Auckland, Wellington',text_cn:'奥克兰，惠灵顿'},
	{id:'+12:00,0',text_en:'(+12:00) Fiji, Kamchatka, Marshall Is.',text_cn:'斐济，堪察加半岛，马绍尔群岛'},
	{id:'+13:00,0',text_en:"(+13:00) Nuku'alofa",text_cn:'努库阿洛法'}
]}];
INFO_popupValue.push({name:"PRO_sUnit",posx:307,posy:270,width:58,rowNumber:2,value:[{id:'foot',text_en:'foot',text_cn:'英尺'},{id:'cm',text_en:'cm',text_cn:'厘米'}]});
INFO_popupValue.push({name:"PRO_hUnit",posx:307,posy:125,width:58,rowNumber:2,value:[{id:'foot',text_en:'foot',text_cn:'英尺'},{id:'cm',text_en:'cm',text_cn:'厘米'}]});
INFO_popupValue.push({name:"PRO_wUnit",posx:307,posy:172,width:58,rowNumber:2,value:[{id:'lb',text_en:'lb',text_cn:'磅'},{id:'kg',text_en:'kg',text_cn:'公斤'}]});

if(LANG=="cn"){
	posy=93
	posm=190
	posd=288
}else{	
	posm=93
	posd=190
	posy=288
}

INFO_popupValue.push({name:"PRO_month",posx:posm,posy:222,width:79,rowNumber:6,value:[]});

var monthNameList=new Array({en:'January',cn:'1'},{en:'February',cn:'2'},{en:'March',cn:'3'},{en:'April',cn:'4'},{en:'May',cn:'5'},{en:'June',cn:'6'},{en:'July',cn:'7'},{en:'August',cn:'8'},{en:'September',cn:'9'},{en:'October',cn:'10'},{en:'November',cn:'11'},{en:'December',cn:'12'});

var currentPopName,popUpChanged=false;

for(var i=0;i<12;i++){
	INFO_popupValue[INFO_popupValue.length-1].value.push({id:i+1,text_en:monthNameList[i].en,text_cn:monthNameList[i].cn});
}

INFO_popupValue.push({name:"PRO_day",posx:posd,posy:222,width:79,rowNumber:6,value:[]});

for(i=1;i<=31;i++){
	INFO_popupValue[INFO_popupValue.length-1].value.push({id:i,text:i});
}
INFO_popupValue.push({name:"PRO_year",posx:posy,posy:222,width:79,rowNumber:6,value:[]});

for(i=2013;i>=1900;i--){
	INFO_popupValue[INFO_popupValue.length-1].value.push({id:i+1,text:i});
}

var back_ucode=$.cookie('back_ucode');
var back_scode=$.cookie('back_scode');
var back_ecode=$.cookie('back_ecode');

var sensorList=new Array(); 
var currentSensorID=0;
var myDate = new Date();
var my=myDate.getFullYear();
var mm=myDate.getMonth()+1;
var md=myDate.getDate();
var sexID=0;
var mytime=my+"-"+mm+"-"+md+" "+myDate.toLocaleTimeString();  
	
var headimage;	
function monthNametoID(name){
	for(var i=0;i<monthNameList.length;i++){
		if(eval("monthNameList["+i+"]."+LANG)==name){
			return i+1;
		}
	}
	return 0;
}
function changeSex(event){
	sexID=event.data.id;
	changSexPic(sexID);
	
}
function changSexPic(sid){
	if(sid=="M"){sid=0;}
	if(sid=="F"){sid=1;}
	$("#INFO_sex"+sid).attr('src',"../images/se_yes.png");
	$("#INFO_sex"+(1-sid)).attr('src',"../images/se_no.png");
	$('#PRO_sel').fadeOut();
	sid==0 ? $('#gender').val("M"):$('#gender').val("F");
}
var timezone;
function calculate_time_zone() {
	var rightNow = new Date();
	var jan1 = new Date(rightNow.getFullYear(), 0, 1, 0, 0, 0, 0);  // jan 1st
	var june1 = new Date(rightNow.getFullYear(), 6, 1, 0, 0, 0, 0); // june 1st
	var temp = jan1.toGMTString();
	var jan2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	temp = june1.toGMTString();
	var june2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	var std_time_offset = (jan1 - jan2) / (1000 * 60 * 60);
	var daylight_time_offset = (june1 - june2) / (1000 * 60 * 60);
	var dst;
	if (std_time_offset == daylight_time_offset) {
		dst = "0"; // daylight savings time is NOT observed
	} else {
		// positive is southern, negative is northern hemisphere
		var hemisphere = std_time_offset - daylight_time_offset;
		if (hemisphere >= 0)
			std_time_offset = daylight_time_offset;
		dst = "1"; // daylight savings time is observed
	}
	timezone=convert(std_time_offset);
	$("#PRO_sel").val(convert(std_time_offset)+","+dst);
	$("#PRO_timeZone").html($("#PRO_sel").find("option:selected").text());
	
}

function convert(value) {
	var hours = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var mins = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var secs = parseInt(value);
	var display_hours = hours;
	// handle GMT case (00:00)
	if (hours == 0) {
		display_hours = "00";
	} else if (hours > 0) {
		// add a plus sign and perhaps an extra 0
		display_hours = (hours < 10) ? "+0"+hours : "+"+hours;
	} else {
		// add an extra 0 if needed 
		display_hours = (hours > -10) ? "-0"+Math.abs(hours) : hours;
	}
	
	mins = (mins < 10) ? "0"+mins : mins;
	return display_hours+":"+mins;
}

function showpop(popName){
	
	popUpChanged=(currentPopName!=popName);
	currentPopName=popName;
	
	for(var i=0;i<INFO_popupValue.length;i++){
		var nobj=INFO_popupValue[i];
		if(popName==nobj.name){
			$('#PRO_popup').css("left",nobj.posx);
			$('#PRO_popup').css("top",nobj.posy);
			$('#PRO_sel').width(nobj.width);
			$('#PRO_sel').attr("size",nobj.rowNumber);
			$('#PRO_sel option').each(function(){$(this).remove();}); 
			exStr="";
			if(popName !="PRO_day" && popName !="PRO_year" ){exStr="_"+LANG;}
			for(var j=0;j<nobj.value.length;j++){
				$("#PRO_sel").append("<option value='"+nobj.value[j].id+"'>"+eval("nobj.value["+j+"].text"+exStr)+"</option>");
			}
			if(popUpChanged){
				$("#PRO_sel").hide();
			}
			$("#PRO_sel").slideToggle("fast");
			break;
		}
	}
}
	
$(function(){

	$('#PRO_bigTitle').text(getText('pro_my'));
	$('#PRO_accountTitle').text(getText('pro_as'));
	$('#PRO_infoTitle').text(getText('pro_info'));
	$('#pname').html(getText('pro_name'));
	$('#pmale').html(getText('pro_male'));
	$('#pfemale').html(getText('pro_female'));
	$('#pheight').html(getText('pro_height'));
	$('#pweight').html(getText('pro_weight'));
	$('#pdob').html(getText('pro_dob'));
	$('#cimage').text(getText('pro_changpic'));
	$('#cpass').text(getText('pro_changpas'));
	$('#pinfo').text(getText('pro_info'));
	$('#swidth').html(getText('pro_step'));
	$('#tzone').html(getText('pro_timezone'));
	$('#PRO_submit').text(getText('pro_submit'));
	$('#PRO_infoTitle').text(getText('pro_info'));
	$('#PRO_sensorTitle').text(getText('pro_sensorset'));
	
	$('#change_c').html(getText('pro_cpass'));
	$('#change_n').html(getText('pro_npass'));
	$('#change_r').html(getText('pro_rpass'));
	$('#PRO_month').val(getText('pro_month'));
	$('#PRO_day').val(getText('pro_day'));
	$('#PRO_year').val(getText('pro_year'));
	
		//---------性别---
		for(i=0;i<2;i++){
			$('#INFO_sex'+i).css("cursor","pointer");
			$('#INFO_sex'+i).bind("click",{id:i},changeSex);
		}
		//---------时区
		$(".PRO_clickInput").bind({
			click:function(){showpop($(this).children().attr("id"));}
		});

		$('#PRO_sel').bind({
			change:function(event){
				
				$(this).fadeOut();
				if($("#"+currentPopName).val()==$(this).find("option:selected").text()){return;}
				$("#"+currentPopName).val($(this).find("option:selected").text());
				$("#"+currentPopName).css("color","#6b6b6b");
				var value=$("#"+currentPopName).val();
				//alert(currentPopName+"  "+value);
				var showValue;
				switch(currentPopName){
					case "PRO_hUnit":
					case "PRO_sUnit":
						if(value==getText('pro_foot')){changeUnit("Inch");}
						if(value==getText('pro_cm')){changeUnit("Metric");}
					break;
					case "PRO_wUnit":
						if(value==getText('pro_lb')){changeUnit("Inch");}
						if(value==getText('pro_kg')){changeUnit("Metric");}
					break;	
					case "PRO_timeZone":
						var leftpos=value.indexOf("(");
						var rightpos=value.indexOf(")");
						timezone=value.substring(leftpos+1,rightpos)
						
					break;
				}
				
			}
		});
		$(".PRO_clickText").bind({
			click:function(){$('#PRO_sel').fadeOut();}
		});
		
		$('#PRO_close').bind({
			click:function(event){hidethis();}
		});
		
		showpop("PRO_timeZone");
		calculate_time_zone();
		$('#PRO_sel').hide();
		//监听键盘，只允许输入数字和小数点
		$(".PRO_inputNumber").keypress(function(event) {
			var keyCode = event.which;
			if (keyCode == 46 || (keyCode >= 48 && keyCode <=57) ||keyCode == 8 ||keyCode == 127)
				return true;
			else
				return false;
			}).focus(function() {
				this.style.imeMode='disabled';
		});
		//----------------out暂存所有数字,全部保存为英制数值----tempH---tempW---tempS-----
		$(".PRO_inputNumber").bind({
			focusout:function(){
				//--------长度--------
				
				if($('#PRO_hUnit').val()==getText('pro_foot')){
					$('#tempH').val(unitToMetric({from:"foot",foot:$('#PRO_h1').val(),inch:$('#PRO_h2').val()}));
					$('#tempS').val(unitToMetric({from:"foot",foot:$('#PRO_s1').val(),inch:$('#PRO_s2').val()}));
				}
				if($('#PRO_hUnit').val()==getText('pro_cm')){
					$('#tempH').val(unitToMetric({from:"cm",cm:$('#PRO_h1').val()}));
					$('#tempS').val(unitToMetric({from:"cm",cm:$('#PRO_s1').val()}));
				}	
				if($('#PRO_wUnit').val()==getText('pro_lb')){
					$('#tempW').val(unitToMetric({from:"lb",lb:$('#PRO_w').val()}));
				}
				if($('#PRO_wUnit').val()==getText('pro_kg')){
					$('#tempW').val(unitToMetric({from:"kg",kg:$('#PRO_w').val()}));
				}
				//------------改变高重后，改变步长--------------
				if($(this).attr("id")=="PRO_h1" || $(this).attr("id")=="PRO_h2"){
					
					if(sexID==0){
						$('#tempS').val($('#tempH').val()*0.415);
					}else{
						$('#tempS').val($('#tempH').val()*0.413);
					}
					changeUnit($('#unit').val());
				}
			}
				
		});
		$('.btnBack1').bind({
			mouseenter:function(){$(this).css("background-image","url('../images/bt_back2.png')");},
			mouseleave:function(){$(this).css("background-image","url('../images/bt_back1.png')");},
			click:function(){
				$('#PRO_infoTitle').html($(this).children().eq(1).html());
				$('.PRO_mainInfo').each( function(){$(this).hide();});
				$('#'+$(this).attr("id")+'Area').show();
				if($(this).attr("id")=="PRO_images"){
					//var iframeSrc = $("#IFRAME_upload").attr("src");
                	//$("#IFRAME_upload").attr("src", iframeSrc);
					$("#IFRAME_upload").attr("src","adjusthead.php?ucode="+back_ucode+"&scode="+back_scode+"&ecode="+back_ecode+"&pic="+headimage);
				}
				
			}
			
		});
		$('.PRO_mainInfo').each( function(){$(this).hide();});
		
		
		
		$('#PRO_infoArea').show();
		buildButton('PRO_submit');
		$('#PRO_submit').bind({
			click:function(){
				if($("#PRO_infoArea").css("display") =="block"){
					savePersonalInfo();
				}
				if($("#PRO_passwordArea").css("display") =="block"){
					savePassword();
				}
			}
		});
		//$('div').each(function() {$('#'+this.id).addClass("G_unselect");});
		//alert(headimage);
		//$("#IFRAME_upload").attr("src","adjusthead.php?ucode="+back_ucode+"&scode="+back_scode+"&ecode="+back_ecode+"&pic="+headimage);
		//alert("adjusthead.php?ucode="+back_ucode+"&scode="+back_scode+"&ecode="+back_ecode+"&pic="+headimage);
		getUserInfo();
		
		$('#Frame_profileSetup').show();	
});
function hidethis(){
	parent.hidePop('popProfile');
	
}


function savePersonalInfo(){
	$('#errInfo').html();
	if($('#PRO_userName').val()==""){
		$('#errInfo').html(getText('pro_noname'));
		return;
	}
	
	if($('#PRO_h1').val()==""){
		$('#errInfo').html(getText('pro_noheight'));
		return;
	}
	if($('#PRO_w').val()==""){
		$('#errInfo').html(getText('pro_noweight'));
		return;
	}
	if($('#PRO_month').val()==getText('pro_month') ||$('#PRO_day').val()==getText('pro_day') ||$('#PRO_year').val()==getText('pro_year')){
		$('#errInfo').html(getText('pro_nodob'));
		return;
	}
	if($('#PRO_s1').val()==""){
		$('#errInfo').html(getText('pro_nostep'));
		return;
	}
	

	
	$('#PRO_sel').fadeOut();
	//--------------判断个人信息------		
	
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,nickname:$('#PRO_userName').val(),gender:$('#gender').val(),
		dob:$('#PRO_year').val()+'-'+monthNametoID($('#PRO_month').val())+'-'+$('#PRO_day').val(),height:$('#tempH').val(),
		weight:$('#tempW').val(),stepwidth:$('#tempS').val(),timezone:timezone,cdate:mytime,unit:$('#unit').val(),source:"w"
	};
	
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/saveprofile.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			back_ecode=msg.ecode;
			$.cookie('back_ecode', back_ecode,{path:'/', expires:1000});
			$('#PRO_replyInfo').html(getText('pro_prochanged'));
			$('#PRO_reply').show();
			$('#PRO_infoArea').hide();
			
			autohide();
			if(parent.pageID==2){
				$.cookie('back_username',$('#PRO_userName').val(),{path:'/', expires:1000});
				$("#INFO_name", parent.document).html($('#PRO_userName').val());
			}
		}
    });
	
}


	
function savePassword(){
	//--------------判断修改密码
	$('.blankRow').each(function() {$(this).html('');});
	var curpass=$('#PRO_curPass').val();
	var newpass=$('#PRO_newPass').val();
	var repass=$('#PRO_rePass').val();
	if(curpass==""){
		$('#er_1').html(getText('pro_entercpass'));return;
	}
	if(newpass==""){
		$('#er_2').html(getText('pro_enternpass'));return;
	}
	if(newpass.length<6){
		$('#er_2').html(getText('pro_passSorter'));return;
	}
	if(repass==""){
		$('#er_3').html(getText('pro_reenter'));return;
	}	
	
	if(newpass != repass){
		$('#er_2').html('');
		$('#er_3').html(getText('pro_diffpass'));
		return;
	}
	if(newpass == curpass){
		$('#er_2').html(getText('pro_needdiff'));
		$('#er_3').html(getText('pro_needdiff'));
		return;
	}

	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,password:curpass,newpass:newpass,cdate:mytime,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",url:'../res/saveprofile.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			if (msg.status==401){
				$('#er_1').html(getText('pro_wrongpass'));
			}			
			if (msg.status==200){
				back_ecode=msg.ecode;
				$.cookie('back_ecode', back_ecode,{path:'/', expires:1000});
				$('#PRO_replyInfo').html(getText('pro_passchanged'));
				$('#PRO_reply').show();
				$('#PRO_passwordArea').hide();
				autohide();
			}
		}
    });
}
function autohide(){
	$('body').oneTime('1s',function(){ 
			hidethis();
			parent.beginLoad();
	}); 
}
function unitToMetric(obj){
	var v1,v2;
	
	if(obj.from=="cm"){
		//v1=Number(obj.cm)/30.48; //------1英寸=2.54cm
		v1=Number(obj.cm);
		return v1.toFixed(1);
	}
	if(obj.from=="foot"){
		v1=Number(obj.foot)+Number(obj.inch)/12;
		v1*=30.48;
		return v1;
	}
	if(obj.from=="lb"){
		//v1=obj.lb;
		v1=Number(obj.lb)*0.45359237;
		return v1;
	}
	
	if(obj.from=="kg"){
		//v1=Number(obj.kg)/0.45359237;
		v1=Number(obj.kg);
		return v1;
	}
}
function getFromTemp(obj){
	var v1,v2;
	var value=Number(obj.value);
	if(obj.to=="foot"){
		value/=30.48;
		v2=Math.floor(value);
		v1=Math.round((value-v2)*12);
		return {foot:v2,inch:v1};
	}	
	if(obj.to=="cm"){
		//v1=Math.floor(2.54*value*12);
		v1=value.toFixed(1);
		return {cm:v1};
	}
	if(obj.to=="lb"){
		//v1=Math.floor(value*10)/10;
		v1=Math.round(value*2.2046226218488);
		return {lb:v1};
	}
	if(obj.to=="kg"){
		//v1=Math.floor(value/0.045359237)/10;
		v1=value.toFixed(1);
		return {kg:v1};
	}
}

function showThumb(img){
	/*
	$("#Pro_headDiv").width(img.width);
	$("#Pro_headDiv").height(img.height);
	$("#Pro_head").attr('src',"../upload/head_"+$.cookie('back_userid')+".jpg");	
	*/
}
function changeThumb(imgcss){
	/*
	$('#Pro_head').css({ 
		width: imgcss.width, 
		height: imgcss.height,
		//marginLeft:imgcss.marginLeft, 
		//marginTop: imgcss.marginLeft 
	});
	$('#Pro_headDiv').css("left",imgcss.left)
	$('#Pro_headDiv').css("top",imgcss.top)
	var nobj=$('#IFRAME_upload').contents().find('#timg');
	//$("#info").html("width:"+imgcss.width+" height:"+imgcss.height+" left:"+imgcss.left+" top:"+imgcss.top+"<br>iframe<br>"+"width:"+nobj.width()+" height:"+nobj.height()+" left:"+nobj.css("marginLeft")+" top:"+nobj.css("marginTop"));
	*/
}
function getUserInfo(){
	var nmyDate = new Date();
	var nmy=nmyDate.getFullYear();
	var nmm=nmyDate.getMonth()+1;
	var nmd=nmyDate.getDate();
	
	var nmytime=nmy+"-"+nmm+"-"+nmd+" "+nmyDate.toLocaleTimeString();
	
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",cdate:nmytime};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
        url:'../res/getinfo.php',data:JSON.stringify(outData), 
        success: function (msg) {
			dealData(msg);
        }
    });
}

function dealData(r){
	
	//var data=eval('(' + r + ')');  

	
	
	if(r.status != 200 ){return;}
	back_ecode=r.ecode;
	$.cookie('back_ecode', back_ecode,{path:'/', expires:1000});
	sensorList=r.sensorlist;
	//------add in sensor list
	$('#PRO_sensor div').each(function(){$(this).remove();});
	var obj;
	for(var i=0;i<sensorList.length;i++){
		j=i+1;
		obj=sensorList[i];
		
		var power="0000"+obj.power;
		power=power.substring(power.length-4,power.length);

		var strs='<div id="sensoritem'+i+'" class="PRO_senList"><table cellpadding="0" cellspacing="0">';
		strs+='<tr height=43><td><div class="PRO_senNO">'+j+'</div></td><td width=25><img src="../images/sensor'+power+'.png" />';
		strs+='</td><td><div  class="PRO_nameBack" id="sensorname'+i+'">'+obj.nickname+'</div></td></tr></table></div>';
    	$(strs).appendTo($('#PRO_sensor'));
	}
	
	showSensor();
}
function showSensor(){
	
	var obj=sensorList[currentSensorID];
	if (obj.dob != "0000-00-00"){
		var dob=obj.dob;
		$('#PRO_year').val(Number(dob.substring(0,4)));
		var mnum=Number(dob.substring(5,7))-1;
		if(mnum<0){mnum=0;}
		$('#PRO_month').val(eval("monthNameList["+mnum+"]."+LANG));
		$('#PRO_day').val(Number(dob.substring(8,10)));
		$('#PRO_year').css("color","#6b6b6b");
		$('#PRO_month').css("color","#6b6b6b");
		$('#PRO_day').css("color","#6b6b6b");
	}
	if(obj.nickname != undefined){
		$('#PRO_userName').val(obj.nickname);
		
	}
	if(obj.height != undefined){
		$('#tempH').val(obj.height);
		$('#PRO_h1').val(obj.height);
	}
	if(obj.weight != undefined){
		$('#tempW').val(obj.weight);
		$('#PRO_w').val(obj.weight);
	}
	if(obj.stepwidth != undefined){
		$('#tempS').val(obj.stepwidth);
		$('#PRO_s1').val(obj.stepwidth);
	}
	headimage=obj.headimage;
	$("#Pro_head").attr("src",'../upload/'+obj.headimage); 
	
	$("#Pro_head").width(182);
	$("#Pro_head").height(182);
	
	if(obj.gender != undefined){
		changSexPic(obj.gender);
	}
	
	changeUnit(obj.unit);

}
function changeUnit(units){
	
	$('#unit').val(units);
	if(units=="Metric"){
		showValue=getFromTemp({to:"cm",value:$('#tempH').val()});
		$("#h_u1").html(getText('pro_cm'));$("#h_u2").html("");
		$("#h_u1").width(100);$("#h_v2").hide();
		$('#PRO_h1').val(showValue.cm);
		$('#PRO_h2').val(0);
		$('#PRO_hUnit').val(getText('pro_cm'));
		showValue=getFromTemp({to:"cm",value:$('#tempS').val()});
		$("#s_u1").html(getText('pro_cm'));$("#s_u2").html("");
		$("#s_u1").width(100);$("#s_v2").hide();
		$('#PRO_s1').val(showValue.cm);
		$('#PRO_s2').val(0);
		$('#PRO_sUnit').val(getText('pro_cm'));
		showValue=getFromTemp({to:"kg",value:$('#tempW').val()});
		$('#PRO_w').val(showValue.kg);
		$("#w_u").html(getText('pro_kg'));
		$('#PRO_wUnit').val(getText('pro_kg'));
	}
	if(units=="Inch"){
		showValue=getFromTemp({to:"foot",value:$('#tempH').val()});
		$("#h_u1").html(getText('pro_foot'));$("#h_u2").html(getText('pro_inche'));
		$("#h_u1").width(40);$("#h_v2").show();
		$('#PRO_h1').val(showValue.foot);
		$('#PRO_h2').val(showValue.inch);
		$('#PRO_hUnit').val(getText('pro_foot'));
		showValue=getFromTemp({to:"foot",value:$('#tempS').val()});
		$("#s_u1").html(getText('pro_foot'));$("#s_u2").html(getText('pro_inche'));
		$("#s_u1").width(40);$("#s_v2").show();
		$('#PRO_s1').val(showValue.foot);
		$('#PRO_s2').val(showValue.inch);
		$('#PRO_sUnit').val(getText('pro_foot'));
		
		showValue=getFromTemp({to:"lb",value:$('#tempW').val()});
		$('#PRO_w').val(showValue.lb);
		$("#w_u").html(getText('pro_lb'));
		$('#PRO_wUnit').val(getText('pro_lb'));
	}
}
function updatedHead(headpic){
	//alert("change profile"+headpic);
	headimage=headpic
	$("#Pro_head").attr("src","../upload/"+headpic); 
	parent.updatedHead(headpic);
}
