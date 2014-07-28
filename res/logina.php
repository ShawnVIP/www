<?php
include "dbconnect.php";



$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$email=$obj -> email;
$password=$obj -> password;

$source=$obj -> source;
$devicetoken=$obj -> devicetoken;

$ucode="";
$scode="";
$nickname="";

$email="s@sohu.com";
$password="1234";
$source="a";
$devicetoken="8d0ceae3 7d93f07d 8022070f c107bbe7 d93187cd 8b3d4747 c210abc5 5f52ebf6";

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



//--------check database--------------
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //

$sql = "select userid,salt from  accountinfo where email=?"; //
//echo  "select userid,salt from  accountinfo where email=$email";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($ucode,$salt);  
if(! $stmt->fetch()){
	echo json_encode(array('status'=>'101'));
	exit;
}
$stmt->close();
//echo "\n pass:$password, sale:$salt";
$password = convertpass($salt,$password);

$sql = "select * from  accountinfo where email=? and password=?"; 
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $email,$password);
$stmt->execute();
$stmt->store_result();

if(! $stmt->fetch()){
	echo json_encode(array('status'=>'101'));
	exit;
}
$stmt->close();

$ecode=randomkeys(16);


$sql="select id,nickname,seedkey from sensorinfo where userid=? ";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $ucode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($scode,$nickname,$kcode);  
if(! $stmt->fetch()){
	echo json_encode(array('status'=>'202','userInfo'=>array('ucode'=>$ucode,'use'=>$ecode)));
	exit;
}
$stmt->close();

saveSession($ucode,$scode,$ecode,$source);
$now=date("Y-m-d H:i:s");
if($source=="a" && $devicetoken !=""){  //upload device token
	$sql="update sensorinfo set devicetoken=? where id=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); //
	$stmt->bind_param("ss",$devicetoken, $scode);
	$stmt->execute();
	$sql="select id from devicelist where devicetoken=? and  sensorid=? ";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss",$devicetoken, $scode);
	$stmt->execute();
	if(! $stmt->fetch()){
		$sql="insert into  devicelist (devicetoken,userid,sensorid,addtime) values (?,?,?,?)";
		$stmt = $mysqli->stmt_init();
		$stmt = $mysqli->prepare($sql); 
		$stmt->bind_param("ssss",$devicetoken,$ucode, $scode,$now);
		$stmt->execute();
	}
	
}

echo json_encode(array('status'=>'200','userInfo'=>array('ucode'=>$ucode,'scode'=>$scode,'nickname'=>$nickname,'ecode'=>$ecode,'kcode'=>$kcode)));


?>