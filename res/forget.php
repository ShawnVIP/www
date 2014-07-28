<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$email=$obj -> email;

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 
$sql ="select userid from accountinfo where email=?";
$userid="";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userid); 
if (! $stmt->fetch()) {
	echo json_encode(array('status'=>401)); //邮件不存在
	exit;
}
$key=randomkeys(32);
/*if($username==""){
	$username=substr($email,0,strpos($email,"@"));
}*/
$sql ="update accountinfo set forgetstr='" . $key . "' where email=?";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $email);
$stmt->execute();


require("class.phpmailer.php"); //下载的文件必须放在该文件所在目录
$mail = new PHPMailer(); //建立邮件发送类
/*

$address ="info@sense-u.com";

$mail->IsSMTP(); // 使用SMTP方式发送
$mail->Host = "smtpout.secureserver.net"; // 您的企业邮局域名

$mail->SMTPAuth = true; // 启用SMTP验证功能
//$mail->SMTPSecure = "ssl"; 
$mail->Username = "info@sense-u.com"; // 邮局用户名(请填写完整的email地址)
$mail->Password = "ledonetwork123"; // 邮局密码

//$mail->Port=80;
//$mail->Port=25;


$mail->AddReplyTo("info@sense-u.com","sense-u");   //回复的邮件地址 

$mail->From = "info@sense-u.com"; //邮件发送者email地址
$mail->FromName = "sense-u";

 */
$address ="shawn@haisw.net";

$mail->IsSMTP(); // 使用SMTP方式发送
$mail->Host = "mail.haisw.net"; // 您的企业邮局域名

$mail->SMTPAuth = true; // 启用SMTP验证功能
$mail->SMTPSecure = "tls"; 

$mail->Username = "shawn@haisw.net"; // 邮局用户名(请填写完整的email地址)
$mail->Password = "iris040530"; // 邮局密码

$mail->Port=587;
//$mail->Port=25;


$mail->AddReplyTo("info@sense-u.com","sense-u");   //回复的邮件地址 

$mail->From = "info@sense-u.com"; //邮件发送者email地址
$mail->FromName = "sense-u";



$mail->AddAddress("$email", "$username");//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
//$mail->AddReplyTo("", "");
//$mail->AddAttachment("/var/tmp/file.tar.gz"); // 添加附件
$mail->IsHTML(true); // set email format to HTML //是否使用HTML格式
//$mail->WordWrap   = 80; //设置换行  
//$mail->MsgHTML($body);   //邮件的内容 
//$mail->SetLanguage('zh_cn');     //设置错误信息语言为简体中文 
$mail->Subject = "Forgotten Password from sense-u"; //邮件标题

//$mail->AltBody = "This is the body in plain text for non-HTML mail clients"; //附加信息，可以省略
$mail->Body = "<p>$email, We received a request to reset your password. To reset your password and access your account, click the link below.</p><p><a href='https://haisw.net/sense-u/?mail=$email&passkey=$key'>Reset Password</a></p>
<p>The link resets your forgotten password and lets you create a new one. If you didn’t request to change your password, please report this Reset Password email to us at <a href='mailto:info@sense-u.com'>info@sense-u.com</a></p><p>Thank you for using sense-u.com!</p>";
if(!$mail->Send())
{
echo json_encode(array('status'=>'402','message'=>($mail->ErrorInfo)));
exit;
}
echo json_encode(array('status'=>'200'));

	//echo('{"status":0,"userInfo":{"username":"' . $xName . '","email":"' . $email . '","id":12,"age":' . $age . ',"sex":"' . $sex .'","country":"China","city":"Beijing","head":"head/me.jpg","citycode":2151330}}');

?>