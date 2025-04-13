<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";
$response = [];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    
    try{
        
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $hashPassword = password_hash($newPassword,PASSWORD_BCRYPT);
        $admission_number = $_POST['admission_number'];
        $sql = $conn->prepare("select * from login_table");
        $result = $sql->execute();
        
        
        if($result){            
            $sql2 = $conn->prepare("select * from login_table where admission_number = ? ");
            $result2 = $sql2->execute([$admission_number]);
            $row2 = $sql2->rowCount();
            if($row2 == 1){
                $fetch2 = $sql2->fetch(PDO::FETCH_ASSOC);
                if(password_verify( $oldPassword,$fetch2['password'] )){
                    $sql3 = $conn->prepare("update login_table set password = ? where admission_number = ?");
                    $result3 = $sql3->execute([$hashPassword,$admission_number]);
                    if($result3){
                        $response['message'] = "password changed";
                    }else{
                        $response['message'] = "process failed";
                    }
                }else{
                    $response['message'] = "wrong old Password";
                }
            }else{
                $response['message'] = "Account doesn`t exist";
            }
        }else{
            $response['message'] = "no database";
        }
    }catch (PDOException $alt){
        $response['message'] = $alt->getMessage();
    }
}

echo json_encode($response);
// echo "cool";


//kakq xbqh jttv nwcz


?>