<?php
session_start();
if(isset($_POST['add'])){
    // print_r($_POST['buyId']);
    include_once 'database.php';
    if(isset($_SESSION['sessionId'])){
        $custId=$_SESSION['sessionId'];
        $prodId=$_POST['buyId'];
        
        if(isset($_SESSION['cart'])){
            $cart_item_id= array_column($_SESSION['cart'], "buyId");
            echo 'it worked';
            $_SESSION['item_id']=$cart_item_id;
            print_r($cart_item_id);
    
            if(in_array($_POST['buyId'], $cart_item_id)){
                echo "<script> alert('This product is already added') </script>";
                echo "<script>window.location= 'index.php'</script>";
            }else{
                $num= count($_SESSION['cart']);
                $item_array=array(
                    'buyId'=> $_POST['buyId']
                );
                $_SESSION['cart'][$num]= $item_array;
                print_r($_SESSION['cart']);
            }
            // header("Location:index.php?added".$cart_item_id);
        }else{
            $item_array=array(
    
                'buyId'=> $_POST['buyId']
            );
            //Create new session variable
            $_SESSION['cart'][0]=$item_array;
            print_r($_SESSION['cart']);
            // header("Location:index.php?added1stItem");
        }

        $sql="insert into products_customer(productID, customerID) values(?,?);";
        $stmt= mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            echo 'sql error4';
            // header("Location: sell_welcome.php?error=sqlerror1");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "ss", $prodId,$custId);
            mysqli_stmt_execute($stmt);
            echo "<script> alert('This product has been added') </script>";
            echo "<script>window.location= 'index.php'</script>";
                
        }
    }
    else{
        echo '<script>alert("Pls sign in")</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    }

}

?>