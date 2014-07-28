<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$lang=strtolower($obj -> lang);
$relation=strtolower($obj -> relation);


$sql="select * from relation where relation='$relation' order by orderid";
//echo $sql;

$outdata=array();

$result=mysql_query($sql,$conn); 
while($row=mysql_fetch_array($result)){
	
	$vname=array();
	$value=array();

	array_push($vname,"id");
	array_push($value,$row['id']);
	array_push($vname,"name");
	array_push($value,$row[$lang.'_name']);
	array_push($vname,"mname");
	array_push($value,$row[$lang.'_mname']);
	array_push($vname,"fname");
	array_push($value, $row[$lang.'_fname']);
	array_push($vname,"mid");
	array_push($value,$row['mid']);
	array_push($vname,"fid");
	array_push($value,$row['fid']);
	array_push($outdata,array_combine($vname,$value));
	
}

echo json_encode(array('status'=>200,'outdata'=>$outdata));


?>