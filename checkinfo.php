<!doctype html>
<html>
<head>
<meta charset="utf-8" >
<title>Check INFO</title>
</head>
<link href="css/main_en.css" type="text/css" rel="stylesheet" />
<link href="css/redmond/jquery-ui-1.10.1.custom.css" rel="stylesheet" >

<script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script>
<script type="text/javascript" src="js/jquery.cookie.js" ></script>
<script type="text/javascript" src="js/jquery.mousewheel.js" ></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js" ></script>
<script type="text/javascript" src="js/info.js" ></script>
<style type="text/css" >

body {margin:20px; color:#202020; font-size:12px;}
#dateList {width:200px}

</style>


<body>

<p>accountinfo</p>
<table width="800" border="1" cellspacing="1" cellpadding="5" align="center" >
  <tr>
    <td width="89" >email</td>
    <td>
    <input name="email" type="text" id="email" value="s@sohu.com" ></td>
    <td><button id="search" >Search this email</button></td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td>userid</td>
    <td width="248"id="userid" >&nbsp;</td>
     <td>&nbsp;</td> <td>&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>
<p>sensorifno</p>
<table  align="center" width="800" border="1" cellspacing="1" cellpadding="5" >
  <tr>
    <td>sensorid</td>
    <td ><div id="sensorid">&nbsp;</div></td>
    <td>nickname</td>
    <td id="nickname">&nbsp;</td>
  </tr>
  <tr>
    <td width="89" >headimage</td>
    <td width="248" id="headimage">&nbsp;</td>
    <td width="177" >picture</td>
    <td width="231" ><img src="" width="20" height="20"  alt="" id="headpic"/></td>
  </tr>
 <tr>
    <td width="89" >dob</td>
    <td width="248" id="dob">&nbsp;</td>
    <td width="177" >timezone</td>
    <td width="231" id="timezone">&nbsp;</td>
  </tr>
 
  <tr>
    <td>unit</td>
    <td id="unit">&nbsp;</td>
    <td>summary</td>
    <td id="summary">&nbsp;</td>
  </tr>
    <tr>
    <td>createdate</td>
    <td  id="createdate">&nbsp;</td>
    <td>gender</td>
    <td  id="gender">&nbsp;</td>
  </tr>
  <tr>
    <td width="89" >updated</td>
    <td width="248" id="updated">&nbsp;</td>
    <td width="177" >age</td>
    <td width="231" id="age">&nbsp;</td>
  </tr>
 
 
  <tr>
    <td>detailid</td>
    <td id="detailid">&nbsp;</td>
    <td>seedkey</td>
    <td id="seedkey">&nbsp;</td>
  </tr>
    <tr>
    <td>lastupdate</td>
    <td id="lastupdate">&nbsp;</td>
    <td>power</td>
    <td id="power">&nbsp;</td>
  </tr>
  <tr>
    <td width="89" >devicetoken</td>
    <td width="248" id="devicetoken">&nbsp;</td>
    <td width="177" >fallalert</td>
    <td width="231" id="fallalert">&nbsp;</td>
  </tr>
 <tr>
    <td width="89" >positionalert</td>
    <td width="248" id="positionalert">&nbsp;</td>
    <td width="177" >para0(transmitpower)</td>
    <td width="231" id="para0">&nbsp;</td>
  </tr>
 
  <tr>
    <td>para1(fallthreshold)</td>
    <td id="para1">&nbsp;</td>
    <td>para2(fallimpact)</td>
    <td id="para2">&nbsp;</td>
  </tr>
      <tr>
    <td>para3(fallangleh)</td>
    <td id="para3">&nbsp;</td>
    <td>para4(fallanglel)</td>
    <td id="para4">&nbsp;</td>
  </tr>
  <tr>
    <td width="89" >defalutgaol</td>
    <td width="248" id="defaultgoal">&nbsp;</td>
    <td width="177" >language</td>
    <td width="231" id="language">&nbsp;</td>
  </tr><tr>
    <td width="89" >usertype</td>
    <td width="248" id="usertype">&nbsp;</td>
    <td width="177" id="">&nbsp;</td>
    <td width="231" id="">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p><p>my relation</p>

<table  align="center" width="800" border="1" cellspacing="1" cellpadding="5" >
  <tr>
    <td width="150">addin date</td>
    <td width="100">friend id</td>
    <td width="200">how I call</td>
    <td>guardian mode</td>
  </tr>
  <tbody id="myFriendList">
    
  </tbody>
</table>
<p>&nbsp;</p>
<p> relation to me</p>
<table  align="center" width="800" border="1" cellspacing="1" cellpadding="5" >
  <tr>
    <td width="150">addin date</td>
    <td width="100">friend id</td>
    <td width="200">how call me</td>
    <td>guardian mode</td>
  </tr>
  <tbody id="friendToMeList">
    
  </tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>dailyvalue</p>
<table align="center"  width="800" border="1" cellspacing="1" cellpadding="5" >
  <tr>
    <td>day</td>
    <td><select name="dateList"  size="1" id="dateList" >
      
    </select></td>
    <td><button id="changeTime" >Change Time</button></td>
    <td>&nbsp;</td>
  </tr><tr>
    <td>age</td>
    <td id="sensorAge">&nbsp;</td>
    <td>updated</td>
    <td id="updated">&nbsp;</td>
  </tr>
  <tr>
    <td width="89" >height</td>
    <td width="248" id="height">&nbsp;</td>
    <td width="177" >weight</td>
    <td width="231" id="weight">&nbsp;</td>
  </tr>
  <tr>
    <td width="89" >step</td>
    <td width="248" id="step">&nbsp;</td>
    <td width="177" >stepwidth</td>
    <td width="231" id="stepwidth">&nbsp;</td>
  </tr>
 
  <tr>
    <td width="89" >runningwidth</td>
    <td width="248" id="runningwidth">&nbsp;</td>
    <td width="177" id="">&nbsp;</td>
    <td width="231" id="">&nbsp;</td>
  </tr>
  
  <tr>
    <td>bmr</td>
    <td id="bmr">&nbsp;</td>
    <td>bmi</td>
    <td id="bmi">&nbsp;</td>
  </tr> <tr>
    <td>stepgoal</td>
    <td id="stepgoal">&nbsp;</td>
    <td>totalsteps</td>
    <td id="totalsteps">&nbsp;</td>
  </tr>
  <tr>
    <td>caloriesgoal</td>
    <td id="caloriesgoal">&nbsp;</td>
    <td>totalcal</td>
    <td id="totalcal">&nbsp;</td>
  </tr>
  <tr>
    <td width="89" >distancegoal</td>
    <td width="248" id="distancegoal">&nbsp;</td>
    <td width="177" >totaldistance</td>
    <td width="231" id="totaldistance">&nbsp;</td>
  </tr> <tr>
    <td width="89" >sleepgoal</td>
    <td width="248" id="sleepgoal">&nbsp;</td>
    <td width="177" >totalsleep</td>
    <td width="231" id="totalsleep">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>goal reaching detail percentage</p>
<p>&nbsp;</p>
<table  align="center" width="800" border="1" cellspacing="1" cellpadding="5" >
  <tbody id="goalList">
    <tr>
      <td >date</td>
      <td >week id</td>
      <td >cal token</td>
      <td>cal goal</td>
      <td>cal per</td>
      <td >dis token</td>
      <td>dis goal</td>
      <td>dis per</td>
      <td >step token</td>
      <td>step goal</td>
      <td>step per</td>
      <td >sleep token</td>
      <td>sleep goal</td>
      <td>sleep per</td>
    </tr>
    
  </tbody>
</table>
<p>&nbsp;</p>
<p>goal reaching summary percentage</p>
<p>&nbsp;</p>
<table  align="center" width="800" border="1" cellspacing="1" cellpadding="5" >

  <tbody id="percentage">
  <tr>
      <td  >dateweek id</td>
      <td  style="text-align: right" >claories</td>
      <td>cal per</td>
      <td  style="text-align: right" >distance</td>
      <td>dis per</td>
      <td  style="text-align: right" >step</td>
      <td>step per</td>
      <td style="text-align: right" >sleep</td>
      <td>sleep per</td>
    </tr>
  </tbody>
</table><p>&nbsp;</p>
<p>alertlist</p>
<table  align="center" width="800" border="1" cellspacing="1" cellpadding="5" >
  <tr>
    <td>alert date</td>
    <td>alert type</td>
    <td>alert mark</td>
  </tr>
  <tbody id="alertTable">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>
<p>&nbsp;</p>
<p>sensorstation</p>
<table  align="center" width="800" border="1" cellspacing="1" cellpadding="5" >
  <tr>
    <td>totime</td>
    <td>position id</td><td>position mode</td>
    <td>position picture</td>
    <td>last time</td>
  </tr>
  <tbody id="stationTable">
   
  </tbody>
</table>
<p>&nbsp;</p>
<p>upload_data</p>
<table align="center" width="800" border="1" cellspacing="1" cellpadding="5" >
  <tr>
    <td>time</td>
    <td>calories</td>
    <td>steps</td>
    <td>distance</td>
    <td>move</td>
    <td>sleepmode</td>
    <td>angle</td>
    <td>maxspeed</td>
    <td>minspeed</td>
    <td>averagespeed</td>
    <td>detectedposition</td>
  </tr>
  <tbody id="uploadDataTable">
  </tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div id="dialog-modal" title="alert" class="tempLabel" ><p id="alertinfo" ></p></div>

</body>
</html>
