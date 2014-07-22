<?php
$lang="en";
setcookie("lang",$lang);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main</title>
<link href="../css/main_cn.css" type="text/css" rel="stylesheet" />

<style type="text/css">
body {
 margin:0px;
}
#Frame_profileSetup{width:924px; height:545px; position:absolute; z-index:101; background-color:white;display:none}



.G_unselect {-moz-user-select: none;  
            -khtml-user-select: none;  
            user-select: none; cursor:default;		
}

#PRO_close {
	position: absolute;
	width: 23px;
	height: 23px;
	z-index: 1;
	left: 881px;
	top: 19px;
	cursor: pointer;
}
.PRO_inputSmall { width:58px; height:28px; background:url(../images/info_input.png) no-repeat
; }

.PRO_inputSmall input {
	width:50px;
	height:28px;
	line-height:28px;
	border:0;
	color:#6b6b6b;
	background-color:transparent;
	padding-left:5px;
	padding-right:5px;text-align:center;
	
}

.PRO_selectSmall{ width:58px; height:28px; background:url(../images/info_sel_sort.png) no-repeat
;text-align:left;cursor:pointer;}

.PRO_selectSmall input{ 
	width:44px;
	height:28px;
	line-height:28px;
	border:0;
	color:#6b6b6b;
	background-color:transparent;
	text-align:center;
	cursor:pointer;
	
;}

.PRO_selectBig{ width:79px; height:28px; background:url(../images/info_sel_long.png) no-repeat
;text-align:left;cursor:pointer;}

.PRO_selectBig input{ 
	width:64px;
	height:28px;
	line-height:28px;
	border:0;
	color:#c6c6c6;
	background-color:transparent;
	text-align:center;
	cursor:pointer;
	
;}

.PRO_selectLong{ width:200px; height:28px; background:url(../images/info_sel_large.png) no-repeat
;text-align:left;cursor:pointer;}

.PRO_selectLong input{ 
	width:180px;
	height:28px;
	line-height:28px;
	border:0;
	color:#6b6b6b;
	background-color:transparent;
	text-align:left;
	cursor:pointer;
	padding-left:5px
	
;}
.PRO_Label{
	text-align:right;
	padding-right:2px;
	font-size:14px;
	color:#6a6a6a;
}

.PRO_subLabel{
	text-align:left;
	padding-left:2px;
}

#PRO_popup {
	position:absolute;
	z-index:3;
	left: 301px;
	top: 253px;
	
}
.PRO_title{font-size:20px; padding-left:10px; color:#4b4b4b;}
.PRO_menuList{ text-align:left;border:0;BORDER: #b4b4b4 1px solid;}
.PRO_menuList option{height:20px;line-height:20px; text-height:20px; vertical-align:central}
#apDiv2 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:3;
	left: 175px;
	top: 163px;
}
#apDiv3 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:3;
	left: 174px;
	top: 267px;
}
.PRO_clickInput{}
.PRO_clickText{}

#PRO_account {
	position:absolute;
	width:212px;
	height:337px;
	z-index:4;
	left: 35px;
	top: 115px;
}
#PRO_accountTitle {
	position:absolute;
	left: 35px;
	top: 89px;
}
#PRO_infoTitle {
	position:absolute;
	left: 258px;
	top: 89px;
}
#PRO_infoArea {
	
}
#PRO_infoArea td{
	font-size:14px;color:#6a6a6a;
}

#PRO_sensorTitle {
	position:absolute;
	left: 681px;
	top: 89px;
}
#PRO_sensor{
	position:absolute;
	width:205px;
	height:341px;
	z-index:7;
	left: 681px;
	top: 115px;
}
#PRO_submit {
	position: absolute;
	width: 110px;
	height: 41px;
	z-index: 8;
	left: 777px;
	top: 483px;
}
.btnBack2 {background:url(../images/bt_back2.png);}
.btnBack1 {background:url(../images/bt_back1.png); width:192px; height:36px; cursor:pointer;}
.btnBack1 div{float:left; font-size:14px; color:#6c6c6c; font-weight:bold; padding-left:15px; padding-top:9px;}
#PRO_images {
	position:absolute;
	z-index:1;
	left: 12px;
	top: 210px;
}
#PRO_password {
	position:absolute;
	z-index:2;
	left: 12px;
	top: 250px;
}
#PRO_info {
	position:absolute;
	z-index:3;
	left: 12px;
	top: 290px;
}


#apDiv6 {
	position:absolute;
	width:182px;
	height:182px;
	z-index:4;
	left: 16px;
	top: 14px;
	border: solid 1px #dedede;
	background:#f5f5f5;
	//padding:8px;
	overflow:hidden;
}
.PRO_areaBack{background:#efefef;}
#apDiv7 {
	position:relative;
	float:left;
	z-index:1;
	top: 23px;
	left: -1px;
}
.PRO_senList { padding-top:10px;}
.PRO_senList div{ position:relative;}
.PRO_senNO{padding-left:3px;background:url(../images/pro_sen_idback.png) no-repeat left center; width:18px;height:30px;line-height:26px; color:white;font-size:18px; font-weight:bold;}

.PRO_nameBack{background:url(../images/pro_sen_nameback.png) no-repeat; width:122px; height:28px; line-height:28px; color:#6b6b6b; text-align:center; font-size:12px;}
#apDiv8 {
	position:absolute;
	z-index:2;
	left: -1px;
	top: 86px;
	display:none;
}
#apDiv9 {
	position:absolute;
	z-index:3;
	left: -1px;
	top: 149px;
	display:none;
}
#PRO_bigTitle {
	position:absolute;
	z-index:9;
	font-size:38px;
	color:#6dbf0d;
	left: 33px;
	top: 30px;
}

.PRO_mainInfo {
	position:absolute;
	width:389px;
	height:320px;
	z-index:2;
	left: 259px;
	top: 115px;
	padding:10px 10px 10px 10px;
	display:block;
}
#PRO_passwordArea {
	display:none;
}

#PRO_imagesArea { 
    display:none;
}

.blankRow{ font-size:12px; color:#ff0000; height:20px; width:170px}

#errInfo {
	position: absolute;
	width: 274px;
	height: 26px;
	z-index: 10;
	left: 493px;
	top: 492px;
	font-size: 13px;
	color: red;
	text-align: right;
}
#PRO_reply {display:none;}
.PRO_senNameBack{width:122px; height:28px; background:url(../images/pro_sen_nameback.png) no-repeat}

.PRO_senNameBack input {
	width:110px;
	height:24px;
	line-height:24px;
	border:0;
	color:#6b6b6b;
	background-color:transparent;
	padding-left:5px;
	padding-right:5px;text-align:center;
	
}
#PRO_titleBack{width:924px;height:63px; background:url(../images/title_back.jpg) repeat-x; position:absolute}
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
var LANG="<?php echo $lang; ?>";
</script>
<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>

<script type="text/javascript" src="../js/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type='text/javascript' src='../js/reglogin.js'></script>
<script type="text/javascript" src="../js/profile.js"></script>


</head>

<body >

<div id="Frame_profileSetup" class="G_bigRound">
  
  <div id="PRO_infoArea" class="PRO_areaBack PRO_mainInfo">
    <table width=100% cellpadding="0" cellspacing="0"><tr><td height=14 ></td></tr>

     <tr><td height=48> <table cellpadding="0" cellspacing="0"><tr> <td width=80  class="PRO_Label" id="pname">Name:</td>
       <td width=173 class="PRO_senNameBack">
    <input type="text" id="PRO_userName" maxlength="8" /></td><td width=40 class="PRO_Label" id="pmale">Male</td><td><img  id="INFO_sex0" src="../images/se_yes.png" /></td><td width=60 class="PRO_Label" id="pfemale">Female</td><td><img  id="INFO_sex1" src="../images/se_no.png" /></td></tr></table></td></tr>
     <tr><td align="center"><img src="../images/info_line.png" /></td></tr>
     <tr><td height=48><table cellpadding="0" cellspacing="0"><tr><td width=80 class="PRO_Label" id="pheight">Height:</td><td width=58 class="PRO_inputSmall PRO_clickText" id="h_v1"><input class="PRO_inputNumber" type="text" id="PRO_h1" value="" /></td>
     <td width=40 class="PRO_subLabel" id="h_u1">cm</td><td width=58 class="PRO_inputSmall PRO_clickText" id="h_v2"><input type="text" id="PRO_h2" value=""  class="PRO_inputNumber"/></td><td width="50" class="PRO_subLabel" id="h_u2">inches</td><td width=58 class="PRO_selectSmall PRO_clickInput">
    <input type="text" id="PRO_hUnit" value="cm" readonly="readonly"/>
     </td></tr></table></td></tr>
     <tr><td height=48><table cellpadding="0" cellspacing="0"><tr>
       <td width=80 class="PRO_Label" id="pweight">Weight:</td>
       <td width=58 class="PRO_inputSmall PRO_clickText"><input type="text" id="PRO_w" value=""  class="PRO_inputNumber" /></td>
       <td width=152 class="PRO_subLabel" id="w_u">kg</td>
       <td width=58 class="PRO_selectSmall PRO_clickInput">
    <input type="text" id="PRO_wUnit" value="kg" readonly="readonly" />
     </td></tr></table></td></tr>
       <tr><td align="center"><img src="../images/info_line.png" /></td></tr>
       <tr><td height=48><table cellpadding="0" cellspacing="0"><tr>
       <td width=80 class="PRO_Label" id="pdob">Brthday:</td>
       <td width=79 class="PRO_selectBig PRO_clickInput">
    <input type="text" id="PRO_month" value="Month" readonly="readonly"  /></td><td width=19>&nbsp;</td>
       <td width=79 class="PRO_selectBig PRO_clickInput">
    <input type="text" id="PRO_day" value="Day" readonly="readonly" /></td><td width=19>&nbsp;</td>
       <td width=79 class="PRO_selectBig PRO_clickInput">
    <input type="text" id="PRO_year" value="Year" readonly="readonly" /></td></tr></table></td></tr>
        <tr><td height=48><table cellpadding="0" cellspacing="0"><tr>
          <td width=80 class="PRO_Label" id="swidth">Step Width:</td>
          <td width=58 class="PRO_inputSmall PRO_clickText" id="s_v1"><input type="text" id="PRO_s1" value="" class="PRO_inputNumber" /></td>
          <td width=40 class="PRO_subLabel" id="s_u1">cm</td><td width=58 class="PRO_inputSmall PRO_clickText" id="s_v2"><input type="text" id="PRO_s2" value="" class="PRO_inputNumber" /></td><td width="50" class="PRO_subLabel" id="s_u2">inches</td><td width=58 class="PRO_selectSmall PRO_clickInput">
    <input type="text" id="PRO_sUnit" value="cm" readonly="readonly"/>
     </td></tr></table></td></tr>
           <tr><td align="center"><img src="../images/info_line.png" /></td></tr>
            <tr><td height=48><table cellpadding="0" cellspacing="0"><tr>
       <td width=80  class="PRO_Label" id="tzone">Timezone:</td>
       <td width=273  id="PRO_timeZone"></td>
      </tr></table><input type="hidden" id="tempH" value="0" /><input type="hidden" id="tempW" value="0" /><input type="hidden" id="tempS" value="0" /><input type="hidden" id="userid" value="<?php echo $userid; ?>" /><input type="hidden" id="unit" value="Metric" /><input type="hidden" id="gender" value="M" /></td></tr>
       
    </table>
    <div id="PRO_popup">
       <select name="PRO_sel" id='PRO_sel' size="5" class="PRO_menuList">

       </select>
    </div>  
  </div>
  <div id="PRO_accountTitle" class="PRO_title">Account Settings</div>
  <div id="PRO_account" class="PRO_areaBack">
    <div id="PRO_images" class="btnBack1">
      <div><img src="../images/bt_s1.png" /></div>
      <div id="cimage">Change Image</div></div>
    <div id="PRO_password" class="btnBack1"><div><img src="../images/bt_s2.png" /></div>
    <div id="cpass">Change Password</div></div>
    <div id="PRO_info" class="btnBack1"><div><img src="../images/bt_s3.png"/></div><div id="pinfo">Personal Info</div></div>
   <!------缩略图显示窗�---->
    <div id="apDiv6">
   		<div id="Pro_headDiv" style="border:1px #e5e5e5 solid; position:absolute;">
		<img  id="Pro_head" src="../images/blank.gif" style="position: relative;" /> </div>
     </div>       
  </div>
  <div id="PRO_infoTitle" class="PRO_title">Personal Info</div>
  <div id="PRO_sensorTitle" class="PRO_title">Sensor Settings</div>
  <div id="PRO_sensor"  class="PRO_areaBack">
  
    
  </div>
  <div id="PRO_submit">Submit</div>
  <div id="errInfo" ></div>
  <div id="PRO_reply" class="PRO_areaBack PRO_mainInfo"><table width=100% height=100%><tr><td align=center id="PRO_replyInfo">sucess full</td></tr></table></div>
  
  <div id="PRO_bigTitle">MY PROFILE</div>
  <div id="PRO_close"><img src="../images/pop_closebig.png" width="23" height="23" /></div>
  <div id="PRO_passwordArea"  class="PRO_areaBack PRO_mainInfo">
  <table align=center><tr><td colspan=3 height=80></td></tr>
  <tr>
    <td class="PRO_Label" id="change_c">Current Password:</td><td class="PRO_senNameBack"><input id="PRO_curPass" type="password" /></td><td></td></tr>
  <tr><td >&nbsp;</td>
  <td class="blankRow" colspan=2 id="er_1">&nbsp;</td></tr>
  <tr><td class="PRO_Label" id="change_n">New Password:</td><td   class="PRO_senNameBack"><input id="PRO_newPass" type="password" /></td><td></td></tr>
  <tr>
    <td>&nbsp;</td>
    <td class="blankRow" colspan=2 id="er_2">&nbsp;</td></tr>
  <tr><td class="PRO_Label" id="change_r">Retype New Password:</td><td  class="PRO_senNameBack"><input id="PRO_rePass" type="password" /></td><td></td></tr><tr>
    <td >&nbsp;</td>
    <td class="blankRow" colspan=2 id="er_3">&nbsp;</td></tr>
  </table>
  </div>
  <div id="PRO_imagesArea"  class="PRO_areaBack PRO_mainInfo"> <iframe width=389 height=320 allowtransparency="true" frameborder="0" scrolling="no"  id="IFRAME_upload" ></iframe></div>
 
</div>

</body>
</html>

<!--http://www.ajaxload.info/ -->