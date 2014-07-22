<?php
$lang="en";
$scode=$_REQUEST['scode'];
$ucode=$_REQUEST['ucode'];
$ecode=$_REQUEST['ecode'];
$pic=$_REQUEST['pic'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>upload</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/main_<?php echo $lang; ?>.css" type="text/css" rel="stylesheet" />
<!--[if IE]><link rel="stylesheet" href="../css/globalie_<?php echo $lang; ?>.css" type="text/css" /><![endif]-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7840951-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
var LANG="en";
</script>

<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>

<script language="javascript" src="../js/uploadhead.js"></script>
<script type="text/javascript">

	function updatedHead(headpic,ecode){
		parent.updatedHead(headpic)
	}
	function hidethis(){
		parent.hidethis();
		
	}	
	
</script>
<style>
body {margin:0px}
#myContent { width:389px;height:320px}
#backpic {width:200px;height:200px; position:absolute; left:95px; top:30px; border-color:grey}
#mainarea {position:absolute; top:280px; display:none}
#choosepicture {
	position: absolute;
	top: 250px;
	left: 99px;
	width: 192px;
	height: 36px;
	text-align:center; line-height:36px
}
.btnBack1 {background:url(../images/bt_back1.png); cursor:pointer;}
.pickpic {cursor:pointer;}
</style>
</head>
<body><div id="myContent">
<div id="backpic" class="pickpic"><img src="../upload/<?php echo $pic; ?>"  /> </div>
<div id="choosepicture" class="btnBack1">Choose head picture</div>
<div id="mainarea">
	<form action="../res/uploadhead.php" method="post" enctype="multipart/form-data">
    <p>Pictures:
    <input type="file" name="picture"  id="pickpicture" onchange="getPhotoSize(this)"/>
    <input type="hidden" name="scode" id="scode" value="<?php echo $scode; ?>" />
    <input type="hidden" name="ucode" id="ucode" value="<?php echo $ucode; ?>" />
    <input type="hidden" name="ecode" id="ecode" value="<?php echo $ecode; ?>" />
     <input type="hidden" name="lang" id="lang" value="<?php echo $lang; ?>" />
    <input type="submit" value="Send" id="submitpicture"/>
    </p>
    </form>
	</div>	
</div></body></html>
