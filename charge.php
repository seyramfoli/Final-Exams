<?php

require_once('vendor/autoload.php');
$stripe = new \Stripe\StripeClient('sk_test_51HQvfzGnX6tvw2VTj0G9UyqrnWsGNRbAVwBE7Tshilq4ZEEdkS0labBfhJFhxRJSm0pINEcmX9KI9qB2ISbm8nVF00zoxxBl9M');

//Sanitize POST Array
$POST= filter_var_array($_POST, FILTER_SANITIZE_STRING);

$email=$_SESSION['sessionEmail'];
$fname=$_SESSION['sessionFname'];
$lname=$_SESSION['sessionLname'];
$token= $POST['stripeToken'];
echo $token;

//Create Customer IN Stripe
$customer =\Stripe\Customer::create(array(
    "email"=>$email,
    "source"=>$token
));

//Charge Customer
$charge= \Stripe\Charge::create(array(
    "amount"=> 5000,
    "currency"=>"usd",
    "description" => "Adleks Products",
    "customer" => $customer->id

));
?>