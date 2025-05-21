<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");



include "conn.php";

$response = [];


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $candidee_num = $_POST['candidee_num'];
    // $response['message'] = $candidee_num;
    $sqlStudentProfile1 = $conn->prepare("select * from login_table where admission_number = ?");
    $resultStudentProfile = $sqlStudentProfile1->execute([$candidee_num]);
    if($resultStudentProfile){
        $response['message'] = "Data received";
        while($fetchStudentProfile = $sqlStudentProfile1->fetch(PDO::FETCH_ASSOC)){
          $response['fname'] = $fetchStudentProfile['fname'];
          $response['lname'] = $fetchStudentProfile['lname'];
          $response['role'] = $fetchStudentProfile['role'];
          $response['level'] = $fetchStudentProfile['level'];
        }
    }else{
        $response['message'] = "Query error in file student_profile.php";
    }
}

echo json_encode($response);






?>