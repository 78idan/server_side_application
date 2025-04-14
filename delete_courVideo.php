<?php

header("Access-Allow-Control-Origin: *");
header("Access-Allow-Control-Methods: GET,OPTIONS,POST ");
header("Access-Allow-Control-Headers: Content-Type,Authorization");
header("Content-Type: application/json");

include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD']== "POST"){
    $delete_id = $_POST['delete_id'];
    $table_name = $_POST['table_name'];
    $response['message'] = $table_name;
    $sql1 = $conn->prepare("select * from `$table_name`");
    $result1 = $sql1->execute();
    if($result1){
        $sql2 = $conn->prepare("delete from `$table_name` where db_mg_id = ?");
        $result2 = $sql2->execute([$delete_id]);
        if($result2){
            $response['message'] = "deleted Video";
        }else{
            $response['message'] = "Video not deleted";
        }
    }else{
        $response['message'] = "Table not exist";
    }
}

echo json_encode($response);





?>