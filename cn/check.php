<?php
require_once('../lib/Stripe.php');
 
if ($_POST) {
Stripe::setApiKey("sk_test_Plw7EAXypAImA8l07ah3DVVU");
$error = '';
$success = '';
try {
if (!isset($_POST['stripeToken']))
throw new Exception("The Stripe Token was not generated correctly");
Stripe_Charge::create(array("amount" => 1000,
"currency" => "usd",
"card" => $_POST['stripeToken']));
$success = 'Your payment was successful.';
}
catch (Exception $e) {
$error = $e->getMessage();
}
}
 
?>