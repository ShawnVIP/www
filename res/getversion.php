<?php

include "dbconnect.php";

$sql="select * from appversion order by id desc limit 0,1";
$result=mysql_query($sql, $conn);

$row=mysql_fetch_array($result);


$appversion=$row['appversion'];
$appurl=$row['appurl'];
$hardversion=$row['hardversion'];
$binfilename=$row['binfilename'];


echo json_encode(array('status'=>200, 'appversion'=>$appversion,'appurl'=>$appurl,'hardversion'=>$hardversion,'binfilename'=>'hardbin/'.$binfilename));	

?>