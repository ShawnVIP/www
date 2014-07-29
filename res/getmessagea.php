<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$json_string='{"mode":"2","numberPerPage":"1000","pageNumber":"1","ucode":"L222syBlfPBqCfrcMxnh3AMWtdROaEHtlyVv","scode":"1","dates":"2014-6-1","ecode":"AJvb6U2I22jPeebK","source":"a","cdate":"2014-06-17 17:27:32"}';

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$number=(int)$obj -> numberperpage;
$page=(int)$obj -> pagenumber;
$mode=(int)$obj -> mode;

// scheckuser($ucode,$scode,$ecode,$source);



//--------------check ucode---------------------

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

if($mode==2){
	$checkStr="";
}else{
	$checkStr="and a.readmode=" . $mode;
}

$sqla ="SELECT count(fromid) as cid FROM message as a, sensorinfo as b WHERE a.delmark=0 and a.fromid=b.id and a.toid=? " . $checkStr;
$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("s",$scode);
$stmta->execute();
$stmta->store_result();
$stmta->bind_result($cid);
$stmta->fetch();
	
$sqla ="SELECT a.id, a.readmode,a.fromid,a.message,a.sdate,a.readmode,b.nickname,b.headimage FROM message as a, sensorinfo as b WHERE a.delmark=0 and a.fromid=b.id and a.toid=? " . $checkStr ." order by sdate desc limit ". ($page-1)*$number."," .$number ;
$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("s",$scode);
$stmta->execute();
$stmta->store_result();
$stmta->bind_result($messageid,$readmode,$fcode,$message, $sdate, $readmode,$nickname,$headimage);
	
$mname=array();
	
while ($stmta->fetch()) {
	array_push($mname,array('fcode'=>$fcode,'nickname'=>$nickname,'headimage'=>$headimage,'sdate'=>$sdate,'messageid'=>$messageid,'message'=>$message,'readmode'=>$readmode));	
}

echo json_encode(array('status'=>200,'totalnumber'=>$cid,'msglist'=>$mname));


?>