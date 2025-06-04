<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $dateData  = $_POST['dateData'];
    $schedule_no = "1";
    if($dateData == "date retrieved"){
        $sql1 = $conn->prepare("select * from ipt_schedule where schedule_no = ?");
        $result1 = $sql1->execute([$schedule_no]);
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(!empty($fetch1['startingDate'])){
            $response['message'] = "date not empty";
            $response['startingDate'] = $fetch1['startingDate'];
            $response['endingDate'] = $fetch1['endingDate'];
        }else{
            $response['message'] = "date empty";
        }
    }
}



echo json_encode($response);





?>