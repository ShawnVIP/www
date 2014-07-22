var pageID=2; // userpage
var maxIndex=100;
var bigcirBack = new Image();  
Number.prototype.toFixed=function(len){
	var add = 0;
	var s,temp;
	var s1 = this + "";
	var start = s1.indexOf(".");
	if(s1.substr(start+len+1,1)>=5)add=1;
	var temp = Math.pow(10,len);
	s = Math.floor(this * temp) + add;
	return s/temp;
};
var txtLib=({
	s_remove:{cn:"删除",en:"Remove"},
	
});
function getText(textName){
	return eval('txtLib.'+textName+"."+LANG);
}

document.write("<script type='text/javascript' src='../js/reglogin.js'></"+"script>"); 
	var pageName="mysenseu";
	var activityColor=new Array("#66bd00","#bfbfbf","#ffa200");
	var sleepColor=new Array("#00c0ff","#bfbfbf","#ffa200");
	var DaysInEachMonth=new Array(31,31,28,31,30,31,30,31,31,30,31,30,31);
	var monthNameList,monthNameSortList;
	if(LANG=="cn"){
		monthNameList=new Array("","一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月");
		monthNameSortList=monthNameList;
	}else{
		monthNameList=new Array("","Janeary","Feberay","March","April","May","June","July","August","September","October","Novenber","December");
		monthNameSortList=new Array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	}
	var calTaken,caloriesGoal;
	var stepsTaken,stepGoal;
	var disTaken,disGoal;
	var slpTaken,slpGoal;
	var footPerStep;
	var bmr;
	var deepSleep,totalSleep;
	var currentDate=new Date();
	var nowStr=currentDate.getFullYear()+"-"+(currentDate.getMonth()+1)+"-"+currentDate.getDate();
	var oldMonth=0;
	var allDataList=new Array();
	var nowDate=new Date();
	var nowDateStr=nowDate.getFullYear()+"-"+(nowDate.getMonth()+1)+"-"+nowDate.getDate();
	var minDateStr="";
	var myDate = new Date();
	var my=myDate.getFullYear();
	var mm=myDate.getMonth()+1;
	var md=myDate.getDate();
	
	var mytime=my+"-"+mm+"-"+md+" "+myDate.toLocaleTimeString();  

	//----------------------summary list-------------
	var sumSelectID=1;

	var sumNameBar=new Array();
	sumNameBar[1]=["Calories","ACT_cal","ACT_calValue"];
	sumNameBar[2]=["Steps Taken","ACT_steps","ACT_stepsValue"];
	sumNameBar[3]=["Miles Travel","ACT_miles","ACT_milesValue"];
	

	var carTitleItem=new Array();
	carTitleItem[1]={leftTitle:"Calories",iconImage:"act_bar_cal.png",currentValue:0,totalValue:0,percent:0,units:"Calories"};
	carTitleItem[2]={leftTitle:"Steps",iconImage:"act_bar_step.png",currentValue:0,totalValue:0,percent:0,units:"Steps"};
	carTitleItem[3]={leftTitle:"Travel",iconImage:"act_bar_dis.png",currentValue:0,totalValue:0,percent:0,units:"Km"};
	
	

	
	var backPos=new Array();
	backPos[1]={itemName:"l_proBarCal",x:34,y:206,w:934,oy:206,pic:"actbar_backb.png"};
	backPos[2]={itemName:"m_proStep",x:34,y:289,w:463,oy:289,pic:"actbar_backs.png"};
	backPos[3]={itemName:"m_proMile",x:505,y:289,w:463,oy:289,pic:"actbar_backs.png"};
	var CCID=1;//----------currentChartID
	//---------------------warning list-----------------
	var warnList=new Array();
	warnList.push({name:"war_act",value:0});
	warnList.push({name:"war_cal",value:0});
	warnList.push({name:"war_step",value:0});
	warnList.push({name:"war_dis",value:0});

	var back_ucode=$.cookie('back_ucode');
	var back_scode=$.cookie('back_scode');
	var back_ecode=$.cookie('back_ecode');
	
	var back_loginMode=$.cookie('back_loginMode');

	var dateStr; //------------------------current date yyyy-mm-dd
	var sleepBarWidth,adjustSleepWidth,sleepBeginTimeValue; //--sleep条宽度以及左边调整位置----
	var tmpDataList=new Array();
	var actDataList=new Array();
	var stepDataList=new Array();
	var disDataList=new Array();
	var totalDataList=new Array();
	var sleepDataList=new Array();
	var actExtraDataList=new Array();
	var slpExtraDataList=new Array();
	var friendListData=new Array();
	//var calTakenMax
	var sleepMoveMax,sleepFromTimeID,sleepToTimeID;
	//--------------------加入顺序执行命令流
	var orderList=new Array();
	orderList.push("getUserInfomation()");
	
	orderList.push("changeDatebyNum(0)");
//------mode为1：HHMM格式时间抓换为 HH|MM|am/pm 格式，mode为2则总分钟数转换------------
	var bigCal,sumAct,mStep,mMile,sumSlp,bigSlp; //-----------状态条
	
	var sensorList=new Array(); 
	var currentSensorID=0;
	var act=new chartArea(); //---pre define act chart, for it will be change manytimes 
	
	var switchsleepMode=0;
	var familyList=new Array(); //-----family list---------
	var familyAverange=new Array(); //-----family list---------
	//var perList=new Array(); //-----family list---------
	var tabClickedMode=new Array(0,0,0);
	var percentGroup=new Array("step","calories","distance","sleep");
	var percentItemID=1; //----------------family 类型---------------
		
$(function(){
	//if($.browser.msie){$.fx.off=true}
		preloadImages('../images/per_big.png');
		if($.cookie('back_loginMode')==null){
			$.cookie('back_ucode', null);
			$.cookie('back_scode', null);
			$.cookie('back_ecode', null);
			$.cookie('back_loginMode',null);
			parent.location="index.php";
			return;
		}
		$('#familyImg').hide();
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
				
				if(oldMonth!=currentDate.getMonth()+1){
					$("#IFRAME_calc").attr("src","calendar.php?year="+currentDate.getFullYear()+"&month="+(currentDate.getMonth()+1)+"&day="+currentDate.getDate());
					oldMonth=currentDate.getMonth()+1;
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
		/*
		$('#MS_activity').bind("mouseenter",{left:$('#MS_activity').css("left"),top:$('#MS_activity').css("top"),catalog:"ACT"},showSetupBack);
		$('#MS_activity').bind("mouseleave",{},hideSetupBack);	
		$('#MS_activity').bind({
			click:function(event){showActivitySetup();}
		});
		
		$('#btn_profile').bind({
			click:function(event){showProfileSetup();}
		});
		*/
		//-------------卡路里mouse over

		$('#l_proBarCal').bind("mouseenter",{id:1},showSetupBack);
		$('#l_proBarCal').bind("mouseleave",{id:1},hideSetupBack);	
		$('#m_proStep').bind("mouseenter",{id:2},showSetupBack);
		$('#m_proStep').bind("mouseleave",{id:2},hideSetupBack);
		$('#m_proMile').bind("mouseenter",{id:3},showSetupBack);
		$('#m_proMile').bind("mouseleave",{id:3},hideSetupBack);
		
		$('#l_proBarCal').bind("click",{id:1},changeActChart);
		$('#m_proStep').bind("click",{id:2},changeActChart);
		$('#m_proMile').bind("click",{id:3},changeActChart);
		
		$('#INFO_head').bind({
			click:function(event){
				$('#topmenu')[0].contentWindow.showProfileSetup();
			}
		});
		$('#setupGoal').bind({
			click:function(event){hideAllPop();showCalSetup();}
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
		
		
		
		bigCal=new barItem();
		sumAct=new barItem();
		mStep=new barItem();
		mMile=new barItem();
		sumSlp=new barItem();
		bigSlp=new barItem();
		
		sumSetDefault();
		
		
		resizeArea();
		
		$(window).resize(function(){resizeArea();});
		$(window).scroll(function(){changePosition();});
		
		$('#Frame_main').show();
		
		$('#confirm_close').bind({
			click:function(event){hidePop('FAM_confirmRemove');}
		});
		buildButton('FAM_confirm',{Width:150});
		$('#FAM_confirm').bind({
			click:function(event){FAM_delete();}
		});
		
		$('#tabACT').bind({
			click:function(event){switchTap(0);}
		});
		$('#tabSLP').bind({
			click:function(event){switchTap(1);}
		});
		$('#tabFRI').bind({
			click:function(event){switchTap(2);}
			
		});
		$('#BTN_search').bind({
			click:function(event){showsearch();}
		});
		
		$('#INFO_message').bind({
			click:function(event){
				$('#MSG_iframe').attr("src","popmessage.php");
				showPopMessage();
			}
		});
		$('#INFO_msgIcon').bind({
			click:function(event){
				$('#MSG_iframe').attr("src","popmessage.php");
				showPopMessage();
			}
		});
		$('#MSG_popup').bind({
			mouseleave:function(event){hidePopMessage();}
		});
		
		$('#itemContainer').bind({
			mouseleave:function(event){$('#itemContainer').fadeOut();}
		});
		adjustBarPosition();
		setupAllValue();
		//showFriendList();
		$('#Frame_SLP').hide();
		$('#slpFromMin').timepicker({
    		showPeriodLabels: false,
			hours: {
				starts: 13,                // First displayed hour
				ends: 23                  // Last displayed hour
			},
			minutes: {
				starts: 0,                // First displayed minute
				ends: 55,                 // Last displayed minute
				interval: 5               // Interval of displayed minutes
			},
		});
		$('#slpToMin').timepicker({
    		showPeriodLabels: false,
			hours: {
				starts: 0,                // First displayed hour
				ends: 11                  // Last displayed hour
			},
			minutes: {
				starts: 0,                // First displayed minute
				ends: 55,                 // Last displayed minute
				interval: 5               // Interval of displayed minutes
			},
		});
		//$("#slpFromDay").datepicker();
		//$("#slpToDay").datepicker();
		$("#slpFromDay").datepicker({dateFormat:"yy-mm-dd"});
		$("#slpToDay").datepicker({dateFormat:"yy-mm-dd"});
		
		$('#changeSlpTime').button();
		$('#changeSlpTime').bind({
			click:function(event){changeSleepTime();}
		});	
		$('#addFamily').bind("mouseenter",{},showFamIn);
		$('#addFamily').bind("mouseleave",{},showFamOut);
		$('#addFamily').bind({
			click:function(event){showsearchFamily();}
		});
		//----------------定义family区域单选框------------
		$("img[id^='perCheckImg']").each(function(){
			$(this).css('cursor','pointer');
			$(this).click(function(){switchShowPercent($(this).attr("id"));});
			
		});
		$("div[id^='perCheckTxt']").each(function(){
			$(this).css('cursor','pointer');
			$(this).click(function(){switchShowPercent($(this).attr("id"));});
			
		});
		
});	

function showFamIn(event){
	$('#familyImg').stop(false,true).fadeIn();
}
function showFamOut(event){
	$('#familyImg').stop(false,true).fadeOut();
}

	function conver24to12(timeString,mode){
		var nh,nm;
		//mode=0: hhmm, mode=1:timeid, mode=2: hh:mm:ss
		if(mode==0){
			nh=Number(timeString.substring(0,2));
			nm=timeString.substring(2,4);
		}
		if(mode==2){
			nh=Number(timeString.substring(0,2));
			nm=timeString.substring(3,5);
		}
		if(mode==1){
			if(timeString>1440){timeString-=1440;};
			nh=Math.floor(timeString/60);
			nm=(100+timeString-nh*60)+'';
			nm=nm.substring(1,3);
		}
		var timeStr="am";
		if(nh >= 12){
			timeStr="pm";
		}
		if(nh==0){
			nh=12;timeStr="am";
		}
		if(nh>12){
			nh-=12;timeStr="pm";
		}
		return nh+"|"+nm+"|"+timeStr;
	}
	function getPercent(cv,tv){
		
		if(cv<=tv){
			return Math.floor(100*cv/tv);
		}else{
			return 100;
		}
	}
	function countIDFromDataStr(basetime,nowtime){
		//---------------根据时间计算出从属ID---------
		//-----------采用除以5后向下取整-------------
		var fh,fm,th,tm;
		if(basetime=""){
			fromid=0;
		}else{
			fh=Number(basetime.substring(0,2));
			fm=Number(basetime.substring(2,4));
			fromid=Math.floor((fh*60+fm)/5);
		}
		th=Number(nowtime.substring(0,2));
		tm=Number(nowtime.substring(2,4));
		toid=Math.floor((th*60+tm)/5);
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
			var tempstr,imgsrc;
			
			$(d).find('yweather\\:condition').each(function(i){
				tempstr=$(this).attr('temp');
				//imgcode=$(this).attr('code');
			});
			
			$(d).find('description').each(function(i){
				var tempStr=($(d).text()).split(String.fromCharCode(34));
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
		currentDate=new Date(y,m-1,d);
		switchsleepMode=0;
		setupAllValue();
	}
	function changeDatebyNum(num){
		
		//alert(currentDate);
		
		currentDate.setTime(currentDate.getTime()+num*24*3600*1000);
		dateStr=currentDate.getFullYear()+"-"+(currentDate.getMonth()+1)+"-"+currentDate.getDate();
		
		
	}
	function setupAllValue(){
		//-------设定当前日期并显示日期---------------
		tabClickedMode[0]=0;
		tabClickedMode[1]=0;
		tabClickedMode[2]=0;
		dateStr=currentDate.getFullYear()+"-"+(currentDate.getMonth()+1)+"-"+currentDate.getDate();
		//clean all map---------
		var ctx = document.getElementById('ACT_can').getContext('2d');
		ctx.clearRect(0,0,890,114);
		
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
		var tstr=dt.split(" ");
		$('#INFO_upperDate').html(tstr[2]+"<br><span>"+tstr[1]+'</span>');
		
		//beginLoad();
		//orderList.push("loadActivityData()");
		//orderList.push("loadSleepData()");
		orderList.push("getWarning()");
		//orderList.push("getFriend()");
		loadNextServerProcess();
		switchTap(0);
		$('#SLP_lable').show();
		$('#s_proBarSlp').hide();
	}
	function beginLoad(){
		orderList.push("loadActivityData()");
		//orderList.push("loadSleepData()");
		loadNextServerProcess();
	}
	function addWarning(r){
		var dataList=r.info;
		back_ecode=r.ecode;
		$.cookie('back_ecode', back_ecode,{path:'/', expires:1000});
	
		$('#INFO_warGroup div').each(function(){$(this).remove();});	
		$('#INFO_numGroup div').each(function(){$(this).remove();});	

		for(i=0;i<dataList.length;i++){
			var obj=dataList[i];
			
			childDiv=$('<div class="INFO_warIcon" id="INFO_war'+i+'"><img src="../images/'+warnList[obj.catalog].name+'.png" /></div>');
			childDiv.appendTo($('#INFO_warGroup'));
			childDiv.attr("titles",obj.title);
			childDiv.attr("detail",obj.detail);
			childDiv.bind("mouseenter",{id:i},showWarningBack);
			childDiv.bind("mouseleave",{id:i},hideWarningBack);
			//childDiv=$('<div class="INFO_warNum" id="INFO_num'+i+'">'+warnList[i].value+'</div>');
			//childDiv.appendTo($('#INFO_numGroup'));
		}
		
	}
	/*
	function getFriend(){
		back_ecode=$.cookie('back_ecode');
		var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w"};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/getfriend.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				showFriendList(msg);
				loadNextServerProcess();
        	}
    	});

		
	}
	*/
	function getWarning(){
		back_ecode=$.cookie('back_ecode');
		var outData={ucode:back_ucode,scode:back_scode,dates:dateStr,ecode:back_ecode,source:"w"};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/getwarning.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				addWarning(msg);
				loadNextServerProcess();
        	}
    	});

		
	}
	function showWarningBack(event){
		
		$('#INFO_popup').css("left",400+event.data.id*55);
		$('#INFO_title').html($('#INFO_war'+event.data.id).attr("titles"));
		$('#INFO_detail').html($('#INFO_war'+event.data.id).attr("detail"));

		$('#INFO_popup').fadeIn(20);
	}
	function hideWarningBack(event){
		
		$('#INFO_popup').hide();
	}		
			
	function loadActivityData(){
		$('#ACT_data').css("opacity",0.2);
		$('#ACT_time').css("opacity",0.2);
		showLoading('ACT');
		back_ecode=$.cookie('back_ecode');
		var outData={type:"act",ucode:back_ucode,scode:back_scode,dates:dateStr,cdate:mytime,ecode:back_ecode,source:"w"};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/getdata.php',
			data:JSON.stringify(outData), 
        	success: function (msg) {
				
				dealActivityData(msg);
				loadNextServerProcess();
				
        	}
    	});
		/*
		$.getScript("http://haisw.net/senseu/getdata_test.php", 
        function(){            
            dealActivityData(returnData);     
        });   
		*/ 
		
	}
	function loadFamilyData(){
		showLoading('FAM');
		back_ecode=$.cookie('back_ecode');
		var outData={type:"family",ucode:back_ucode,scode:back_scode,dates:dateStr,cdate:mytime,ecode:back_ecode,source:"w"};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/getmembers.php',
			data:JSON.stringify(outData), 
        	success: function (msg) {
				if(msg.status !=200){
					$.cookie('back_ucode', null);
					$.cookie('back_scode', null);
					$.cookie('back_ecode', null);
					$.cookie('back_loginMode', null);
					showPop('popupReg');
					return;	
					
				}
				dealFamilyData(msg);
				loadNextServerProcess();
				
        	}
    	});
		
	}
	function dealFamilyData(r){
		hideLoading('FAM');
		familyList=r.peopleList;
		familyAverange=r.peopleAverange;
		redraw();
		
	}
	function dealActivityData(r){
		hideLoading('ACT');
		//var data=eval('(' + r + ')');  
		//$.cookie('back_ecode', r.ecode);
		//back_ecode=r.ecode
		var dataList=r.data;
		calTaken=Number(r.calTaken);
		stepsTaken=Number(r.stepsTaken);
		disTaken=Number(r.disTaken);
		
		caloriesGoal=Number(r.caloriesGoal);
		//bmr=Number(r.bmr);
		disGoal=Number(r.disGoal);
		stepGoal=Number(r.stepGoal);
		
		footPerStep=Number(r.footPerStep);
		calTaken=Number(r.calTaken);
		//calTakenMax=0
		carTitleItem[1].currentValue=calTaken;
		carTitleItem[1].totalValue=caloriesGoal;
		caloriesGoal<calTaken ? carTitleItem[1].percent=100:carTitleItem[1].percent=(calTaken*100/caloriesGoal).toFixed(1);
		
		carTitleItem[2].currentValue=stepsTaken;
		carTitleItem[2].totalValue=stepGoal;
		stepGoal<stepsTaken ? carTitleItem[2].percent=100:carTitleItem[2].percent=(stepsTaken*100/stepGoal).toFixed(1);
		
		carTitleItem[3].currentValue=disTaken;
		carTitleItem[3].totalValue=disGoal.toFixed(3);
		disGoal<disTaken ? carTitleItem[3].percent=100:carTitleItem[3].percent=(disTaken*100/disGoal).toFixed(1);
		
		
			
		var slist="";
		//------------seprate to three parts, act,step,distance
		
		//0:timeStr |  1: cal | 2: step | 3: dis | 4: | wakup(1) sleep(0) | 5: cal>0 0; act=0 1 color for cal | 6: sleepmode (from sensor) | 7: move value
		actDataList=[];
		stepDataList=[];
		disDataList=[];
		for(var i=0;i<dataList.length;i++){
			var subData=dataList[i].split("|");
			actDataList.push( subData[0] +"|" + subData[1] + "|0" );
			stepDataList.push( subData[0] +"|" + subData[2] + "|0");
			disDataList.push( subData[0] +"|" + subData[3] + "|0");
			
			//tmpDataList.push( subData[0] +"|" + subData[1] + "|" + subData[7]);	
		}
		
		totalDataList=['',actDataList,stepDataList,disDataList];
		//var act=new chartArea();
		act.belongs="ACT";
		
		act.data=totalDataList[CCID];
		
		act.color=["#66bd00","#bfbfbf","#ffa200"];
		
		act.itemMainType='bar';
		act.itemLineType='';
		act.init();
		
		actExtraDataList=r.actedata;
		slpExtraDataList=r.slpedata;
		amode=0;
		
		if(actExtraDataList != ""){
			
			act.edata=actExtraDataList;
			act.add();
			amode=1;
		}
		if(r.falldata.length>0){
			act.falldata=r.falldata;
			act.addFall();
		}
		adjustActArea(amode);
		aniSetup();
		tabClickedMode[0]=1;
	
	}
	function aniSetup(){

		bigCal.p={belongs:"l_proBarCal",smode:"l",leftIcon:"",currentValue:calTaken,totalValue:caloriesGoal};
		bigCal.init();
		sumAct.p={belongs:"s_proBarAct",smode:"s",leftIcon:"../images/icon_activity.png",currentValue:calTaken,totalValue:caloriesGoal};
		sumAct.init();
		sumAct.change();
		mStep.p={belongs:"m_proStep",smode:"m",leftIcon:"",currentValue:stepsTaken,totalValue:stepGoal};
		mStep.init();
		mMile.p={belongs:"m_proMile",smode:"m",leftIcon:"",currentValue:disTaken,totalValue:disGoal};
		mMile.init();
		adjustBarPosition();
	}

	function loadSleepData(){
		$('#SLP_data').css("opacity",0.2);
		$('#SLP_time').css("opacity",0.2);
		showLoading('SLP');

		var outData={type:"sleep",ucode:back_ucode,scode:back_scode,dates:dateStr,cdate:mytime,ecode:back_ecode,source:"w"};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/getsleep.php',
			data:JSON.stringify(outData), 
        	success: function (msg) {
				
				dealSleepData(msg);
				//loadNextServerProcess();
				
        	}
    	});

	}
	function dealSleepData(r){
		hideLoading('SLP');
		//--------定义时间日期输入框数值以及起点和终点
		fdate=r.fdate;
		ftime=r.ftime;
		tdate=r.tdate;
		ttime=r.ttime;
		mindate=r.mindate;
		$('#slpFromDay').val(fdate);
		$('#slpFromMin').val(ftime.substring(0,5));
		$('#slpToDay').val(tdate);
		$('#slpToMin').val(ttime.substring(0,5));
		$("#slpToDay").datepicker( "option", "minDate", tdate );
		$("#slpToDay").datepicker( "option", "maxDate", tdate );
		$("#slpFromDay").datepicker( "option", "minDate", mindate );
		$("#slpFromDay").datepicker( "option", "maxDate", tdate );	
		var sourceDataList=r.data;
		var dataList=new Array();
		
		//----------setup period line. 
		hourFrom=parseInt(ftime.substring(0,2));
		hourTo=parseInt(ttime.substring(0,2));
		
		var nfrom=hourFrom;
		var nto=hourTo;
		if(nfrom>12){nfrom-=24;}
		if(nto>12){nto-=24;}
		var def=Math.floor((nto+nfrom)/2);
		from=-12+def;
		to=12+def;

		beginHour=12+def;
		
		fdatestr=fdate.split('-');
		tdatestr=tdate.split('-');
		
		
		distHour=nfrom-beginHour;
		if(distHour<0){distHour+=24;}
		
		wb=new Date(fdatestr[0]+"/"+fdatestr[1]+"/"+fdatestr[2]+" "+ftime);
		wu=new Date(tdatestr[0]+"/"+tdatestr[1]+"/"+tdatestr[2]+" "+ttime);
			
		sleepTime=parseInt((wu.getTime()-wb.getTime())/60000);
			
		
		
		//-------- toHour-FromHour 
		var slp=new chartArea();
		slp.color=["","#00c4ff","#bfbfbf","#00c4ff"];
		slp.belongs="SLP";
		slp.data=sourceDataList;
		slp.distHour=distHour;
		slp.drawBaseLine();
		slp.beginHour=beginHour;
		slp.slpTimeLong=parseInt(sleepTime/5);
		slp.setupHour();
		slp.putData();

		eStr=(conver24to12(ftime,2)).split('|');
		infoStr='<span>'+eStr[0]+':'+eStr[1]+'<span>'+eStr[2]+'</span></span>';
		$('#SLP_wentBed').html(infoStr);
		eStr=(conver24to12(ttime,2)).split('|');
		infoStr='<span>'+eStr[0]+':'+eStr[1]+'<span>'+eStr[2]+'</span></span>';
		$('#SLP_wakeUp').html(infoStr);
		
		infoStr='<span>'+formatTime(sleepTime)+'</span>';
		$('#SLP_wholeSleep').html(infoStr);
		
		infoStr='<span>'+formatTime(slp.deepSleep)+'</span>';
		$('#SLP_deepSleep').html(infoStr);
		$('#SLP_lable').hide();
		$('#s_proBarSlp').show();
		sumSlp.p={belongs:"s_proBarSlp",smode:"s",leftIcon:"../images/icon_sleep.png",currentValue:slp.deepSleep,totalValue:slpGoal};
		
		sumSlp.init();

		bigSlp.p={belongs:"l_proBarSlp",smode:"l",leftIcon:"",currentValue:slp.deepSleep,totalValue:slpGoal};
		bigSlp.init();
		
		/*
		if(switchsleepMode==0){
			switchTap(0);
			switchsleepMode=1;
		}else{
			switchTap(1);
		}
		*/

		//---------------change activity-------		
		tabClickedMode[1]=1;
		switchTap(1);
		
	}
	
	function hideLoading(objname){
		
		$('#'+objname+'_loading').hide();
	}
	function showLoading(objname){
		$('#'+objname+'_loading').show();
	}
			
	function getUserInfomation(){
		back_ecode=$.cookie('back_ecode');
		var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",cdate:mytime};
		$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'../res/getinfo.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				dealUserData(msg);
				loadNextServerProcess();
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

		showPop('popupReg');
		return;	
		
	}
	sensorList=data.sensorList;
	back_ecode=data.ecode;
	$.cookie('back_ecode', back_ecode,{path:'/', expires:1000});
	$.cookie('back_gander', data.gander,{path:'/', expires:1000});
    $.cookie('back_unit', sensorList[0].unit,{path:'/', expires:1000});
    $.cookie('back_defaultgoal', sensorList[0].defaultgoal,{path:'/', expires:1000});
    $.cookie('back_caloriesgoal', sensorList[0].caloriesgoal,{path:'/', expires:1000});
    $.cookie('back_distancegoal', sensorList[0].distancegoal,{path:'/', expires:1000});
    $.cookie('back_stepgoal', sensorList[0].stepgoal,{path:'/', expires:1000});
    $.cookie('back_stepwidth', sensorList[0].stepwidth,{path:'/', expires:1000});
	
	currentSensorID=0;
	showSensor();
	loadNextServerProcess();
}


function getDateInfo(dateStr){
	var dateInfo= new Date(Date.parse(dateStr.replace(/-/g,   "/")));
	var y=dateInfo.getFullYear();
	var m= dateInfo.getMonth()+1;
	var d=dateInfo.getDate();
	var H=dateInfo.getHours();
	var M=dateInfo.getMinutes();
	if(H<10){H="0"+H}
	if(M<10){M="0"+M}
	if(m<10){m="0"+m}
	if(d<10){d="0"+d}
	
	if(LANG=="cn"){
	return H+":"+M+" "+y+"/"+m+"/"+d;
	}else{
		return H+":"+M+" "+m+"/"+d+" "+y;
	}
}	
function showSensor(){
	
	var obj=sensorList[currentSensorID];
	
	$('#INFO_name').html(obj.nickname+'');
	
	$("#INFO_head img").attr("src","../upload/"+obj.headimage); 	
	var power="0000"+obj.power;

	power=power.substring(power.length-4,power.length);
	$("#INFO_sensorIcon img").attr("src","../images/sensor"+power+".png"); 
	$('#INFO_sensorStation').html('<span>Last Sync:</span><br />'+getDateInfo(obj.lastupdate)+'<br /><span>Battery: </span>'+obj.power+'%');
	
	showMessage(obj.message);
	if(obj.message>0){
		$('#MSG_iframe').attr("src","popmessage.php");
	}else{
		$('#MSG_iframe').attr("src","empty.html");
	}
	if(obj.unit=="Metric"){
		$.cookie('back_unit',"Km",{path:'/', expires:1000});
	}else{
		$.cookie('back_unit',"Mile",{path:'/', expires:1000});
	}
	slpGoal=obj.sleepgoal;
	CCID=obj.detailid;

}

function showMessage(mlength){
	if(mlength>0){
		mlength>1 ? strs="You have "+mlength+" messages.":strs="You have "+mlength+" message.";
		$('#INFO_message').html(strs);
		$('#INFO_msgIcon').show();
	
	}else{
		$('#INFO_message').html("");
		$('#INFO_msgIcon').hide();
		$('#MSG_popup').hide();
	}
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

				$('#sumSelect'+sumSelectID).html(sumNameBar[sumSelectID][0]+'<span><img src="../images/selected.png" /></span>');
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
		sexID=event.data.id;
		$("#INFO_sex"+sexID).attr('src',"../images/se_yes.png");
		$("#INFO_sex"+(1-sexID)).attr('src',"../images/se_no.png");
	}
	function changeSumID(event){
		
		sumSelectID=event.data.id;
		sumSetDefault();
		//--------------设置动画
		//sumNameBar[1]="ACT_cal"
		//alert($("#ACT_cal").progressbar("value"))
		tarValue=$("#"+sumNameBar[sumSelectID][1]).progressbar("value");
		curValue=$("#MS_activity").progressbar("value");
		var sum_INT=window.setInterval(function(){ 
		if(tarValue != curValue){
			curValue+=(tarValue-curValue)/5;
			curValue<tarValue ? curValue=Math.ceil(curValue):curValue=Math.floor(curValue);
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
		showPop('Frame_profileSetup');
		//$('#lightBack').fadeIn(50);
		//$('#Frame_profileSetup').fadeIn();
		$("#IFRAME_profile").attr("src","profile.php?userid="+back_userid);
	}


	function showActivitySetup(){
		
	}

	function closeSearch(){
		hidePop('Frame_search');
		//$('#lightBack').fadeOut();
		//$('#Frame_search').fadeOut();
	}
	function closeGoalSetup(){
		hidePop('Frame_goalSetup');
		//$('#lightBack').fadeOut();
		//$('#Frame_goalSetup').fadeOut();
	}
	function closeProfileSetup(){
		hidePop('Frame_profileSetup');
		//$('#lightBack').fadeOut();
		//$('#Frame_profileSetup').fadeOut();
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
	$("#PRO_timeZone").attr("value",$("#timezone").find("option:selected").text());
	
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

function changeSleepTime(){
	//-------------检时间格式-------------
	
	if(!checkMinusFormat($('#slpFromMin'))){return;}
	if(!checkMinusFormat($('#slpToMin'))){return;}
	fromdate=$("#slpFromDay").val()+" "+$('#slpFromMin').val()+":00";
	todate=$("#slpToDay").val()+" "+$('#slpToMin').val()+":00";
	fdate=new Date(new Date(Date.parse(fromdate.replace(/-/g,   "/"))));
	tdate=new Date(new Date(Date.parse(todate.replace(/-/g,   "/"))));
	fd=fdate.getTime();
	td=tdate.getTime();
	if(td<fd){
		$('#slpToMin').focus();
		return;	
	}
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,fdate:$("#slpFromDay").val(),tdate:$("#slpToDay").val(),ftime:$('#slpFromMin').val()+":00",ttime:$('#slpToMin').val()+":00",sdate:dateStr,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/changesleep.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				showAdjustSleep(msg);
				
        }
	});
	
	//http://fgelinas.com/code/timepicker/
	/*
	$(document).ready(function() {
		$('#timepicker_start').timepicker({
			showLeadingZero: false,
			onHourShow: tpStartOnHourShowCallback,
			onMinuteShow: tpStartOnMinuteShowCallback
		});
		$('#timepicker_end').timepicker({
			showLeadingZero: false,
			onHourShow: tpEndOnHourShowCallback,
			onMinuteShow: tpEndOnMinuteShowCallback
		});
	});
	
	function tpStartOnHourShowCallback(hour) {
		var tpEndHour = $('#timepicker_end').timepicker('getHour');
		// all valid if no end time selected
		if ($('#timepicker_end').val() == '') { return true; }
		// Check if proposed hour is prior or equal to selected end time hour
		if (hour <= tpEndHour) { return true; }
		// if hour did not match, it can not be selected
		return false;
	}
	function tpStartOnMinuteShowCallback(hour, minute) {
		var tpEndHour = $('#timepicker_end').timepicker('getHour');
		var tpEndMinute = $('#timepicker_end').timepicker('getMinute');
		// all valid if no end time selected
		if ($('#timepicker_end').val() == '') { return true; }
		// Check if proposed hour is prior to selected end time hour
		if (hour < tpEndHour) { return true; }
		// Check if proposed hour is equal to selected end time hour and minutes is prior
		if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
		// if minute did not match, it can not be selected
		return false;
	}
	
	function tpEndOnHourShowCallback(hour) {
		var tpStartHour = $('#timepicker_start').timepicker('getHour');
		// all valid if no start time selected
		if ($('#timepicker_start').val() == '') { return true; }
		// Check if proposed hour is after or equal to selected start time hour
		if (hour >= tpStartHour) { return true; }
		// if hour did not match, it can not be selected
		return false;
	}
	function tpEndOnMinuteShowCallback(hour, minute) {
		var tpStartHour = $('#timepicker_start').timepicker('getHour');
		var tpStartMinute = $('#timepicker_start').timepicker('getMinute');
		// all valid if no start time selected
		if ($('#timepicker_start').val() == '') { return true; }
		// Check if proposed hour is after selected start time hour
		if (hour > tpStartHour) { return true; }
		// Check if proposed hour is equal to selected start time hour and minutes is after
		if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
		// if minute did not match, it can not be selected
		return false;
	}
	*/
}

function showAdjustSleep(r){
	loadSleepData();
	
	
}
function checkMinusFormat(obj){
	var _reTimeReg = /^[0-5][0-9]:[0-5][0-9]$/;
	if(!_reTimeReg.test(obj.val())){
		obj.focus();
		
		return false;
	}
	return true;
	
}

function showPopMessage(){
	//$('#MSG_iframe').attr("src","popmessage.php");
	$('#MSG_popup').fadeIn();
}
function hidePopMessage(){
	$('#MSG_popup').fadeOut();
}
function showSetupBack(event){
	
	$('#'+backPos[event.data.id].itemName).removeClass('G_smallShadow');
	$('#Back_'+backPos[event.data.id].itemName).addClass('barBack_'+event.data.id);
}	
function hideSetupBack(event){
	$('#'+backPos[event.data.id].itemName).addClass('G_smallShadow');
	$('#Back_'+backPos[event.data.id].itemName).removeClass('barBack_'+event.data.id);
}
function showsearch(){
	showPop('Frame_search');
	//$('#lightBack').fadeIn(50);
	//$('#Frame_search').fadeIn(50);
	
	
}

function showsearchFamily(){
	showPop('Frame_search');
	//$('#lightBack').fadeIn(50);
	//$('#Frame_search').fadeIn(50);
	
	
}

function showCalSetup(){
	
	//if(dateStr==nowDateStr){
		showPop('Frame_goalSetup');
		back_ecode=$.cookie('back_ecode');
		$("#IFRAME_goalSetup").attr("src","calsetup.php?ucode="+back_ucode+"&scode="+back_scode+"&ecode="+back_ecode+"&source=w&cdate="+mytime);
		$('#Frame_goalSetup').show();
	//}else{
		//showwait("Sorry","Only today's goal could be setup.");
	//}
		
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
			adjustBarPosition();
		}
	}
	if(tabClickedMode[fid]==0){
		switch(fid){
			case 0:
				loadActivityData();
			break;
			case 1:
				loadSleepData();
			break;
			case 2:
				loadFamilyData();
			break;
		}
	}

}
function updateGoalInfo(cg,sg,dg){
	caloriesGoal=cg;
	stepGoal=sg;
	disGoal=dg;
	aniSetup();
	
	getWarning();
}
function changeActChart(event){
		hideSetupBack(event);
		if(CCID != event.data.id){
			
			CCID=event.data.id;
			act.data=totalDataList[CCID] ;   
			
			act.init();
			amode=0;
			if(actExtraDataList != ""){
				act.edata=actExtraDataList;
				act.add();
				amode=1;
			}
			adjustActArea(amode);
			sumAct.change();
			var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",ccid:CCID};
			$.ajax({type: "POST",contentType: "application/json",dataType: "json",url:'../res/saveorder.php',data:JSON.stringify(outData)});
		}
}


function barItem(){

	this.p={belongs:"",smode:"",leftIcon:"",currentValue:0,totalValue:0,backColor:""};
	
	this.leftTitle="";
	this.leftDown="";
	this.rightTitle="";
	this.rightDown="";
	this.percent=0;
	this.currentPercent=0;
	this.intValue=0;
	this.width=0;
	this.height=0;
	this.units="";
	this.backPic="";
	this.frontPic="";
	this.initMode=0;
	this.iconImage="";

}
barItem.prototype.change=function(){
	
	$("#"+this.p.belongs+"LeftIcon img").attr("src","../images/"+carTitleItem[CCID].iconImage);
	$('#'+this.p.belongs+'LeftTop').html(carTitleItem[CCID].leftTitle);
	$('#'+this.p.belongs+'LeftDown').html(carTitleItem[CCID].totalValue+" "+carTitleItem[CCID].units);
	
	$('#'+this.p.belongs+'RightTop').html(carTitleItem[CCID].percent+"<span>%</span>");
	$('#'+this.p.belongs+'Back').width(this.width*carTitleItem[CCID].percent/100);
	
};




barItem.prototype.init=function(){
	if(this.initMode ==0){
		this.intiMode=1;
		//------------删除所有子元素------------------------
		$('#'+this.p.belongs+" div").each(function(){$(this).remove();});
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
	
	this.p.totalValue>0 ? this.percent=(100*this.p.currentValue/this.p.totalValue).toFixed(1):this.percent=0;
	if(this.percent>100){this.percent=100;}
	//alert(this.p.belongs+"  "+this.p.currentValue+"   "+this.p.totalValue+"   "+this.percent)
	//$('#'+this.p.belongs+'LeftDown').html(this.p.currentValue+this.units);
	$('#'+this.p.belongs+'RightTop').html(this.percent+"<span>%</span>");
	$('#'+this.p.belongs+'Back').width(this.width*this.percent/100);
	
	switch(this.p.belongs){
		case "s_proBarAct":
			this.leftTitle="Activity";
			this.leftDown=this.p.totalValue+" cal";
			this.backPic="s_back.jpg";
			this.frontPic="s_f_act.jpg";
			break;
		case "s_proBarSlp":
			this.leftTitle="Sleep";
			this.leftDown=formatTime(this.p.totalValue);
			this.backPic="s_back.jpg";
			this.frontPic="s_f_slp.jpg";
			
			break;
		case "l_proBarCal":
			this.leftTitle=(this.p.currentValue).toFixed(1)+" <span>cal burned</span>";
			this.leftDown="Calories";
			if(this.p.totalValue-this.p.currentValue>0){
				this.rightDown=(this.p.totalValue-this.p.currentValue).toFixed(1)+" cal remain";
			}else{
				this.rightDown="0 cal remain";
			}
			this.backPic="l_back.jpg";
			this.frontPic="l_f_act.jpg";
			break;
		case "m_proStep":
			this.leftTitle=this.p.currentValue+" <span>of "+this.p.totalValue+"</span>";
			this.leftDown=this.p.currentValue+" Steps Taken";
			this.backPic="l_back.jpg";
			this.frontPic="l_f_act.jpg";
			break;
		case "m_proMile":
			temp=parseFloat(this.p.totalValue);
			this.leftTitle=this.p.currentValue.toFixed(3) +" <span>"+$.cookie('back_unit')+" of "+temp.toFixed(3)+" "+$.cookie('back_unit')+"</span>";
			//this.leftDown=Math.floor(100*this.p.currentValue)/100+" "+$.cookie('back_unit')+" Travel";
			this.leftDown=(this.p.currentValue).toFixed(3)+" "+$.cookie('back_unit')+" Travel";
			this.backPic="l_back.jpg";
			this.frontPic="l_f_act.jpg";
			break;
		case "l_proBarSlp":
			this.leftTitle=formatTime(this.p.currentValue);
			this.leftDown="Deep sleep";
			this.rightDown=formatTime(this.p.totalValue);
			this.backPic="l_back.jpg";
			this.frontPic="l_f_slp.jpg";
			break;
	}
	$("#"+this.p.belongs).css("background-image","url('../images/"+this.backPic+"')");
	$("#"+this.p.belongs+"Back").css("background-image","url('../images/"+this.frontPic+"')");
	
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
};
barItem.prototype.adjust=function(){
	$("#"+this.p.belongs+"Left").css("top",(this.height-$("#"+this.p.belongs+"Left").height())/2);	
	$("#"+this.p.belongs+"Right").css("top",(this.height-$("#"+this.p.belongs+"Right").height())/2);
};
function adjustBarPosition(){
	bigCal.adjust();
	sumAct.adjust();
	mStep.adjust();
	mMile.adjust();
	sumSlp.adjust();
	bigSlp.adjust();
}
function updatedHead(headpic){
	//alert("change senseu"+headpic);
	$("#INFO_head img").attr("src",'../upload/'+headpic); 
}

function adjustActArea(mode){
	
	dy=26*mode;
	$('#Frame_ACT').height(417+dy);
	$('#ACT').height(147+dy);
	for(i=1;i<4;i++){
		$('#Back_'+backPos[i].itemName).css("top",backPos[i].y+dy);
	}
	
	mode==0 ? $('#ACT_eContent').hide():$('#ACT_eContent').show();
	
}
/*
function showFriendList(r){
	$('#FRI_list div').each(function(){$(this).remove();});
	
	
	friendListData=r.friendlist;
	showFriendLabel();
	for(var i=0;i<r.friendlist.length;i++){
		var obj=r.friendlist[i];
		$('<div class="FriItem" id="friItem'+i+'"></div>').appendTo($('#FRI_list'));
		var obja=new friendItem();
		obja.itemID=i;
		obja.picURL="../upload/"+obj.head;
		obja.pname=obj.nickname;
		obja.perAct=Math.floor(obj.peract*100);
		obja.perSlp=Math.floor(obj.perslp*100);
		obja.init();
	}
	$('.FriItem').mouseenter(function(){
		$(this).addClass("friOverItem");
		$(this).addClass("G_bigRoundShadowNoBorder");
		$('#btnContent'+$(this).attr("itemID")).show();
	});
	$('.FriItem').mouseleave(function(){
		$(this).removeClass("friOverItem");
		$(this).removeClass("G_bigRoundShadowNoBorder");
		$('#btnContent'+$(this).attr("itemID")).hide();
		
	});
	$("#FRI_list").sortable();
	$("#FRI_list").disableSelection();			
}

function showFriendPer(type,id,percent,color){
	var obj=new smallBar();
	obj.belongs="fri"+type+"PerBar"+id;
	obj.color=color;
	obj.percent=percent;
	obj.init();
	$('#fri'+type+'Per'+id).html(percent);
	$('#fri'+type+'Per'+id).css("color",color);
	$('#fri'+type+'PerMark'+id).css("color",color);
}
*/
function smallBar(){
	
	this.belongs="";
	this.percent=0;
	this.width=0;
	this.height=0;
	this.color="#FF9900";
	this.initMode=0;
}
smallBar.prototype.init=function(){
	
	//------------删除所有子元素------------------------
	$('#'+this.belongs+" div").each(function(){$(this).remove();});
	this.width=$('#'+this.belongs).width();
	this.height=$('#'+this.belongs).height();
	//--------------添加底部颜色div区域-------------------------------------------
	$('<div id="'+this.belongs+'Back" class="G_smallRound"></div>').appendTo($('#'+this.belongs));
	$("#"+this.belongs+"Back").height(this.height);
	$("#"+this.belongs+"Back").css("background",this.color);

	$('#'+this.belongs+'Back').width(this.width*this.percent/100);
	
	
};
function friendItem(){
	this.belongs="";
	this.itemID=0;
	this.picURL="";
	this.pname="";
	this.perAct=0;
	this.perSlp=0;
	this.sensorID=0;
}
var currentFriendItemID=0;
friendItem.prototype.init=function(){
	this.belongs="friItem"+this.itemID;
	$('#'+this.belongs+" div").each(function(){$(this).remove();});
	var strs='<table cellpadding="0" cellspacing="0">';
	strs+='<tr><td width="116" rowspan="4" class="pictable" >';
	strs+='<div class="headback G_smallRound G_smallShadow" ><div class="headpic G_smallRound" id="friHead'+this.itemID+'"><img src="'+this.picURL+'" width=100% height=100% /></div></div></td>';
	strs+='<td height=29 colspan="3" class="friName" id="friName'+this.itemID+'">'+this.pname+'</td></tr>';
	strs+='<tr><td width=125  class="friendItemAreaAct friTextPosition" ><span class="friItemNum " id="friActPer'+this.itemID+'"></span>';
	strs+='<span class="friItemPer" id="friActPerMark'+this.itemID+'">%</span></td><td width=1 class="friItemBot"></td>';
    strs+='<td width="125" class="friendItemAreaSlp friTextPosition"><span class="friItemNum " id="friSlpPer'+this.itemID+'"></span>';
	strs+='<span class="friItemPer" id="friSlpPerMark'+this.itemID+'">%</span></td></tr>';
    strs+='<tr><td height=23  ><div class="G_smallRound G_smallShadow friBar" id="friActPerBar'+this.itemID+'"></div></td>';
    strs+='<td width=1></td><td><div class="G_smallRound G_smallShadow friBar" id="friSlpPerBar'+this.itemID+'"></div></td></tr>';
    strs+='<tr><td height="5"  ></td><td width=1 ></td><td></td></tr><tr>';
    strs+='<td height="35" colspan="4"><table align="right" id="btnContent'+this.itemID+'" class="templetes">';
    //strs+='<tr><td width="80"><img src="../images/fri_mes.png" width="63" height="18" id="btnMsg'+this.itemID+'" class="downButton" /></td>';
	strs+='<tr><td width="80"></td>';
    strs+='<td width="67"><img src="../images/fri_del.png" width="63" height="18" id="btnDel'+this.itemID+'" class="downButton" /></td></tr></table></td></tr></table>';
	$(strs).appendTo($('#'+this.belongs));
	showFriendPer("Act",this.itemID,this.perAct,"#FF9900");
	showFriendPer("Slp",this.itemID,this.perSlp,"#00c0ff");
	//$('#friHead'+this.itemID).css("background","url(../images/fri_undef.jpg)");
	//$('#friHead'+this.itemID).css("background","url("+this.picURL+")");
	$('#friItem'+this.itemID).attr("itemID",this.itemID);
	$('#btnDel'+this.itemID).bind("click",{sid:this.sensorID,cid:this.itemID},removeFriend);
};

function removeFriend(event){
	currentFriendItemID=event.data.cid;
	back_ecode=$.cookie('back_ecode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,rcode:friendListData[currentFriendItemID].scode,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/removefriend.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				showRemove(msg);
				
        }
    });
	
}

function showRemove(r){
	if(r.status != 200){return;}
	//alert(currentFriendItemID);
	$('#friItem'+currentFriendItemID).remove();
	friendListData.splice(currentFriendItemID,1);
	showFriendLabel();
}
function showFriendLabel(){
	if(friendListData.length==0){
		$('#FRI_lable').show();
		$('#s_proBarFri').hide();
		return;
	}else{
		$('#FRI_lable').hide();
		$('#s_proBarFri').show();
	}
	var obj=friendListData[0];
	picURL="../upload/"+obj.head;
	pname=obj.nickname;
	perAct=Math.floor(obj.peract*100);
	
	strs='<table align="center" height=50 border="0" cellpadding="0" cellspacing="0">';
	strs+='<tr><td width=50 ><img src="'+picURL+'" width="50" height="50" /></td><td class="friLabName">'+pname+'</td>';
	strs+='<td width=1 ></td><td width=44><img src="../images/war_act.png" width="44" height="44" /></td>';
	strs+='<td width="80" align=center><span class="friLabNum">'+perAct+'</span><span class="friLabPer">%</span></td></tr></table>';
	$('#s_proBarFri').html(strs);
}
function redraw(){
	drawDetail();
	/*
	 bigcirBack.src ="../images/per_big.png";
	bigcirBack.onload=function(){
		drawDetail();
	};
	*/
}

function switchShowPercent(nid){
	
	var tempItemID=parseInt(nid.substring(11,12));
	if(tempItemID==percentItemID){
		return;
	}else{
		percentItemID=tempItemID;
		$("img[id^='perCheckImg']").attr("src","../images/se_no.png");
		$('#perCheckImg'+percentItemID).attr("src","../images/se_yes.png");
		
		drawContextList[0].toValue=eval('familyAverange.'+percentGroup[percentItemID]);
	
		for(var i=0;i<drawContextList.length-1;i++){
			drawContextList[i+1].toValue=eval("familyList["+i+"].percentage."+percentGroup[percentItemID]);
		}
		beginToDraw();
	}
}
var drawContextList=new Array();
var selectItemID=0
function removeFamily(){
	var obj=familyList[selectItemID]
	$('#FAM_hideHead').attr("src","../upload/"+obj.headimage);
	$('#FAM_cname').text(obj.nickname+" ("+obj.relation+")");
	showPop('FAM_confirmRemove');
}

function FAM_delete(){
	back_ecode=$.cookie('back_ecode');
	var outData={ucode:back_ucode,scode:back_scode,dates:dateStr,ecode:back_ecode,fcode:familyList[selectItemID].scode,source:"w"};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
		url:'../res/removefriend.php',
        data:JSON.stringify(outData), 
        success: function (msg) {
			familyList.slice(selectItemID,1)
			hidePop('FAM_confirmRemove');
			loadFamilyData();
        }
    });
}
function drawDetail(){
	
	//familyList=r.peopleList;
	//familyAverange=r.peopleAverange;
	var contentImgData;
	var bigboxWidth=290; //中心区域
	var smallBoxWidth=140;//子区域
	var itemRadio=220; //子圆圈环绕中心半径
	var mainWidth=$('#mainFamily').width();
	var mainHeight=$('#mainFamily').height();
	var cenX=mainWidth/2;
	var cenY=mainHeight/2;
	var itemLength=familyList.length;
	//itemLength=5;
	$('#mainFamily *').each(function(){$(this).remove();});
	
	//$('<canvas id="mainCanvas" class="process" width="'+mainWidth+'px" height="'+mainHeight+'px" >61%</canvas> ').appendTo($('#mainFamily'));
	//------define middle big circle and arouand circle-----------------------
	$('<div id="middleCircle" class="absDiv"><canvas id="middleCanvas" class="process" width="'+bigboxWidth+'px" height="'+bigboxWidth+'px"></canvas><div id="middlePicture" class="absDiv"></div><div id="middleText"  class="absDiv"></div><div id="middlePercent"  class="absDiv">%</div></div>').appendTo($('#mainFamily'));
	$('#middleText').css("top",75);
	//$('#middleText').css("left",74);
	$('#middleText').css("font-size",100);
	$('#middleText').css("font-weight","bold");
	
	$('#middlePercent').css("top",120);
	//$('#middlePercent').css("left",185);
	$('#middlePercent').css("font-size",50);
	$('#middlePercent').css("font-weight","bold");
	
	drawContextList=[];
    
	var canvas =document.getElementById('middleCanvas');
	canvasBuffer = document.createElement("canvas");  
    canvasBuffer.width = canvas.width;  
    canvasBuffer.height = canvas.height;  
	drawContextList.push({canvas:canvas,buffer:canvasBuffer,fromValue:0,toValue:eval('familyAverange.'+percentGroup[percentItemID])});
	
	for(var i=0;i<itemLength;i++){
		$('<div id="aroundCircle'+i+'"  class="absDiv"><canvas id="aroundCanvas'+i+'" class="process" width="'+smallBoxWidth+'px" height="'+smallBoxWidth+'px"></canvas><div id="aroundText'+i+'"  class="aroundText absDiv"></div><div class="aroundPer absDiv">%</div><div class="aroundName absDiv"></div><div id="removeAro'+i+'" class="absDiv"></div></div>').appendTo($('#mainFamily'));

		var itemX=itemRadio*Math.cos(i*Math.PI*2/itemLength-Math.PI/2)*1.2;
		var itemY=itemRadio*Math.sin(i*Math.PI*2/itemLength-Math.PI/2);
		$('#aroundCircle'+i).css('left',cenX+itemX-smallBoxWidth/2);
		$('#aroundCircle'+i).css('top',cenY+itemY-smallBoxWidth/2);	
		canvas =document.getElementById('aroundCanvas'+i);
		canvasBuffer = document.createElement("canvas");  
	    canvasBuffer.width = canvas.width;  
	    canvasBuffer.height = canvas.height; 
		drawContextList.push({canvas:canvas,buffer:canvasBuffer,fromValue:0,toValue:eval("familyList["+i+"].percentage."+percentGroup[percentItemID])});
		$('#aroundCircle'+i+' div').eq(0).css("color","white");
		$('#aroundCircle'+i+' div').eq(1).css("color","white");
		$('#aroundCircle'+i+' div').eq(2).css("color","#6a6a6a");
		$('#aroundCircle'+i+' div').eq(2).text(familyList[i].nickname+" ("+familyList[i].relation+")");
		if(i>0){
			buildButton("removeAro"+i,{Width:80,Size:"small",Color:"y",Title:getText('s_remove')});
			$('#removeAro'+i).attr('btnID',i);
			$('#aroundCircle'+i).attr('btnID',i);
			$('#removeAro'+i).click(function(){
				selectItemID=$(this).attr('btnID')
				removeFamily();
			});

			
			$('#aroundCircle'+i).mouseenter(function(){
				
				$('#removeAro'+$(this).attr("btnID")).fadeIn();
			});
			$('#aroundCircle'+i).mouseleave(function(){
				$('#removeAro'+$(this).attr("btnID")).fadeOut();
				
			});

		}
	}
	$("div[id^='removeAro']").css("left",60)
	$("div[id^='removeAro']").css("top",10);
	$("div[id^='removeAro']").hide();
	$('.aroundText').css("top",45);
	//$('.aroundText').css("left",20);
	$('.aroundText').css("font-size",40);
	$('.aroundText').css("font-weight","bold");
	$('.aroundPer').css("top",62);
	//$('.aroundPer').css("left",80);
	$('.aroundPer').css("font-size",20);
	$('.aroundPer').css("font-weight","bold");
	$('.aroundName').width(232);
	$('.aroundName').height(20);
	//$('.aroundName').css("background","#ff6600");
	$('.aroundName').css("left",-45);
	$('.aroundName').css("top",135);
	$('.aroundName').css("font-size",20);
	$('.aroundName').css("font-size",14);
	$('.aroundName').css("text-align","center");
	
	$("div[id^='aroundCircle']").width(smallBoxWidth);
	$("div[id^='aroundCircle']").height(smallBoxWidth);
	//$("div[id^='aroundCanvas']").width(smallBoxWidth);
	//$("div[id^='aroundCanvas']").height(smallBoxWidth);
	//$("div[id^='aroundCircle']").css("background","#ff6600");
	
	$('#middleCircle').width(bigboxWidth);
	$('#middleCircle').height(bigboxWidth);
	$('#middlePicture').width(bigboxWidth);
	$('#middlePicture').height(bigboxWidth);
	
	$('#middlePicture').css("background-image","url('../images/per_big.png')");
	$('#middlePicture').css('left',0);
	$('#middlePicture').css('top',0);
	$('#middlePicture').css("text-align","right");
	$('#middleCircle').css("left",cenX-bigboxWidth/2);
	$('#middleCircle').css("top",cenY-bigboxWidth/2);
	//$("#middleCircle").css("background","#ff9900");
	
	//$('<div id="itemContent"></div>').appendTo($('#mainFamily'));
	//$('#itemContent').hide();
	beginToDraw();
}
function copyContent(fromCanvas,toCanvas){
 	var context = toCanvas.getContext('2d');
 	context.clearRect(0, 0, toCanvas.width, toCanvas.height); 
 	context.drawImage(fromCanvas, 0, 0); 
 }
 
function getUpdatedColor(fromColor,toColor,currentValue){
	var fr=fromColor[0];
	var fg=fromColor[1];
	var fb=fromColor[2];
	var tr=toColor[0];
	var tg=toColor[1];
	var tb=toColor[2];	
		
	var cr=Math.floor(fr+(tr-fr)*currentValue/100);
	var cg=Math.floor(fg+(tg-fg)*currentValue/100);
	var cb=Math.floor(fb+(tb-fb)*currentValue/100);
		
	var sr='0'+cr.toString(16);
	var sg='0'+cg.toString(16);
	var sb='0'+cb.toString(16);
	return '#'+sr.substring(sr.length-2,sr.length)+sg.substring(sg.length-2,sg.length)+sb.substring(sb.length-2,sb.length);
} 
function adjustTextPosition(itemName,itemValue,itemSize){
	if(itemSize=="big"){
		if(itemValue<10){
			$('#middleText').css("left",104);
			$('#middlePercent').css("left",157);
			return;
		}
		if(itemValue==100){
			$('#middleText').css("left",16);
			$('#middlePercent').css("left",215);
			return;
		}
		$('#middleText').css("left",74);
		$('#middlePercent').css("left",186);
		return;
	}
	if(itemSize=="small"){
		if(itemValue<10){
			$('#'+itemName+' div').eq(0).css("left",52);
			$('#'+itemName+' div').eq(1).css("left",75);
			return;
		}
		if(itemValue==100){
			$('#'+itemName+' div').eq(0).css("left",26);
			$('#'+itemName+' div').eq(1).css("left",95);
			return;
		}
		$('#'+itemName+' div').eq(0).css("left",39);
		$('#'+itemName+' div').eq(1).css("left",85);
		return;
	}
}
function beginToDraw(){	
	
    var cenBackRadio=133;
    var cenBackColor='#dde4f0';
    var itemColor="#66bd00";
    var itemBackColor='#a5a5a5';
    
    var cenInRadio=121;
    var itemRadio=220;
    var itemOutRadio=62;
	var itemInRadio=52;
	var itemCoreRadio=47;
	var itemCoreColor='#b7b7b7';
	
	var cenPer=20;
	var itemPer=50;
	//--------------中心数据的背景色及动态弧线-------------------------------------------------
	
	var temp={pos:0};
	var fromColor=new Array(255,158,4);
	var toColor=new Array(102,189,0);
    TweenLite.to(temp,1,{pos:1, onUpdate:function(){
    	
	    clearCanvas(drawContextList[0].buffer);
	   	clearCanvas(drawContextList[0].canvas);
	   	drawCirItem(drawContextList[0].buffer,cenBackRadio,0, Math.PI*2, cenBackColor,1,true);
	   	var fromAng=-Math.PI/2;
	   	var currentValue=drawContextList[0].fromValue+temp.pos*(drawContextList[0].toValue-drawContextList[0].fromValue);
	   	var toAng=Math.PI * currentValue/ 50-Math.PI/2;
	   	//console.log("from:"+fromAng+" to:"+toAng);
	   	//var itemColorValue=fromColor+parseInt((toColor-fromColor)*currentValue/100);
	   	//console.log("currentValue:"+"from:"+fromAng+" to:"+toAng);
		//drawCirItem(drawContextList[0].canvas,cenBackRadio,fromAng, toAng, '#'+itemColorValue.toString(16),24,false);
		var itemColor=getUpdatedColor(fromColor,toColor,currentValue);
		drawCirItem(drawContextList[0].buffer,cenBackRadio,fromAng, toAng, itemColor,24,false);
		copyContent(drawContextList[0].buffer,drawContextList[0].canvas);
		$('#middleText').css("color",itemColor);
		var showtext=parseInt(currentValue);
		$('#middleText').text(showtext);	
		$('#middlePercent').css("color",itemColor);
		adjustTextPosition('middleCircle',showtext,'big');
		//console.log(showtext);
		for(var i=1;i<drawContextList.length;i++){
			clearCanvas(drawContextList[i].buffer);
			clearCanvas(drawContextList[i].canvas);
			//--------------子数据背景色及边缘颜色------------------------------------------------
			drawCirItem(drawContextList[i].buffer,itemOutRadio,0, Math.PI*2, itemBackColor,8,false);
			drawCirItem(drawContextList[i].buffer,itemCoreRadio,0, Math.PI*2, itemCoreColor,1,true);

			
			currentValue=drawContextList[i].fromValue+temp.pos*(drawContextList[i].toValue-drawContextList[i].fromValue);
			toAng=Math.PI * currentValue/ 50;
			itemColor=getUpdatedColor(fromColor,toColor,currentValue);
			drawCirItem(drawContextList[i].buffer,itemOutRadio,-Math.PI/2, toAng-Math.PI/2, itemColor,8,false);
			var ra=(Math.PI-toAng)/2;
			drawCirItem(drawContextList[i].buffer,itemCoreRadio,ra, toAng+ra, itemColor,1,true);
			copyContent(drawContextList[i].buffer,drawContextList[i].canvas);
			showtext=parseInt(currentValue);
			$('#aroundText'+(i-1)).text(showtext);
			adjustTextPosition('aroundCircle'+(i-1),showtext,'small');
			//$("#aroundCircle"+(i-1)+" div").css("color",itemColor);
		}

	    
   },onComplete:function(){
   		for(var i=0;i<drawContextList.length;i++){
   			drawContextList[i].fromValue=drawContextList[i].toValue;
   		}
   		
   }});
 

   tabClickedMode[2]=1;
  
}
function clearCanvas(canvas){
	var context = canvas.getContext('2d');
	context.clearRect(0, 0, canvas.width, canvas.height);
}
function drawCirItem(canvas,radio,startAng,endAng,color,lineWidth,fillMode){
	var context = canvas.getContext('2d');
	var cenx=canvas.width/2;
	var ceny=canvas.height/2;
	context.beginPath();
	var realRadio=radio;
	if(lineWidth>1){
		realRadio=radio-lineWidth/2;
	}
	context.arc(cenx, ceny, realRadio, startAng,endAng, false);
	if(fillMode){
		context.closePath();	
		context.fillStyle = color;
		context.fill();
	}else{
		context.lineCap="round";
		context.lineWidth = lineWidth;
		context.strokeStyle =color;
	    context.stroke();
	}
	
}
