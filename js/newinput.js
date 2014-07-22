
document.write("<script type='text/javascript' src='../js/reglogin.js'></"+"script>"); 

var pageID=5; // userpage

var maxIndex=100;

var pageName="newinput";
var timeTable=[];
var currentValueRow=0;
var dateListMin=[];
var outList=[];
var currentDate;
var DaysInEachMonth=new Array(31,28,31,30,31,30,31,31,30,31,30,31);
var nowDate=new Date();
var nowYear=nowDate.getFullYear();
var nowMonth=nowDate.getMonth()+1;
var nowDay=nowDate.getDate();
currentDate=nowYear+"-";
if(nowMonth>9){currentDate+=nowMonth;}else{currentDate+="0"+nowMonth;}
if(nowDay>9){currentDate+="-"+nowDay;}else{currentDate+="-0"+nowDay;}

var back_ucode=$.cookie('back_ucode');
var back_scode=$.cookie('back_scode');
var back_ecode=$.cookie('back_ecode');
var back_loginMode=$.cookie('back_loginMode');

var back_bmr,back_sw
var sensorList=new Array(); 
var currentSensorID=0
var myDate = new Date();
var my=myDate.getFullYear();
var mm=myDate.getMonth()+1;
var md=myDate.getDate()
var mh=myDate.getHours();
var mi=myDate.getMinutes();
var ms=myDate.getSeconds();

var mytime=my+"-"+mm+"-"+md+" "+mh+":"+mi+":"+ms;  
	
$(function(){
	if(back_ucode!=null){
		back_ucode=$.cookie('back_ucode');
		back_scode=$.cookie('back_scode');
		back_ecode=$.cookie('back_ecode');
		var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",cdate:mytime};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/getinfo.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				dealgetInfo(msg);
				
        	}
    	});

	}
	$("#processbar" ).progressbar({value: 0});
	//progressbarValue = $("#processbar" ).find(".ui-progressbar-value" );
	//progressbarValue.css({"background": '#66bd00'});
	$('#addnew').button({icons:{primary:"ui-icon-plusthick"}});
	$( "#addnew" ).click(function() {addNewTimeData({mode:0,from:0,to:0})});
	$('#autoBuild').button({icons:{primary:"ui-icon-lightbulb"}});
	$( "#autoBuild" ).click(function() {autoBuild($('#parts').spinner("value"))});
	$('#parts').spinner({max:24,min:1});
	$('#cleanData').button()
	$('#cleanData').button({icons:{primary:"ui-icon-closethick"}});
	$( "#cleanData" ).click(function() {cleanData()});
	$('#zeroData').button()
	$('#zeroData').button({icons:{primary:"ui-icon-arrowthickstop-1-s"}});
	$( "#zeroData" ).click(function() {zeroData()});
	$('#randValue1').button()
	$('#randValue1').button({icons:{primary:"ui-icon-script"}});
	$( "#randValue1" ).click(function() {randBuildValue()});
	$('#clearDatabase').button()
	$('#clearDatabase').button({icons:{primary:"ui-icon-trash"}});
	$( "#clearDatabase" ).click(function() {delDataBase()});
	$('#valuelist').hide();
	$('#buildAllData').hide();
	$('#listAllData').hide();
	
	//监听键盘，只允许输入数字和小数点
	$(".inputLong").keypress(function(event) {
		var keyCode = event.which;
		if ( (keyCode >= 48 && keyCode <=57) ||keyCode == 8 ||keyCode == 127 || keyCode == 46 ){
			return true;
		}else{
			return false;
		}
		}).focus(function() {
			this.style.imeMode='disabled';
	});
	
	$('.inputLong').bind({
		change:function(event){saveValueData();}
	});	
	$('#buildList').button()
	$('#buildList').button({icons:{primary:"ui-icon-flag"}});
	$('#buildList').click(function() {buildAllData()});
	//$('#showList').button()
	//$('#showList').button({icons:{primary:"ui-icon-document"}});
	//$( "#showList" ).click(function() {showAllData()});
	
	$('#postList').button()
	$('#postList').button({icons:{primary:"ui-icon-disk"}});
	$( "#postList" ).click(function() {postAllData()});
	
	$('#minparts').spinner({max:20,min:1,value:5});
	//$('#showList').button("option","disabled", true);
	$('#minparts').spinner("option","disabled", true);
	$('#postList').button("option","disabled", true);
	
	$('#dateYear').spinner({max:2014,min:2013});
	$('#dateMonth').spinner({max:12,min:1});
	$('#dateDay').spinner({max:31,min:1});
	$('#dateYear').spinner("value",nowYear);
	$('#dateMonth').spinner("value",nowMonth);
	$('#dateDay').spinner("value",nowDay);
	adjustDayList();
	$('.inputDate').bind({
		blur:function(event){adjustDayList();}
	});	
	$('#ucode').text("user ID:"+back_ucode);
	$('#scode').text("sensor ID:"+back_scode);
	$('#zeroRand1').button({icons:{primary:"ui-icon-shuffle"}});
	$('#zeroLin').button({icons:{primary:"ui-icon-refresh"}});
	$("#zeroRand1" ).click(function() {$("input[name^='rfrom'],input[name^='rto']").each(function(){$(this).val(0)});saveValueData();});
	$("#zeroLin" ).click(function() {$("input[name^='lto']").each(function(){$(this).val(0)});saveValueData();});
	if(back_loginMode==null){
		$.cookie('afterLoginJump','newinput.php');
		$( "#dialog-modal" ).dialog({height: 140,modal: true});
		//document.getElementById('popupRegFrame').contentWindow.showSignUp();
		$('#content').hide();
	};
});

function dealgetInfo(value){
	if(value.status != 200 ){return}
	back_ecode=value.ecode
	$.cookie('back_ecode', back_ecode);
	sensorList=value.sensorlist
	showSensor();
}
function showSensor(){
	
	var obj=sensorList[currentSensorID]

	$.cookie('back_bmr', obj.bmr);
	$.cookie('back_sw', obj.stepwidth);
	back_bmr=parseFloat(obj.bmr);
	back_sw=parseFloat(obj.stepwidth);
	if(isNaN(back_sw)){back_sw=74.7}
	$('#username').text(obj.nickname);
	
	$('#userbmr').text("BMR:"+back_bmr);
	$('#stepWidth').text("Step Width:"+back_sw+" mm");

}
	
function adjustDayList(){
	//alert(DaysInEachMonth[$('#dateMonth').spinner("value")-1])
	$('#dateDay').spinner("option","max",DaysInEachMonth[$('#dateMonth').spinner("value")-1]);
	nowYear=$('#dateYear').spinner("value")
	nowMonth=$('#dateMonth').spinner("value")
	nowDay=$('#dateDay').spinner("value")
	currentDate=nowYear+"-"
	if(nowMonth>9){currentDate+=nowMonth}else{currentDate+="0"+nowMonth}
	if(nowDay>9){currentDate+="-"+nowDay}else{currentDate+="-0"+nowDay}
}
function postAllData(){
	$('#alertinfo').html("remove old data, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	$('#postList').button("option","disabled", true);
	//var outData={ucode:100,data:outList,sensorid:1};
	/*
	var newData=[];
	for(i=0;i<20;i++){
		newData.push(outList[i]);
	}
	*/
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,rdate:currentDate,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/newinput_removedata.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			back_ecode=msg.ecode
			$.cookie('back_ecode', back_ecode);
			contuploadData()
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	

}
function contuploadData(){
	var outData={ucode:back_ucode,scode:back_scode,data:outList,ecode:back_ecode,source:"w"};
	$('#alertinfo').html("uploading action data, please wait...");
	$('#out').html(JSON.stringify(outData));
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/upload_data.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			uploadAlert();
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });
}
function uploadAlert(){
	$('#alertinfo').html("upload alert data, please wait...");
	var outData={ucode:back_ucode,scode:back_scode,alertlist:[{stamp:mytime,type:1}],ecode:back_ecode,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/upload_alert.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			uploadPower();
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });
}

function uploadPower(){
	$('#alertinfo').html("upload power data, please wait...");
	var outData={ucode:back_ucode,scode:back_scode,power:Math.floor(Math.random()*100),ecode:back_ecode,source:"w",cdate:mytime};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/updatepower.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			back_ecode=msg.ecode;
			$.cookie('back_ecode', back_ecode);
			$( "#dialog-modal" ).dialog("close");
			$('#postList').button("enable");
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });
}

function delDataBase(){
	$('#alertinfo').html("clear database, please wait...");
	$( "#dialog-modal" ).dialog({height: 140,modal: true});
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,rdate:currentDate,source:"w"};
	$('#out').html(JSON.stringify(outData));
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/newinput_removedata.php',
		data:JSON.stringify(outData), 
        success: function (msg) {
			back_ecode=msg.ecode
			$.cookie('back_ecode', back_ecode);
			$( "#dialog-modal" ).dialog("close");
        },
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
       		$('#alertinfo').html("unknown error!");
        }
    });	
}

function idToMin(id){
	
	var hour=Math.floor(id/60)
	if (hour<10){hour="0"+hour}
	var mins=id-hour*60
	if (mins<10){mins="0"+mins}
	return currentDate+" "+hour+":"+mins
}
//-----------生成所有的每分钟数据
//{"stamp":"2012-07-13 16:35", "calories":333, "steps":10, "distance":21.5}
//{"stamp":"2012-07-13 15:20","temp":36.5}
//timeTable.push({id:newTableID,from:fromValue,to:toValue,sleepMode:0,
		//value:[{rfrom:0,rto:0,lto:0},{rfrom:0,rto:0,lto:0},
		//{rfrom:0,rto:0,lto:0},{rfrom:0,rto:0,lto:0},{rfrom:0,rto:0,lto:0}
	//]});
//

function buildAllData(){
	dateListMin=[];
	for(i=0;i<1440;i++){
		dateListMin.push({stamp:idToMin(i),value:[0,0,0,0,0],sleepMode:0})
	}
	//-----------计算所有的分钟值---------------
	$("input[name='awakeMode']:checkbox:checked").each(function(){
		var nid=($(this).attr("id"))
		var did=parseInt(nid.substring(5,nid.length))
		timeTable[did].sleepMode=0
		//alert(nid)
		
	});
	rmode=0
	$("input[name='withRand']:checkbox:checked").each(function(){
		rmode=1
	});
	
	//for(i=0;i<timeTable.length;i++){
		//alert(i+"   "+timeTable[i].sleepMode);
	//}
	//5个值单独计算---------
	for(m=0;m<5;m++){
		if(m!=3){crate=5}else{crate=1}
		for(i=0;i<timeTable.length;i++){
			if(i==0){
				if(rmode==1){
					lastLine=getRand(timeTable[i].value[m].lto);
				}else{
					lastLine=timeTable[i].value[m].lto;	
				}
			}else{
				lastLine=timeTable[i-1].value[m].lto;
			}
			rate=1;
			
			//-------计算线性增长值--------------
			fromHour=timeTable[i].from;
			toHour=timeTable[i].to;
			hourLength=toHour-fromHour+1;

			dataDiff=(timeTable[i].value[m].lto-lastLine)/(hourLength*60);
		
			for(j=fromHour*60;j<(toHour+1)*60;j++){
				if(rmode==1){
					dateListMin[j].value[m]=rate*((j-fromHour*60)*dataDiff+lastLine+getRandRange(timeTable[i].value[m].rfrom,timeTable[i].value[m].rto))/crate;
				}else{
					dateListMin[j].value[m]=rate*((j-fromHour*60)*dataDiff+lastLine+timeTable[i].value[m].rfrom)/crate;
				}
				if(m==0){dateListMin[j].sleepMode=timeTable[i].sleepMode;
			}
		}
		//-------------按照实际时间显示-------------------
	  }
	
	}
	
	$('#listAllData').show();
	$('#outList table').remove();
	//$('#showList').button("enable");
	//$('#minparts').spinner("enable");
	$('#postList').button("option","disabled", true);
	$('#out').html();
	showAllData();
}
function showAllData(){
	$('#outList table').remove();
	var tableStr='<table width=750 align=center cellpadding="2" cellspacing="2" id="listTable"><tr><td>id</td><td>time</td><td>calories</td><td>steps</td>';
	tableStr+='<td>distance</td><td>temperature</td><td>movement</td><td>sleepMode</td></tr></table>';
	$(tableStr).appendTo($('#outList'));
	outList=[]
	var dis=parseInt($('#minparts').spinner("value"))
	var outValue=[]
	var totalC=0
	var buildC=0
	var totalS=0
	var totalD=0
	var c=10
	var pos=2
	for(i=0;i<1440-dis+1;i+=dis){
		outList.push({stamp:idToMin(i),calories:0,steps:0,distance:0,temp:0,move:0,sleepmode:dateListMin[i].sleepMode,angle:0,maxspeed:0,minspeed:0,averagespeed:0,detectedposition:0});
		outValue=[0,0,0,0,0]
		for(m=0;m<5;m++){
			for(j=0;j<dis;j++){
				if(m!=3){
					outValue[m]=parseFloat(outValue[m])+parseFloat(dateListMin[i+j].value[m])
				}else{
					outValue[m]=parseFloat(dateListMin[i+j].value[m])	
				}
			}
			
		}
		outValue[0]=parseInt(outValue[0]*100)/100
		outValue[1]=Math.floor(outValue[1])
		outValue[2]=parseInt(outValue[1]*back_sw)/10
		outValue[3]=parseInt(outValue[3]*10)/10
		outValue[4]=Math.floor(outValue[4])
		
		buildC+=outValue[0]
		totalC+=Math.floor(back_bmr/2.88)/100+outValue[0]
	 	totalS+=outValue[1]
		totalD+=outValue[2]
	
		cal=outValue[0].toFixed(2)
		ste=outValue[1]
		dist=outValue[2].toFixed(3)
		tem=outValue[3].toFixed(1)
		mov=outValue[4]
		
		outList[outList.length-1].calories=cal;
		outList[outList.length-1].steps=ste;
		outList[outList.length-1].distance=dist;
		outList[outList.length-1].temp=tem;
		outList[outList.length-1].move=mov;
		
		outList[outList.length-1].angle=parseInt(Math.random()*10);
		outList[outList.length-1].maxspeed=parseInt(Math.random()*10);
		outList[outList.length-1].minspeed=parseInt(Math.random()*10);
		outList[outList.length-1].averagespeed=parseInt(Math.random()*10);
		c--
		if(c==0){
			c=parseInt(Math.random()*10+5)
			pos=parseInt(Math.random()*7+1);
		}
		outList[outList.length-1].detectedposition=pos;
		
		//outValue[0].toFixed(2)
		trcomp='<tr><td>'+outList.length+'</td><td>'+idToMin(i)+'</td><td>'+cal+'</td><td>'+ste+'</td>';
		trcomp+='<td>'+dist+' m</td><td>'+tem+'</td><td>'+mov+'</td><td>'+dateListMin[i].sleepMode+'</td></tr>'
		$("#listTable tr:last-child").after(trcomp);	
	}
	$('#buildCal').text("Build calories: "+buildC.toFixed(2));
	
	
	$('#totalCal').text("Total calories: "+totalC.toFixed(2));
	$('#totalStep').text("Total steps: "+totalS);
	$('#totalDist').text("Total distance: "+totalD/1000+" km");
	
	$('#postList').button("enable");
}

function saveValueData(){
	rid=currentValueRow
	for(i=0;i<5;i++){
		timeTable[rid].value[i].rfrom=parseInt($('#rfrom'+i).val());
		timeTable[rid].value[i].rto=parseInt($('#rto'+i).val());
		timeTable[rid].value[i].lto=parseInt($('#lto'+i).val());
	}
	$('#rfrom2').val(($('#rfrom1').val()*back_sw/1000).toFixed(3))
	$('#rto2').val(($('#rto1').val()*back_sw/1000).toFixed(3))
	$('#lto2').val(($('#lto1').val()*back_sw/1000).toFixed(3))
	
	timeTable[rid].value[2].rfrom=timeTable[rid].value[1].rfrom*back_sw/1000
	timeTable[rid].value[2].rto=timeTable[rid].value[1].rto*back_sw/1000
	timeTable[rid].value[2].lto=timeTable[rid].value[1].lto*back_sw/1000
	
	
}
function getRandRange(m,n){
	m=parseFloat(m)
	n=parseFloat(n)
	return Math.abs(Math.random()*(n-m)+m)
}
function getRand(m){
	m=parseFloat(m)
	if(m==0){
		return Math.floor(Math.random()*2)
		
	}else{
		return Math.floor(((Math.random()-0.5)/3+1)*m)
	}
}
function randBuildValue(){

	rid=currentValueRow
	/*
	timeTable.push({id:i,value:[
		{rmode:0,rfrom:0,rto:0,lmode:0,lfrom:0,lto:0},
		{rmode:0,rfrom:0,rto:0,lmode:0,lfrom:0,lto:0},
		{rmode:0,rfrom:0,rto:0,lmode:0,lfrom:0,lto:0},
		{rmode:0,rfrom:0,rto:0,lmode:0,lfrom:0,lto:0},
		{rmode:0,rfrom:0,rto:0,lmode:0,lfrom:0,lto:0}
	]});
	*/
	//cal 2~20
	//temp 18~24
	//step 0~60
	//Dist 0~120
	//Move 0~20
	var basebmr=Math.floor(back_bmr/2.88)/100
	var randomRange=[{from:basebmr,to:10+basebmr,line:20},{from:30,to:60,line:0},{from:0,to:10,line:0},{from:0,to:2,line:20},{from:0,to:25,line:10}];
	if(currentValueRow==0){
		 randomRange=[{from:basebmr,to:5+basebmr,line:2},{from:0,to:0,line:0},{from:0,to:0,line:0},{from:0,to:2,line:20},{from:0,to:25,line:10}];
	}
	if($('#toHour'+currentValueRow).val()>21){
		randomRange=[{from:basebmr,to:5+basebmr,line:2},{from:0,to:0,line:0},{from:0,to:0,line:0},{from:0,to:2,line:20},{from:0,to:25,line:0}];
	}
	
	for(i=0;i<5;i++){
		if(i==2){
			timeTable[rid].value[i].rfrom=(timeTable[rid].value[i-1].rfrom*back_sw/1000).toFixed(3)
			timeTable[rid].value[i].rto=(timeTable[rid].value[i-1].rto*back_sw/1000).toFixed(3)
			timeTable[rid].value[i].lto=(timeTable[rid].value[i-1].lto*back_sw/1000).toFixed(3)
		}else{
			timeTable[rid].value[i].rfrom=getRand(randomRange[i].from)
			timeTable[rid].value[i].rto=getRand(randomRange[i].to)
			timeTable[rid].value[i].lto=getRand(randomRange[i].line)
		}
		$('#rfrom'+i).val(timeTable[rid].value[i].rfrom);
		$('#rto'+i).val(timeTable[rid].value[i].rto);
		$('#lto'+i).val(timeTable[rid].value[i].lto);
	}

}
function zeroData(){
	
	for(var rid=0;rid<timeTable.length;rid++){
		for(i=0;i<5;i++){
			timeTable[rid].value[i].rfrom=0
			timeTable[rid].value[i].rto=0
			timeTable[rid].value[i].lto=0
			$('#rfrom'+i).val(0);
			$('#rto'+i).val(0);
			$('#lto'+i).val(0);
		}
	}
	
}
function cleanData(){
	timeTable=[];
	$('#mainTimeTable div').each(function(){$(this).remove();});	
	
	$('#parts').spinner("option","max",24);
	$('#parts').spinner("option","min",1);
	$('#parts').spinner("value",4);
	showPercent(-1)
	$('#valuelist').hide();
	$('#buildAllData').hide();
	$('#listAllData').hide();

	$('#autoBuild').button("enable");
	$('#parts').spinner("enable");	
	$('#listAllData').hide();
	$('#addnew').button("enable");	
}
function addNewTimeData(obj){
	var cmode=' checked';
	var newTableID=timeTable.length
	if(newTableID==0){
		fromValue=0
		toValue=0
	}else{
		fromValue=timeTable[newTableID-1].to+1
		toValue=fromValue
	}
	if(obj.to>20){cmode='';}
	if(obj.from<8){cmode='';}
	if(fromValue==24){return}
	if(obj.mode==1){
		fromValue=obj.from
		toValue=obj.to
	}
	//$('.inputSort').spinner({ disabled: true });
	var tableStr='<div id="row'+newTableID+'"><table ><tr><td width=45 alig=center>';
	tableStr+='<button id="selectRow'+newTableID+'">select</button></td>';
	tableStr+='<td width=100></td><td width=50 class="G_contentBlack rightAlign">From:</td><td width=50>';
	tableStr+='<input name="fromHour'+newTableID+'" id="fromHour'+newTableID+'" value='+fromValue+' size="5" maxlength="2" class="inputSort" /></td>';
	tableStr+='<td width=30 class="G_contentBlack rightAlign">to:</td><td width=50>';
	tableStr+='<input name="toHour'+newTableID+'" id="toHour'+newTableID+'" value='+toValue+' size="5" maxlength="2" class="inputSort" /></td>';
	tableStr+='<td width=30><td><input type="checkbox" class="awakeCheck" id="awake'+newTableID+'" name="awakeMode" '+cmode+'/"><label for="awake'+newTableID+'">Awake</label></td>';
	
	tableStr+='<td width=30></td><td width=60><button id="delRow'+newTableID+'">delete</button></td></tr></table></div>';
	$(tableStr).appendTo($('#mainTimeTable'));	
	timeTable.push({id:newTableID,from:fromValue,to:toValue,sleepMode:1,
		value:[{rfrom:0,rto:0,lto:0},{rfrom:0,rto:0,lto:0},
		{rfrom:0,rto:0,lto:0},{rfrom:0,rto:0,lto:0},{rfrom:0,rto:0,lto:0}
	]});
	
	$('#selectRow'+newTableID).button({icons:{primary:"ui-icon-info"}});
	$('#selectRow'+newTableID).attr("value",newTableID);
	$('#selectRow'+newTableID).click(function() {showInfo($(this).attr("value"))});
	//$('#awake'+newTableID).button();
	//------删除按钮处理------------------
	$('#delRow'+newTableID).attr("value",newTableID);
	$('#delRow'+newTableID).bind({
		click:function(event){
			removeRow(parseInt($(this).attr("value")));
		}
	});	
	
	initType();
	
	$(".inputSort" ).spinner({
		change: function( event, ui ) {
			//--------change relev value----------
			changeValue($(this).attr("id"),$(this).spinner("value"))
			
		}
	});
	showPercent(toValue)
	$('#valuelist').show();
	$('#buildAllData').show();
	
	currentValueRow=newTableID
	randBuildValue();
	$("#mainTimeTable div").each(function(){$(this).removeClass("selectedItem");})
	$("#row"+currentValueRow).addClass("selectedItem");
}
function removeRow(rid){
	$('#row'+rid).remove()
	timeTable.pop();
	if(rid==0){
		$('#listAllData').hide();
		$('#autoBuild').button("enable");
		$('#parts').spinner("enable");
		return
	}
	rid--
	//-----显示最后一行的数据
	showInfo(rid)
	//-----激活最后一行的状态
	//alert($('#delRow'+rid).attr("id")+" "+rid);
	//$('#fromHour'+rid).spinner("option","enabled",true);
	//$('#toHour'+rid).spinner("option","enabled",true);
	$('#fromHour'+rid).spinner("enable");
	$('#toHour'+rid).spinner("enable");
	$('#delRow'+rid).button("enable");
	$('.awakeCheck')[rid].disabled=false
	//------调整parts的值
	changeRestValue();
	
}
function showInfo(rid){
	currentValueRow=rid
	for(i=0;i<5;i++){
		$('#rfrom'+i).val(timeTable[rid].value[i].rfrom);
		$('#rto'+i).val(timeTable[rid].value[i].rto);
		$('#lto'+i).val(timeTable[rid].value[i].lto);
	}
	$("#mainTimeTable div").each(function(){$(this).removeClass("selectedItem");})
	
	for(i=0;i<timeTable.length;i++){
		if(i!=currentValueRow){
			$('#awake'+i).attr('disabled', 'disabled');
		}else{
			$('#awake'+i).removeAttr('disabled');
		}
	}
	$("#row"+currentValueRow).addClass("selectedItem");
}

function showPercent(value){
	var percent=Math.ceil(100*(value+1)/24)
	$("#processbar" ).progressbar( "option", "value", percent );
	$('#processLabel').text(percent+"%");
}

function changeRestValue(){
	var newTableID=timeTable.length	
	var fromObj=$('#fromHour'+(newTableID-1))
	var toObj=$('#toHour'+(newTableID-1))
	var toValue=parseInt(toObj.spinner("value"))
	var partObj=$('#parts')
	partObj.spinner("option","max",23-toValue);
	
	showPercent(toValue)
	if(toValue==23){
		
		//$('#autoBuild').button("option","disabled", true);
		partObj.spinner("option","disabled", true);
		partObj.spinner("option","min",0);
		partObj.spinner("option","max",0);
		$('#addnew').button("option","disabled", true);
	}else{
		$('#autoBuild').button("enable");
		partObj.spinner("enable");
		partObj.spinner("option","min",1);
		partObj.spinner("option","value",1+Math.ceil(parseInt((23-toValue)/3)))
		$('#addnew').button("enable");
	}
}
function changeValue(id,value){
	var rid,cmode
	
	if(id.substring(0,2)=="fr"){
		rid=parseInt(id.substring(8,id.length))
		cmode="from"
	}else{
		rid=parseInt(id.substring(6,id.length))
		cmode="to"
	}
	var fObj=$('#fromHour'+rid)
	var tObj=$('#toHour'+rid)
	currentFrom=parseInt(fObj.spinner("value"));
	currentTo=parseInt(tObj.spinner("value"))
	if(cmode=="from"){
		if(currentTo<currentFrom){
			currentTo=currentFrom
		}
		tObj.spinner("option","min",currentFrom);
	}else{
		changeRestValue()
	}
	
	timeTable[rid].from=currentFrom
	timeTable[rid].to=currentTo
}
function initType(){
	
	//$('button').button();
	var newTableID=timeTable.length
	//-----------先判断是否是第一个，如果是，则左边的min为0，max为23，右边的min为0，max为23
	
	var fromObj=$('#fromHour'+(newTableID-1))
	var toObj=$('#toHour'+(newTableID-1))
	var delObj=$('#delRow'+(newTableID-1))
	fromObj.spinner();
	toObj.spinner();
	delObj.button();
	if(newTableID==1){
		fromObj.spinner("option","min",0);
		fromObj.spinner("option","max",23);
		toObj.spinner("option","min",0);
		toObj.spinner("option","max",23);
		return
	}
	
	var lastFromObj=$('#fromHour'+(newTableID-2))
	var lastToObj=$('#toHour'+(newTableID-2))
	var lastDelObj=$('#delRow'+(newTableID-2))
	$('.awakeCheck')[newTableID-2].disabled=true
	
	lastFromObj.spinner({ disabled: true });
	lastToObj.spinner({ disabled: true });
	lastDelObj.button( "option", "disabled", true );
	var lastToValue=lastToObj.spinner("value")
	//------------否则两边的from和to的min都是上一个的值
	fromObj.spinner("option","min",lastToValue+1);
	fromObj.spinner("option","max",23);
	toObj.spinner("option","min",lastToValue+1);
	toObj.spinner("option","max",23);
	
	
	
}
function autoBuild(n){
	if(timeTable.length==0){
		fromHour=0
		leftHour=24
	}else{
		fromHour=timeTable[timeTable.length-1].to+1
		leftHour=24-fromHour
	}
	var itemList=[];
	for(var i=0;i<n;i++){
		itemList.push(1)
	}
	for(i=n;i<leftHour;i++){
		var k=Math.floor(Math.random()*n)
		itemList[k]++
	}
	var from=fromHour
	var to=fromHour
	var total=fromHour
	for(i=0;i<itemList.length;i++){
		from=total
		to=total+itemList[i]-1
		total+=itemList[i]
		addNewTimeData({mode:1,from:from,to:to});
	}
	changeRestValue();
}
		