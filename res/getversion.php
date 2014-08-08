<?php

include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$totalmode=$obj -> totalmode;
if($totalmode==1){
	
	
	$verlist=array();
	$sql="select * from appversion order by id desc";
	$result=mysql_query($sql, $conn);
	while($row=mysql_fetch_array($result)){
	
		$appversion=$row['appversion'];
		$appurl=$row['appurl'];
		$hardversion=$row['hardversion'];
		$binfilename=$row['binfilename'];
		array_push($verlist,array('appversion'=>$appversion,'appurl'=>$appurl,'hardversion'=>$hardversion,'binfilename'=>'hardbin/'.$binfilename,'update'=>$row['udate']));
	}
	
	echo json_encode(array('status'=>200, 'binlist'=>$verlist));	
	exit;
}

$sql="select * from appversion order by id desc limit 0,1";
$result=mysql_query($sql, $conn);

$row=mysql_fetch_array($result);


$appversion=$row['appversion'];
$appurl=$row['appurl'];
$hardversion=$row['hardversion'];
$binfilename=$row['binfilename'];


echo json_encode(array('status'=>200, 'appversion'=>$appversion,'appurl'=>$appurl,'hardversion'=>$hardversion,'binfilename'=>'hardbin/'.$binfilename));	

?>