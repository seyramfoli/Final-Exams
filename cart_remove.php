<?php
session_start();
if(isset($_POST['remove'])){
    // print_r($_POST['buyId']);
    include_once 'database.php';
    if(isset($_SESSION['sessionId'])){
        $custId=$_SESSION['sessionId'];
        $prodId=$_POST['buyId'];
        
     
     
        foreach($_SESSION['cart'] as $key=>$value){
            if($value['buyId']==$_POST['buyId']){
                unset($_SESSION['cart'][$key]);
            }
        }
        $sql="delete from  products_customer where productID=? and customerID =?;";
        $stmt= mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            echo 'sql error4';
            // header("Location: sell_welcome.php?error=sqlerror1");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "ss", $prodId,$custId);
            mysqli_stmt_execute($stmt);
            echo "<script> alert('This product has been removed') </script>";
            echo "<script>window.location= 'checkout.php'</script>";
                
        }
    }
    else{
        echo '<script>alert("Pls sign in")</script>';
        echo '<script>window.location.href = "checkout.php";</script>';
        exit();
    }

}

?>