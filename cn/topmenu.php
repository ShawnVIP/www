<?php
session_start();
$_SESSION['userloginMode']=$_COOKIE['back_userid'];

$lang="cn";




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/main_cn.css" type="text/css" rel="stylesheet" />

<style type="text/css">
.areaFrame {width:1000px;height:112px;}
a:link {color: #777777; text-decoration:none;} //未访问
a:active {color: #777777; } //激活
a:visited {color:#777777;text-decoration:none;} //已访
a:hover {color: #2d2d2d; text-decoration:underline;} //鼠标移  

.blankRow {height:20px; font-size:12px; color:#ff0000; padding-left:10px; vertical-align:top;}
.btnHand {cursor:pointer;}
.up_loginInput {	
	width:124px;
	height:27px;
	line-height:27px;
	border:0;
	color:#cccccc;
	background-color:transparent;
	padding-left:5px;
	padding-right:5px;
}
.up_loginInputBack {	width:136px;
	height:29px;
	text-align:center;
	background:url(../images/inp_bg.png) no-repeat;
	padding-top:1px;
}
.inputArea {position:relative;
	float:right;
	top:5px;
	right:0px;
	text-align:right;
}
#logo {
	width: 120px;
	height: 25px;
	top: 43px;
	left: 10px;
	position: relative;
	cursor: pointer;
}

#textMenu {
	position: absolute;
	right: 135px;
	width: 680px;
	top: 87px;
	left: 321px;
	text-align: right;
	color: #3e3f41;
	height: 21px;
}
.homeMenu{text-align:right; padding-left:70px; color:black; cursor:default;}
.homeMenuBtn{cursor:pointer; color:#868686}
body,td,th {
	font-family: Conv_KlavikaRegular-Plain, Arial, sans-serif;
}

#alreadylogin{display:none}
#newlogin{display:nnone;}
.btn { position:absolute;top:0px}
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
<script type="text/javascript" src="../js/reglogin.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type="text/javascript" src="../js/topmenu.js"></script>
</head>

<body >
<div id="topMenuArea" class="areaFrame">
 
    
  <div class="inputArea" id="newlogin">
      <table cellpadding="0" cellspacing="0" >
        <tr >
          <td width="10" height=31><input type="hidden" value="<?php echo $mode; ?>" id="G_mode" /></td>
          <td  class="up_loginInputBack"><input type="text" id="up_loginEmail" value="email" class="up_loginInput" /></td>
          <td width="6"></td>
          <td class="up_loginInputBack" ><input type="text" id="passwordt" value="password" class="up_loginInput"  />
            <input type="password" id="up_loginPass" value="" class="up_loginInput"  style="display:none" /></td>
          <td width="9"></td>
          <td width="68" align="center"><div id="up_btnLogin" class="btn">登录</div></td>
          <td width="2"></td>
          <td width="78" id="regtable"><div id="reg" class="btn">注册</div></td>
        </tr>
        <tr>
          <td colspan="4" class="blankRow" id="up_loginWrong" align="left"></td>
        </tr>
      </table>
    </div>
     <div class="inputArea" id="alreadylogin">
      <table cellpadding="0" cellspacing="0" >
        <tr>
          <td class="G_smallText" height=31><span id="btn_profile" >我的档案</span></td>
          <td width="10"></td>
          <td class="G_smallText"><span id="btn_Guide">使用指南</span></td>
          <td width="10"></td>
          <td width="78"><div id="logout" class="btn">退出</div></td>
        </tr>
        
      </table>
    </div>
    <div id="logo"><img src="../images/s-logo.png" alt="" width="133" height="44" /></div>
    <div id="textMenu">
      <table cellpadding="0" cellspacing="0" class="upMenu" align=right >
        <tr>
          <td class="homeMenu"><span id="menu1">主页</span></td>
          <td   class="homeMenu"><span id="menu2">SENSE-U</span></td>
          <td  class="homeMenu"><span id="menu3">工作原理</span></td>
          <td  class="homeMenu"><span id="menu4">预购</span></td>
        </tr>
      </table>
  </div>
  </div>


</body>
</html>
