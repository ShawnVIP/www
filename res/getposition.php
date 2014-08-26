<?php
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

//$json_string='{"ucode":"7ZYSquiG2Q0BEibjMXpYJnPnydPgtIdUCq9M","scode":"605","ecode":"640S9VQGT5x80rsE","source":"w","stamp":"2013-8-20 17:55:52","alertlist":[{"stamp":"'.$now.'","type":129}]}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$date=$obj -> dates;
$fcode=$obj-> fcode;

checkuser($ucode,$scode,$ecode,$source);
if($scode != $fcode){
	$sql="select * from familylist where sensorid=$scode and friendid=$fcode and guardian=1";
	$result=mysql_query($sql,$conn); 
	if(! mysql_fetch_array($result)){
			
		echo json_encode(array('status'=>506,'message'=>'wrong linkage between two sensorid'));
		exit();
	}
}


$poslist=array();
$sql="SELECT * FROM sensorposition where udate like '" . $date . "%' and scode='$fcode' order by udate";
$result=mysql_query($sql,$conn);
while ($row=mysql_fetch_array($result)) {
	
	array_push($poslist,array('stamp'=> $row['udate'],'longitude'=>$row['longitude'],'latitude'=>$row['latitude']));

}
$alertlist=array();
$sql="SELECT * FROM alertposition where udate like '" . $date . "%' and scode='$fcode' order by udate";
$result=mysql_query($sql,$conn);
while ($row=mysql_fetch_array($result)) {
	
	array_push($alertlist,array('stamp'=> $row['udate'],'longitude'=>$row['longitude'],'latitude'=>$row['latitude']));

}
$sensor=array();

$sql="SELECT * FROM sensorstation where sensorid=$fcode and sdate='$date' and delmark=0 order by totime";
//echo $sql;
$result=mysql_query($sql,$conn); 

while($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();
	array_push($vname,"totime");
	array_push($value,$row['totime']);
	array_push($vname,"position");
	array_push($value,$row['position']);
	array_push($vname,"lasttime");
	array_push($value,$row['lasttime']);
	array_push($sensor,array_combine($vname,$value));
	
}

echo json_encode(array('status'=>200,'poslist'=>$poslist,'alertlist'=>$alertlist,'stationlist'=>$sensor));

?>

