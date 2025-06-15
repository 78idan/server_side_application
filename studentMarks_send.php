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
    $level = $_POST['level'];
    $department = $_POST['department'];
    $program = $_POST['program'];
    $asses_score = $_POST['asses_score'];
    $report_date = $_POST['report_date'];
    $finish_date = $_POST['finish_date'];
    $permission_with = $_POST['permission_with'];
    $permission_without = $_POST['permission_without'];
    $opinion_skill = $_POST['opinion_skill'];
    $opinion_adequacy = $_POST['opinion_adequacy'];
    $calendar = $_POST['calendar'];
    $industry_id = "1";

    $sql1 = $conn->prepare("select * from `$candidate_table` where industry_id = ? ");
    $result1 = $sql1->execute([$industry_id]);
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(!empty($fetch1['company']) ){
            $response['message'] = "You can`t submit twice";
        }else{
            $sql2 = $conn->prepare("update `$candidate_table` set company = ?,supervisor = ? , student_name = ?,admin_no = ?, level = ?,department = ?,program = ?,asses_score = ?,report_date=?,finish_date = ?,permission_with = ?,permission_without = ?,opinion_skill = ?, opinion_adequacy = ?, calendar = ? where industry_id = ?");
            $result2 = $sql2->execute([$company,$supervisor,$student_name,$admin_no,$level,$department,$program,$asses_score,$report_date,$finish_date,$permission_with,$permission_without,$opinion_skill,$opinion_adequacy,$calendar,$industry_id]);
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