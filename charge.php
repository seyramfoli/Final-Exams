<?php
session_start();
require_once 'database.php';
require_once('vendor/autoload.php');
// require_once('vendor/stripe-php/init.php');
\Stripe\Stripe::setApiKey('sk_test_51HQvfzGnX6tvw2VTj0G9UyqrnWsGNRbAVwBE7Tshilq4ZEEdkS0labBfhJFhxRJSm0pINEcmX9KI9qB2ISbm8nVF00zoxxBl9M');

//Sanitize POST Array
$POST= filter_var_array($_POST, FILTER_SANITIZE_STRING);

$custId=$_SESSION['sessionId'];
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

// echo '<br><br>';
// print_r($customer);
// echo '<br><br>';
// print_r($charge);
// echo '<br><br>';

// echo $charge->last4;
// echo $charge->status;
date_default_timezone_set('GMT');
$currentTime= date("Y-m-d H:i:s", time());
echo $currentTime;

$sql = "insert into orders(orderTime, customerID) values(?,?)";
$stmt= mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: payment.php?error=sqlerror0");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "ss", $currentTime,$custId);
    mysqli_stmt_execute($stmt);
    // header("Location: orders.php?success=purchased");
    // exit();
}


$sql="select orderID from orders where orderTime=? and customerID=?";
$stmt= mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){

    header("Location: signIn.php?error=sqlerror1");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "ss", $currentTime,$custId);
    mysqli_stmt_execute($stmt);
    $result= mysqli_stmt_get_result($stmt);
    if($row=mysqli_fetch_assoc($result)){
        $oID=$row['orderID'];
        // header("Location: orders.php?success+oidAcquired");
        // exit();
    }else{

        // header("Location: payment.php?error=nonexistenceId");
        // exit();
    }
}

$sql = "insert into payments(accountDetails, customerID, orderID) values(?,?,?)";
$stmt= mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: payment.php?error=sqlerror2");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "sss", $charge->id,$custId,$oID);
    mysqli_stmt_execute($stmt);
    header("Location: orders.php?success=paymentAdded");
    exit();
}
// //Redirect to success
// unset($_SESSION['totalAmt']);
// header('Location: orders.php?tid='.$charge->id.'&product='.$charge->description)
?>