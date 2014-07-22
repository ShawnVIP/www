var pageID=2; // userpage
var maxIndex=100;
document.write("<script type='text/javascript' src='js/reglogin.js'></"+"script>"); 
	var pageName="mysenseu";
	var activityColor=new Array("#66bd00","#bfbfbf","#ffa200");
	var sleepColor=new Array("#00c0ff","#bfbfbf","#ffa200");
	var DaysInEachMonth=new Array(31,31,28,31,30,31,30,31,31,30,31,30,31);
	var monthNameList=new Array("","Janeary","Feberay","March","April","May","June","July","August","September","October","Novenber","December");
	var monthNameSortList=new Array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	var calTaken,caloriesGoal;
	var stepsTaken,stepGoal;
	var disTaken,disGoal;
	var slpTaken,slpGoal;
	var footPerStep;
	var deepSleep,totalSleep;
	var currentDate=new Date();
	var nowStr=currentDate.getFullYear()+"-"+(currentDate.getMonth()+1)+"-"+currentDate.getDate();
	var oldMonth=0;
	var allDataList=new Array();
	var nowDate=new Date();
	var nowDateStr=nowDate.getFullYear()+"-"+(nowDate.getMonth()+1)+"-"+nowDate.getDate()
	
	/*
	var back_sname=$.cookie('back_sname');
	
	var back_country=$.cookie('back_country');
	var back_city=$.cookie('back_city');
	var back_citycode=$.cookie('back_citycode');
	var back_head=$.cookie('back_head');
	var back_age=$.cookie('back_age');
	var back_sex=$.cookie('back_sex');
	
	*/
	//var back_ucode=$.cookie('back_ucode');
	

	//var tempEmail=$.cookie('tempEmail');
	//----------------------summary list-------------
	var sumSelectID=1

	var sumNameBar=new Array()
	sumNameBar[1]=["Calories","ACT_cal","ACT_calValue"]
	sumNameBar[2]=["Steps Taken","ACT_steps","ACT_stepsValue"]
	sumNameBar[3]=["Miles Travel","ACT_miles","ACT_milesValue"]
	//---------------------warning list-----------------
	var warnList=new Array()
	warnList.push({name:"war_act",value:0})
	warnList.push({name:"war_act",value:0})
	warnList.push({name:"war_act",value:0})
	warnList.push({name:"war_act",value:0})

	var back_ucode=$.cookie('back_ucode');
	var back_scode=$.cookie('back_scode');
	var back_sname=$.cookie('back_sname');
	var back_loginMode=$.cookie('back_loginMode');
	var dateStr;
	var sleepBarWidth,adjustSleepWidth,sleepBeginTimeValue; //--sleep条宽度以及左边调整位置----
	var tmpDataList=new Array();
	var activietDataList=new Array();
	var sleepDataList=new Array();
	var calTakenMax
	var sleepMoveMax,sleepFromTimeID,sleepToTimeID;
	//--------------------加入顺序执行命令流
	var orderList=new Array();
	orderList.push("getUserInfomation()");
	orderList.push("getWarning()");
	orderList.push("changeDatebyNum(0)");
//------mode为1：HHMM格式时间抓换为 HH|MM|am/pm 格式，mode为2则总分钟数转换------------
	var bigCal,sumAct,mStep,mMile,sumSlp,bigSlp //-----------状态条
	var sensorList=new Array(); 
	var currentSensorID=0
	function conver24to12(timeString,mode){
		var nh,nm
		if(mode==0){
			nh=Number(timeString.substring(0,2))
			
			nm=timeString.substring(2,4)
		}
		if(mode==1){
			if(timeString>1440){timeString-=1440;};
			nh=Math.floor(timeString/60)
			nm=(100+timeString-nh*60)+'';
			nm=nm.substring(1,3)
		}
		var timeStr="am";
		if(nh >= 12){
			timeStr="pm"
		}
		if(nh==0){
			nh=12;timeStr="am"
		}
		if(nh>12){
			nh-=12;timeStr="pm"
		}
		//alert(nh+"|"+nm+"|"+timeStr);
		return nh+"|"+nm+"|"+timeStr;
	}
	function getPercent(cv,tv){
		
		if(cv<=tv){
			return Math.floor(100*cv/tv)
		}else{
			return 100;
		}
	}
	function countIDFromDataStr(basetime,nowtime){
		//---------------根据时间计算出从属ID---------
		//-----------采用除以5后向下取整-------------
		var fh,fm,th,tm
		if(basetime=""){
			fromid=0
		}else{
			fh=Number(basetime.substring(0,2))
			fm=Number(basetime.substring(2,4))
			fromid=Math.floor((fh*60+fm)/5)
		}
		th=Number(nowtime.substring(0,2))
		tm=Number(nowtime.substring(2,4))
		toid=Math.floor((th*60+tm)/5)
		return toid-fromid;
	}
	
	
	function formatTime(datenum){
		var s_hour=parseInt(datenum/60);
		var s_min=datenum-s_hour*60;
		if(s_min>=10){
			return s_hour+"<span>h</span>"+s_min+"<span>min</span>";
		}else{
			return s_hour+"<span>h</span>0"+s_min+"<span>min</span>";
		}
	}
	function setupStationBar(barName,currentValue,totalValue){
		
		
		var tw=$('#'+barName).width();
		var rate=Math.floor(100*currentValue/totalValue);
		dvalue=totalValue-currentValue;
		if(dvalue<=0){rate=100;dvalue=0;}
		//$('#'+barName+"Percent").html(rate+"%");
		//--------在状态栏上显示变量值
		switch(barName){
			case "MS_activity":
			
			$('#'+barName+"Value").html(currentValue+"<span>cal</span>");
			break;
			case "MS_sleep":
			$('#'+barName+"Value").html(formatTime(currentValue));
			break;	
			case "ACT_cal":
			$('#'+barName+"Value").html(currentValue+" <span>cal burbed</span>");
			$('#'+barName+"Mark").html(dvalue+" <span>cal remain</span>");			
			break;	
			case "ACT_steps":
			$('#'+barName+"Value").html(currentValue+"<span>of "+totalValue+"</span>");
			break;	
			case "ACT_miles":
			$('#'+barName+"Value").html(currentValue+"<span>miles of "+totalValue+" miles</span>");
			break;	
			case "SLP_sleep":
			$('#'+barName+"Value").html(formatTime(currentValue));
			$('#'+barName+"Mark").html(formatTime(totalValue));			
			break;
							
		}
		//$('#'+barName+"Bar").animate({width:tw*rate/100},1000);
	}

	function getWeather(){
		$.get('http://weather.yahooapis.com/forecastrss?w='+back_citycode+'&u=c',
		function(d){
			var tempstr,imgsrc
			
			$(d).find('yweather\\:condition').each(function(i){
				tempstr=$(this).attr('temp');
				//imgcode=$(this).attr('code');
			});
			
			$(d).find('description').each(function(i){
				var tempStr=($(d).text()).split(String.fromCharCode(34))
				for(var i=0;i<tempStr.length;i++){
					//alert(tempStr[i])
					if(tempStr[i].indexOf('yimg')>-1 && tempStr[i].indexOf('http')==0 ){
						imgsrc=tempStr[i];
						
					}
				}
			});
			$('#weather_pic').attr('src',imgsrc);
			$('#weather_temp').html(tempstr+' &ordm;C');
		});
	}
	function changeDate(y,m,d){
		$("#INFO_upperDate").html(monthNameSortList[m]+".<span>"+d+"</span>");
		$('#Frame_calendar').hide();
		currentDate=new Date(y,m-1,d)
		setupAllValue();
	}
	function changeDatebyNum(num){
		
		//alert(currentDate);
		
		currentDate.setTime(currentDate.getTime()+num*24*3600*1000);
		dateStr=currentDate.getFullYear()+"-"+(currentDate.getMonth()+1)+"-"+currentDate.getDate()
		/*
		if(dateStr==nowDateStr){
			$('#INFO_arrowR').hide();
		}else{
			$('#INFO_arrowR').show();
		}
		*/
		//alert("--"+dateStr+"---"+minDateStr+"--");
		
		//setupAllValue();
		
	}
	function setupAllValue(){
		//-------设定当前日期并显示日期---------------
		
		dateStr=currentDate.getFullYear()+"-"+(currentDate.getMonth()+1)+"-"+currentDate.getDate()

		/*
		if(dateStr==nowStr){
			var hh=currentDate.getHours()<10?"0"+currentDate.getHours():currentDate.getHours();   
         	var mm=currentDate.getMinutes()<10?"0"+currentDate.getMinutes():currentDate.getMinutes();   
         	var ss=currentDate.getSeconds()<10?"0"+currentDate.getSeconds():currentDate.getSeconds();    
			dateStr+="T"+hh+":"+mm+":"+ss;
		}else{
			dateStr+="T23:59:59"
		}
		*/
		//alert(dateStr)
		var dt=currentDate.toString();
		var tstr=dt.split(" ")
		$('#INFO_upperDate').html(tstr[2]+"<br><span>"+tstr[1]+'</span>');
		
		orderList.push("loadActData()");
		orderList.push("loadSleepData()");
		//orderList.push("loadTmpData()");
		loadNextServerProcess();
		
		//---------加入提醒状态
		
	}
	function addWarning(r){
		var dataList=r.info;
		$('#INFO_warGroup div').each(function(){$(this).remove()});	
		$('#INFO_numGroup div').each(function(){$(this).remove()});	

		for(i=0;i<dataList.length;i++){
			var obj=dataList[i]
			
			childDiv=$('<div class="INFO_warIcon" id="INFO_war'+i+'"><img src="images/'+warnList[obj.catalog].name+'.png" /></div>');
			childDiv.appendTo($('#INFO_warGroup'));
			childDiv.attr("titles",obj.title);
			childDiv.attr("detail",obj.detail);
			childDiv.bind("mouseenter",{id:i},showWarningBack);
			childDiv.bind("mouseleave",{id:i},hideWarningBack);
			//childDiv=$('<div class="INFO_warNum" id="INFO_num'+i+'">'+warnList[i].value+'</div>');
			//childDiv.appendTo($('#INFO_numGroup'));
		}
		
	}
			
	function getWarning(){
		$.getJSON("res/getwarning.php",{ucode:back_ucode,scode:back_scode,dates:dateStr},
			function(r){
				addWarning(r);
				loadNextServerProcess();
			}
		);	
		
	}
	function loadActData(){
		$('#ACT_data').css("opacity",0.2);
		$('#ACT_time').css("opacity",0.2);
		showLoading('ACT')
		//var jstr="http://184.72.40.64/api/index.php/userdata/activity/"+back_ucode+"/date/"+dateStr
		//var jstr="res/getdata.php?&userid="+back_ucode+"&getdate="+dateStr
		$.getJSON("res/getdata.php",{type:"act",ucode:back_ucode,scode:back_scode,dates:dateStr},
			function(r){
				dealActivityData(r);
				loadNextServerProcess();
			}
		);	
	}

	function dealActivityData(r){
		hideLoading('ACT');
		//var data=eval('(' + r + ')');  
		
		var dataList=r.data;
		
		if(dataList.length==0){return}
		calTaken=Number(r.calTaken);
		stepsTaken=Number(r.stepsTaken);
		disTaken=Number(r.disTaken);
		
		caloriesGoal=Number(r.caloriesGoal);
		disGoal=Number(r.disGoal);
		stepGoal=Number(r.stepGoal);
		
		footPerStep=Number(r.footPerStep);
		calTaken=Number(r.calTaken);
		calTakenMax=0
		var slist=""
		for(var i=0;i<dataList.length;i++){
			var subData=dataList[i].split("|")
			//allDataList.push({id:countIDFromDataStr("",subData[0]),temp:subData[1],cal:subData[2],step:subData[3],dis:subData[4],move:subData[5],wakeup:subData[6],actmode:subData[7],sleepmode:subData[8],tempmode:subData[9]})
			//if(subData[5]==1){
				activietDataList.push( subData[0] +"|" + subData[2] + "|" + subData[6]);
				if(Number(subData[2])>calTakenMax){calTakenMax=Number(subData[2])}
				//slist+=subData[0]+"max:"+calTakenMax+"val:"+subData[2]+"\n"
			//}
			tmpDataList.push( subData[0] +"|" + subData[1] + "|" + subData[7]);	
		}
		//alert(slist)
		var act=new chartArea();
		act.belongs="ACT";
		act.data=activietDataList;
		act.color=["#66bd00","#bfbfbf","#ffa200"];
		act.itemMainType='bar'
		act.itemLineType=''
		act.init();
		

		aniSetup();


		var tmp=new chartArea();
		tmp.belongs="TMP";
		tmp.data=tmpDataList;
		tmp.color=["#66bd00","#ffa200","#bfbfbf"];
		tmp.itemMainType='dot'
		tmp.itemLineType=''
		tmp.init();
		//aniSetup()
		
		
	}
	function aniSetup(){

		bigCal.p={belongs:"l_proBarCal",smode:"l",leftIcon:"",currentValue:calTaken,totalValue:caloriesGoal};
		bigCal.init();
		sumAct.p={belongs:"s_proBarAct",smode:"s",leftIcon:"images/icon_activity.png",currentValue:calTaken,totalValue:caloriesGoal};
		sumAct.init();
		mStep.p={belongs:"m_proStep",smode:"m",leftIcon:"",currentValue:stepsTaken,totalValue:stepGoal};
		mStep.init();
		mMile.p={belongs:"m_proMile",smode:"m",leftIcon:"",currentValue:disTaken,totalValue:disGoal};
		mMile.init();
		adjustBarPosition();
	}

	function loadSleepData(){
		$('#SLP_data').css("opacity",0.2);
		$('#SLP_time').css("opacity",0.2);
		showLoading('SLP')
		//var jstr="http://184.72.40.64/api/index.php/userdata/sleep/"+back_ucode+"/date/"+dateStr
		//var jstr="res/getdata.php?type=sleep&userid="+back_ucode+"&getdate="+dateStr
		$.getJSON("res/getdata.php",{type:"sleep",ucode:back_ucode,scode:back_scode,dates:dateStr},
			function(r){
				dealSleepData(r);
				loadNextServerProcess();
			}
		);			
	}

	function dealSleepData(r){
		
		hideLoading('SLP')
		var dataList=r.data;
		if(dataList.length==0){return;}
		var fromTime=dataList[0].substring(0,4)
		var toTime=dataList[dataList.length-1].substring(0,4)
		sleepFromTimeID=countIDFromDataStr('',fromTime)
		sleepFromTimeID=Math.floor(sleepFromTimeID/12-1)*12
		sleepToTimeID=countIDFromDataStr('',toTime)
		sleepToTimeID=Math.ceil(sleepToTimeID/12+1)*12
		
		slpTaken=0;
		deepSleep=0;
		sleepMoveMax=0
		var addDay=0
		//-------判断sleep的第二个数据项，0表示睡眠中，1表示深度睡眠，2表示浅睡眠sleep:1：蓝色，2：灰色
		for(var i=0;i<dataList.length;i++){
			var subData=dataList[i].split("|")
			if(subData[2]>0){
				slpTaken+=5;
				if(subData[2]==1){deepSleep+=5;}
			}
			
		}
		var slp=new chartArea();
		slp.belongs="SLP";
		slp.data=dataList;
		//slp.fromTimeId=sleepFromTimeID;
		//slp.toTimeId=sleepToTimeID;
		slp.color=["","#00c4ff","#bfbfbf","#00c4ff"];
		slp.itemMainType='bar'
		slp.itemLineType=''
		slp.init();
				
		
		sumSlp.p={belongs:"s_proBarSlp",smode:"s",leftIcon:"images/icon_sleep.png",currentValue:slpTaken,totalValue:slpGoal};
		sumSlp.init();

		bigSlp.p={belongs:"l_proBarSlp",smode:"l",leftIcon:"",currentValue:slpTaken,totalValue:slpGoal};
		bigSlp.init();
	
		var eStr=(conver24to12(fromTime,0)).split('|');
		$('#SLP_wentBed').html('Went to bed at<br /><span>'+eStr[0]+':'+eStr[1]+'<span>'+eStr[2]+'</span></span>');
		eStr=(conver24to12(toTime,0)).split('|');
		$('#SLP_wakeUp').html('Wake up at<br /><span>'+eStr[0]+':'+eStr[1]+'<span>'+eStr[2]+'</span></span>');
		$('#SLP_wholeSleep').html('Whole sleep time<br /><span>'+formatTime(slpTaken)+'</span>');
		$('#SLP_deepSleep').html('Deep sleep time<br /><span>'+formatTime(deepSleep)+'</span>');
		$('#SLP_wakeUpTime').html('Wake up time<br /><span>2 <span>times</span></span>');
		
		//alert("bar pos:"+ $('#l_proBarSlp').css("top")+" height:"+$('#l_proBarSlp').height()+ " left top:"+ $('#l_proBarSlpLeft').css("top")+ " left height:"+ $('#l_proBarSlpLeftTop').height()+ " right top:"+ $('#l_proBarSlpRight').css("top"));

		adjustBarPosition();
		//switchTap(0);
		

		//---------------change activity-------		
		
	}
	
	function hideLoading(objname){
		
		$('#'+objname+'_loading').hide();
	}
	function showLoading(objname){
		$('#'+objname+'_loading').show();
	}
			
	function getUserInfomation(){
		//dealUserData()
		
		$.get('res/getinfo.php?ucode='+back_ucode+'&scode='+back_scode,
		//$.get('http://184.72.40.64/api/index.php/users/'+back_ucode,

			function(r){
				
				dealUserData(r);
				
				loadNextServerProcess();
			}
		);
		
	}	
	function dealUserData(r){
		
		var data=eval('(' + r + ')');  
		sensorList=data.sensorList
		currentSensorID=0
		showSensor();
		loadNextServerProcess();
		
	}
function showSensor(){
	var obj=sensorList[currentSensorID]
	$('#INFO_name').html(obj.nickname);
	$("#INFO_head img").attr("src","upload/"+obj.headimage); 	
	var power="0000"+obj.power;

	power=power.substring(power.length-4,power.length)
	$("#INFO_sensorIcon img").attr("src","images/sensor"+power+".png"); 	
	$('#INFO_sensorStation').html('Connected<br /><span>battery:</span>'+obj.power+'%')
	

	if(obj.unit=="Metric"){
		$.cookie('back_unit',"Km")
	}else{
		$.cookie('back_unit',"Mile")
	}
	slpGoal=obj.sleepgoal

}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

	
		function sumSetDefault(){
		for(i=1;i<4;i++){
			if (i==sumSelectID){
				$('#sumSelect'+sumSelectID).addClass("ACT_itemSelected");
				$('#sumSelect'+sumSelectID).html(sumNameBar[sumSelectID][0]+'<span><img src="images/selected.png" /></span>');
			}else{
				$('#sumSelect'+i).removeClass("ACT_itemSelected");
				$('#sumSelect'+i).html(sumNameBar[i][0]);
			}
		}
		
	}
	function coverSumID(event){
		if(sumSelectID!=event.data.id){
			$('#sumSelect'+event.data.id).addClass("ACT_itemSelected");
		}
		
	}
	function outSumID(event){
		if(sumSelectID!=event.data.id){
			$('#sumSelect'+event.data.id).removeClass("ACT_itemSelected");
		}
	}
	function changeSex(event){
		sexID=event.data.id
		$("#INFO_sex"+sexID).attr('src',"images/se_yes.png");
		$("#INFO_sex"+(1-sexID)).attr('src',"images/se_no.png");
	}
	function changeSumID(event){
		
		sumSelectID=event.data.id;
		sumSetDefault();
		//--------------设置动画
		//sumNameBar[1]="ACT_cal"
		//alert($("#ACT_cal").progressbar("value"))
		tarValue=$("#"+sumNameBar[sumSelectID][1]).progressbar("value")
		curValue=$("#MS_activity").progressbar("value")
		var sum_INT=window.setInterval(function(){ 
		if(tarValue != curValue){
			curValue+=(tarValue-curValue)/5
			curValue<tarValue ? curValue=Math.ceil(curValue):curValue=Math.floor(curValue)
			$("#MS_activity").progressbar({value:curValue});
			$('#MS_activityPercent').html(curValue+"%");
		}else{ 
			$("#MS_activity").progressbar({value:tarValue});
			$('#MS_activityPercent').html(tarValue+"%");
			window.clearInterval(sum_INT);
		};}, 10);
		$('#ACT_select').fadeOut();
		$('#MS_activityValue').html($('#'+sumNameBar[sumSelectID][2]).html());
	}
	function showProfileSetup(){
		
		//$('body').css("overflow","hidden")
		//resizeArea();
		$('#lightBack').fadeIn(50)
		$('#Frame_profileSetup').fadeIn()
		$("#IFRAME_profile").attr("src","profile.php?userid="+back_ucode);
	}


	function showActivitySetup(){
		
	}
	function showWarningBack(event){
		
		$('#INFO_popup').css("left",336+event.data.id*55);
		$('#INFO_title').html($('#INFO_war'+event.data.id).attr("titles"))
		$('#INFO_detail').html($('#INFO_war'+event.data.id).attr("detail"))

		$('#INFO_popup').fadeIn(20);
	}
	function hideWarningBack(event){
		
		$('#INFO_popup').hide();
	}

	function closeGoalSetup(){
		$('#lightBack').fadeOut()
		$('#Frame_goalSetup').fadeOut()
	}
	function closeProfileSetup(){

		$('#lightBack').fadeOut()
		$('#Frame_profileSetup').fadeOut()
		getUserInfomation();
	}

	function loadNextServerProcess(){
		if(orderList.length>0){
			eval(orderList.shift());
		}
	}
	
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
	$("#timezone").attr("value",convert(std_time_offset)+","+dst);
	$("#PRO_timeZone").attr("value",$("#timezone").find("option:selected").text())
	
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
	
$(function(){
	//if($.browser.msie){$.fx.off=true}
		if($.cookie('back_loginMode')==null){
			parent.location="index.php"
		}
		$('#INFO_btnComplete').button({
			icons: {primary: 'ui-icon-mail-closed' }
		});
		$('#INFO_btnAdd').button({
			icons: {primary: 'ui-icon-plusthick' }
		});
		
		$('#Frame_addMore').button();
		//http://ajax.open-open.com/ProgressBar.htm 修改进度条颜色

		$('#icon_logout').bind({
			click:function(event){self.location='index.php?mode=1';}
		});	
		//--------改变日期----------------
		$('#INFO_upperDate').bind({
			
			click:function(event){
				/*
				if(oldMonth!=currentDate.getMonth()+1){
					$("#IFRAME_calc").attr("src","calendar.php?defdate="+dateStr+"&mindate="+minDateStr+"&maxdate="+nowDateStr);
					oldMonth=currentDate.getMonth()+1
				}
				$('#Frame_calendar').toggle();
				*/
				
				if(oldMonth!=currentDate.getMonth()+1){
					$("#IFRAME_calc").attr("src","calendar.html?year="+currentDate.getFullYear()+"&month="+(currentDate.getMonth()+1)+"&day="+currentDate.getDate());
					oldMonth=currentDate.getMonth()+1
				}else{
					
					$("#IFRAME_calc")[0].contentWindow.setupNewDay(currentDate.getDate());
				}
				$('#Frame_calendar').toggle();
			
			}
		});	
		$('#INFO_arrowL').bind({
			click:function(event){changeDatebyNum(-1);setupAllValue();$('#Frame_calendar').hide();}
		});	
		
		$('#INFO_arrowR').bind({
			click:function(event){changeDatebyNum(1);setupAllValue();$('#Frame_calendar').hide();}
		});	
		var mybody=$("body");   
 		var  mywidth=mybody.width();     
		if(mywidth>940){     
 			var bianJu=(mywidth-940)/2;
			mybody.css("margin-left" ,bianJu);
			mybody.css("margin-right" ,bianJu);   
		} 
		//-----------------mouse over-----------------
		
		$('#MS_activity').bind("mouseenter",{left:$('#MS_activity').css("left"),top:$('#MS_activity').css("top"),catalog:"ACT"},showSetupBack);
		$('#MS_activity').bind("mouseleave",{},hideSetupBack);	
		$('#MS_activity').bind({
			click:function(event){hideAllPop();showActivitySetup();}
		});
		
		$('#btn_profile').bind({
			click:function(event){hideAllPop();showProfileSetup();}
		});

		
		//-------------卡路里mouse over

		$('#l_proBarCal').bind("mouseenter",{},showSetupBack);
		//$('#l_proBarCal').bind("mouseleave",{},hideSetupBack);	
		$('#l_proBarCal').bind({
			click:function(event){
				hideAllPop();
				showCalSetup();}
		});
		//--------summary  setup--------------
		
		for(i=1;i<4;i++){			
			$('#sumSelect'+i).bind("mouseenter",{id:i},coverSumID);
			$('#sumSelect'+i).bind("mouseleave",{id:i},outSumID);
			$('#sumSelect'+i).bind("click",{id:i},changeSumID);
		}
		
		$('#MS_activity').bind({
			click:function(event){$('#ACT_select').fadeIn();}
		});
		
		$('#Frame_userInfo').bind({
			mouseleave:function(event){$('#INFO_popup').hide();}
		});
		$('#ACT_select').bind({
			mouseleave:function(event){$('#ACT_select').fadeOut();}
		});
		$('#PRO_close').bind({
			click:function(event){closeProfileSetup();}
		});
		$('#GOA_close').bind({
			click:function(event){closeGoalSetup();}
		});
		
		
		bigCal=new barItem();
		sumAct=new barItem();
		mStep=new barItem();
		mMile=new barItem();
		sumSlp=new barItem();
		bigSlp=new barItem();
		
		sumSetDefault()
		
		setupAllValue();
		
		resizeArea();
		
		$(window).resize(function(){resizeArea();});
		$(window).scroll(function(){changePosition();});
		
		$('#Frame_main').show();
		

		$('#tabACT').bind({
			click:function(event){switchTap(0);}
		});
		$('#tabSLP').bind({
			click:function(event){switchTap(1);}
		});
		$('#tabFRI').bind({
			click:function(event){switchTap(2);}
		});
		adjustBarPosition();
		showFriendList(); 
		$("#Frame_addMore").width(1000)
		//get sensor list

		showCalSetup();
		
});
	

function showFriendList(){
	//$('#FRI_list').each(function(){$(this).remove()});
	for(var i=1;i<7;i++){
		
		$('<div class="FriItem G_unselect" id="friItem'+i+'"></div>').appendTo($('#FRI_list'));
		var obja=new friendItem()
		obja.itemID=i
		obja.picURL="head/np"+i+".jpg"
		obja.pname="TEST"+i
		obja.perAct=Math.floor(Math.random()*100)
		obja.perSlp=Math.floor(Math.random()*100)
		obja.init()
		$('#btnMsg'+i).attr("itemID",i)
		$('#btnMsg'+i).attr("act","message")
		$('#btnDel'+i).attr("itemID",i)
		$('#btnDel'+i).attr("act","delete")
		
	}
	$('.FriItem').mouseenter(function(){
		$(this).addClass("friOverItem")
		$(this).addClass("G_bigRoundShadowNoBorder")
		$('#btnContent'+$(this).attr("itemID")).show();
	})

	$('.FriItem').mouseleave(function(){
		$(this).removeClass("friOverItem");
		$(this).removeClass("G_bigRoundShadowNoBorder")
		$('#btnContent'+$(this).attr("itemID")).hide();
		
	});
	$('.downButton').click(function(){
		if($(this).attr("act")=="delete"){
			deleteFriItem($(this).attr("itemID"))
		};
	});
	$("#FRI_list").sortable({ cursor: "move" });
	$("#FRI_list").disableSelection();			
}
function deleteFriItem(itemID){
	$('#friItem'+itemID).remove();
	$("#FRI_list").sortable({ cursor: "move" });
}
function showFriendPer(type,id,percent,color){
	var obj=new smallBar()
	obj.belongs="fri"+type+"PerBar"+id
	obj.color=color
	obj.percent=percent
	obj.init()
	$('#fri'+type+'Per'+id).html(percent)
	$('#fri'+type+'Per'+id).css("color",color)
	$('#fri'+type+'PerMark'+id).css("color",color)
}

function showSetupBack(event){	
	$('#l_proBarCal').removeClass('G_smallShadow')
	$('#ACT_calPickBack').fadeIn(20)
}	
function hideSetupBack(event){
	$('#l_proBarCal').addClass('G_smallShadow')
	$('#ACT_calPickBack').hide();
}
function showCalSetup(){
	hideSetupBack();
	
	$('#lightBack').fadeIn(50)
	//$('#Frame_goalSetup').fadeIn()
	//$("#IFRAME_goalSetup").attr("src","calsetup.php?userid="+back_ucode);
	//alert("showsetup");
}
function hideAllPop(){
	$('#Frame_calendar').hide();	
}
var frameList= new Array('ACT','SLP','FRI');
	
function switchTap(fid){
	hideAllPop();
	for(var i=0;i<frameList.length;i++){
		if(i != fid){
			$('#tab'+frameList[i]).addClass('tapUnselect');
			$('#Frame_'+frameList[i]).hide();
		}else{
			$('#tab'+frameList[i]).removeClass('tapUnselect');
			if(i==0){
				$('#Frame_'+frameList[i]).removeClass('G_bigRoundShadow');	
				$('#Frame_'+frameList[i]).addClass('G_bigRoundShadowSpc');
			}else{
				$('#Frame_'+frameList[i]).addClass('G_bigRoundShadow');	
				$('#Frame_'+frameList[i]).removeClass('G_bigRoundShadowSpc');
			}
			$('#Frame_'+frameList[i]).show();
			adjustBarPosition()
		}
	}

}
function updateGoalInfo(cg,sg,dg){
	caloriesGoal=cg
	stepGoal=sg
	disGoal=dg
	aniSetup();
}


function smallBar(){
	
	this.belongs=""
	this.percent=0
	this.width=0;
	this.height=0;
	this.color="#FF9900";
	this.initMode=0
}
smallBar.prototype.init=function(){
	
	//------------删除所有子元素------------------------
	$('#'+this.belongs+" div").each(function(){$(this).remove()});
	this.width=$('#'+this.belongs).width();
	this.height=$('#'+this.belongs).height();
	//--------------添加底部颜色div区域-------------------------------------------
	$('<div id="'+this.belongs+'Back" class="G_smallRound"></div>').appendTo($('#'+this.belongs));
	$("#"+this.belongs+"Back").height(this.height);
	$("#"+this.belongs+"Back").css("background",this.color)

	$('#'+this.belongs+'Back').width(this.width*this.percent/100);
	
	
}

function friendItem(){
	this.belongs=""
	this.itemID=0
	this.picURL="";
	this.pname=""
	this.perAct=0
	this.perSlp=0
}
friendItem.prototype.init=function(){
	this.belongs="friItem"+this.itemID
	$('#'+this.belongs+" div").each(function(){$(this).remove()});
	var strs='<table cellpadding="0" cellspacing="0">';
	strs+='<tr><td width="116" rowspan="4" class="pictable" >';
	strs+='<div class="headback G_smallRound G_smallShadow" ><div class="headpic G_smallRound" id="friHead'+this.itemID+'"></div></div></td>';
	strs+='<td height=29 colspan="3" class="friName" id="friName'+this.itemID+'">'+this.pname+'</td></tr>';
	strs+='<tr><td width=125  class="friendItemAreaAct friTextPosition" ><span class="friItemNum " id="friActPer'+this.itemID+'"></span>';
	strs+='<span class="friItemPer" id="friActPerMark'+this.itemID+'">%</span></td><td width=1 class="friItemBot"></td>';
    strs+='<td width="125" class="friendItemAreaSlp friTextPosition"><span class="friItemNum " id="friSlpPer'+this.itemID+'"></span>';
	strs+='<span class="friItemPer" id="friSlpPerMark'+this.itemID+'">%</span></td></tr>';
    strs+='<tr><td height=23  ><div class="G_smallRound G_smallShadow friBar" id="friActPerBar'+this.itemID+'"></div></td>';
    strs+='<td width=1></td><td><div class="G_smallRound G_smallShadow friBar" id="friSlpPerBar'+this.itemID+'"></div></td></tr>';
    strs+='<tr><td height="5"  ></td><td width=1 ></td><td></td></tr><tr>';
    strs+='<td height="35" colspan="4"><table align="right" id="btnContent'+this.itemID+'" class="templetes">';
    strs+='<tr><td width="80"><img src="images/fri_mes.png" width="63" height="18" id="btnMsg'+this.itemID+'" class="downButton" /></td>';
    strs+='<td width="67"><img src="images/fri_del.png" width="63" height="18" id="btnDel'+this.itemID+'" class="downButton" /></td></tr></table></td></tr></table>';
	$(strs).appendTo($('#'+this.belongs));
	showFriendPer("Act",this.itemID,this.perAct,"#FF9900")
	showFriendPer("Slp",this.itemID,this.perSlp,"#00c0ff")
	//$('#friHead'+this.itemID).css("background","url(images/fri_undef.jpg)");
	$('#friHead'+this.itemID).css("background","url("+this.picURL+")");
	$('#friItem'+this.itemID).attr("itemID",this.itemID)
	
}

function barItem(){

	this.p={belongs:"",smode:"",leftIcon:"",currentValue:0,totalValue:0,backColor:""};
	
	this.leftTitle="";
	this.leftDown=""
	this.rightTitle="";
	this.rightDown=""
	this.percent=0
	this.currentPercent=0;
	this.intValue=0;
	this.width=0;
	this.height=0;
	this.units="";
	this.backPic=""
	this.frontPic=""
	this.initMode=0

}

barItem.prototype.init=function(){
	if(this.initMode ==0){
		this.intiMode=1
		//------------删除所有子元素------------------------
		$('#'+this.p.belongs+" div").each(function(){$(this).remove()});
		this.width=$('#'+this.p.belongs).width();
		this.height=$('#'+this.p.belongs).height();
		//--------------添加底部颜色div区域-------------------------------------------
		$('<div id="'+this.p.belongs+'Back" class="G_smallRound"></div>').appendTo($('#'+this.p.belongs));
		$("#"+this.p.belongs+"Back").height(this.height);
		
		//----------------添加左侧文字区----------
		if(this.p.smode=="s"){
			$('<div id="'+this.p.belongs+'LeftIcon" class="s_leftIcon"><img src="'+this.p.leftIcon+'"></div>').appendTo($('#'+this.p.belongs));
			$("#"+this.p.belongs+"LeftIcon").css("top",(this.height-40)/2);
		}
		$('<div id="'+this.p.belongs+'Left" class="'+this.p.smode+'_leftInfo"></div>').appendTo($('#'+this.p.belongs));
		////---------添加上部文字显示--------------------
		$('<div id="'+this.p.belongs+'LeftTop" class="'+this.p.smode+'_leftTop"></div>').appendTo($('#'+this.p.belongs+'Left'));
		$('<div id="'+this.p.belongs+'LeftDown" class="'+this.p.smode+'_leftDown"></div>').appendTo($('#'+this.p.belongs+'Left'));
		
		//------------right percent---------------------------------
		$('<div id="'+this.p.belongs+'Right" class="'+this.p.smode+'_rightInfo"></div>').appendTo($('#'+this.p.belongs));
		//----------------------添加右侧文字------------------------
		$('<div id="'+this.p.belongs+'RightTop" class="'+this.p.smode+'_rightTop"></div>').appendTo($('#'+this.p.belongs+'Right'));
		//alert('<div id="'+this.p.belongs+'RightTop" class="'+this.p.smode+'_rightTop">'+this.leftTitle+'</div>');
		if(this.p.smode=="l"){
			$('<div id="'+this.p.belongs+'RightDown" class="'+this.p.smode+'_rightDown"></div>').appendTo($('#'+this.p.belongs+'Right'));
		}
	}
	this.p.totalValue>0 ? this.percent=Math.ceil(1000*this.p.currentValue/this.p.totalValue)/10:this.percent=0;
	if(this.percent>100){this.percent=100}
	
	//$('#'+this.p.belongs+'LeftDown').html(this.p.currentValue+this.units);
	$('#'+this.p.belongs+'RightTop').html(this.percent+"<span>%</span>");
	$('#'+this.p.belongs+'Back').width(this.width*this.percent/100);
	
	switch(this.p.belongs){
		case "s_proBarAct":
			this.leftTitle="Activity";
			this.leftDown=this.p.currentValue+" cal";
			this.backPic="s_back.jpg"
			this.frontPic="s_f_act.jpg"
			break;
		case "s_proBarSlp":
			this.leftTitle="Sleep";
			this.leftDown=formatTime(this.p.currentValue);
			this.backPic="s_back.jpg"
			this.frontPic="s_f_slp.jpg"
			break;
		case "l_proBarCal":
			this.leftTitle=this.p.currentValue+" <span>cal burned</span>";
			this.leftDown="Calries";
			if(this.p.totalValue-this.p.currentValue>0){
			this.rightDown=Math.floor(10*(this.p.totalValue-this.p.currentValue))/10+" cal remain";
			}else{
				this.rightDown="0 cal remain";
			}
			this.backPic="l_back.jpg"
			this.frontPic="l_f_act.jpg"
			break;
		case "m_proStep":
			this.leftTitle=this.p.currentValue+" <span>of "+this.p.totalValue+"</span>";
			this.leftDown=this.p.currentValue+" Steps Taken";
			this.backPic="l_back.jpg"
			this.frontPic="l_f_act.jpg"
			break;
		case "m_proMile":
			this.leftTitle=this.p.currentValue +" <span>"+$.cookie('back_unit')+" of "+100+" "+$.cookie('back_unit')+"</span>";
			//this.leftDown=Math.floor(100*this.p.currentValue)/100+" "+$.cookie('back_unit')+" Travel";
			this.leftDown=this.p.currentValue+" "+$.cookie('back_unit')+" Travel";
			this.backPic="l_back.jpg"
			this.frontPic="l_f_act.jpg"
			break;
		case "l_proBarSlp":
			this.leftTitle=formatTime(this.p.currentValue);
			this.leftDown="Deep sleep";
			this.rightDown=formatTime(this.p.totalValue);
			this.backPic="l_back.jpg"
			this.frontPic="l_f_slp.jpg"
			break;
	}
	$("#"+this.p.belongs).css("background-image","url('images/"+this.backPic+"')");
	$("#"+this.p.belongs+"Back").css("background-image","url('images/"+this.frontPic+"')");
	
	$('#'+this.p.belongs+'LeftTop').html(this.leftTitle);
	$('#'+this.p.belongs+'LeftDown').html(this.leftDown);
	$('#'+this.p.belongs+'RightDown').html(this.rightDown);
	
	//$("#"+this.p.belongs+"Left").css("top",(this.height-$("#"+this.p.belongs+"Left").height())/2);	
	//$("#"+this.p.belongs+"Right").css("top",(this.height-$("#"+this.p.belongs+"Right").height())/2);
	//alert(this.p.currentValue+"  "+this.p.totalValue+"  "+this.percent);
	
	/*
	this.intValue=window.setInterval(function(){ 
	//-----------动态变化
	
	if(Math.abs(Math.floor(this.percent - this.currentPercent))>0){
			
		this.currentPercent+=(this.percent-this.currentPercent)/5
		this.currentPercent<this.percent ? this.currentPercent=Math.ceil(this.currentPercent):this.currentPercent=Math.floor(this.currentPercent);
		$('#'+this.p.belongs+'LeftDown').html(this.currentPercent*this.p.totalValue+this.units);
		$('#'+this.p.belongs+'Right').html(this.currentPercent+"%");
		$('#'+this.p.belongs+'Back').width(this.width*this.currentPercent/100);
	}else{ 
		$('#'+this.p.belongs+'LeftDown').html(this.p.currentValue+this.units);
		$('#'+this.p.belongs+'Right').html(this.currentPercent+"%");
		alert(this.currentPercent+"  "+this.currentPercent);
		window.clearInterval(this.intValue)	
	};}, 20);
	*/	
}
barItem.prototype.adjust=function(){
	$("#"+this.p.belongs+"Left").css("top",(this.height-$("#"+this.p.belongs+"Left").height())/2);	
	$("#"+this.p.belongs+"Right").css("top",(this.height-$("#"+this.p.belongs+"Right").height())/2);
}
function adjustBarPosition(){
	bigCal.adjust()
	sumAct.adjust()
	mStep.adjust()
	mMile.adjust()
	sumSlp.adjust()
	bigSlp.adjust()
}
function updatedHead(headpic){
	//alert("change senseu"+headpic);
	$("#INFO_head img").attr("src",'upload/'+headpic); 
}