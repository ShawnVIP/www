<?php 
include "dbconnect.php";



$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$cdate=formatDateStr($obj -> cdate);

$vipmode=checkuser($ucode,$scode,$ecode,$source);

//$scode=1;
//$cdate="2013-9-25";
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
$sql="SELECT totime,position FROM sensorstation where sensorid=$scode and sdate='$cdate' and adjtype=0 order by totime";

/*

0：静止
1：睡眠中
2：端坐
3：非端坐
4：走路
5：跑步
6：未定义
-1：无数据

return: 
position:2/(2+3)
lasttime:3
*/
$result=mysql_query($sql,$conn); 	
$lasttime="00:00:00";
$elist=array();
$edata=array();
for($i=0;$i<=7;$i++){
	array_push($edata, array('positionid'=>$i,'lasttime'=>0,'percent'=>0));
}
$totallast=0;
while ($row=mysql_fetch_array($result)){
	$nowtime=$row['totime'];
	$lastmin= (strtotime($nowtime) - strtotime($lasttime))/60; 
	$position=$row['position'];
	array_push($elist, array('t'=>$row['totime'] ,'i'=>$position,'last'=>$lastmin));
	if($position>=0){
		$edata[$position][lasttime]+=$lastmin;
	}
	$lasttime=$nowtime;
	$totallast+=$lastmin;
}

for($i=0;$i<=7;$i++){
	$edata[$i][percent]=$edata[$i][lasttime]/$totallast;
}

$positionStation=$edata[3][lasttime]/($edata[3][lasttime]+$edata[4][lasttime]);
$wrongPositionLast=$edata[4][lasttime];

echo json_encode(array('status'=>200,'positionStation'=>$positionStation,'wrongPositionLast'=>$wrongPositionLast,'elist'=>$elist,'edata'=>$edata));


?>