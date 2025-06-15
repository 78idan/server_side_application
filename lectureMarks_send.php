<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";

$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $candidate_table = $_POST['candidate_table'];
    $company = $_POST['company'];
    $supervisor = $_POST['supervisor'];
    $student_name = $_POST['student_name'];
    $admin_no = $_POST['admin_no'];
    // $level = $_POST['level'];
    // $department = $_POST['department'];
    // $program = $_POST['program'];
    $management_score = $_POST['management_score'];
    $student_score = $_POST['student_score'];
    $log_score = $_POST['log_score'];
    $problem_student = $_POST['problem_student'];
    $problem_management = $_POST['problem_management'];
    $observation = $_POST['observation'];
    $view = $_POST['view'];
    $calendar = $_POST['calendar'];
    $college_id = "1";

    $sql1 = $conn->prepare("select * from `$candidate_table` where college_id = ? ");
    $result1 = $sql1->execute([$college_id]);
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(!empty($fetch1['company']) ){
            $response['message'] = "You can`t submit twice";
        }else{
            $sql2 = $conn->prepare("update `$candidate_table` set company = ?,supervisor = ? , student_name = ?,admin_no = ?,management_score = ?,student_score=?,log_score = ?,problem_student = ?,problem_management = ?,observation = ?, view = ?, calendar = ? where college_id = ?");
            $result2 = $sql2->execute([$company,$supervisor,$student_name,$admin_no,$management_score,$student_score,$log_score,$problem_student,$problem_management,$observation,$view,$calendar,$college_id]);
            if($result2){
                $response['message'] = "submitted";
            }else{
                $response['message'] = "Query failed";
            }
        }
    }
}


echo json_encode($response);
?>