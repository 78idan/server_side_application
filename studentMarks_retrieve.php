<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){

    

    $candidate_table = $_POST['candidate_table'];
    $industry_id = "1";
    $sql1 = $conn->prepare("select * from `$candidate_table` where industry_id = ? ");
    $result1 = $sql1->execute([$industry_id]);   
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        // $response['message'] = $fetch1['company'];         
        if(empty($fetch1['company']) || $fetch1['company'] == "null"){
            $response['message'] = "Empty feature";
        }else{
            $response['company'] = $fetch1['company'];
            $response['supervisor'] = $fetch1['supervisor'];
            $response['asses_score'] = $fetch1['asses_score'];
            $response['report_date'] = $fetch1['report_date'];
            $response['finish_date'] = $fetch1['finish_date'];
            $response['permission_with'] = $fetch1['permission_with'];
            $response['permission_without'] = $fetch1['permission_without'];
            $response['opinion_skill'] = $fetch1['opinion_skill'];
            $response['opinion_adequacy'] = $fetch1['opinion_adequacy'];
            $response['calendar'] = $fetch1['calendar'];
        }
    }else{
        $response['message'] = "Query not field";
    }

}

echo json_encode($response);

?>