<?php
$user = "root"; //mysqlusername
$pass = ""; //mysqlpassword
$host = "localhost:3308"; 
$dbname= "emas";

$conn = mysqli_connect($host,$user,$pass,$dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
