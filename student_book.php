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
    $date_time = $_POST['date_time'];
    $activity = $_POST['activity'];
    $sql1 = $conn->prepare("select * from `$candidate_table` where week = ? and day = ? ");
    $result1 = $sql1->execute([$week,$day]);
    if($result1){
        $row1 = $sql1->rowCount();
        if($row1 == 1){
            $response['message'] = "Already filled";
        }else{
            $sql2 = $conn->prepare("insert into `$candidate_table`(week,day,date_time,activity) values(?,?,?,?)");
            $result2 = $sql2->execute([$week,$day,$date_time,$activity]);
            if($result2){
                $response['message'] = "Details Submitted";
            }else{
                $response['message'] = "Query 2 failed";
            }
        }
    }else{
        $response['message'] = "Query failed";
    }
    // $response['message'] = $date_time;
}

echo json_encode($response);


?>