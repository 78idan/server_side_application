<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";

$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $Table_name = $_POST['Table_name'];

    $sql1 = $conn->prepare("select * from `$Table_name`");
    $result1 = $sql1->execute();
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(empty($fetch1['technical_report'])){
            $response['message'] = "Empty recorded";
        }else{
            $response['technical_report'] = $fetch1['technical_report'];
            $response['total'] = $fetch1['total'];
        }
    }

}


echo json_encode($response);
?>