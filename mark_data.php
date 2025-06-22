<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";
$response = [];


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $Table_name = $_POST['Table_name'];
    $technical_report = $_POST['technical_report'];
    $total = $_POST['total'];
    $marker_id = 1;
    $sql1 = $conn->prepare("select * from `$Table_name` where marker_id = ? ");
    $result1 = $sql1->execute([$marker_id]);
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(!empty($fetch1['technical_report'])){
            $response['message'] = "You can`t upload twice";
        }else{
            $sql2 = $conn->prepare("update `$Table_name` set technical_report = ? , total = ? where marker_id = ?");
            $result2 = $sql2->execute([$technical_report,$total,$marker_id]);
            if($result2){
                $response['message'] = "Scores Submitted";
            }
        }
    }
}


echo json_encode($response);

?>