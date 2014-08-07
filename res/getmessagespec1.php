<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$json_string='{"readmode":"0","ucode":"L222syBlfPBqCfrcMxnh3AMWtdROaEHtlyVv","scode":"605","fcode":"591","ecode":"AJvb6U2I22jPeebK","source":"a","direction":"0","msgid":262,"msgnumber":20}';

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

if($readmode==2){
	$checkStr="";
}else{
	$checkStr=" and a.readmode=" . $readmode;
}

if($direction==1){
	$sql ="SELECT a.id,a.fromid, a.message,a.sdate,b.nickname, b.headimage FROM message as a,sensorinfo as b  WHERE b.id=a.fromid and  a.id>$msgid and a.delmark=0 and ((a.toid=$scode and a.fromid=$fcode) or (a.toid=$fcode and a.fromid=$scode))  " . $checkStr ." order by a.id limit 0,$msgnumber";
}else{
	$msgstr="";
	if($msgid>0){
		$msgstr='and a.id<' .$msgid;
	}
	$sql ="SELECT a.id,a.fromid, a.message,a.sdate,b.nickname, b.headimage FROM message as a,sensorinfo as b  WHERE b.id=a.fromid  $msgstr and a.delmark=0 and ((a.toid=$scode and a.fromid=$fcode) or (a.toid=$fcode and a.fromid=$scode))  " . $checkStr ." order by a.id desc limit 0,$msgnumber";
}

//echo $sql;

$msglist=array();
$result=mysql_query($sql, $conn);

while($row=mysql_fetch_array($result)){
	array_push($msglist,array('messageid'=>$row['id'],'message'=>$row['message'],'sdate'=>$row['sdate'],'scode'=>$row['fromid'],'nickname'=>$row['nickname'],'headimage'=>$row['headimage']));
	$sqla="update message set readmode=1 where id=" . $row['id'];
	$resulta=mysql_query($sqla, $conn);
}

echo json_encode(array('status'=>200,'msglist'=>$msglist));

?>