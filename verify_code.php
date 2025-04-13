<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json");

include "conn.php";
$response = [];
if($_SERVER['REQUEST_METHOD']=="POST"){
    $email = $_POST['email'];
    $forgot_otp = $_POST['forgot_otp'];
    try{
        $sql1 = $conn->prepare("select * from login_table");
        $result1 = $sql1->execute();
        if($result1){
            $sql2 = $conn->prepare("select * from login_table where email = ?");
            $result2 = $sql2->execute([$email]);
            $fetch1 = $sql2->fetch(PDO::FETCH_ASSOC);
            $row2 = $sql2->rowCount();
            if($row2 == 1 ){
                if($fetch1['forgot_otp'] == $forgot_otp){
                    $response['message'] = "otp matches";
                }else{
                    $response['message'] = "Invalid Code";
                }
            }else{
                $response['message'] = "User Exist more than 1";
            }
        }else{
            $response['message']="Table doesn`t exist";
        }
    }catch(PDOException $alt ){
        $response['message'] = $alt->getMessage();
    }

}


echo json_encode($response);




?>