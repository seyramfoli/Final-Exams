<?php
session_start();
require_once('vendor/autoload.php');
// require_once('vendor/stripe-php/init.php');
\Stripe\Stripe::setApiKey('sk_test_51HQvfzGnX6tvw2VTj0G9UyqrnWsGNRbAVwBE7Tshilq4ZEEdkS0labBfhJFhxRJSm0pINEcmX9KI9qB2ISbm8nVF00zoxxBl9M');

//Sanitize POST Array
$POST= filter_var_array($_POST, FILTER_SANITIZE_STRING);

$email=$_SESSION['sessionEmail'];
$fname=$_SESSION['sessionFname'];
$lname=$_SESSION['sessionLname'];
$token= $POST['stripeToken'];
$totalstr=$_SESSION['totalAmt'];
$totalAmt= $totalstr*100;
echo $token;
echo $totalAmt;

//Create Customer IN Stripe
$customer =\Stripe\Customer::create(array(
    "email"=>$email,
    "source"=>$token
));

//Charge Customer
$charge= \Stripe\Charge::create(array(
    "amount"=> $totalAmt,
    "currency"=>"usd",
    "description" => "Adleks Products",
    "customer" => $customer->id

));

//Redirect to success
unset($_SESSION['totalAmt']);
header('Location: orders.php?tid='.$charge->id.'&product='.$charge->description)
?>