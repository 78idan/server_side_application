<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";

$response = [];
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $IpAdress = $_POST['IpAdress'];
    $week = $_POST['week'];
    $day = $_POST['day'];
    $candidate_table = $_POST['candidate_table'];

    // $response['message'] = $IpAdress;

    $sql1 = $conn->prepare("select * from `$candidate_table` where week = ? and day = ? ");
    $result1 = $sql1->execute([$week,$day]);
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(!empty($fetch1['photo'])){
            $response['message'] = "Photo filled";
            $data = $fetch1['photo'];

            $urlPhoto = "http://".$IpAdress."/project_app/photo/".$data;

            $response['url'] = $urlPhoto;
        }else{
            $response['message'] = "Photo unfilled";
        }
    }

}

echo json_encode($response);

?>