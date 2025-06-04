<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
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
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(!empty($fetch1['week'])){
            $response['message'] = "Week found";
            $response['week'] = $fetch1['week'];
            $response['day'] = $fetch1['day'];
            $response['activity'] = $fetch1['activity'];
        }else{
            $response['message'] = "week not found";
        }
    }

}

echo json_encode($response);

?>