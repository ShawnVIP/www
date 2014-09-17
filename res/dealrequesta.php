<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$json_string='{
    "reltome": "4",
    "relforme": "14",
    "guardian": "2",
    "cdate": "2014-09-16 17:31:28",
    "ecode": "NsRRkEAUZEJBSU6S",
    "ucode": "EQsaWrSnsNxKoxuAnVeWI9I1xLoiJXH8knf6",
    "source": "a",
    "scode": "675",
    "devicetoken": "b4960c98 7be9cfae 47aee3f7 fc58724f 706b9619 239070e5 25bfe0be 1c403444",
    "fid": "321"
}';

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$action=$obj -> action;
$reqcode=$obj -> reqcode;
$now=date("Y-m-d H:i:s");
checkuser($ucode,$scode,$ecode,$source);

if($action=="accept"){$accept=1;}else{$accept=2;}

//--------------check ucode---------------------


$sql="select * from familyreqlist where fromscode=$reqcode and toscode=$scode";
$result=mysql_query($sql, $conn);
if($row=mysql_fetch_array($result)){
	$guardian=$row['guardian'];
	$becare=$row['becare'];
	$reltome=$row['reltome'];
	$relforme=$row['relforme'];
}else{
	echo json_encode(array('status'=>'505','message'=>'no relavance'));
	exit;
}


if($accept==2){
	echo json_encode(array('status'=>'200','message'=>'already decline'));
	exit;
}
$sql="insert into familylist (sensorid,friendid,sdate,relation,guardian,becare) values ($reqcode,$scode,'$now','$relforme',$guardian,$becare)";
echo $sql;
//$result=mysql_query($sql, $conn);

$guardian==1 ? $nbecare=1:$nbecare=0;

$becare==1 ? $nguardian=1:$nguardian=0;
	
$sql="insert into familylist (sensorid,friendid,sdate,relation,guardian, becare) values ($scode,$reqcode,'$now','$reltome',$nguardian,$nbecare)";

echo $sql;

//$result=mysql_query($sql, $conn);
	
$sql="delete from familyreqlist where fromscode=$reqcode and toscode=$scode";
//$result=mysql_query($sql, $conn);

echo json_encode(array('status'=>200,'ecode'=>$ecode));


?>