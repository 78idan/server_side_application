<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");


include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST" ){
    $admission_number = $_POST['admission_number'];

    try{
        $sql1 = $conn->prepare("select * from login_table");
        $result1 = $sql1->execute();
        if($result1){
            $sql2 = $conn->prepare("select * from login_table where admission_number = ?");
            $result2 = $sql2->execute([$admission_number]);
            $row2 = $sql2->rowCount();
            if($row2 == 1){
                $fetch2 = $sql2->fetch(PDO::FETCH_ASSOC);
                $response['message'] = "Data retreieved";
                $response['fname'] = $fetch2['fname'];
                $response['lname'] = $fetch2['lname'];
            }else{
                $response['message'] = "User doesn`t exist";
            }
        }else{
            $response['message'] = "Table doesn`t exist";
        }
    }catch(PDOException $alt ){
        $response['message'] = $alt->getMessage();
    }

}

echo json_encode($response);


?>