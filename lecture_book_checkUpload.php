<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $candidate_table = $_POST['candidate_table'];
    $week = $_POST['week'];
    $day = $_POST['day'];

    $sql1 = $conn->prepare("select * from `$candidate_table` where week = ? and day = ? ");
    $result1 = $sql1->execute([$week,$day]);
    if($result1){
        $row1 = $sql1->rowCount();
        if($row1 == 0){
            $response['message'] = "Please fill Activiy";
        }else{
            $response['message'] = "filled";
        }
    }else{
        $response['message'] = "Query failed";
    }

}

echo json_encode($response);

?>