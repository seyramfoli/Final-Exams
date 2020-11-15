<?php

if(isset($_POST['submit'])){
    require 'database.php';

    $email= $_POST['email'];
    $password=$_POST['password'];

    if(empty($email)||empty($password)){
        
        header("Location: signIn.php?error=emptyfields");
        exit();
    }else{
        $sql="select * from customers where email = ?";
        $stmt= mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){

            header("Location: signIn.php?error=sqlerror0");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result= mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                $passCheck=password_verify($password, $row['password']);
                if(passCheck==false){

                    header("Location: signIn.php?error=wrongpass");
                    exit();
                }elseif(passCheck==true){
                    session_start();
                    $_SESSION['sessionId']=$row['customerID'];
                    $_SESSION['sessionEmail']=$row['email'];
                    $_SESSION['sessionFname']=$row['fname'];
                    $_SESSION['sessionLname']=$row['lname'];
                    header("Location: index.php?success=logged_in");
                }else{
                    header("Location: signIn.php?error=wrong1pass");
                }
            }else{

                header("Location: signIn.php?error=nouser");
                exit();
            }
        }
    }
    
}else{

    header("Location: index.php?error=accessforbidden");
    exit();
}
?>