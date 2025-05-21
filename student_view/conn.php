<?php


$localhost = "localhost";
$user = "root";
$password = "";
$dbname = "project_app";



try{
    $conn = new PDO("mysql:host=$localhost;dbname=$dbname;charset=utf8",$user,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $alt){
    echo $alt->getMessage();
}








?>