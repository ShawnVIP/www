<?php 

$lang="cn";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>setup</title>
<link href="../css/main_cn.css" type="text/css" rel="stylesheet" />


<style type="text/css">
body {
 margin:0px;
	
}
.tieleText{font-size:14px; color:#85bd4f; font-weight:bold;}
.unitText{font-size:14px; color:#85bd4f;}
#mainFrame {
	position: absolute;
	width: 304px;
	height: 486px;
	background: url(../images/goalsetup_back.gif);
	z-index: 1;
	left: 0px;
	top: 0px;
	display:block;
}
#PRO_bigTitle {
	position:absolute;
	z-index:9;
	font-size:38px;
	color:#6dbf0d;
	left: 33px;
	top: 30px;
}
#G_tditle1 {
	position: absolute;
	width: 148px;
	height: 20px;
	z-index: 10;
	left: 37px;
	top: 92px;
}
#G_tditle2 {
	position: absolute;
	width: 148px;
	height: 20px;
	z-index: 10;
	left: 37px;
	top: 185px;
}
#G_tditle3 {
	position: absolute;
	width: 148px;
	height: 20px;
	z-index: 10;
	left: 37px;
	top: 277px;
}
#G_tditle4 {
	position: absolute;
	width: 148px;
	height: 20px;
	z-index: 10;
	left: 37px;
	top: 362px;
}

#u1 {
	position: absolute;
	width: 46px;
	height: 20px;
	z-index: 10;
	left: 250px;
	top: 136px;
}
#u2 {
	position: absolute;
	width: 46px;
	height: 20px;
	z-index: 10;
	left: 250px;
	top: 229px;
}
#u3 {
	position: absolute;
	width: 46px;
	height: 20px;
	z-index: 10;
	left: 250px;
	top: 322px;
}

.PRO_senNameBack {width:208px; height:40px;}
.PRO_senNameBack input {
	width:208px;
	height:40px;
	line-height:28px;
	font-size:30px;
	border:0;
	color:#bfbfbf;
	background-color:transparent;
	padding-left:5px;
	padding-right:5px;text-align:center;
	
}
#v1 {
	position: absolute;
	width: 208px;
	height: 40px;
	z-index: 11;
	left: 37px;
	top: 117px;
}
#v2 {
	position: absolute;
	width: 208px;
	height: 40px;
	z-index: 11;
	left: 37px;
	top: 210px;
}
#v3 {position: absolute;
	width: 208px;
	height: 40px;
	z-index: 11;
	left: 37px;
	top: 300px;
}
#PRO_submit{
	position: absolute;
	width: 110px;
	height: 41px;
	left: 93px;
	top: 428px;
}
#PRO_close{
	position: absolute;
	width: 23px;
	height: 23px;
	z-index: 1;
	left: 263px;
	top: 20px;
	cursor: pointer;
}
#PRO_defalutShow{
	position: absolute;
	left: 32px;
	top: 388px;
	width: 264px;
	height: 29px
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
var LANG="cn";
</script>
<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type='text/javascript' src='../js/reglogin.js'></script>
<script type='text/javascript' src='../js/calsetup.js'></script>

</head>

<body>
<div id="mainFrame" class="G_bigRound">
 
  <div id="PRO_bigTitle">Goal Settings</div>
  
  <div id="G_tditle1" class="tieleText">Daily Steps Goal:</div>
  <div id="G_tditle2" class="tieleText">Daily Distance Goal:</div>
  <div id="G_tditle3" class="tieleText">Daily Calories Goal:</div>
  <div id="u1" class="unitText">steps</div>
  <div id="u2" class="unitText">km</div>
  <div id="u3" class="unitText">cal</div>
  <div id="v1" class="PRO_senNameBack">
    <input id="s1" type="text" />
 </div>
  <div id="v2" class="PRO_senNameBack">
    <input id="s2" type="text" />
  </div>
  <div id="v3" class="PRO_senNameBack">
    <input id="s3" type="text" />
  </div>
  <div id="G_tditle4" class="tieleText">传感器默认显示值</div>
  <div id="PRO_defalutShow" class="unitText">
   
     <input name="defgoal" type="radio" value="step" /><span id="d1">行走步数</span>
     <input name="defgoal" type="radio" value="distance" /><span id="d2">行走距离</span>
     <input name="defgoal" type="radio" value="calories" checked="checked" /><span id="d3">消耗卡路里</span>
     
  </div>
  <div id="PRO_submit"></div>
  <div id="PRO_close"><img src="../images/pop_closebig.png" width="23" height="23" /></div>
</div>
<input type="hidden" id="unit" value="" />
<input type="hidden" id="stepwidth" value="" />
<input type="hidden" id="rate" value="" />

</body>
</html>