<?php

$lang="cn";


$frameid=$_REQUEST["frameid"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="../css/main_cn.css" type="text/css" rel="stylesheet" />

<style type="text/css">
.btn{
	height: 41px;
	position: absolute;
	width: 120px;
	left: 85px;
	top: 252px;
}

.blankRow {height:20px; font-size:11px; color:#ff0000; padding-left:10px; vertical-align:top;}
.btnHand {cursor:pointer; color:#0096ff}
.middleFont {font-size:12px;}
.padLeft {padding-left:10px;}
.padLeftMin {padding-left:7px;}
.popInputLongBack {	width:277px;
	height:30px; padding-left:10px;
	background:url(../images/input_back_long.png) no-repeat;
	padding-top:1px;
}
.popUpTable {color:#707070;}
.popupLabel {	font-size:40px; height:44px;
}
.popupLabels{font-size:36px; height:44px;}
.popupLongText {	
	width:248px;
	height:25px;
	line-height:25px;
	border:none;
	background-color:transparent;
	color:#707070; font-size:16px;
	padding-left:5px;
	padding-right:5px
}
.popup_bigBtnBack {position:relative;width:193px;height:40px; background:url(../images/bnt_back.png); cursor:pointer; text-align:center; color:#FFF; line-height:40px; font-size:14px; font-weight:bold;}
.popup_login_bottom {	
	height:9px;
	overflow:hidden;
}
.popup_login_content {
	height:343px;
	overflow:hidden;
}
.popup_login_top {	
	height:10px;
	overflow:hidden;
}
.smallFont {font-size:12px;}
#forgetArea {	width: 368px;
	position: absolute;
	z-index: 4;
	left: 791px;
	top: 0px;
	background: url(../images/regback.jpg);
	
}
#forgetClose {	position:absolute;
	left: 333px;
	top: 9px;
}
#regTable {
	position: absolute;
	left: 50px;
	top: 15px;
	width: 277px;
}
.padCheck {padding-left:5px; height:20px;}
.popInputShortBack {	width:124px;
	height:30px;
	text-align:center;
	background:url(../images/input_back_short.png) no-repeat;
}
.popupShortText {	
	width:114px;
	height:25px;
	line-height:25px;
	border:none;
	padding-right:5px;
	padding-left:5px;
	color:#707070; font-size:16px;
	background-color:transparent
}
#loginArea {
	width: 368px;
	height: 363px;
	position: absolute;
	z-index: 5;
	left: 406px;
	top: 85px;
	background: url(../images/regback.jpg);
	
}
#loginClose {	position:absolute;
	left: 333px;
	top: 9px;
	z-index:10;
}
#regTable2 {
	position: absolute;
	left: 50px;
	top: 15px;
	width: 300px;
}
#regArea {
	width: 368px;
	position: absolute;
	z-index: 4;
	left: 12px;
	top: 20px;
	background: url(../images/regback.jpg);
	
}

#resetArea{
	width: 368px;
	position: absolute;
	z-index: 4;
	left: 200px;
	top: 20px;
	background: url(../images/regback.jpg);
	
}

#regClose {	position:absolute;
	left: 333px;
	top: 9px;
	z-index:10;
}
#resetClose{
	position:absolute;
	left: 333px;
	top: 9px;
	z-index:10;
	
}
#signUpContent {
	position: absolute;
	left: 50px;
	top: 15px;
	width: 300px;
}
#resetContent {
	position: absolute;
	left: 50px;
	top: 15px;
	width: 300px;
}


.hidden {display:none;}
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
var LANG="cn";
</script>
<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.orbit-1.2.3.min.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type='text/javascript' src='../js/reglogin.js'></script>
<script type="text/javascript" src="../js/popupreg.js"></script>
<script type="text/javascript" src="../js/jquery.corner.js"></script>
</head>

<body style="margin:0px">
<div id="forgetArea" class="mainFrame">
  <div class="popup_login_top"></div>
  <div  class="popup_login_content">
    <div id="forgetClose" class="btnHand" ><img src="../images/reg_close.png" width="23" height="23" /></div>
    <div id="regTable">
      <table cellpadding="0" cellspacing="0" class="popUpTable">
        <tr>
          <td  class="popupLabel" id="l_findpass">密码找回</td>
        </tr>
        <tr>
          <td  class="blankRow" ></td>
        </tr>
        <tr>
          <td class="middleFont padLeft" id="find_email">电子邮箱</td>
        </tr>
        <tr>
          <td class="popInputLongBack"><input type="text" class="popupLongText" id="pop_forgetEmail" value="" /></td>
        </tr>
        <tr>
          <td  class="blankRow" id="pop_forgetWrong"></td>
        </tr>
        <tr>
          <td  class="padLeft smallFont" height="92" id="forget_back">输入您注册使用的电子邮箱，我们会发一封邮件用于密码找回</td>
        </tr>
        <tr>
          <td class="blankRow" id="forgetWrongPass"></td>
        </tr>
        <tr>
          <td  height="56"  ><div id="btnForget" class="btn">继续</div><div id="btnClose" class="btn hidden">关闭</div></td>
        </tr>
        <tr>
          <td class="blankRow"></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="popup_login_bottom"></div>
</div>
<div id="loginArea"  class="mainFrame" >
  <div class="popup_login_top"></div>
  <div  class="popup_login_content">
    <div id="loginClose" class="btnHand" ><img src="../images/reg_close.png" width="23" height="23" /></div>
    <div id="regTable2">
      <table width="300" cellpadding="0" cellspacing="0" class="popUpTable">
        <tr>
          <td colspan="5" class="popupLabel" id="l_login">登录</td>
        </tr>
        <tr>
          <td colspan="5" class="blankRow" ></td>
        </tr>
        <tr>
          <td colspan="5" class="middleFont padLeft" id="login_email">电子邮箱</td>
        </tr>
        <tr>
          <td colspan="5" class="popInputLongBack"><input type="text" class="popupLongText" id="pop_loginEmail" /></td>
        </tr>
        <tr>
          <td colspan="5" class="blankRow" id="loginWrongEmail"></td>
        </tr>
        <tr>
          <td width="10" ></td>
          <td width="124" class="middleFont" id="login_pass">密码</td>
          <td width="7" >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td  ></td>
          <td  class="popInputShortBack" ><input type="password" class="popupShortText" id="pop_loginPass" value=""/></td>
          <td  >&nbsp;</td>
          <td  class="smallFont" width="124" colspan="3" ><span onclick="showForget()" class="btnHand" id="forgetpass">忘记密码?</span></td>
         
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td colspan="5" class="blankRow" id="loginWrongPass"></td>
        </tr>
        <tr>
          <td colspan="5" class="padCheck smallFont"><table cellpadding="0" cellspacing="0">
            <tr>
              <td><input type="checkbox" id="saveEmailCookies" name="saveEmailCookies" value=""  class="pop_input"/></td>
              <td class="middleFont" id="keepEmail">在此计算机上保留电子邮箱地址</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="5" class="blankRow" id="pop_loginWrong"></td>
        </tr>
        <tr>
          <td colspan="5" height="56"  ><div id="pop_btnLogin"  class="btn">提交</div></td>
        </tr>
        <tr>
          <td colspan="5" height=10></td>
        </tr>
        <tr >
          <td colspan="5"  class="padCheck smallFont"><span id="noJoin">还不是我们的一员?</span> <span class="btnHand" id="loginToSignUp">现在加入</span></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="popup_login_bottom"></div>
</div>
<div id="regArea" class="mainFrame">
  <div class="popup_login_top"></div>
  <div  class="popup_login_content">
    <div id="regClose" class="btnHand" ><img src="../images/reg_close.png" width="23" height="23" /></div>
    <div id="signUpContent">
      <table cellpadding="0" cellspacing="0" class="popUpTable">
        <tr>
          <td colspan="5" class="popupLabel" id="l_reg">注册</td>
        </tr>
        <tr>
          <td colspan="5" class="blankRow"></td>
        </tr>
        <tr>
          <td colspan="5" class="middleFont padLeft" id="reg_email">电子邮箱</td>
        </tr>
        <tr>
          <td colspan="5" class="popInputLongBack"><input type="text" class="popupLongText" id="signInputEmail" maxlength="50" /></td>
        </tr>
        <tr>
          <td colspan="5" class="blankRow" id="wrongEmail"></td>
        </tr>
        <tr>
          <td width="10" ></td>
          <td width="35" class="middleFont" id="reg_pass">密码</td>
          <td width="7" >&nbsp;</td>
          <td colspan="2" ><span class="middleFont" id="reg_repass">再次输入密码</span></td>
        </tr>
        <tr>
          <td  ></td>
          <td  class="popInputShortBack" ><input type="password" class="popupShortText" id="SignInputPass" value=""/></td>
          <td  >&nbsp;</td>
          <td width="5" class="popInputShortBack" ><input type="password"  class="popupShortText" id="SignReInputPass" value=""/></td>
          <td colspan="2"  >&nbsp;</td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td colspan="5" class="blankRow" id="wrongPass"></td>
        </tr>
        <tr>
          <td colspan="5" class="padCheck smallFont" ><table border="0" cellpadding="0" cellspacing="0" width=100%><tr><td width="20"><input name="agreeSignUp" type="checkbox"  class="pop_input" id="agreeSignUp" value=""/></td>
          <td><span id="reg_agree">我同意</span><span class="btnHand" id="reg_prav">条款和各项条件</span>.</td></tr></table></td>
        </tr> <tr>
          <td colspan="5" class="blankRow" id="pop_regWrong"></td>
        </tr>
        <tr>
          <td colspan="5" height="56"  ><div id="btnSignup" class="btn">提交</div></td>
        </tr>
        <tr>
          <td colspan="5" height=10></td>
        </tr>
        <tr>
          <td colspan="5"  class="padCheck smallFont"><span id="reg_already">已经是我们的一员?</span> <span  class="btnHand" id="signUpToLogin">现在登录</span></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="popup_login_bottom"></div>
</div>

<div id="resetArea" class="mainFrame">
  <div class="popup_login_top"></div>
  <div  class="popup_login_content">
    <div id="resetClose" class="btnHand" ><img src="../images/reg_close.png" width="23" height="23" /></div>
    <div id="resetContent">
      <table cellpadding="0" cellspacing="0" class="popUpTable">
        <tr>
          <td colspan="5" class="popupLabels" id="l_reset">Reset Password</td>
        </tr>
       
        <tr>
          <td colspan="5" height=68 class="middleFont padLeft" id="res_create">Create a new password</td>
        </tr>
        <tr>
          <td colspan="5" class="blankRow"></td>
        </tr>
        <tr>
          <td width="10" ></td>
          <td width="35" class="middleFont" id="res_pass">Password</td>
          <td width="7" >&nbsp;</td>
          <td colspan="2" ><span class="middleFont" id="res_repass">Retype Password</span></td>
        </tr>
        <tr>
          <td  ></td>
          <td  class="popInputShortBack" ><input type="password" class="popupShortText" id="ResetInputPass" value=""/></td>
          <td  >&nbsp;</td>
          <td width="5" class="popInputShortBack" ><input type="password"  class="popupShortText" id="ResetReInputPass" value=""/></td>
          <td colspan="2"  >&nbsp;</td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td colspan="5" class="blankRow" id="wrongResetPass"></td>
        </tr>
        <tr>
          <td colspan="5" class="padCheck smallFont" >&nbsp;</td>
        </tr> <tr>
          <td colspan="5" class="blankRow"></td>
        </tr>
        <tr>
          <td colspan="5" height="40"  ><div id="btnResetPass" class="btn">重设密码</div></td>
        </tr>
        
      </table>
    </div>
  </div>
  <div class="popup_login_bottom"></div>
</div>
<input type="hidden" id="frameid" value="<?php echo $frameid; ?>" />
</body>
</html>
