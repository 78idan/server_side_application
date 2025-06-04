<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $week = $_POST['week'];
    $day = $_POST['day'];
    $candidate_table = $_POST['candidate_table'];
    $sql1 = $conn->prepare("select * from `$candidate_table` where week = ? and day = ? ");
    $result1 = $sql1->execute([$week,$day]);
    if($result1){
        while($fetch1 = $sql1->fetch(PDO::FETCH_ASSOC) ){
            $response['date_time'] = $fetch1['date_time'];
            $response['activity'] = $fetch1['activity'];
        }
    }
    // $response['message'] = $candidate_table;
}

echo json_encode($response);

?>