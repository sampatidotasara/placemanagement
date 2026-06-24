<?php

$host = "localhost";
$user = "intern_user";
$password = "Internship@123";
$dbname = "internship";

$conn = new mysqli($host,$user,$password,$dbname);

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

?>
