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
$sql="select * from alertlist where sid=$scode and DATE_FORMAT(alertdate,'%Y-%m-%d')='$date' and delmark=0 order by alertdate";
//echo $sql;
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();

	array_push($vname,"alertdate");
	array_push($value,$row['alertdate']);
	
	array_push($vname,"alerttype");
	array_push($value,$row['alerttype']);
	
	array_push($vname,"alertmark");
	array_push($value,$row['alertmark']);
	
	array_push($sensor,array_combine($vname,$value));
	
}

echo json_encode(array('status'=>200,'sensorList'=>$sensor));

?>