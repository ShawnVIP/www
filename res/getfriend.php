<?php 
include "dbconnect.php";
header("Content-Type: text/html;charset=utf-8"); 
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$lang=strtolower($obj -> lang);

$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
mysql_query("SET NAMES 'UTF8'");

$lang="cn";
$sql="select * from relation order by id";
//echo $sql;

$outdata=array();

$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();

	array_push($vname,"id");
	array_push($value,$row['id']);
	array_push($vname,"name");
	array_push($value,convert2utf8($row[$lang.'_name']));
	array_push($vname,"mname");
	array_push($value,$row[$lang.'_mname']);
	array_push($vname,"fname");
	array_push($value,$row[$lang.'_fname']);

	array_push($outdata,array_combine($vname,$value));
	
}



echo json_encode(array('status'=>200,'outdata'=>$outdata));


?>