<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-9-22","cdate":"2013-9-22 13:35:22","ecode":"SpmcZjeQEcUvf1Bq","source":"w"}';
//$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2013-10-10","cdate":"2013-10-10 23:03:22","ecode":"LNMzlQlYjC09Nc5x","source":"w"}';
//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2014-1-1","cdate":"2014-1-1 23:03:22","ecode":"FShs3C7M8o37W5Vk","source":"w"}';
$json_string='{"type":"act","ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"1","dates":"2014-8-16","cdate":"2014-6-26 22:50:51","ecode":"qyRYwl3L4LUKXkir","source":"a"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$dates=$obj -> dates;
$cdate=$obj -> cdate;
$source=$obj -> source;



checkuser($ucode,$scode,$ecode,$source);

$goalonly=$obj -> source;
//checkuser($ucode,$scode,$ecode,$source);

$goalonly=1;


$valueList=checkDailyValueb($scode,$dates,1,true);


echo json_encode(array('status'=>200,'caloriesgoal'=>$valueList[0][caloriesgoal],'distancegoal'=>$valueList[0][distancegoal],'stepgoal'=>$valueList[0][stepgoal],'sleepgoal'=>$valueList[0][sleepgoal],'caloriestoken'=>$valueList[0][totalcal],'distancetoken'=>$valueList[0][totaldistance],'steptoken'=>$valueList[0][totalsteps],'sleeptoken'=>$valueList[0][totalsleep],'ecode'=>$ecode));
	
function checkDailyValueb($scode,$date,$addnew,$returnmode){
	global $conn;
	
	$valueList=array();
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
	echo $sql;
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
		if($addnew==1){
			$sql="INSERT INTO dailyvalue (date,sensorid,age,height,weight,step,stepwidth,runningwidth,bmr,bmi,stepgoal,caloriesgoal,distancegoal,sleepgoal) value ('$date',$scode,$age,$height,$weight,$step,$stepwidth,$runningwidth,$bmr,$bmi,$stepgoal,$caloriesgoal,$distancegoal,$sleepgoal)";
			$result=mysql_query($sql,$conn);
		}
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
	
	if($returnmode){
		
		$vname=array();
		$value=array();
		
		array_push($vname,"age");
		array_push($value,(int)$age);
		
		array_push($vname,"updated");
		array_push($value,(int)$updated);
		
		array_push($vname,"height");
		array_push($value,(float)$height);
		
		array_push($vname,"weight");
		array_push($value,(float)$weight);
		array_push($vname,"step");
		array_push($value,(int)$step);
		array_push($vname,"stepwidth");
		array_push($value,(int)$stepwidth);
		array_push($vname,"runningwidth");
		array_push($value,(int)$runningwidth);
		
		array_push($vname,"bmr");
		array_push($value,(float)$bmr);
		array_push($vname,"bmi");
		array_push($value,(float)$bmi);
		
		array_push($vname,"stepgoal");
		array_push($value,(int)$stepgoal);
		
		array_push($vname,"totalsteps");
		array_push($value,(int)$totalsteps);
		
		array_push($vname,"caloriesgoal");
		array_push($value,(int)$caloriesgoal);
		
		array_push($vname,"totalcal");
		array_push($value,(int)$totalcal);
		
		array_push($vname,"distancegoal");
		array_push($value,(float)$distancegoal);
		
		array_push($vname,"totaldistance");
		array_push($value,(float)$totaldistance);
		
		array_push($vname,"sleepgoal");
		array_push($value,(int)$sleepgoal);
		
		array_push($vname,"totalsleep");
		array_push($value,(int)$totalsleep);
			
		array_push($valueList,array_combine($vname,$value));
		return $valueList;
	}
	
}


?>

