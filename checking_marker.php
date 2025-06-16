<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";
$response = [];


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $candidate_num = $_POST['candidate_num'];

    $sql1 = $conn->prepare("select * from admin_region_table where marker = ?");
    $result1 = $sql1->execute([$candidate_num]);
    if($result1){
        $row1 = $sql1->rowCount();
        if($row1 == 0){
            $response['message'] = "not exist";
        }else{
            $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
            $response['message'] = "exist";
            $response['region_name'] = $fetch1['region_name'];
        }
    }else{
        $response['message'] = "Query failed";
    }
}

echo json_encode($response);

?>