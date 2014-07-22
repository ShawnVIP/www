<?php

if($_COOKIE['back_loginMode'] != "1"){
	header("Location: index.php");  
	exit;	
}

$lang="cn";



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DaTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/main_cn.css" type="text/css" rel="stylesheet" />

<style type="text/css">
.s_leftIcon{position:absolute;}
.s_leftInfo{position:absolute;left:40px;}
.s_leftTop{color:white;font-size:18px;text-align:left;}
.s_leftDown{color:white;font-size:12px;text-align:left;}
.s_rightInfo{position:absolute;right:10px;}
.s_rightTop{color:white;font-size:32px;text-align:right;}
.s_rightTop span{font-size:18px;}
.m_leftInfo{position:absolute;left:20px;}
.m_leftTop{color:white;font-size:28px;text-align:left;}
.m_leftTop span{font-size:20px;}
.m_leftDown{color:white;font-size:12px;text-align:left;}
.m_rightInfo{position:absolute;right:10px;}
.m_rightTop{color:white;font-size:52px;text-align:right;}
.m_rightTop span{font-size:39px;}
.l_leftInfo{position:absolute;left:20px;}
.l_leftTop{color:white;font-size:28px;text-align:left;}
.l_leftTop span{font-size:20px;}
.l_leftDown{color:white;font-size:14px;text-align:left;}
.l_rightInfo{position:absolute;right:10px;}
.l_rightTop{color:white;font-size:32px;text-align:right;}
.l_rightTop span{font-size:20px;}
.l_rightDown{color:white;font-size:14px;text-align:right;}
#lightBack{position:absolute;width:500px;height:505px;z-index:100;left:0px;top:0px;background-color:#4c4c4c;opacity:0.34;display:none;}
.G_smallShadow{-webkit-box-shadow:2px 2px 4px #DDDDDD;-moz-box-shadow:2px 2px 4px #DDDDDD;box-shadow:2px 2px 4px #DDDDDD;}
.G_SpaceRow{height:26px;}
.G_percent{float:right;color:#FFFFFF;font-size:44px;position:absolute;right:0px;line-height:61px;top:3px;padding-right:10px;}
.G_mapMark{position:relative;float:right;top:19px;right:40px;width:100px}
.G_floatBarLabel{position:absolute;float:left;width:148px;height:45px;font-size:18px;color:white;text-align:center;}
.G_labelLeftText{float:left;width:90px;padding-top:8px;}
.G_labelLeftText span{font-size:12px;}
.G_labelRightText{float:right;width:54px;padding-top:8px;}
.G_sPercent{float:right;padding-right:10px;position:relative;}
.G_sPercentUp{color:#FFFFFF;font-size:34px;text-align:right;margin-top:3px;}
.G_sPercentDown{color:#FFFFFF;font-size:18px;text-align:right;margin-top:-8px;}
.G_sPercentDown span{font-size:12px;}


.G_barLeftText{width:200px;position:absolute;float:left;padding-left:10px;}
.G_statusTitle{color:white;font-size:24px;padding-top:10px;}
.G_statusValue{color:white;font-size:18px;}
.G_statusValue span{font-size:12px;}
.G_smallText{font-size:12px;color:#808080;}
.G_middleGreenText{font-size:14px;color:#5aa701;}
.G_unselect{-moz-user-select:none;-khtml-user-select:none;user-select:none;cursor:default;}
.G_labelGreen{color:#66bd00;background:url(../images/mark_green.png) no-repeat;height:18px;line-height:15px;font-size:14px;padding-left:15px}
.G_labelGray{color:#bfbfbf;background:url(../images/mark_gray.png) no-repeat;height:18px;line-height:15px;font-size:14px;padding-left:15px}
.G_labelOrange{color:#ffa200;background:url(../images/mark_orange.png) no-repeat;height:18px;line-height:15px;font-size:14px;padding-left:15px}
.G_labelBlue{color:#00c0ff;background:url(../images/mark_blue.png) no-repeat;height:18px;line-height:15px;font-size:14px;padding-left:15px}


#Frame_userInfo{position:relative;height:62px;width:1000px;background:url(../images/back_userinfo.png)}
#Frame_myStatus{position:relative;height:107px;width:1000px;}
#Frame_ACT{height:417px;position:relative;}
#Frame_SLP{height:417px;position:relative;}
#Frame_FRI{position:relative;height:610px }

#Frame_TMP{height:271px;position:relative;background:url(../images/back_temp.png)}
#Frame_goalSetup{width:304px;height:430px;position:absolute;z-index:200}
#Frame_calendar{position:absolute;width:218px;height:220px;left:776px;top:172px;z-index:9;display:none;}
#Frame_search{
	position: absolute;
	width: 613px;
	height: 371px;
	left: 100px;
	top: 135px;
	z-index: 103;
	display: none;
}
#Frame_addMore{font-size:24px;color:#666666;text-align:center;line-height:67px;font-weight:lighter;background:url(../images/back_addnew.png)}
#ACT{position:absolute;left:55px;top:42px;width:890px;height:147px;}
#ACT_calRecomm{color:white;font-size:13px;text-align:center;position:absolute;width:400px;left:220px;top:40px;display:none;}
#m_proStep{position:relative;left:13px;top:10px;}
#m_proMile{position:relative;left:13px;top:10px;}
#Back_l_proBarCal{
	position: absolute;
	left: 34px;
	top: 205px;
	display: block;
	height: 91px;
	width: 934px;
}
#Back_m_proStep{
	position: absolute;
	left: 505px;
	top: 299px;
	display: block;
	height: 91px;
	width: 463px;
}
#Back_m_proMile{
	position: absolute;
	left: 34px;
	top: 299px;
	display: block;
	height: 91px;
	width: 463px;
}
.barBack_1{
	background: url(../images/actbar_backb.png) no-repeat;
}
.barBack_2{
	background: url(../images/actbar_backs.png) no-repeat;
}
.barBack_3{
	background: url(../images/actbar_backs.png) no-repeat;
}
#SLP{position:absolute;left:55px;top:42px;width:890px;height:147px;}
#l_proBarSlp{width:909px;position:absolute;left:46px;top:216px;height:66px;}
#SLP_info{
	width: 860px;
	position: absolute;
	left: 70px;
	top: 305px;
	height: 100px;
}

#SLP_info div{float:left;}
.SLP_infoText{padding-left:30px;color:#9c9c9c;font-size:14px;}
.SLP_infoText span{color:#00c0ff;font-size:28px;}
.SLP_infoText span span{font-size:20px;}
.SLP_timeText{color:#9c9c9c;font-size:14px;}
.FriItem {float:left; width:397px; height:156px; margin-left:50px; margin-right:30px;}
#FRI_pagelist { position:relative; text-align:center; padding-top:40px; padding-bottom:30px;}
#INFO_head{position:absolute;top:6px;left:20px;width:50px;height:50px;background:url(../images/avatar.gif); cursor:pointer}
#INFO_name{
	font-size: 18px;
	color: #9c9c9c;
	width: 100px;
	position: absolute;
	left: 71px;
	top: 14px;
}
#INFO_moreInfo{position:absolute;left:74px;top:38px;}
#INFO_upperDate{
	position: absolute;
	left: 950px;
	top: 6px;
	width: 45px;
	height: 38px;
	background: url(../images/calc_icon_back.png) no-repeat;
	font-size: 14px;
	text-align: center;
	line-height: 13px;
	color: #9c9c9c;
	font-weight: bold;
	padding-top: 12px;
	cursor: pointer;
}
#INFO_upperDate span{font-size:10px;text-align:center}
#INFO_arrowL{
	position: absolute;
	left: 190px;
	top: 28px;
	cursor: pointer;display:none;
}
#INFO_arrowR{
	position: absolute;
	left: 290px;
	top: 28px;
	cursor: pointer;display:none;
}
#INFO_sensorIcon{
	position: absolute;
	left: 200px;
	top: 11px;
}
#INFO_sensorStation{
	position: absolute;
	left: 220px;
	top: 9px;
	font-size: 13px;
	color: #66bd00;
}
#INFO_sensorStation span{font-size:11px;color:#5c5c5c;}
#INFO_sep1{position:absolute;left:183px;top:11px;}
#INFO_sep2{
	position: absolute;
	left: 350px;
	top: 10px;
}
#INFO_warGroup{
	position: absolute;
	left: 355px;
	top: 10px;
}
.INFO_warIcon{float:left;width:55px;cursor:pointer;}
#INFO_numGroup{
	position: absolute;
	left: 374px;
	top: 5px;
}
.INFO_warNum{width:25px;height:25px;color:white;font-size:12px;line-height:23px;text-align:center;font-weight:bold;background:url(../images/war_back.png) no-repeat;padding-right:30px;float:left;}

#ACT_cal .ui-progressbar-value{height:100%;background-color:#63be00;}
#ACT_steps .ui-progressbar-value{height:100%;background-color:#63be00;}
#ACT_miles .ui-progressbar-value{height:100%;background-color:#63be00;}
#ACT_loading{position:absolute;width:300px;height:100px;background-color:#DDFFE2;left:324px;top:34px;display:none;}
#ACT_loading div{position:relative;float:left;}
#SLP_loading{position:absolute;width:300px;height:100px;background-color:#DDFFE2;left:324px;top:34px;display:none;}
#SLP_loading div{position:relative;float:left;}
#TMP_loading{position:absolute;width:300px;height:100px;background-color:#DDFFE2;left:324px;top:34px;display:none;}
#TMP_loading div{position:relative;float:left;}
#FAM_loading{position:absolute;width:300px;height:100px;background-color:#DDFFE2;left:324px;top:34px;display:none;}
#FAM_loading div{position:relative;float:left;}
#TMP{position:absolute;left:55px;top:80px;width:890px;height:147px;}
#TMP_leftLabel{font-size:24px;}
.templetes{display:none}
#GOA_close{position:absolute;width:14;height:14;z-index:1;left:283px;top:6px;cursor:pointer;}
#search_close{
	position: absolute;
	width: 23px;
	height: 23px;
	z-index: 1;
	left: 580px;
	top: 6px;
	cursor: pointer;
}
.areaFrame{width:1000px;}
.showArea{}
.s_proBar{position:relative;left:18px;top:33px;width:279px;height:50px;}
.l_proBar{
	position: relative;
	left: 13px;
	width: 909px;
	height: 66px;
}
.m_proBar{position:relative;width:438px;height:66px;}
.tapAreaItem{width:316px;height:120px;float:left;cursor:pointer;}
#spar{width:1px;float:left;}
#tapArea{height:110px;top:84px;}
#coverWhiteACT{width:317px;height:5px;left:0px;top:-1px;position:relative;z-index:8;background:white;}
#coverWhiteSLP{width:317px;height:5px;left:319px;top:-1px;position:relative;z-index:8;background:white;}
#coverWhiteFRI{width:317px;height:5px;left:637px;top:-1px;position:relative;z-index:8;background:white;}
#l_proBarCal{
	cursor: pointer;position: relative;top: 10px;
}
.tapUnselect{background:url(../images/back_unselect.png)}
.mainContent{background:url(../images/back_maincontent.png);}
.friendContent{background:url(../images/fri_areaback.jpg);}
.friendItemAreaAct{ background:url(../images/war_act.png) no-repeat left; }
.friTextPosition{text-align:right; padding-right:10px;  letter-spacing:-2px;}
.friendItemAreaSlp{ background:url(../images/war_slp.png) no-repeat left; }
.friItemNum{ font-weight:bold; font-size:52px;}
.friItemPer{ font-size:30px;}
.friName{font-size:18px;color:#808080; line-height:20px; padding-left:10px}
.friLabNum{font-size:39px;color:#66bd00;}
.friLabPer{font-size:19px;color:#66bd00;}
.friLabName{font-size:14px; color:#6b787e;}
.friBar{ margin-left:10px;width:112px;height:20px; background-color:#d3d3d3}
.headback {width:96px;height:96px; background:#e0e0e0; padding:4px;}
.headpic {width:96px;height:96px; background:#CCC }
.pictable{ padding-left:8px;}
.friItemBot{background:#d1d1d1;}
.friOverItem{ background:url(../images/fri_itemback.jpg) repeat-x top}
.FriBack {width:300px; height:156px; position:relative}
.downButton{cursor:pointer}
.arrowMouse {}
#INFO_popup{
	position: absolute;
	left: 400px;
	top: -5px;
	background: url(../images/icon_pop.png);
	width: 218px;
	height: 70px;
	padding-top: 14px;display:none;
}
#INFO_popup div{ position:relative; float:left; margin-left:30px; width:160px; }

#INFO_title { font-size:18px;color:#ff9900}
#INFO_detail { padding-top:2px; font-size:12px; line-height:14px; color:#666};
.G_time{position:absolute;height:23px; background-color:#0C9}
.G_time div{font-size:13px;color:#a2a2a2;width:72px;position:absolute;padding-top:10px;background:url(../images/time_bar.gif) left top no-repeat;}

.G_eContent { height:30px;}
.G_ebar {top:13px; height:4px; background:#bfbfbf;left:13px; width:864px; position:relative;z-index:10}
.G_iconbar {top:0px; height:4px; background:#bfbf00;left:13px; width:864px; position:relative}
.ext_iconItem {position:absolute; height:4px}
.ext_actItem {position:absolute; height:4px}
#setupGoal {
	position: absolute;
	width: 90px;
	height: 24px;
	z-index: 40;
	left: 18px;
	top: 13px;
	font-size: 14px;
	color: #aaa;
}
#INFO_message {
	position: absolute;
	left: 684px;
	top: 25px;
	width: 160px;
	font-size: 13px;
	color: #FF9900;
}
#INFO_msgIcon{
	position: absolute;
	left: 644px;
	top: 15px;
	width: 34px;
	height: 34px;
	background: url(../images/war_message.png);display:none
}
#MSG_popup{
	position: absolute;
	left: 532px;
	top: 45px;
	width: 273px;
	height: 270px;
	z-index: 30;
}
#extInfoBox{
	position: absolute;
	left: 67px;
	top: 62px;
	width: 212px;
	height: 70px; padding:5px; line-height:20px;
	z-index: 150;display:none; font-size:12px;color:white
}

.divPos {position:absolute; }
.cur { cursor:pointer}
.bigitem { position:absolute;  z-index:50}
.smallItem { position:absolute;  z-index:49}
#itemContainer {
	position: absolute;
	z-index: 100;
	left: 28px;
	top: 101px;
	width: 136px;
	height: 107px;
}
#FRI_lable {font-size:24px; color:#bebebe; width:100% ;height:100%; line-height:120px; text-align:
center}
#SLP_lable {font-size:24px; color:#bebebe; width:100% ;height:100%; line-height:120px; text-align:
center}
#s_proBarFri td {padding-left:3px; padding-right:3px;}

#ui-datepicker-div{ font-size: 12px;}
.space_td {width:1px; background:url(../images/spare_bar.jpg)}
input {text-align:center; border:none}

#changeSlpTime { font-size:12px}
#mainFamily{width:900px;height:600px; position:absolute; left:50px}
#addFamily {
	position: absolute;
	left: 855px;
	top: 31px;
	width: 80px;
	height: 80px;
	background: url(../images/family_add.png); cursor:pointer;
}
#percentageType{
	position: absolute;
	width: 101px;
	left: 70px;
	top: 41px;
}
.familyPercentTypeMenu {padding-left:2px;
	font-size:14px; line-height:26px;
	color:#6a6a6a;}
</style>
<link rel="stylesheet" href="../js/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css" />
<link rel="stylesheet" href="../css/jquery.ui.timepicker.css" type="text/css" />
<style type="text/css">
.FAM_bigInfo {	font-size: 30px;
	line-height: 45px;text-align:center;color:#6a6a6a;
}
#FAM_cname {color:#6a6a6a; font-size:16px}
#FAM_confirm {	position: absolute;
	height: 41px;
	width: 150px;
	left: 208px;
	top: 246px;}
#FAM_confirmRemove {
	position: absolute;
	width: 566px;
	height: 322px;
	left: 159px;
	top: 169px; background:#f2f2f2;
}
#FAM_info {	position: absolute;
	width: 470px;
	height: 222px;
	left: 43px;
	top: 27px;	
}
#confirm_close {	position: absolute;
	width: 23px;
	height: 23px;
	left: 526px;
	top: 12px;	
}
#FAM_cenLabel{
	width: 200px;
	color: #6a6a6a;
	font-size: 16px;
	width: 200px;
	left: 400px;
	top: 440px;
	text-align: center
}

</style>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7840951-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7840951-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
var LANG="cn";
</script>

<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>


    <script type="text/javascript" src="../js/ui-1.10.0/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="../js/ui-1.10.0/jquery.ui.tabs.min.js"></script>
    <script type="text/javascript" src="../js/ui-1.10.0/jquery.ui.position.min.js"></script>

    <script type="text/javascript" src="../js/jquery.ui.timepicker.js"></script>

 

<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="../js/excanvas.js"></script>
<script type="text/javascript" src="../js/jcanvas.min.js"></script>
<script type="text/javascript" src="../js/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="../js/ledo.chart.js"></script>
<script type="text/javascript" src="../js/gs/TweenLite.min.js"></script>
<script type="text/javascript" src="../js/senseu.js"></script>



</head>

<body onload="MM_preloadImages('../images/activity_label_0.png','../images/activity_label_1.png','../images/activity_label_2.png','../images/sleep_label_0.png','../images/sleep_label_1.png','../images/sleep_label_2.png')">

<!-- Hidden Templetes -->
<div id="templetes" class="templetes" >
	<div class="templetes timebar">
	</div>
    <div class="sleep_wakeup" id="sleep_wakeup"><div id="wakeup1">Wake up</div></div>
</div>
<!----- end templete -->



<div id="main">

  
  <div class="G_bigRoundShadow" id="Frame_userInfo">
          <!-------my status -->
    
  	<div id="INFO_head" class="G_smallRound"><img width=50 height=50 /></div>
    <div id="INFO_name"></div>
    <div id="INFO_moreInfo" class="G_smallText"></div>
        <div id="INFO_upperDate" class="G_unselect"></div>
         
        <div id="INFO_arrowL"><img src="../images/arrow_l.png" /></div>
        <div id="INFO_arrowR"><img src="../images/arrow_r.png" /></div>
        <div id="INFO_sensorIcon"><img src="../images/sensor0000.png" /></div>
        <div id="INFO_sensorStation"></div>
        <div id="INFO_warGroup"></div>
    <div id="INFO_numGroup"></div> 

        <div id="INFO_msgIcon"></div>
        <div id="INFO_message" class="downButton"></div>
        <div id="INFO_sep1"><img src="../images/seprate_bar.gif" /></div>
    <div id="INFO_sep2"><img src="../images/seprate_bar.gif" /></div>
        <div id="INFO_popup">
       	  <div id="INFO_title"></div><div id="INFO_detail"></div>
        </div>
        
    <div id="MSG_popup" class="templetes"><iframe id="MSG_iframe" width="273" height="270" allowtransparency="true" scrolling="no" src="empty.html" frameborder="0" ></iframe></div>
  </div>
    <div class="G_SpaceRow">&nbsp;</div>

<div id="Frame_myStatus" class="showArea">
    <div class="tapAreaItem G_tabRound" id="tabACT">
    	<div class="G_smallRound G_smallShadow s_proBar" id="s_proBarAct"></div>
	</div><div id="spar">&nbsp;</div>
    <div class="tapAreaItem G_tabRound"  id="tabSLP">
    	<div id="SLP_lable">睡眠</div>
        <div class="G_smallRound G_smallShadow s_proBar templetes" id="s_proBarSlp"></div>
	</div>
     <div class="tapAreaItem G_tabRound"  id="tabFRI">
     	<div id="FRI_lable" >家庭</div>
        
        <div class="s_proBar templetes" id="s_proBarFri"></div>
     </div>
</div> 
 <div id="Frame_calendar" class="G_smallRound G_smallShadow"><iframe width=218 height=224 allowtransparency="true" frameborder="0" scrolling="no" src="" id="IFRAME_calc"></iframe></div>  
  <div id="Frame_search"><iframe width=613 height=371 allowtransparency="true" frameborder="0" scrolling="no" id="IFRAME_search" src="search.php"></iframe> </div> 
     
<div id="Frame_goalSetup" class="templetes">
<iframe width=304 height=486 allowtransparency="true" frameborder="0" scrolling="no" src="" id="IFRAME_goalSetup"></iframe>
   
</div>   
  <!-- Activity 数据区-->
  <div class="G_bigRoundShadowSpc mainContent" id="Frame_ACT">
 
 <div class="downButton" id="setupGoal"><img src="../images/act_setup.png" width="16" height="16" />设置</div>
	<div id="coverWhiteACT"></div>
   	<div class="G_mapMark"><div class="G_labelGreen">有效</div><div class="G_labelGray">无效</div></div>
        
    
    <!-- 以下为activity数据显示区-->
    <div id="ACT"><canvas id="ACT_can" width=890 height=114></canvas></div>
        
        <!---卡路里区-->
    <div id="Back_l_proBarCal">
    <div  class="G_smallRound G_smallShadow l_proBar"  id="l_proBarCal"></div></div>
    

    
        <!---STEPS区-->
    <div id="Back_m_proStep">
    <div class="G_smallRound G_smallShadow m_proBar downButton" id="m_proStep"></div>
    </div>
      <!---MILES区-->
    <div id="Back_m_proMile">
   	  <div class="G_smallRound G_smallShadow m_proBar downButton" id="m_proMile"></div>
    </div>  
    <!---信息弹出区-->
    <div id="extInfoBox"></div>
      <!-- 旋转图标 -->
    <div id="itemContainer" class="divPos"></div>
     <div id="ACT_loading" class="G_smallRound G_smallShadow"><div style="left:70px; top:34px"><img src="../images/ajax-loader.gif" width="32" height="32" /></div>
  
    
  <div class="G_middleGreenText" style="top:42px;left:80px"> loading, please wait.</div></div>  
  </div>
 
   	
 
     
  <div class="G_bigRoundShadowSpc mainContent" id="Frame_SLP">
    <div id="coverWhiteSLP"></div>
    <div class="G_mapMark"><div class="G_labelBlue">深睡眠</div><div class="G_labelGray">正常睡眠</div></div>
         <!-- 以下为sleep数据显示区-->
       <div id="SLP"><canvas id="SLP_can" width=890 height=114></canvas></div>
       
      <!-- 以下为sleep bar数据显示区-->
      <div class="G_smallRound G_smallShadow l_proBar" id="l_proBarSlp">
			
    </div>
     
     
    <!-- sleep底部信息 -->
    <div id="SLP_info"><table width="860" height=100 border="0" cellpadding="0" cellspacing="0"><tr><td  rowspan="2"  ><table width="200" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td class="SLP_timeText">起始:</td>
        <td align=center><input name="slpFromDay" type="text" id="slpFromDay" style="width:75px" maxlength="10" readonly="readonly" /></td>
        <td height="24" align="right"><input name="slpFromMin" type="text" id="slpFromMin" style="width:50px" maxlength="5" /></td>
      </tr>
      <tr>
        <td class="SLP_timeText">终止:</td>
        <td  align=center><input name="slpToDay" type="text" id="slpToDay"  style="width:75px"  maxlength="10"  readonly="readonly"/></td>
        <td height="24" align="right"><input name="slpToMin" type="text" id="slpToMin"  style="width:50px"  maxlength="5" /></td>
      </tr>
      <tr>
        <td height="24" colspan="3" align="right"><button id="changeSlpTime">提交</button></td>
      </tr>
    </table></td><td height="28" class="space_td"></td><td  class="SLP_infoText">开始睡觉时间</td><td class="space_td"></td><td  class="SLP_infoText">醒来时间</td><td class="space_td"></td><td  class="SLP_infoText">全部睡眠时间</td><td class="space_td"></td><td  class="SLP_infoText">深睡眠时间</td></tr>
    <tr><td height="45" class="space_td"></td><td  class="SLP_infoText" id="SLP_wentBed">&nbsp;</td><td class="space_td"></td><td   id="SLP_wakeUp" class="SLP_infoText">&nbsp;</td><td class="space_td"></td><td id="SLP_wholeSleep" class="SLP_infoText">&nbsp;</td><td class="space_td"></td><td  class="SLP_infoText" id="SLP_deepSleep">&nbsp;</td></tr>
    </table>
   
      </div>
    
	<div id="SLP_loading" class="G_smallRound G_smallShadow"><div style="left:70px; top:34px"><img src="../images/ajax-loader.gif" width="32" height="32" /></div>
  <div class="G_middleGreenText" style="top:42px;left:80px"> loading, please wait.</div></div>

  </div>
    <!---分割线-->
     <!-- Family 数据区-->
     <div class="G_bigRoundShadowSpc friendContent" id="Frame_FRI">
     	<div id="coverWhiteFRI"></div>
     	<div id="mainFamily">
     	  
     	</div>
        <div class="absDiv" id="FAM_cenLabel">家庭目标到达值</div>
        <div id="percentageType">
        <table>
        <tr><td><img src="../images/se_yes.png" id="perCheckImg1" /></td><td><div  class="familyPercentTypeMenu" id="perCheckTxt1" >卡路里</div></td></tr>
        <tr><td><img src="../images/se_no.png" id="perCheckImg2" /></td><td><div  class="familyPercentTypeMenu" id="perCheckTxt2" >距离</div></td></tr>
        <tr><td><img src="../images/se_no.png" id="perCheckImg0" /></td><td><div  class="familyPercentTypeMenu" id="perCheckTxt0" >步数</div></td></tr>
       <!--
       <tr><td><img src="../images/se_no.png" id="perCheckImg3" /></td><td><div  class="familyPercentTypeMenu" id="perCheckTxt3" >睡眠</div></td></tr>
       -->
       <tr><td height=20></td><td></td></tr>
       <tr><td><img src="../images/se_yes.png" id="perPerioImg0" /></td><td><div  class="familyPercentTypeMenu" id="perPerioTxt0" >本日</div></td></tr>
        <tr><td><img src="../images/se_no.png" id="perPerioImg1" /></td><td><div  class="familyPercentTypeMenu" id="perPerioTxt1" >本周</div></td></tr>
        <tr><td><img src="../images/se_no.png" id="perPerioImg2" /></td><td><div  class="familyPercentTypeMenu" id="perPerioTxt2" >本月</div></td></tr>
       
       
       </table></div>
     	<div id="addFamily"><img src="../images/family_add_cover.png" id="familyImg" /></div>
     	<div id="FAM_loading" class="G_smallRound G_smallShadow"><div style="left:70px; top:34px"><img src="../images/ajax-loader.gif" width="32" height="32" /></div>
		
     </div>
     
     <!--
  	<div class="G_bigRoundShadowSpc friendContent" id="Frame_FRI">
    	<div id="coverWhiteFRI"></div>
       <table width=1000 cellpadding="0" cellspacing="0">
       <tr><td colspan=5 height=5></td></tr>
       <tr><td width=60></td><td width=190><img src="../images/fri_add.png" width="190" height="46" id="BTN_search" /></td><td width=5></td><td width="196">&nbsp;</td><td></td></tr>
       <tr><td colspan=5 height=35></td></tr>
       <tr><td colspan=5>
       <div id="FRI_list">
       		
           
            
       </div>
       </td></tr>
        <tr><td colspan=5 height=35 align=center></td></tr>
       </table>
      
      
    	
      	
  	</div>
  	-->
  <div class="G_SpaceRow templetes">&nbsp;</div>
     
     <div class="G_bigRoundShadow templetes" id="Frame_TMP">
       <div class="G_leftLabel" id="TMP_leftLabel">温度</div>
       <div class="G_mapMark">
         <div class="G_labelGreen">正常</div><div class="G_labelOrange">热</div><div class="G_labelGray">冷</div></div>
        <!-- 以下温度数据显示区-->
    <div id="TMP"><canvas id="TMP_can" width=890 height=114></canvas></div>
       
       <div id="TMP_loading" class="G_smallRound G_smallShadow"><div style="left:70px; top:34px"><img src="../images/ajax-loader.gif" width="32" height="32" /></div>
  <div class="G_middleGreenText" style="top:42px;left:80px"> loading, please wait.</div></div>  
       
  </div>
 
 
  
</div>
<div id="lightBack"></div>
<div id="FAM_confirmRemove" class="G_bigRound templetes">
   <div id="FAM_info">
     <table width="100%"><tr><td  align="center" height=70><img src="../images/blank.gif" id="FAM_hideHead" width="70"  height=70/></td></tr>
     	   <tr><td  align="center" ><span id="FAM_cname"></span></td></tr>
     	   <tr><td class="FAM_bigInfo" height="120">是否确定移除此家庭成员?</td></tr></table>
   	</div>
    <div id="FAM_confirm">确定</div>
    <div id="confirm_close"> <img src="../images/pop_closebig.png" width="23" height="23" /></div>
</div>
</body>
</html>


<!--http://www.ajaxload.info/ -->