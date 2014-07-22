<?php
$lang="cn";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<link href="../css/main_cn.css" type="text/css" rel="stylesheet" />

<link href="../css/redmond/jquery-ui-1.10.1.custom.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="../js/reglogin.js"></script>
<script type="text/javascript" src="../js/message.js"></script>
<style type="text/css">
#popupMessage {position:absolute; background:url(../images/pop_message.png); width:273px; height:270px;}

#msg_head{
	position: absolute;
	width: 75px;
	height: 75px;
	left: 100px;
	top: 63px;
}
#msg_text {
	position: absolute;
	width: 232px;
	height: 27px;
	left: 23px;
	top: 32px;
	font-size: 13px;
	color: #404040;
	text-align: center
}
#msg_name {
	position: absolute;
	width: 154px;
	height: 22px;
	left: 65px;
	top: 143px;
	font-size: 16px;
	color: #66bd00;
	text-align: center;
	z-index: 20
}
#accept {
	position: absolute;
	left: 46px;
	top: 180px;
	
	width: 92px;
	height: 31px;
}
#decline {
	position: absolute;
	left: 145px;
	top: 180px;
	
	width: 92px;
	height: 31px;
}
#mainContent{display:none;}

body { margin:0px}
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

<body>

<div id="popupMessage"><div id="mainContent">
  <div id="msg_text"></div>
    <div id="msg_head"></div>
 	<div id="msg_name"></div>
   
    <div id="accept">Accept</div>
  	<div id="decline">Decline</div>
    </div>
</div>

 
</body>
</html>
