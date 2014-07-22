<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$scode=$obj -> sensorid;
$datestr=$obj -> date;



//--------------check ucode---------------------
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
$sensor=array();
$sql="SELECT * FROM basedata_$datestr where sensorid=$scode order by stime";
//echo $sql;
$result=mysql_query($sql,$conn); 

while($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();
	array_push($vname,"time");
	array_push($value,$row['stime']);
	array_push($vname,"calories");
	array_push($value,$row['calories']);
	array_push($vname,"steps");
	array_push($value,$row['steps']);
	array_push($vname,"distance");
	array_push($value,$row['distance']);
	array_push($vname,"move");
	array_push($value,$row['move']);
	array_push($vname,"sleepmode");
	array_push($value,$row['sleepmode']);
	array_push($vname,"angle");
	array_push($value,$row['angle']);
	array_push($vname,"maxspeed");
	array_push($value,$row['maxspeed']);
	array_push($vname,"minspeed");
	array_push($value,$row['minspeed']);
	array_push($vname,"averagespeed");
	array_push($value,$row['averagespeed']);
	array_push($vname,"detectedposition");
	array_push($value,$row['detectedposition']);
	array_push($sensor,array_combine($vname,$value));
	
}

echo json_encode(array('status'=>200,'sensorList'=>$sensor));

?>