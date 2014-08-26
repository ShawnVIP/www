<?php

include "dbconnect.php";

/*
$ucode=$_POST[ucode];
$scode=$_POST[scode];
$ecode=$_POST[ecode];
$source=$_POST[source];
$lang=$_POST[lang];
*/

$filename= randomkeys(36) . ".jpg";//要生成的图片名字
$tmpFile="../upload/_".$filename;
$finalfilename="../upload/".$filename;


$head =  $GLOBALS['HTTP_RAW_POST_DATA'];
$begin=0;

for($i=0;$i< strlen($head);$i++){
	$midstr=substr($head,$i,1);
	$order=	ord($midstr);
	if($order==255){
		$begin=$i;
		$i=strlen($head);
	}
}

//------------------get userinfo------------------------------

$headstr=substr($head,0,$begin);
$headstr=str_replace('"','',$headstr);

$headstr = preg_replace('/[\n\r\t]/', ' ', $headstr);

$pattern='/--Boundary[+A-Z0-9]*/';
$replacement='';
$headstr= preg_replace($pattern, $replacement, $headstr);

$pattern='/Content[-A-Za-z:-;]*/';
$replacement='';
$headstr= preg_replace($pattern, $replacement, $headstr);

$headstr=str_replace('form-data;','',$headstr);

$strlist=split ("name=", $headstr);

$valuelist = array();  
for($i=1;$i<count($strlist)-1;$i++){
	$tempstr=split (" ", $strlist[$i],2);
	array_push($valuelist,array(trim($tempstr[0]),trim($tempstr[1])));
	eval('$'.trim($tempstr[0]) .'="'.trim($tempstr[1]) .'";');
	
}


checkuser($ucode,$scode,$ecode,$source);

//--------------------------------

$midstr=substr($head,$begin,strlen($head)-$begin-33);
$file = fopen($tmpFile, 'wb');

fwrite($file,$midstr);
fclose($file);


list($width, $height) = getimagesize($tmpFile);

$newwidth=200;
$newheight=200;
$sourceWidth=$width;
if($width>$height){
	$sourceWidth=$height;
	$rate=$height/$newheight;
	$px=($width-$height)/2;
	$py=0;
}else{
	$rate=$width/$newwidth;
	$px=0;
	$py=($height-$width)/2;
}
// 加载图像


$ext="";
$ext="jpg";
$src_im = imagecreatefromjpeg($tmpFile);

$dst_im = imagecreatetruecolor($newwidth, $newheight);


// 调整大小
imagecopyresampled($dst_im, $src_im, 0, 0, $px, $py, $newwidth, $newheight, $sourceWidth, $sourceWidth);

//输出缩小后的图像
//imagejpeg($dst_im,"../upload/". $filename);
imagejpeg($dst_im,$finalfilename,95);

imagedestroy($dst_im);
imagedestroy($src_im);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql = "update sensorinfo set headimage=? where id=?"; //预处理sql语句
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ss", $filename,$scode);
$stmt->execute();
$stmt->close();

echo json_encode(array('status'=>200, 'picture'=>$filename, 'scode'=>$scode));	

?>