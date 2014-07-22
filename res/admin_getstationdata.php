<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$scode=$obj -> sensorid;
$date=$obj -> date;



//--------------check ucode---------------------
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
$sensor=array();
$sql="SELECT * FROM sensorstation where sensorid=$scode and sdate='$date' and delmark=0 order by totime";
//echo $sql;
$result=mysql_query($sql,$conn); 

while($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();
	array_push($vname,"totime");
	array_push($value,$row['totime']);
	array_push($vname,"position");
	array_push($value,$row['position']);
	array_push($vname,"lasttime");
	array_push($value,$row['lasttime']);
	array_push($sensor,array_combine($vname,$value));
	
}

echo json_encode(array('status'=>200,'sensorList'=>$sensor));

?>