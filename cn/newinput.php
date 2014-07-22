<?php
$lang="cn";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/main_cn.css" type="text/css" rel="stylesheet" />

<link href="../css/redmond/jquery-ui-1.10.1.custom.css" rel="stylesheet">

<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.cookie.js"></script>
<script type="text/javascript" src="../js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="../js/newinput.js"></script>

    
<style type="text/css">

body {margin:0px; color:#8b8b8b; font-size:12px;}
.mousePointer {cursor:pointer}
#header {height:95px; }
.under { text-decoration:underline}
.demoHeaders {margin-top: 5px;}
.valueHeader { padding-left:5px; width:100px}
.tableText { padding-left:10px; padding-right:10px;font-size:14px;color:#66bd00;line-height:22px;}

.inputLong {width:60px; text-align:center; }
.inputSort {width:40px; text-align:center}
.inputPart {width:40px; text-align:center}
.inputDate{width:40px;text-align:center;}
#processbar { height: 20px}
#processLabel { float: left;
margin-left: 50%;
font-weight: bold;
text-shadow: 1px 1px 0 #fff; font-size:12px; line-height:20px}

.titlePdding {}
.tempLabel{display:none;}
.rightAlign {text-align:right}
.selectedItem {background:#e2e8ed;}
.checkValue{}
.awakeCheck{};
#outList >td {padding:5px;}

.showinfo {color:#469bdd; font-weight:bold}
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
</head>

<body>
<div id="main"> <div id="content"  class="areaFrame">
<!---标题 -->
<div class="G_bigRoundShadow" id="header">

<table width="850" align=center>
	<tr><td height="28" colspan=2><span class="ui-icon ui-icon-calendar showinfo" style="float: left; margin-right: .3em;"></span>
      <input name="dateYear" type="text" class="inputDate" id="dateYear" />
      <input name="dateMonth" type="text" class="inputDate" id="dateMonth" />
      <input name="dateDay" type="text" class="inputDate" id="dateDay" /></td>
      <td  colspan=2 class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-tag" style="float: left; margin-right: .3em;"></span><span id="ucode" class="showinfo">102</span></td>
      <td  class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-tag" style="float: left; margin-right: .3em;"></span><span id="scode" class="showinfo">102</span></td></tr>
    <tr>
   
    <td  height="28" class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-person" style="float: left; margin-right: .3em;"></span><span id="username" class="showinfo"></span></td>
    <td class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-mail-closed" style="float: left; margin-right: .3em;"></span><span id="usermail" class="showinfo"></span></td>
    
    <td class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-arrowthick-2-e-w" style="float: left; margin-right: .3em;"></span><span id="stepWidth" class="showinfo"></span></td>
    <td class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-heart" style="float: left; margin-right: .3em;"></span><span id="userbmr" class="showinfo"></span></td>
   	<td></td>
</tr>
<tr>
 <td height="28" class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-signal" style="float: left; margin-right: .3em;"></span><span id="buildCal" class="showinfo">calories:0</span></td>
  <td  class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-signal" style="float: left; margin-right: .3em;"></span><span id="totalCal" class="showinfo">Total calories:0</span></td>
 <td  class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-seek-next" style="float: left; margin-right: .3em;"></span><span id="totalStep" class="showinfo">Total steps:0</span></td>
 <td  class="G_contentBlack titlePdding"><span class="ui-icon ui-icon-arrow-2-e-w" style="float: left; margin-right: .3em;"></span><span id="totalDist" class="showinfo">Total distance:0 km</span></td>
 <td></td></tr>
</table>
</div>
<br />
<!---Hour Pick List -->
<div class="G_bigRoundShadow" id="timelist">
<table width=850 align=center cellpadding="2" cellspacing="2"><tr><td width="872" class="G_headTitle">Time List</td></tr>
<tr><td><div id="processbar"><div id="processLabel">0%</div></div></td></tr>
  <tr>
    <td><div id="mainTimeTable" ><div class="tempLabel"><table><tr>
      <td width="44" align=center><input name="check" type="radio" value="0" /></td>
      <td width="53" class="G_contentBlack">From</td>
      <td width="50"> <input name="hour_from" id="hour_from" value="8" size="5" maxlength="2" class="inputSort" /></td>
      <td width="25">to:</td>
      <td width="50"><input name="spinner" id="spinner" value="12" size="5" maxlength="2" class="inputSort"/></td><td width=30></td>
      <td width="60"  > <button>delete</button></td>
  </tr></table></div>
  
  </div>
  
  </td>
  </tr>
  <tr><td height=10>  </td></tr>
  <tr>
    <td >
      
      <table><tr><td><button id="addnew">Add</button></td><td width=10></td><td ><button id="autoBuild" >Build rest</button></td><td> <input name="parts" id="parts" value="4" size="2" maxlength="2" class="inputPart" /> parts</td><td width=10></td><td><button id="cleanData">Delete all</button></td><td width=10></td><td><button id="zeroData">Zero data</button></td><td width=10></td><td><button id="clearDatabase">Clear Database</button></td></tr></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<br />
<!---Value List -->
<div class="G_bigRoundShadow" id="valuelist">
<table width=850 align=center><tr>
  <td class="G_headTitle">Value List (all the values are setting for 5 minutes unit)</td></tr>

<tr><td align="center">
<table ><tr>
    <td class="valueHeader G_contentBlack">Calories:</td><td>
<table class="G_contentGreen tableText"><tr ><td  class="tableText">Randomize From:</td><td><input name="rfrom0" type="text" class="inputLong" id="rfrom0" /></td><td>To:</td><td><input name="rto0" type="text"  class="inputLong" id="rto0"/></td></tr></table>
</td>

<td width=20></td><td>
<table class="G_contentGreen tableText"><tr>
<td>Linear To:</td><td><input name="lto0" type="text"   class="inputLong" id="lto0"/></td></tr></table>
</td>

</tr></table></td></tr>
<!--  from -->
<tr><td align="center">
<table >
  <tr>
  <td class="valueHeader G_contentBlack">Steps:</td>
  <td><table class="G_contentGreen tableText">
    <tr >
      
      <td  class="tableText">Randomize From:</td>
      <td><input name="rfrom1" type="text"  class="inputLong" id="rfrom1"/></td>
      <td>To:</td>
      <td><input name="rto1" type="text"  class="inputLong" id="rto1"/></td>
    </tr>
  </table></td>

<td width=20></td><td><table class="G_contentGreen tableText">
  <tr>
    
    <td>Linear To:</td>
    
    <td><input name="lto1" type="text"  class="inputLong" id="lto1"/></td>
  </tr>
</table></td>

</tr></table></td></tr>

<!-- to -->
<!--  from -->
<tr><td  align="center">
<table><tr>
  <td class="valueHeader G_contentBlack">Distance(m):</td>
  <td><table class="G_contentGreen tableText">
    <tr >
      
      <td  class="tableText">Randomize From:</td>
      <td><input name="rfrom2" type="text"  class="inputLong" id="rfrom2" readonly="readonly"/></td>
      <td>To:</td>
      <td><input name="rto2" type="text"  class="inputLong" id="rto2" readonly="readonly"/></td>
    </tr>
  </table></td>

<td width=20></td><td><table class="G_contentGreen tableText">
  <tr>
    
    <td>Linear To:</td>
    
    <td><input name="lto2" type="text"  class="inputLong" id="lto2" readonly="readonly"/></td>
  </tr>
</table></td>

</tr></table></td></tr>

<!-- to -->
<!--  from -->
<tr><td align="center">
<table ><tr>
  <td class="valueHeader G_contentBlack">Temper(&#176;C):</td>
  <td><table class="G_contentGreen tableText">
    <tr >
      
      <td  class="tableText">Randomize From:</td>
      <td><input name="rfrom3" type="text"  class="inputLong" id="rfrom3"/></td>
      <td>To:</td>
      <td><input name="rto3" type="text"  class="inputLong" id="rto3"/></td>
    </tr>
  </table></td>

<td width=20></td><td><table class="G_contentGreen tableText">
  <tr>
    
    <td>Linear To:</td>
    
    <td><input name="lto3" type="text"  class="inputLong" id="lto3"/></td>
  </tr>
</table></td>

</tr></table></td></tr>

<!-- to -->
<!--  from -->
<tr><td align="center">
<table ><tr>
  <td class="valueHeader G_contentBlack">Movement:</td>
  <td><table class="G_contentGreen tableText">
    <tr >
      
      <td  class="tableText">Randomize From:</td>
      <td><input name="rfrom4" type="text"  class="inputLong" id="rfrom4"/></td>
      <td>To:</td>
      <td><input name="rto4" type="text"  class="inputLong" id="rto4"/></td>
    </tr>
  </table></td>

<td width=20></td><td><table class="G_contentGreen tableText">
  <tr>
    
    <td>Linear To:</td>
    
    <td><input name="lto4" type="text"  class="inputLong" id="lto4"/></td>
  </tr>
</table></td>

</tr></table></td></tr>

<!-- to -->
<tr><td  align=center><table width="500"><tr><td><button class="G_contentGreen" id="randValue1">Randomize</button></td>
<td><button class="G_contentGreen" id="zeroRand1">Zero Randomize</button></td>
<td><button class="G_contentGreen" id="zeroLin">Zero Linear</button></td>
</tr></table></td></tr>
</table>

</td></tr>
<tr>
    <td>&nbsp;</td>
  </tr>
</table>

</div>

<br />
<!---Value List -->
<div class="G_bigRoundShadow" id="buildAllData">
<table width=900 align=center><tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td align=center ><table><tr><td><button class="G_headTitle" id="buildList" >Build All Data</button></td><td align=center >
     per
    <input name="minparts" id="minparts" value="5" size="2" maxlength="2" class="inputPart" /> 
    minutes,
    <input type="checkbox" checked name="withRand" id="withRand" />
random data.</td><td width="50" align=center>==></td><td><button class="G_headTitle" id="postList" >upload Data</button></td></tr></table></td></tr><tr>
    <td>&nbsp;</td>
  </tr></table></div>



<br />
<!---Value List -->
<div class="G_bigRoundShadow" id="listAllData">
<table width=900 align=center><tr>
    <td>&nbsp;</td>
  </tr>
<tr>
    <td align=center><div id="outList"></div></td>
  </tr>
  <tr><td id="out"></td></tr></table></div>


</div>



</div>
</div>

<div id="dialog-modal" title="alert" class="tempLabel">
<p id="alertinfo">Please login first.</p>
</div>

</body>
</html>
