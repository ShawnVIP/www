<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$scode=$obj -> sensorid;



//--------------check ucode---------------------
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
$sensor=array();
$vname=array();
$value=array();

array_push($vname,"yearmonth");
array_push($value,date("Ym"));
array_push($vname,"day");
array_push($value,date("d"));

array_push($vname,"type");
array_push($value,'base');

array_push($sensor,array_combine($vname,$value));
$sql="select * from sensordate where sensorid=$scode order by yearmonth desc, day desc";
//echo $sql;
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();

	array_push($vname,"yearmonth");
	array_push($value,$row['yearmonth']);
	array_push($vname,"day");
	array_push($value,$row['day']);

	array_push($vname,"type");
	array_push($value,$row['type']);

	array_push($sensor,array_combine($vname,$value));
	
}

	
echo json_encode(array('status'=>200,'dateList'=>$sensor));


?>