<?php

include "dbconnect.php";

$ucode=$_POST[ucode];
$scode=$_POST[scode];
$ecode=$_POST[ecode];
$source=$_POST[source];
$lang=$_POST[lang];
checkuser($ucode,$scode,$ecode,$source);

$filename= randomkeys(36) . ".jpg";//要生成的图片名字

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$tmpFile=$_FILES["picture"]["tmp_name"];
$type=$_FILES["picture"]['type'];

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
switch($type) {
	case "image/jpeg":
		$ext="jpg";
		//echo "jpg";
		$src_im = imagecreatefromjpeg($tmpFile);
		break;
	case "image/png":
		$ext="png";
		//echo "png";
		$src_im = imagecreatefrompng($tmpFile);
		break;
	default:
		break;
} 

$dst_im = imagecreatetruecolor($newwidth, $newheight);


// 调整大小
imagecopyresampled($dst_im, $src_im, 0, 0, $px, $py, $newwidth, $newheight, $sourceWidth, $sourceWidth);

//输出缩小后的图像
imagejpeg($dst_im,"../upload/". $filename);

imagedestroy($dst_im);
imagedestroy($src_im);


$sql = "update sensorinfo set headimage=? where id=?"; //预处理sql语句
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ss", $filename,$scode);
$stmt->execute();
$stmt->close();

//echo json_encode(array('status'=>200, 'picture'=>$filename,'ecode'=>$ecode));	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<script>

parent.updatedHead("<?php echo $filename; ?>");
document.location="../<?php echo $lang; ?>/adjusthead.php?ucode=<?php echo $ucode; ?>&scode=<?php echo $scode; ?>&ecode=<?php echo $ecode; ?>&pic=<?php echo $filename; ?>";
</script>
</body>
</html>

