<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET,OPTIONS ');
header('Access-Control-Allow-Headers: Content-Type,Authorization ');
header('Content-Type: application/json');


include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashPassword = password_hash($password,PASSWORD_BCRYPT);
    $status = "active";
    $reg_otp = "";

    try{
        $sql1 = $conn->prepare("select * from login_table");
        $result1 = $sql1->execute();
        if($result1){
            $sql2 = $conn->prepare("select * from login_table where email = ?");
            $result2 = $sql2->execute([$email]);
            $row2 = $sql2->rowCount();
            if($row2 == 1){
                $sql3 = $conn->prepare("update login_table set password = ?, status = ?,reg_otp = ? where email = ?");
                $result3 = $sql3->execute([$hashPassword,$status,$reg_otp,$email]);
                if($result3){
                    $response['message'] = "PLease forgive Jesus Christ";
                }else{
                    $response['message'] = "password not updated";
                }
            }else{
                $response['message'] = "User invalid";
            }
        }else{
            $response['message'] = "Table doesn`t exist";
        }
    }catch(PDOException $alt){
        $response['message']=$alt->getMessage();
    }
}


echo json_encode($response);


?>