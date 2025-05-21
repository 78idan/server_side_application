<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json");

include "conn.php";
$response = [];
$retrievedData = "";
if($_SERVER['REQUEST_METHOD'] == "POST" ){
    $tableOfName = $_POST['tableOfName'];
    $admission_number = $_POST['admission_number'];

    $sql1 = $conn->prepare("select * from `$tableOfName` where candidee_num = ? ");
    $result1 = $sql1->execute([$admission_number]);
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        $retrievedData = $fetch1['candidee_answer'];
    }
    $response['message'] = $retrievedData;
}


echo json_encode($response);





?>