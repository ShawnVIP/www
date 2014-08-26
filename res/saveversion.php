<?php

include "dbconnect.php";
writeGetUrlInfo();
$appversion=$_POST[appversion];
$appurl=$_POST[appurl];
$hardversion=$_POST[hardversion];

$tmpFile=$_FILES["binfile"]["tmp_name"];
$binfilename=$_FILES["binfile"]["name"];
$oldname=substr($binfilename,0,strlen($binfilename)-4);
$i=97;
while ( file_exists("../hardbin/" .$binfilename)){
	$binfilename=$oldname . chr($i) . ".bin";
	$i++;
}

move_uploaded_file($_FILES["binfile"]["tmp_name"],"../hardbin/" .$binfilename );

$update=date("Y-m-d H:i:s");


$sql="INSERT INTO appversion(appversion, appurl, hardversion, udate, binfilename) VALUES ('$appversion', '$appurl', '$hardversion', '$update', '$binfilename')";
$result=mysql_query($sql, $conn);
//echo $sql;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<script>

document.location="../hardbin/uploadbin.php";
</script>
</body>
</html>
