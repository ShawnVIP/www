<?php

include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$keyword=strtolower($obj-> keyword);
$source=$obj -> source;
checkuser($ucode,$scode,$ecode,$source);


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例


$sql="select s.sensorid from accountinfo as a, sensorlist as s  where a.email=? and a.userid=s.userid";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s",$keyword);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($friendid);  
if (!$stmt->fetch()) {
	echo json_encode(array('status'=>501));	
	exit;
}

if($friendid==$scode){
	echo json_encode(array('status'=>504));	
	exit;
}

$sql="select * from familyreqlist where fromscode=? and toscode=?";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ss",$scode,$friendid);
$stmt->execute();
if ($stmt->fetch()) {
	echo json_encode(array('status'=>502));	
	exit;
}

$sql="select * from familylist where sensorid=? and friendid=? and delmark=0";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ss",$scode,$friendid);
$stmt->execute();
if ($stmt->fetch()) {
	echo json_encode(array('status'=>503));	
	exit;
}



$itemList=array();   

$sql = "select nickname,headimage from sensorinfo where id=$friendid"; 

$result=mysql_query($sql,$conn); 
$row=mysql_fetch_array($result);
array_push($itemList,array('nickname'=>$row['nickname'],'id'=>$friendid,'headimage'=>$row['headimage']));

		
/*
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("s", $friendid);

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nickname,$headimge);  
$itemList=array();    
if ($stmt->fetch()) {
	if($nickname==""){$nickname="unnamed";}
	array_push($itemList,array('nickname'=>$nickname,'id'=>$friendid,'headimage'=>$headimge));
}
*/
$mysqli->close();

echo json_encode(array('status'=>200, 'memberList'=>$itemList));	

?>