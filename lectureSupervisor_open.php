<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";

$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // $response['message'] = "Hello";
    $IpAdress = $_POST['IpAddress'];
    $candidate_table = $_POST['candidate_table'];
    $college_id = 1;
    $sql1 = $conn->prepare("select * from `$candidate_table` where college_id = ?");
    $result1 = $sql1->execute([$college_id]);
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(empty($fetch1['signature'])){
            $response['message'] = "Empty Photo";
        }else{
            $response['message'] = "http://$IpAdress/project_app/lectureSupervisor/".$fetch1['signature'];
        }
    }
}

echo json_encode($response);
?>