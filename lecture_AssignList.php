<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json");



include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $tableOfName = $_POST['tableOfName'];
    // $response['message'] = $tableOfName;

    $sql1 = $conn->prepare("select * from `$tableOfName` where candidee_num IS NOT NULL and candidee_answer IS NOT NULL and candidee_level IS NOT NULL and candidee_time IS NOT NULL");
    $result1 = $sql1->execute();
    $answerDataFetched = [];
    if($result1){
        $row1 = $sql1->rowCount();
        if($row1<1){
            $response['message'] = "No Answer submitted";
        }else{
            while($fetch1 = $sql1->fetch(PDO::FETCH_ASSOC)){
                $answerDataFetched[] = [
                    "candidee_num"=> $fetch1['candidee_num'],
                    "candidee_level"=> $fetch1['candidee_level'],
                    "candidee_time"=> $fetch1['candidee_time'],
                ];
            }
            $response['message'] = $answerDataFetched;
        }
    }

}


echo json_encode($response);







?>