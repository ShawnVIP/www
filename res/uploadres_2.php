<?php

$mode=$_POST[mode];
$dir=$_POST[radio];
if($dir =="root"){
	$dir="";
}else{
	$dir.="/";
}
$password=md5($_POST[password]);
$outstr="";
if($mode==1 & $password=="f9146ac536fabd9e06a112f4f8c28d66"){
		
	$tmpFile=$_FILES["binfile"]["tmp_name"];
	$binfilename=$_FILES["binfile"]["name"];
	$finalname=$binfilename;
	$oldname=substr($binfilename,0,strlen($binfilename)-4);
	//echo $binfilename;
	$fileext =substr($binfilename, strrpos($binfilename, '.') + 1);
	$i=48;
	$filedir="../".$dir;
	
	while ( file_exists($filedir.$binfilename)){
		$binfilename=$oldname ."_" . chr($i) . "." . $fileext;
		$i++;
		if($i>57){$i+=40;}
	}
	
	//echo $binfilename;
	if($binfilename != $finalname){
		$outstr=" rename " .$filedir.$finalname ." to ". $filedir .$binfilename. ". <br>";
		rename($filedir.$finalname,$filedir.$binfilename);
	}
	$outstr .= " upload ". $filedir .$finalname ." sucessful. <br>";
	move_uploaded_file($_FILES["binfile"]["tmp_name"], $filedir.$finalname );
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>upload bin file</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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

<style>
@charset "UTF-8";
/* CSS Document */
@font-face{font-family:'yahei';src:url(../fonts/helveticaneueltpro-lt-webfont.ttf); font-style:normal; font-weight:normal}

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

.right { text-align:right; padding-right:10px; }
td { padding:10px; }
a:link { text-decoration: none;color: blue}
a:active { text-decoration:blink}
a:hover { text-decoration:underline;color: red}
a:visited { text-decoration: none;color: green}

</style>
</head>
<script>
$(function(){
	$('input:radio[value="<?php echo $_POST[radio]; ?>"]').attr("checked","checked"); 
});
</script>
<body><p></p>
<form action="uploadres.php" id="uploadform" method="post" enctype="multipart/form-data">
<table width=800 align="center">
<tr>
  <td class="right">pass:</td><td><input type="password" name="password" /></td></tr>
<tr>
  <td class="right">direct:</td><td>
  <input name="radio" type="radio" value="root" />root |  
    <input name="radio" type="radio" value="res" />res |
    <input type="radio" name="radio" value="js" />js |
    <input type="radio" name="radio" value="cn" />cn | 
    <input type="radio" name="radio" value="en" />en
    </td></tr>
<tr>
  <td class="right">file:</td><td><input type="file" name="binfile" /></td></tr>
<tr><td class="right"></td><td><input type="hidden" name="mode" value=1 /><input type="submit" value="Send" /></td></tr>
<tr><td></td><td><?php echo $outstr; ?></td></tr>
</table>
</form>
 <hr />
</body></html>
