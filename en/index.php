<?php
setcookie("lang","en");
$lang="en";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<link href="../css/main_en.css" type="text/css" rel="stylesheet" />
<!--[if IE]><link rel="stylesheet" href="../css/globalie_en.css" type="text/css" /><![endif]-->
<style type="text/css">
#videoWindow {position:relative;width:1440px; background:#fbfbfb}
.pic {position:absolute;top:0px;width:1440px;height:645px}
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
	top: 15px;
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
	width: 562px;
	height: 161px;
	z-index: 30
}
#text2{
	position: absolute;
	left: 769px;
	top: 176px;
	width: 504px;
	height: 161px;z-index:30
}
#text3{
	position: absolute;
	left: 769px;
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
	left: 815px;
	top: 105px;
	width: 420px;
	height: 161px;z-index:30
}
#text6{
	position: absolute;
	left: 686px;
	top: 115px;
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
#midtext div {width:192px; font-size:12px; line-height:20px; position:relative; float:left; color:#686868; text-align:center}
.color_grey{color:#8b8b8b;}
.color_green{color:#66bd00;}
.color_dark{color:#686868;}
.size1{font-size:18px; }
.size2{font-size:80px; line-height:80px }
.size3{font-size:18px; line-height:18px  }
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
var LANG="<?php echo $lang; ?>";
</script>

<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type="text/javascript" src="../js/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
<script language="javascript" src="../js/swfobject.js"></script>
<body >

<div id="maxContent">
  <div id="videoWindow">
  	<div id="pic0" class="pic" ><div><img src="../images/hp01.jpg" /></div> <div id="videoButton"></div><div id="text1"><span class="size1 color_grey">Introducing</span><br /><span class="size2 color_dark">Sense-U</span><br /><span class="size3 color_grey">The World's First <span class="color_green">All-in-One</span> Activity Tracker to Connect Your Family</span>
  	</div>
    
  
    
  	  <div id="midtext"><div>24/7 INTELLIGENT ACTIVITY TRACKING</div><div>ELDERLY FALL DETECTION
</div><div>POSTURE MONITORING</div></div></div>
    <div id="pic1" class="pic" style="display:none" ><div><img src="../images/hp02.jpg" /></div><div id="text2"><span class="size5 color_green">Monitor Your Daily Activities</span><br /><span class="size4 color_grey">The clip-and-go Sense-U is wearable the way you want. Clip it to your shirt, jacket, workout gear, backpack, or even your underwear and it stays put: whether you’re running an errand, running around the track, or laying on bed.</span></div></div>
    <div id="pic2" class="pic"  style="display:none"><div><img src="../images/hp03.jpg" /></div><div id="text3"><span class="size5 color_green">Sleep Pattern Tracking</span><br /><span class="size4 color_grey">During sleep, SENSE-U continues to monitor and lets you know both the quality of your sleep and how to improve one of your most important activities</span></div></div>
    <div id="pic3" class="pic" style="display:none"  ><div><img src="../images/hp04.jpg" /></div><div id="text4"><span class="color_green size6 height1">Fall and Inactivity Detection</span><br /><span class="size4 color_grey">For the elderly in your life, SENSE-U automatically detects dangerous situations, such as sudden falls, or long periods of inactivity and sends warning messages to you, family members or any 3<SUP>rd</SUP> party.</span><br /><br /><Br /><table cellpadding="0" cellspacing="0"><tr class="size4 color_grey"><td width="50"><img src="../images/home_fall.png" width="46" height="46" /></td><td width="165" >Fall Detection
</td><td width="50"><img src="../images/home_long.png" width="45" height="46" /></td><td>Inactivity Warning
</td></tr></table></div></div>
    <div id="pic4" class="pic" style="display:none"  ><div><img src="../images/hp05.jpg" /></div><div id="text5"><span class="size6 color_green">Automatic Posture Monitoring</span><br /><span class="size4 color_grey">For children, SENSE-U can monitor posture while sitting or standing and actively provides feedback to improve posture.</span></div></div>
      <div id="pic5" class="pic" style="display:none"  ><div><img src="../images/hp06.jpg" /></div><div id="text6"><span class="size7 color_green">Access Your Data Online</span><br /><span class="size4 color_grey">Your online data is always available at www.sense-u.com. From your online account, you can have a close look into your fitness progress, sleep patterns and those of select family members.</span></div></div>
   </div>
   
   <div id="menuContent"><div id="menuLeftText">Discover more<br />Features of Sense-U</div><div id="iconList"></div></div>

   <div id="buy"><img src="../images/buy-over.png" id="buyover" /></div>
</div>
<div id="main"> <div id="content"></div><div id="homeVideo"><div><iframe id="videoFrame" width=720 height=405 frameborder="0" scrolling="no"></iframe></div></div>
</div>

</body>
</html>
