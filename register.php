<?php
if(isset($_POST['submit'])){
    //Add Database connection
    require 'database.php';

    $fname= $_POST['fname'];
    $lname= $_POST['lname'];
    $email=$_POST['email'];
    $password=$_POST['pswd'];
    $confirmPass=$_POST['confirmPswd'];

    if (empty($fname) ||empty($lname) || empty($email) || empty($password) || empty($confirmPass)){
        header("Location: signUp.php?error=emptyfields&email=".$email);
        exit();
    }elseif(!preg_match("/^[a-zA-Z0-9]*/",$email)){
        header("Location: signUp.php?error=invalidusername&email=".$email);
        exit();
    }elseif($password !== $confirmPass){
        header("Location: signUp.php?error=passworddonotmatch&email=".$email);
        exit();
    }else{
        $sql = "select email from customer where email = ?";
        $stmt= mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: signUp.php?error=sqlerror0");
            exit();

        }else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowCount= mysqli_stmt_num_rows($stmt);

            if($rowCount > 0){
                header("Location: signUp.php?error=usernametaken");
                exit();
            }else{
                $sql= "insert into customer(fname, lname, email, password) values (?, ?, ?, ?)";
                $stmt= mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: signUp.php?error=sqlerror1");
                    exit();

                }else{
                    $hashedPass= password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ssss", $fname,$lname,$email, $hashedPass);
                    mysqli_stmt_execute($stmt);
                    header("Location: signIn.php?success=registered");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysql_close($conn);
}
?>