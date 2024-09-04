<?php 
include('database.php');
include('index.php');

$email = "abc@gmail.com";
$action = 'login';
$ip_address = '192.0.0.0';
$user_agent = "abc";


$sql = "insert into activity_log(email,action,ip_address,abc) values('$email','$action','$ip_adress','$abc')";
$result = $connect -> query($sql);





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>