<?php
// Mysql settings
$user   = "root";
$password = "Frazile@0511";
$database = "facemash";
$host   = "localhost";

$conn = mysqli_connect($host, $user, $password, $database);
if(!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
?>
