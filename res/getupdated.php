<?php 
$mysql_server_name="localhost"; 
$mysql_username="ledo"; 
$mysql_password="Ledo!11@22"; 
$mysql_database="ledo";
$conn=mysql_connect($mysql_server_name, $mysql_username, $mysql_password);
mysql_select_db("ledo", $conn);
$userid=$_REQUEST['userid'];

$strsql="select * from userinfo where id=$userid";
$result=mysql_query($strsql, $conn);
$row=mysql_num_rows($result);
$vname=array();
$value=array();
if($row==1){
	$row=mysql_fetch_array($result);
	$updated=$row['updated'];
	$age=$row['age'];
	$now=date("Y-m-d");
	$strsql="select * from dailyvalue where userid=$userid and date<='$now' order by date desc limit 0,1";
	$result=mysql_query($strsql, $conn);
	$row=mysql_fetch_array($result);
	array_push($vname,"updated");
	array_push($value,$updated);
	array_push($vname,"height");
	array_push($value,$row['height']);
	array_push($vname,"weight");
	array_push($value,$row['weight']);
	array_push($vname,"stepwidth");
	array_push($value,$row['stepwidth']);
	array_push($vname,"runningwidth");
	array_push($value,$row['runningwidth']);
	array_push($vname,"bmi");
	array_push($value,$row['bmi']);
	array_push($vname,"bmr");
	array_push($value,$row['bmr']);
	array_push($vname,"age");
	array_push($value,$age);
	array_push($vname,"sensorid");
	array_push($value,$row['sensorid']);	
	
	 	
	echo json_encode(array('status'=>'200','detailInfo'=>array_combine($vname,$value)));
	//echo json_encode(array('status'=>'200','id'=>$row[id]));
}else{
	echo json_encode(array('status'=>'1','errinfo'=>'user does not exist')); //-----------没有这个用户-------------------
}

	//echo('{"status":0,"userInfo":{"username":"' . $xName . '","email":"' . $email . '","id":12,"age":' . $age . ',"sex":"' . $sex .'","country":"China","city":"Beijing","head":"head/me.jpg","citycode":2151330}}');


?>