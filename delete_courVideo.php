<?php

header("Access-Allow-Control-Origin: *");
header("Access-Allow-Control-Methods: GET,OPTIONS,POST ");
header("Access-Allow-Control-Headers: Content-Type,Authorization");
header("Content-Type: application/json");


$response = [];

if($_SERVER['REQUEST_METHOD']== "POST"){
    $delete_id = $_POST['delete_id'];
    $table_name = $_POST['table_name'];
    $response['message'] = $table_name;
}

echo json_encode($response);





?>