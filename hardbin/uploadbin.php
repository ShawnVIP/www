
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

<script language="javascript" src="../js/uploadbin.js"></script>
<script type="text/javascript">

	function updatedHead(headpic,ecode){
		parent.updatedHead(headpic)
	}
	function hidethis(){
		parent.hidethis();
		
	}	
	
</script>
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
<body><p></p>
<form action="../res/saveversion.php" id="uploadform" method="post" enctype="multipart/form-data">
<table width=800 align="center">
<tr><td class="right">appstore version:</td><td><input name="appversion" id="appversion"  type="text" size="20" /></td></tr>
<tr><td class="right">appstore URL:</td><td><input name="appurl" id="appurl" type="text" size="60" /></td></tr>
<tr><td class="right">hardware version:</td><td><input name="hardversion" id="hardversion" type="text" size="20" /></td></tr>
<tr><td class="right">hardware file:</td><td><input type="file" name="binfile" /></td></tr>
<tr><td class="right"></td><td><input type="submit" value="Send" /></td></tr>
</table>
</form>
 <hr />
  <table border="1" align=center cellpadding="1" cellspacing="0">
  <tr><td>appversion</td><td>appurl</td><td>hardversion</td><td>binfile name</td><td>update date</td></tr>
  <tbody id="myFriendList">
    
  </tbody>
  </table>

</body></html>
