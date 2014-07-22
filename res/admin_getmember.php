<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$scode=$obj -> sensorid;
$date=$obj -> date;



//--------------check ucode---------------------
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
$myfriend=array();
$sql="select * from familylist where sensorid=$scode and delmark=0 order by sdate";
//echo $sql;
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();

	array_push($vname,"friendid");
	array_push($value,$row['friendid']);
	
	array_push($vname,"sdate");
	array_push($value,$row['sdate']);
	
	array_push($vname,"relation");
	array_push($value,$row['relation']);
	
	array_push($vname,"guardian");
	array_push($value,$row['guardian']);
	
	array_push($myfriend,array_combine($vname,$value));
	
}

$friendme=array();
$sql="select * from familylist where friendid=$scode and delmark=0 order by sdate";
//echo $sql;
$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();

	array_push($vname,"sensorid");
	array_push($value,$row['sensorid']);
	
	array_push($vname,"sdate");
	array_push($value,$row['sdate']);
	
	array_push($vname,"relation");
	array_push($value,$row['relation']);
	
	array_push($vname,"guardian");
	array_push($value,$row['guardian']);
	
	array_push($friendme,array_combine($vname,$value));
	
}

echo json_encode(array('status'=>200,'myfriend'=>$myfriend,'friendme'=>$friendme));

?>