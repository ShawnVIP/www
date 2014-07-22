<?php

include "dbconnect.php";
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$fid=$obj-> fid;
$source=$obj -> source;
$reltome=$obj -> reltome;
$relforme=$obj -> relforme;
$guardian=$obj -> guardian;

if($guardian=="" ){
	if( $relforme =="friend"){
		$guardian=0;
	}else{
		$guardian=1;
	} //default set guardian for all family
}
checkuser($ucode,$scode,$ecode,$source);

$now=date("Y-m-d H:i:s");
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql = "select id from familyreqlist where fromscode=? and toscode=? and delmark=0 and deal=0";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $scode,$fid);
$stmt->execute();
$stmt->store_result();
if($stmt->fetch()){
	echo json_encode(array('status'=>'205'));
	exit;
}

$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$relaLib=array();

array_push($relaLib,array('name'=>'爷爷/外公','id'=>1));
array_push($relaLib,array('name'=>'奶奶/外婆','id'=>2));
array_push($relaLib,array('name'=>'爸爸','id'=>3));
array_push($relaLib,array('name'=>'妈妈','id'=>4));
array_push($relaLib,array('name'=>'姐妹','id'=>5));
array_push($relaLib,array('name'=>'兄弟','id'=>6));
array_push($relaLib,array('name'=>'表兄弟','id'=>7));
array_push($relaLib,array('name'=>'阿姨/姑妈/伯母/舅妈','id'=>8));
array_push($relaLib,array('name'=>'叔叔/姑父/伯父/舅父','id'=>9));

for($i=0;$i<count($relaLib);$i++){
	if($relforme==$relaLib[$i][name]){
		$relforme=$relaLib[$i][id];
	}
	if($reltome==$relaLib[$i][name]){
		$reltome=$relaLib[$i][id];
	}
}

$sql="select * from relation where cn_name='$reltome' or en_name='$reltome'";

$result=mysql_query($sql, $conn);
if($row=mysql_fetch_array($result)){
	$reltome=$row['id'];
}

$sql="select * from relation where cn_name='$relforme' or en_name='$relforme'";

$result=mysql_query($sql, $conn);
if($row=mysql_fetch_array($result)){
	$relforme=$row['id'];
}
$sql = "insert into familyreqlist (fromucode,fromscode,toscode,rdate,reltome,relforme,guardian) values ('$ucode',$scode,$fid,'$now','$reltome','$relforme',$guardian)"; //预处理sql语句

$result=mysql_query($sql, $conn);

/*
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("sssssss", $ucode,$scode,$fid,$now,$reltome,$relforme,$guardian);
$stmt->execute();

$mysqli->close();
*/
echo json_encode(array('status'=>200));	
	 
?>