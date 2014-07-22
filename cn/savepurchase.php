<?php

//define('__ROOT__', dirname(dirname(__FILE__))); 
require_once('../lib/Stripe.php');
include "../res/dbconnect.php";
// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://manage.stripe.com/account
Stripe::setApiKey("sk_live_EjRmoLPQqBK8ydHDlvrHDntZ");
//Stripe::setApiKey("sk_test_Plw7EAXypAImA8l07ah3DVVU");

// Get the credit card details submitted by the form
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
$descript=$_REQUEST['desc'];
$amount= $_REQUEST['amount'];
$stime=$now=date("Y-m-d H:i:s");
$ucode=$_REQUEST['ucode'];
$scode= $_REQUEST['scode'];
// Create the charge on Stripe's servers - this will charge the user's card
try {
$charge = Stripe_Charge::create(array(
  "amount" =>$amount, // amount in cents, again
  "currency" => "usd",
  "card" => $token,
  "description" => $descript)
);
} catch(Stripe_CardError $e) {
  // The card has been declined
}
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$strsql="insert into payinfo 
	(stime,token,Email,BillingName,BillingAddressLine1,BillingAddressZip,BillingAddressState,BillingAddressCity,BillingAddressCountry,ShippingName,ShippingAddressLine1,ShippingAddressZip,
	ShippingAddressState,ShippingAddressCity,ShippingAddressCountry,descript,amount,ucode,scode) values 
	('$stime','$token','$Email','$BillingName','$BillingAddressLine1','$BillingAddressZip','$BillingAddressState','$BillingAddressCity','$BillingAddressCountry','$ShippingName','$ShippingAddressLine1','$ShippingAddressZip',
	'$ShippingAddressState','$ShippingAddressCity','$ShippingAddressCountry','$descript',$amount,'$ucode','$scode')";

$result=mysql_query($strsql, $conn);


// Save the customer ID in your database so you can use it later
header("Location: purchase.php");  
?>

