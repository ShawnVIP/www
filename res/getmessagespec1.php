<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$json_string='{"readmode":"0","ucode":"L222syBlfPBqCfrcMxnh3AMWtdROaEHtlyVv","scode":"1","fcode":"629","ecode":"AJvb6U2I22jPeebK","source":"a","direction":"0","msgid":246,"msgnumber":20}';

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$fcode=$obj -> fcode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$msgid=(int)$obj -> msgid;
$direction=(int)$obj -> direction;
$readmode=(int)$obj->readmode;
$msgnumber=(int)$obj -> msgnumber;



//checkuser($ucode,$scode,$ecode,$source);

$sql="select language from sensorinfo where id=$scode";

$result=mysql_query($sql, $conn);
$row=mysql_fetch_array($result);
$lang=strtolower($row['language']);

if($readmode==2){
	$checkStr="";
}else{
	$checkStr=" and readmode=" . $readmode;
}

if($direction==1){
	$sql ="SELECT * FROM message  WHERE id>$msgid and delmark=0 and toid=$scode and fromid=$fcode  " . $checkStr ." order by id limit 0,$msgnumber";
}else{
	$sql ="SELECT * FROM message  WHERE id<$msgid and delmark=0 and toid=$scode and fromid=$fcode  " . $checkStr ." order by id desc limit 0,$msgnumber";
}


$msglist=array();
$result=mysql_query($sql, $conn);

while($row=mysql_fetch_array($result)){
	array_push($msglist,array('messageid'=>$row['id'],'message'=>$row['message'],'sdate'=>$row['sdate']));
}

echo json_encode(array('status'=>200,'msglist'=>$msglist));

?>