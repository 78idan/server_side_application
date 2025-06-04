<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $candidate_num = $_POST['candidate_num'];
    $sql1 = $conn->prepare("select * from report where candidates_no = ?");
    $result1 = $sql1->execute([$candidate_num]);
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        $response['message'] = "log taken";
        $response['region'] = $fetch1['region'];
        $response['street'] = $fetch1['street'];
        $response['area'] = $fetch1['area_desc'];
        $response['candidate_num'] = $fetch1['candidates_no'];
        $response['phone'] = $fetch1['phone_no'];
    }
}


echo json_encode($response);

?>