<?php
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$email=$obj -> email;
$password=$obj -> password;
$source=$obj -> source;
$agreemail=$obj -> agreemail;
$lang=$obj -> lang;

$now=date("Y-m-d");
//$email="j@sohu.com";
//$password="1234";

if($lang==null){
	$lang="en";
}


if($email==null){
	echo json_encode(array('status'=>'403','err'=>'no email')); //
	exit;
}
if($password==null){
	echo json_encode(array('status'=>'404','err'=>'no password')); //
	exit;
}
if($source==null){
	echo json_encode(array('status'=>'405','err'=>'no source')); //
	exit;
}

if($agreemail==null){
	$agreemail=0;
}
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //mysqli

$sql = "select email from  accountinfo where email=?"; //sql
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //sqlmysqli
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if($stmt->fetch()){
	echo json_encode(array('status'=>'400','err'=>'email already exist')); //
	exit;
}
$stmt->close();

$salt=randomkeys(8);
$password= convertpass($salt,$password);


$rip=get_real_ip();
$now=date("Y-m-d G:i:s");

$userid=randomkeys(36);
$ecode=randomkeys(16);



$contbuild=true;
if($contbuild){
	$bytes = openssl_random_pseudo_bytes(16, $cstrong);
	$kcode = bin2hex($bytes);
	$sql="select id from sensorinfo where seedkey='$kcode'";
	$result=mysql_query($sql,$conn); 
	$row=mysql_num_rows($result);
	if($row==0){$contbuild=false;}
}

$sql = "insert into accountinfo (email,password,createdate,ip,userid,salt,agreemail) values (?,?,?,?,?,?,?)"; //sql
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //sqlmysqli
$stmt->bind_param("sssssss", $email,$password,$now,$rip,$userid,$salt,$agreemail);
$stmt->execute();


$sql = "insert into sensorinfo (unit,createdate,lastupdate,ip,userid,headimage,gender,seedkey,nickname) values ('Metric','$now','$now','$rip','$userid','avatar.gif','M','$kcode','')"; 

//echo $sql;
$result=mysql_query($sql,$conn); 


$sql = "select id from  sensorinfo where userid='$userid'"; //sql

$result=mysql_query($sql,$conn);
$row=mysql_fetch_array($result);
 
$scode=$row['id'];


saveSession($userid,$scode,$ecode,$source);


//------- creat a linktable between userid and sensorid
$sql = "insert into sensorlist (userid,builddate,sensorid,orderlist) values ('$userid','$now',$scode,1)"; 
$result=mysql_query($sql,$conn); 

//--------creat a default daily value for this sensor, man, 176cm, stepwidth:73cm, runningwidth:73cm. weight:87kg,  	stepgoal:10000, distancegoal:7.3km age:30. bmr=66.5+13.75*weight+5.003*height-6.755*age, bmi=weight/(height/100^2)
$default_height=176;
$default_stepwidth=$default_height*0.415;
$default_runningwidth=$default_stepwidth;
$default_weight=87;
$default_stepgoal=10000;
$default_distancegoal=$default_stepgoal*$default_stepwidth/100000;
$default_age=30;
$default_bmr=66.5+13.75*$default_weight+5.003*$default_height-6.755*$default_age;
$default_bmi=$default_weight*10000/($default_height*$default_height);
$default_sleepgoal=480;
$default_caloriesgial=4000;
$now=date("Y-m-d");
$sql="insert into dailyvalue (height,weight,step,date,stepgoal,caloriesgoal,stepwidth,distancegoal,runningwidth,bmi,updated,age,bmr,sleepgoal,sensorid) values ($default_height,$default_weight,0,'$now',$default_stepgoal,$default_caloriesgial,$default_stepwidth,$default_distancegoal,$default_runningwidth,$default_bmi,1,$default_age,$default_bmr,$default_sleepgoal, '$scode')";
//echo $strsql;
$result=mysql_query($sql,$conn); 
/*
if($source=="a" && $devicetoken !=""){  //upload device token
	$sql="insert into  devicelist (devicetoken,userid,addtime) values (?,?,?)";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //sqlmysqli
	$stmt->bind_param("sss",$devicetoken, $ucode,$now);
	$stmt->execute();
}
*/
echo json_encode(array('status'=>'201','userInfo'=>array('ucode'=>$userid,'scode'=>$scode,'ecode'=>$ecode,'kcode'=>$kcode)));

?>