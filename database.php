<?php

// params to connect to a database
$dbHost= '127.0.0.1';
$dbUser= 'root';
$dbPass = '';
$dbName = 'rka2022';

//connection to databse
$conn = mysqli_connect($dbHost,$dbUser, $dbPass,$dbName);

if($conn){
   // echo 'connection worked';
}else{
    die("Database connection failed!");

}

?>