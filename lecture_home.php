<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");


include "conn.php";

$response = [];


if($_SERVER['REQUEST_METHOD']=="POST"){
    $admission_number = $_POST['admission_number'];
    // $response['message'] = $admission_number;
    $sql1 = $conn->prepare("select * from login_table where admission_number = ?");
    $result1 = $sql1->execute([ $admission_number ]);
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        $response['message'] = "Data retrieved";
        $response['fname'] = $fetch1['fname'];
        $response['lname'] = $fetch1['lname'];
        $response['role'] = $fetch1['role'];

    }else{
        $response['message'] = "Database Query error";
    }
}

echo json_encode($response);






?>