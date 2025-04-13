<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");



include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // $number = $_POST['admissionNumber'];
    // $response['message']= $number;
    try{
        $admissionNumber = $_POST['admissionNumber'];
        $sql1 = $conn->prepare("select * from login_table");
        $result1 = $sql1->execute();
        if($result1){
             $sql2 = $conn->prepare("select * from login_table where admission_number = ?");
             $result2 = $sql2->execute([$admissionNumber]);
             $row1 = $sql2->rowCount();
             $response['message'] = $row1;
             if($row1 == 1){
                $response['message'] = "hello2";
                 $fetch = $sql2->fetch(PDO::FETCH_ASSOC);
                 if($fetch['status'] == "unactive"){
                     if($fetch['forgot_otp'] == ""){
                         if($fetch['password'] == ""){
                             $response['message'] = "correct";
                             $response['email'] = $fetch['email'];
                         }else{
                             $response['message'] = "Invalid Credentials";
                         }
                     }else{
                         $response['message'] = "Invalid Credentials";
                     }
                 }else{
                     $response['message'] = "Aleady have an account";
                 }
             }else{
                 $response['message'] = "Invalid Credentials";
                 
             }
        }else{
         $response['message'] = "Table don`t exist";
        }
     }catch(PDOException $alt ){
         $response['message'] = $alt->getMessage();
     }
}



echo json_encode($response);



?>