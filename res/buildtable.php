<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<?PHP
include "dbconnect.php";
/*
CREATE TABLE IF NOT EXISTS accountInfo (
  id int(11) NOT NULL AUTO_INCREMENT,
  password varchar(255) NOT NULL,
  email varchar(50) NOT NULL,
  createdate datetime NOT NULL,
  forgetstr varchar(32) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

CREATE TABLE IF NOT EXISTS message (
  id int(11) NOT NULL AUTO_INCREMENT,
  fromid varchar(40) NOT NULL,
  toid varchar(40) NOT NULL,
  message varchar(140) NOT NULL,
  readmode tinyint(1) NOT NULL,
  sdate datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

*/
/*
$token = $_POST['stripeToken'];
$Email=$_POST['stripeEmail'];
$BillingName=$_POST['stripeBillingName'];
$BillingAddressLine1=$_POST['stripeBillingAddressLine1'];
$BillingAddressZip=$_POST['stripeBillingAddressZip'];
$BillingAddressState=$_POST['stripeBillingAddressState'];
$BillingAddressCity=$_POST['stripeBillingAddressCity'];
$BillingAddressCountry=$_POST['stripeBillingAddressCountry'];
$ShippingName=$_POST['stripeShippingName'];
$ShippingAddressLine1=$_POST['stripeShippingAddressLine1'];
$ShippingAddressZip=$_POST['stripeShippingAddressZip'];
$ShippingAddressState=$_POST['stripeShippingAddressState'];
$ShippingAddressCity=$_POST['stripeShippingAddressCity'];
$ShippingAddressCountry=$_POST['stripeShippingAddressCountry'];
$desc=$_REQUEST['desc'];
$amount= $_REQUEST['amount'];
*/

$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
$strsql="CREATE TABLE IF NOT EXISTS payinfo (
	id int(11) NOT NULL AUTO_INCREMENT,
	stime datetime DEFAULT NULL,
	token varchar(50) DEFAULT '',
	Email varchar(50) DEFAULT '',
	BillingName varchar(50) DEFAULT '',
	BillingAddressLine1 varchar(50) DEFAULT '',
	BillingAddressZip varchar(50) DEFAULT '',
	BillingAddressState varchar(50) DEFAULT '',
	BillingAddressCity varchar(50) DEFAULT '',
	BillingAddressCountry varchar(50) DEFAULT '',
	ShippingName varchar(50) DEFAULT '',
	ShippingAddressLine1 varchar(50) DEFAULT '',
	ShippingAddressZip varchar(50) DEFAULT '',
	ShippingAddressState varchar(50) DEFAULT '',
	ShippingAddressCity varchar(50) DEFAULT '',
	ShippingAddressCountry varchar(50) DEFAULT '',
	descript varchar(50) DEFAULT '',
	amount smallint(6) DEFAULT '0',
	PRIMARY KEY (id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$result=mysql_query($strsql, $conn);
//-----------build temp table
//-------actmode 1:activity, 2:sleep 3:temp
/*
$strsql="create table data_date(id int primary key not  null  auto_increment,  userid int(4), sdate DATE)";
$result=mysql_query($strsql, $conn);

$strsql="create table data_value(id int primary key not  null  auto_increment,  dateid int(4), stime TIME,temp FLOAT,calories SMALLINT,steps SMALLINT,distance SMALLINT, move SMALLINT,amode TINYINT, smode TINYINT, tmode TINYINT, sleepbelongs DATE)";
$result=mysql_query($strsql, $conn);
*/
//$strsql="create table sensorlist(id int primary key not  null  auto_increment,  userid int(4), interid SMALLINT, buiddate DATETIME)";
/*
$strsql="create table rawdata(id int primary key not  null  auto_increment,  userid int(4), rawtime TIME, point VARCHAR(40), builddate DATE)";
$result=mysql_query($strsql, $conn);

$strsql="create table learningdata(id int primary key not  null  auto_increment,  userid int(4), category VARCHAR(20), k_met VARCHAR(20),  a_interval INT(4), type VARCHAR(10) , goal INT(4), sleep DATETIME, getup DATETIME, s_interval INT(4) ,sleep_quality VARCHAR(20) ,activity_level_threshold VARCHAR(20), raw_data_enable CHAR(1), num_3D INT(4) , rf_interval INT(4), builddate DATE)";
$result=mysql_query($strsql, $conn);
*/
/*
VISA和MASTERCARD信用卡卡号通常为16位：
ｘｘｘｘ　　ｘｘｘｘ　　ｘｘｘｘ　　ｘｘｘｘ
其中：
第1—6位 为发卡行的 BIN NO.
第7—12位 卡顺序号
第13位 0 代表主卡，1-9 代表副卡
第14位 代表卡结单发出日期
第15位 代表该卡为第几张卡，补发卡后会加1
第16位 检验码
维萨卡（VISA）
卡号长度：16位（以前有极少数的卡为13位，现已停止发行了）
卡号范围：400000 — 499999
万事达卡（MasterCard）
卡号长度：16位
卡号范围：510000 — 559999
美国运通卡（American Express）
卡号长度：15位
卡号范围：340000 — 349999，370000 — 379999
大莱卡（DinersClub）
卡号长度：14位
卡号范围：300000 — 305999，309500 — 309599，360000 — 369999，380000 — 399999
日本国际卡（JCB）
卡号长度：16位
卡号范围：352800 — 358999
*/
/*

$strsql="create table billinfob(id int(4) not null primary key auto_increment,userid int(4),cardtype char(2), cardnumber varchar(16), scode varchar(20),fname varchar(20), lname varchar(20), address1 varchar(100), address2 varchar(100), city varchar(50), country varchar(50), state varchar(10), zip varchar(10), phone varchar(20))";

$result=mysql_query($strsql, $conn);

$strsql="create table shipinfo (id int(4) primary key not null auto_increment, userid int(4), address1 varchar(100)， address2 varchar(100), city varchar(50), country varchar(50), state varchar(10), zip varchar(10), phone varchar(20))";

$result=mysql_query($strsql, $conn);

$strsql="create table purchase (id int(4) primary key not null auto_increment, userid int(4),  colorid TINYINT, quantity SMALLINT, shipmode SMALLINT, shipcost FLOAT(7,2), totalcost FLOAT(7,2), billid int(4), shipid int(4), sameaddress TINYINT)";
$result=mysql_query($strsql, $conn);
*/
//$strsql="create table friendlist (id int(4) primary key not null auto_increment, userid int(4),  friendid int(4), station TINYINT, sdate DATE)";
//$result=mysql_query($strsql, $conn);
?>
<body>
ok
</body>
</html>