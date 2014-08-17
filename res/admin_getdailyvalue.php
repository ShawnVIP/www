<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$scode=$obj -> sensorid;
$date=$obj -> date;
$addnew=0;
$returnmode=1;
if($_POST[mode]==1){
	$scode=$_POST[scode];
	$date=$_POST[date];
	$addnew=(int)$_POST[addnew];
	$returnmode=(int)$_POST[returnmode];
}

//INSERT INTO usedmail (email) SELECT email FROM usedmail where id=1 
//--------------check ucode---------------------

$sensor=array();
$sql="select * from dailyvalue where sensorid=$scode and date='$date'";
//echo $sql;
$newmode=0;
$result=mysql_query($sql,$conn); 
if(!$row=mysql_fetch_array($result)){
	$sql="SELECT * FROM dailyvalue where sensorid=$scode and date<'$date' order by date desc limit 0,1 ";	
	$result=mysql_query($sql,$conn); 
	$row=mysql_fetch_array($result);
	$newmode=1;
}
$age=$row['age'];
$height=$row['height'];
$weight=$row['weight'];
$step=$row['step'];
$stepwidth=$row['stepwidth'];
$runningwidth=$row['runningwidth'];
$bmr=$row['bmr'];
$bmi=$row['bmi'];
$stepgoal=$row['stepgoal'];
$caloriesgoal=$row['caloriesgoal'];
$distancegoal=$row['distancegoal'];
$sleepgoal=$row['sleepgoal'];
if($newmode==1){	
	
	$sql="INSERT INTO dailyvalue (date,sensorid,age,height,weight,step,stepwidth,runningwidth,bmr,bmi,stepgoal,caloriesgoal,distancegoal,sleepgoal) value ('$date',$scode,$age,$height,$weight,$step,$stepwidth,$runningwidth,$bmr,$bmi,$stepgoal,$caloriesgoal,$distancegoal,$sleepgoal)";
	$result=mysql_query($sql,$conn);
	
	$totalsteps=0;
	$totalcal=0;
	$totaldistance=0;
	$totalsleep=0;
	$updated=0;
}else{
	$totalsteps=$row['totalsteps'];
	$totalcal=$row['totalcal'];
	$totaldistance=$row['totaldistance'];
	$totalsleep=$row['totalsleep'];
	$updated=$row['updated'];
}

if($returnmode==1){
	
	$vname=array();
	$value=array();
	
	array_push($vname,"age");
	array_push($value,$age);
	
	array_push($vname,"updated");
	array_push($value,$updated);
	
	array_push($vname,"height");
	array_push($value,$height);
	
	array_push($vname,"weight");
	array_push($value,$weight);
	array_push($vname,"step");
	array_push($value,$step);
	array_push($vname,"stepwidth");
	array_push($value,$stepwidth);
	array_push($vname,"runningwidth");
	array_push($value,$runningwidth);
	
	array_push($vname,"bmr");
	array_push($value,$bmr);
	array_push($vname,"bmi");
	array_push($value,$bmi);
	
	array_push($vname,"stepgoal");
	array_push($value,$stepgoal);
	
	array_push($vname,"totalsteps");
	array_push($value,$totalsteps);
	
	array_push($vname,"caloriesgoal");
	array_push($value,$caloriesgoal);
	
	array_push($vname,"totalcal");
	array_push($value,$totalcal);
	
	array_push($vname,"distancegoal");
	array_push($value,$distancegoal);
	
	array_push($vname,"totaldistance");
	array_push($value,$totaldistance);
	
	array_push($vname,"sleepgoal");
	array_push($value,$sleepgoal);
	
	array_push($vname,"totalsleep");
	array_push($value,$totalsleep);
		
	array_push($sensor,array_combine($vname,$value));
	echo json_encode(array('status'=>200,'sensorList'=>$sensor));
}

?>