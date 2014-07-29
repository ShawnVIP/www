<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$json_string='{"ucode":"phXYXvmB3P14XkRBYoBhrCmNK8WqXkTkOQK6","scode":"629","ecode":"mmijfcVIKsHYAnTc","source":"w","lang":"cn"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;

$lang=strtolower($obj -> lang);
if($lang==""){$lang="cn";}

checkuser($ucode,$scode,$ecode,$source);


$sql="SELECT b.nickname, a.rdate,b.headimage,b.id,a.relforme,a.guardian, c." . $lang . "_name as relname from familyreqlist as a,sensorinfo as b,relation as c where a.fromscode=b.id and a.toscode=$scode and a.deal=0 and a.relforme=c.id";
echo $sql;
$result=mysql_query($sql,$conn); 
$mname=array();
$rel="Family";
while($row=mysql_fetch_array($result)){
	if($row['relforme'] != 17){
		if($lang=="cn"){
			$message="收到一个来自家人的邀请";
		}else{
			$message="You received a family invitation.	";
		}
	}else{
		if($lang=="cn"){
			$message="收到一个来自朋友的邀请";
		}else{
			$message="You received a friend invitation.	";
		}
		
	}
	array_push($mname,array('message'=>$message,'nickname'=>$row['nickname'],'rdate'=>$row['rdate'],'head'=>$row['headimage'],'scode'=>$row['id'],'relation'=>$row['relname'],'guardian'=>$row['guardian']));	
	
}

echo json_encode(array('status'=>200,'msglist'=>$mname,'ecode'=>$ecode));


?>