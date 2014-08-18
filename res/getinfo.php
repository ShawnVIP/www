<?php 
include "dbconnect.php";

/*
create view totalinfo as select b.fallalert,b.positionalert, b.defaultgoal, b.transmitpower,b.fallthreshold,b.fallimpact,b.fallangleh,b.fallanglel,a.orderlist,a.userid,a.station,a.connected,b.power,b.lastupdate as lastupdate,b.nickname,b.headimage,b.dob,b.gender,b.unit, b.vipmode,b.language, c.*,b.detailid  from sensorlist as a, sensorinfo as b,dailyvalue as c where  a.sensorid=b.id and c.sensorid=b.id
*/


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","ecode":"CSvynzkQDDreFJEp","source":"w","cdate":"2014-8-16 下午8:10:54"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$cdate=formatDateStr($obj -> cdate);

checkuser($ucode,$scode,$ecode,$source);




$valueList=checkDailyValue($scode,$cdate,1,true);


$infoList=array();

$email="";
$sql="select email from accountinfo where  userid='$ucode'";
$result=mysql_query($sql,$conn);
if ($row=mysql_fetch_array($result)) {
	$email=$row['email'];
}else{
	echo json_encode(array('status'=>'101','message'=>'no user found'));
	exit;
}

$sql ="SELECT * FROM totalinfo  WHERE  sensorid='$scode' and date='$cdate'";
$outList=array();
$result=mysql_query($sql,$conn);
if ($row=mysql_fetch_array($result)) {
	
	$vname=array();
	$value=array();
	array_push($vname,"email");
	array_push($value,$email);
	array_push($vname,"station");
	array_push($value,$row['station']);
	array_push($vname,"connected");
	array_push($value,$row['connected']);
	array_push($vname,"power");
	array_push($value,$row['power']);
	array_push($vname,"lastupdate");
	array_push($value,$row['lastupdate']);
	array_push($vname,"sensorid");
	array_push($value,$row['sensorid']);
	array_push($vname,"nickname");
	array_push($value,$row['nickname']);
	array_push($vname,"headimage");
	array_push($value,$row['headimage']);
	array_push($vname,"dob");
	array_push($value,$row['dob']);
	array_push($vname,"unit");
	array_push($value,$row['unit']);
	array_push($vname,"gender");
	array_push($value,$row['gender']);
	array_push($vname,"language");
	array_push($value,$row['language']);
	array_push($vname,"defaultgoal");
	array_push($value,$row['defaultgoal']);
	array_push($vname,"fallalert");
	array_push($value,$row['fallalert']);
	array_push($vname,"positionalert");
	array_push($value,$row['positionalert']);
	array_push($vname,"para0");
	array_push($value,$row['transmitpower']);
	array_push($vname,"para1");
	array_push($value,$row['fallthreshold']);
	array_push($vname,"para2");
	array_push($value,$row['fallimpact']);
	array_push($vname,"para3");
	array_push($value,$row['fallangleh']);
	array_push($vname,"para4");
	array_push($value,$row['fallanglel']);
	array_push($vname,"detailid");
	array_push($value,$row['detailid']);	
	array_push($vname,"usertype");
	array_push($value,$row['vipmode']);	
	
	
	$sqla ="SELECT count(a.message) as message from familyreqlist as a,sensorinfo as b where a.fromscode=b.id and a.toscode=$scode and a.deal=0";
	$resulta=mysql_query($sqla,$conn);
	$rowa=mysql_fetch_array($resulta);
	
	array_push($vname,"message");
	array_push($value,$rowa['message']);
	array_push($infoList,array_combine($vname,$value));
	
	array_push($outList,array_merge($valueList[0],$infoList[0]));
	echo json_encode(array('status'=>200,'sensorlist'=>$outList,'ecode'=>$ecode));
}else{
	echo json_encode(array('status'=>201,'message'=>'no info found'));
}

?>