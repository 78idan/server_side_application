<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";

$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $Table_name = $_POST['Table_name'];
    $delete_id = $_POST['delete_id'];

    $sql1 = $conn->prepare("select * from `$Table_name`");
    $result1 = $sql1->execute();
    if($result1){
        $sql2 = $conn->prepare("delete from `$Table_name` where notes_id = ?");
        $result2 = $sql2->execute([$delete_id]);
        if($result2){
            $response['message'] = "deleted notes";
        }else{
            $response['message'] = "fail to delete";
        }
    }else{
        $response['message'] = "Table does not exist";
    }
}

echo json_encode($response);
?>