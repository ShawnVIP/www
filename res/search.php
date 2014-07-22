<?php
$lang="en";
setcookie("lang",$lang);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cn" lang="cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>search family</title>
<link href="../css/main_<?php echo $lang; ?>.css" type="text/css" rel="stylesheet" />
<?php if($lang=="en"){
	echo '<!--[if IE]><link rel="stylesheet" href="../css/globalie_en.css" type="text/css" /><![endif]-->';
} 
?>

	<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="../js/jquery.cookie.js"></script>
	<script type='text/javascript' src='../js/reglogin.js'></script>
	<script src="../js/infinite.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/search.js"></script>

	<style type="text/css">
	body {
 margin:0px
}
.tieleText{font-size:14px; color:#85bd4f; font-weight:bold;}

#mainFrame {
	position: absolute;
	width: 613px;
	height: 371px;
	z-index: 1;
	left: 0px;
	top: 0px;
	display: block;
	background-color: #f2f2f2;
}

.bigback { background:url(../images/fri_areabackbig.jpg) repeat-x }

#PRO_title {
	position: absolute;
	z-index: 9;
	font-size: 38px;
	color: #6dbf0d;
	left: 47px;
	top: 17px;
}

#searchBtn {
	position: absolute;
	width: 73px;
	height: 41px;
	left: 480px;
	top: 102px;
	cursor: pointer
}



#s1{
	width:392px;
	height:53px;
	line-height:28px;
	font-size:30px;
	border:0;
	color:#bfbfbf;
	background-color:transparent;
	text-align:center;
	
	
}
#v1 {
	position: absolute;
	width: 422px;
	height: 53px;
	z-index: 11;
	left: 49px;
	top: 96px;
	background: url(../images/fri_barback.png) no-repeat
}
#v2 {position:relative;left:15px; width:392px; height:53px}

#PRO_submit {
	position: absolute;
	width: 100px;
	height: 41px;
	z-index: 8;
	left: 314px;
	top: 262px;
	background: url(../images/pro_submit.png) no-repeat;
	line-height: 41px;
	color: white;
	text-align: center;
	font-weight: bold;
	cursor: pointer;
}
#wronginfo {
	position: absolute;
	left: 48px;
	top: 159px;
	width: 424px;
	text-align: center;
}
#waitload {
	position: absolute;
	left: 512px;
	top: 140px; display:none;
}
	.infiniteCarousel {
	position: absolute;
	top: 191px;
	width: 260px;
	left: 47px;
	height: 0px;
	}

	.infiniteCarousel .wrapper {
	width: 198px; /* .infiniteCarousel width - (.wrapper margin-left + .wrapper margin-right) */
	overflow: auto;
	min-height: 10em;
	margin: 0 40px;
	position: absolute;
	top: 0;
	}

	.infiniteCarousel ul a img {
		border: 3px solid #333;
	}

	.infiniteCarousel .wrapper ul {
		width: 9999px;
		list-style-image:none;
		list-style-position:outside;
		list-style-type:none;
		margin:0;
		padding:0;
		position: absolute;
		top: 0;
	}

	.infiniteCarousel ul li {
		display:block;
		float:left;
		padding: 10px;
		height: 85px;
		width: 85px;
	}

	.infiniteCarousel ul li a img {
		display:block;
	}

	.infiniteCarousel .arrow {
		display: block;
		text-indent:-9999px;
		height: 36px;
		width: 37px;
		background: url(../images/arrow.png) no-repeat 0 0;
		position: absolute;
		top: 37px;
		cursor: pointer;
	}

	.infiniteCarousel .forward {
		background-position: 0 0;
		right: 0;
	}

	.infiniteCarousel .back {
		background-position: 0 -72px;
		left: 0;
	}

	.infiniteCarousel .forward:hover {
		background-position: 0 -36px;
	}

	.infiniteCarousel .back:hover {
		background-position: 0 -108px;
	}
	
	.headItem {width:95px;height:115px;}
	.headPic {width:95px;height:95px; cursor:pointer}
	.headPic img {width:100%;height:100%;}
	.headName {text-align:center; font-size:12px;}
	#chooseRela{
	position: absolute;
	height: 23px;
	width: 191px;
	left: 290px;
	top: 190px;
}

#sendBtn{width:262px; height:56px; cursor:pointer}

#PRO_selectLong{ width:200px; height:28px; background:url(../images/info_sel_large.png) no-repeat
;text-align:left;cursor:pointer;padding-left:10px; line-height:28px;}


.PRO_senNameBack {width:122px; height:28px; background:url(../images/pro_sen_nameback.png) no-repeat}
	
	#relaDiv{
	position: absolute;
	left: 292px;
	top: 258px;
	width: 180px;
	height: 80px;
}
#relationTable { width:180px;height:80px}
.hide {display:none;}	

#downarea {
	position: absolute;
	width: 613px;
	height: 169px; background:#e4e4e4;
	left: 0;
	top: 204px; 
}
#downarea div { padding:50px; font-size:15px;
}
    #PRO_close {
	position: absolute;
	width: 23px;
	height: 23px;
	z-index: 1;
	left: 570px;
	top: 19px;
	cursor: pointer;
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
<body>
<div id="mainFrame" class="G_bigRound">
  <div id="PRO_title">Add Family Member</div>
  <div id="waitload"><img src="../images/wait-loading.gif" /></div>
  <div id="searchBtn">GO</div>
  <div id="v1" class="PRO_senNameBack">
    <div id="v2"><input type="text" id="s1" maxlength="200" /></div>
 </div>
 <div id="wronginfo" class="G_contentRed"> </div>
 <div class="infiniteCarousel" id="piclist">
      <div class="wrapper"> </div>
  </div>
 <div id="chooseRela" class="hide"><table border="0" cellpadding="0" cellspacing="0"><tr><td><span id="chooseRela">Choose the relationship</span></td></tr><tr><td height=20> </td></tr><tr><td><div id="PRO_selectLong"> </div></td></tr><tr>
    <td height=20><input name="guardian" type="checkbox" id="guardian" /><span id="guardianText">我是他的监护人</span>
      </td></tr>
    <tr><td height=20>&nbsp;</td></tr>
    <tr><td width=262 height=56><div id="sendBtn">Send Request</div></td></tr></table></div>
 
 <div  id="relaDiv" ><select multiple="multiple" id="relationTable" rows=5> </select></div>
 
<div id="downarea" class="G_bigRoundDown"><div id="tips">You can invite your family members by searching full Email address.</div></div>
<div id="PRO_close"><img src="../images/pop_closebig.png" width="23" height="23" /></div>
</div>

</body>
</html>

