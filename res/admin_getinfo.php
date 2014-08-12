<?php 
include "dbconnect.php";

/*
create view totalinfo as select b.fallalert,b.positionalert, b.defaultgoal, b.transmitpower,b.fallthreshold,b.fallimpact,b.fallangleh,b.fallanglel,a.orderlist,a.userid,a.station,a.connected,b.power,b.lastupdate as lastupdate,b.nickname,b.headimage,b.dob,b.gender,b.unit, b.vipmode,b.language, c.*,b.detailid  from sensorlist as a, sensorinfo as b,dailyvalue as c where  a.sensorid=b.id and c.sensorid=b.id
*/


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","ecode":"CvYdlBkGHxgUfH3d","source":"w"}';
$obj=json_decode($json_string); 

$mode=$obj -> mode;
$scode=$obj -> scode;
$value=strtolower($obj -> email);



//--------------check ucode---------------------

$sensor=array();
/*
if($mode=="mail"){
	$sql="select a.userid,a.email,b.* from accountinfo as a, sensorinfo as b, sensorlist as c where a.email='$email' and a.userid=c.userid  and b.id=c.sensorid";
}else{
	$sql="select a.userid,a.email,b.* from accountinfo as a, sensorinfo as b, sensorlist as c where a.userid=c.userid  and b.id=$scode and c.sensorid=$scode";	
}
*/
$finalSql="";
$sql="select a.userid,a.email,b.* from accountinfo as a, sensorinfo as b, sensorlist as c where a.email='$value' and a.userid=c.userid  and b.id=c.sensorid";

$result=mysql_query($sql,$conn); 

if($row=mysql_fetch_array($result)){
	$finalSql=$sql;
}
if($finalSql==""){
	$sql="select a.userid,a.email,b.* from accountinfo as a, sensorinfo as b, sensorlist as c where a.userid=c.userid and b.id=c.sensorid  and b.id='$value'";	
	$result=mysql_query($sql,$conn); 
	if($row=mysql_fetch_array($result)){
		$finalSql=$sql;
	}
}
if($finalSql==""){
	$sql="select a.userid,a.email,b.* from accountinfo as a, sensorinfo as b, sensorlist as c where a.userid=c.userid  and b.id=c.sensorid  and b.nickname='$value'";	
	$result=mysql_query($sql,$conn); 
	if($row=mysql_fetch_array($result)){
		$finalSql=$sql;
	}
}

//echo $finalSql;
$result=mysql_query($finalSql,$conn); 
if($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();

	array_push($vname,"userid");
	array_push($value,$row['userid']);
	array_push($vname,"sensorid");
	array_push($value,$row['id']);
	array_push($vname,"email");
	array_push($value,$row['email']);
	$email=$row['email'];

	array_push($vname,"power");
	array_push($value,$row['power']);
	array_push($vname,"lastupdate");
	array_push($value,$row['lastupdate']);

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
	array_push($vname,"updated");
	array_push($value,$row['updated']);

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
	
	array_push($vname,"createdate");
	array_push($value,$row['createdate']);
		
	array_push($vname,"devicetoken");
	array_push($value,$row['devicetoken']);	
	
	array_push($vname,"timezone");
	array_push($value,$row['timezone']);	
	array_push($vname,"age");
	array_push($value,$row['age']);	
	
	array_push($sensor,array_combine($vname,$value));
	echo json_encode(array('status'=>200,'sensorList'=>$sensor));
	
	$sql="select * from usedmail where email='$email'";
	$resulta=mysql_query($sql,$conn); 
	if(! $rowa=mysql_fetch_array($resulta)){
		$sql="INSERT INTO usedmail  (email) VALUES ('$email')";
		$resulta=mysql_query($sql,$conn); 	
	}
	
}else{
	echo json_encode(array('status'=>201,'sensorList'=>$sensor));
}




?>