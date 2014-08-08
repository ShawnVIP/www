<?php



$jpg = $xmlstr;


$file = fopen("p1.jpg", 'rb');

/*
while(!feof($file)){
	
}
*/
$head = fread($file, filesize("p1.jpg"));
fclose($file);


$tmpFile="n1.jpg";
$finalfilename="n2.jpg";

//$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

//$head =  $GLOBALS['HTTP_RAW_POST_DATA'];


$begin=0;
for($i=0;$i< strlen($head);$i++){
	$midstr=substr($head,$i,1);
	$order=	ord($midstr);
	if($order==255){
		$begin=$i;
		$i=strlen($head);
	}
}

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
//echo json_encode($strlist);

echo json_encode($valuelist);


//preg_match_all('/--Boundary[+A-Z0-9]*/', $headstr, $media);  

//unset($data);  
//echo json_encode($media);

//$strlist=split (";", $passwd_line, 5);


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

//fclose($file);
/*


*/


//echo json_encode($arr);

/*

$file = fopen("../upload/".$filename, 'wb');
fwrite($file,$jpg);
fclose($file);
*/

?>