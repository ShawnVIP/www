<?php

$lang="cn";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<link rel="stylesheet" href="../css/main_cn.css">

<style type="text/css">
#videoWindow {position:relative;width:1440px; background:#fbfbfb}
.pic {position:absolute;top:0px;width:1440px;height:645px}
.hide {display:none}
#maxContent {
	position: absolute;
	overflow: hidden;
	height: 645px; 
}
#main {position:absolute;  left:0px;top:0px; height:645px; width:1px}
#content {height:645px;}

#buy {
	position: relative;
	width: 208px;
	height: 63px;
	top: 545px;
	left: 1011px;
	z-index: 3;
	cursor: pointer;
	background: url(../images/buy-out.png)
}
#buyone {cursor:pointer;}
#menuContent{
	position: absolute;
	left: 218px;
	top: 545px;
	width: 461px;
	height: 61px;
	background: url(../images/home_iback.png);	
}
#menuLeftText {
	position: absolute;
	top: 12px;
	left: 20px;
	color: white;
	font-size: 14px;
	width: 134px;
	height: 31px;
}
#iconList{
	position: absolute;
	top: 6px;
	height: 48px;
	width: 288px;
	left: 167px;
}
.iconItem {float:left; position:relative; width:48px;height:48px;}


#text1{
	position: absolute;
	left: 646px;
	top: 108px;
	width: 590px;
	height: 161px;
	z-index: 30
}
#text2{
	position: absolute;
	left: 755px;
	top: 176px;
	width: 546px;
	height: 161px;
	z-index: 30
}
#text3{
	position: absolute;
	left: 755px;
	top: 130px;
	width: 504px;
	height: 161px;
	z-index: 30
}
#text4{
	position: absolute;
	left: 755px;
	top: 82px;
	width: 504px;
	height: 161px;z-index:30
}
#text5{
	position: absolute;
	left: 755px;
	top: 105px;
	width: 457px;
	height: 161px;
	z-index: 30
}
#text6{
	position: absolute;
	left: 755px;
	top: 105px;
	width: 442px;
	height: 161px;z-index:30
}
#midtext{
	position: absolute;
	left: 651px;
	top: 421px;
	width: 576px;
	height: 47px;
	z-index: 30
}
#midtext div {width:192px; font-size:14px; line-height:20px; position:relative; float:left; color:#686868; text-align:center}
.color_grey{color:#8b8b8b;}
.color_green{color:#66bd00;}
.color_dark{color:#686868;}
.size1{font-size:18px; }
.size2{font-size:80px; line-height:80px }
.size3{font-size:18px; line-height:25px  }
.size4{font-size:14px; line-height:20px }
.size5{font-size:40px; }
.size6{font-size:32px; }
.size7{font-size:38px; }
.height1{line-height:50px}
#apDiv1 {
	position: absolute;
	width: 200px;
	height: 115px;
	z-index: 31;
}
#videoButton {
	position: absolute;
	width: 189px;
	height: 121px;
	z-index: 1;
	left: 1036px;
	top: 293px;
	cursor:pointer;
}
#homeVideo{
	position: absolute;
	width: 720px;
	height: 405px;
	z-index: 200;
	left: 51px;
	top: 68px;
	background:#000
	display:none;
}

</style>

</head>
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
<script type="text/javascript" src="../js/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
<script language="javascript" src="../js/swfobject.js"></script>
<body >

<div id="maxContent">
  <div id="videoWindow">
  	<div id="pic0" class="pic hide" ><div><img src="../images/hp01.jpg" /></div> <div id="videoButton"></div><div id="text1"><span class="size1 color_grey"></span><br /><span class="size2 color_dark">Sense-U</span><br /><span class="size3 color_grey">世界首款<span class="color_green">一体化</span>活动侦测穿戴设备，只为让您和家庭成员更亲密无间而生</span>
  	</div>
    
   
    <div id="midtext"><div>24小时不间断智能运动追踪</div><div>老年人跌倒侦测</div><div>姿态监测</div></div></div>
    <div id="pic1" class="pic hide"><div><img src="../images/hp02.jpg" /></div><div id="text2"><span class="size5 color_green">记录您的日常运动</span><br /><span class="size3 color_grey">超便携的Sense-U可以随心配戴。你可以将它夹在衬衣、外套、运动服、背包上，甚至夹在内衣上也完全没问题。无论您在日常工作、跑步、睡觉时，Sense-U都可以正常工作。</span></div></div>
    <div id="pic2" class="pic hide"  ><div><img src="../images/hp03.jpg" /></div><div id="text3"><span class="size5 color_green">睡眠质量监测</span><br /><span class="size3 color_grey">即使在您睡觉的时候，Sense-U也是不眠不休。它可以让您更好地了解您的睡眠情况，从而知道如何更好地改进睡眠质量。</span></div></div>
    <div id="pic3" class="pic hide" ><div><img src="../images/hp04.jpg" /></div><div id="text4"><span class="color_green size5">跌倒等危险动作监测</span><br /><span class="size3 color_grey">Sense-U可以自动侦测老年人的危险情况，例如摔倒或是长时间没有任何活动，一旦这种情况发生，你、其他的家庭成员或是预先设定的监护人就会收到Sense-U发来的警告信息。</span><br /><br /><Br /><table cellpadding="0" cellspacing="0"><tr class="size4 color_grey"><td width="50"><img src="../images/home_fall.png" width="46" height="46" /></td><td width="165" >摔倒监测</td><td width="50"><img src="../images/home_long.png" width="45" height="46" /></td><td>长时间无活动报警</td></tr></table></div></div>
    <div id="pic4" class="pic hide"><div><img src="../images/hp05.jpg" /></div><div id="text5"><span class="size5 color_green">姿态智能侦测</span><br /><span class="size3 color_grey">Sense-U可以监测孩子们的坐姿或是站姿，并可以动态地给家长提供数据反馈，以便于更好地帮助他们矫正。</span></div></div>
      <div id="pic5" class="pic"><div><img src="../images/hp06.jpg" /></div><div id="text6"><span class="size5 color_green">在线访问您的数据</span><br /><span class="size3 color_grey">您可以随时在www.sense-u.com上访问您的各项数据。 通过您的在线账号，您可以详尽的查阅您的运动量、睡眠质量或者您选定的家庭成员的状况
</span></div></div>
   </div>
   
   <div id="menuContent"><div id="menuLeftText">来见识下<br />Sense-U的不同之处</div><div id="iconList"></div></div>

   <div id="buy"><img src="../images/buy-over.png" id="buyover" /></div>
</div>
<div id="main"> <div id="content"></div><div id="homeVideo"><div><iframe id="videoFrame" width=720 height=405 frameborder="0" scrolling="no"></iframe></div></div>
</div>

</body>
</html>
