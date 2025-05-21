<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");


include "conn.php";

$response = [];


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $table_name = $_POST['table_name'];
    $video_id = $_POST['video_id'];
    // $response['message'] = $table_name;
    $sql1 = $conn->prepare("select * from `$table_name` where db_mg_id = ? ");
    $result1 = $sql1->execute([$video_id]);
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        $url = "http://192.168.63.102/project_app/videos/";
        $actual_url = $url.$fetch1['db_mg_path'];
        $response['message'] = $actual_url;
    }
}

echo json_encode($response);

?>



