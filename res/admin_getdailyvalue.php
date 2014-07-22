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
$sql="select * from dailyvalue where sensorid=$scode and date<='$date' order by date desc limit 0,1";
//echo $sql;
$result=mysql_query($sql,$conn); 
if($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();

	array_push($vname,"age");
	array_push($value,$row['age']);
	
	array_push($vname,"updated");
	array_push($value,$row['updated']);
	
	array_push($vname,"height");
	array_push($value,$row['height']);

	array_push($vname,"weight");
	array_push($value,$row['weight']);
	array_push($vname,"step");
	array_push($value,$row['step']);
	array_push($vname,"stepwidth");
	array_push($value,$row['stepwidth']);
	array_push($vname,"runningwidth");
	array_push($value,$row['runningwidth']);
	
	array_push($vname,"bmr");
	array_push($value,$row['bmr']);
	array_push($vname,"bmi");
	array_push($value,$row['bmi']);
	
	array_push($vname,"stepgoal");
	array_push($value,$row['stepgoal']);
	
	array_push($vname,"totalsteps");
	array_push($value,$row['totalsteps']);
	
	array_push($vname,"caloriesgoal");
	array_push($value,$row['caloriesgoal']);

	array_push($vname,"totalcal");
	array_push($value,$row['totalcal']);
	
	array_push($vname,"distancegoal");
	array_push($value,$row['distancegoal']);


	
	array_push($vname,"totaldistance");
	array_push($value,$row['totaldistance']);
	array_push($vname,"sleepgoal");
	array_push($value,$row['totalsleep']);
	
	array_push($sensor,array_combine($vname,$value));
	echo json_encode(array('status'=>200,'sensorList'=>$sensor));
}else{
	echo json_encode(array('status'=>201,'sensorList'=>$sensor));
}


?>