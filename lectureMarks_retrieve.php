<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){

    

    $candidate_table = $_POST['candidate_table'];
    $college_id = "1";
    $sql1 = $conn->prepare("select * from `$candidate_table` where college_id = ? ");
    $result1 = $sql1->execute([$college_id]);   
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        // $response['message'] = $fetch1['company'];         
        if(empty($fetch1['company']) || $fetch1['company'] == "null"){
            $response['message'] = "Empty feature";
        }else{
            $response['company'] = $fetch1['company'];
            $response['supervisor'] = $fetch1['supervisor'];
            $response['management_score'] = $fetch1['management_score'];
            $response['student_score'] = $fetch1['student_score'];
            $response['log_score'] = $fetch1['log_score'];
            $response['problem_student'] = $fetch1['problem_student'];
            $response['problem_management'] = $fetch1['problem_management'];
            $response['observation'] = $fetch1['observation'];
            $response['view'] = $fetch1['view'];
            $response['calendar'] = $fetch1['calendar'];
        }
    }else{
        $response['message'] = "Query not field";
    }

}

echo json_encode($response);

?>