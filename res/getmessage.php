<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"mode":"0","numberperpage":"1000","pagenumber":"1","ucode":"L222syBlfPBqCfrcMxnh3AMWtdROaEHtlyVv","scode":"1","ecode":"AJvb6U2I22jPeebK","source":"a"}';

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$fcode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;

$readmode=(int)$obj->readmode;



checkuser($ucode,$scode,$ecode,$source);

$sql="select language from sensorinfo where id=$scode";
$result=mysql_query($sql, $conn);
$row=mysql_fetch_array($result);
$lang=strtolower($row['language']);

if($readmode==2){
	$checkStr="";
}else{
	$checkStr=" and a.readmode=" . $readmode;
}

$sql ="SELECT count(a.id) as cid,a.fromid FROM message as a, sensorinfo as b WHERE a.delmark=0 and a.fromid=b.id and a.toid=$scode  " . $checkStr . " group by a.fromid";
//echo $sql;
$numberList=array();
$result=mysql_query($sql, $conn);
$totalnumber=0;
while($row=mysql_fetch_array($result)){
	array_push($numberList,array('fcode'=>$row['fromid'],'msgnumbers'=>$row['cid'],'latestmsg'=>array()));
	$totalnumber+=(int)$row['cid'];
}

$requirement=array();
$mname=array();

//-------get message-----------

for($i=0;$i<count($numberList);$i++){
	$sql ="SELECT a.id, a.readmode,a.fromid,a.message,a.sdate,a.readmode,b.nickname,b.headimage FROM message as a, sensorinfo as b WHERE a.delmark=0 and a.fromid=b.id and a.toid=$scode and a.fromid=". $numberList[$i][fcode] . $checkStr ." order by sdate desc limit 0,1";
	$result=mysql_query($sql, $conn);
	$row=mysql_fetch_array($result);
	$numberList[$i][latestmsg]=array('nickname'=>$row['nickname'],'headimage'=>$row['headimage'],'sdate'=>$row['sdate'],'messageid'=>$row['id'],'message'=>$row['message'],'readmode'=>$row['readmode']);

}

$sql="SELECT a.id,a.rdate,a.fromscode,a.reltome,b.nickname,b.headimage,c.cn_name,c.en_name FROM familyreqlist as a, sensorinfo as b,relation as c where a.toscode=1 and b.id=a.fromscode and a.relforme=c.id order by a.rdate desc";
//echo $sql;
$result=mysql_query($sql, $conn);
while($row=mysql_fetch_array($result)){
	array_push($requirement,array('fcode'=>$row['fromscode'],'nickname'=>$row['nickname'],'headimage'=>$row['headimage'],'rdate'=>$row['rdate'],'requireid'=>$row['id'],'relation'=>$row[$lang.'_name']));
	
}

echo json_encode(array('status'=>200,'totalmsgnumbers'=>$totalnumber,'msglist'=>$numberList,'reqlist'=>$requirement));


?>