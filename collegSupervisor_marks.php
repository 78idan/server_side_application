<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";

$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $Table_name = $_POST['Table_name'];
    
    $sql1 = $conn->prepare("select * from `$Table_name`");
    $result1 = $sql1->execute();
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(empty($fetch1['company'])){
            $response['message'] = "Empty records";
        }else{
            $fetch1['log_score'];
            $score =  $fetch1['management_score'] + $fetch1['student_score'];
            $collegeSupervisorMarks  = (5/100)*$score;
            $response['log_score'] = $fetch1['log_score'];
            $response['collegeSupervisorMarks'] = $collegeSupervisorMarks;
        }
    }
}


echo json_encode($response);

?>