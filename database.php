<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usersdata";

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>
