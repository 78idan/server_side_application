<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json ");


include "conn.php";

$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $table_name = $_POST['table_name'];
    $actual_module = $_POST['actual_module'];
    $table_schema = "project_app";
    $data1 = [];
    // $response['message'] = $table_name;
    $sql1 = $conn->prepare("select table_name from information_schema.tables where table_schema = ? and  table_name like '$table_name%' ");
    $result1 = $sql1->execute([$table_schema]);
    $row1 = $sql1->rowCount();
    // $response['message'] = $row1;
    if($row1 < 1){
        $response['message'] = "No Question Uploaded";
    }else{
        if($result1){
            while($fetch1 = $sql1->fetch(PDO::FETCH_ASSOC) ){
            //   $data1[] = [
            //     "table_name"=>$fetch1['table_name']
            //   ];
            $database_table = $fetch1['table_name'];
            $sql2 = $conn->prepare("select * from `$database_table` where candidee_num IS NULL and candidee_answer IS NULL and candidee_level IS NULL and candidee_time IS NULL  ");
            $result2 = $sql2->execute();
            if($result2){
                $fetch2 = $sql2->fetch(PDO::FETCH_ASSOC);
                $sql3 = $conn->prepare("select * from enrolling_table where module = ? LIMIT 1 ");
                $result3 = $sql3->execute([$actual_module]);
                if($result3){
                    $fetch3 = $sql3->fetch(PDO::FETCH_ASSOC);
                    $sql4 = $conn->prepare("select * from login_table where admission_number = ? ");
                    $result4 = $sql4->execute([$fetch3['lecture_admission']]);
                    if($result4){
                        $fetch4 = $sql4->fetch(PDO::FETCH_ASSOC);
                        $data1[] = [
                            "database_table"=> $database_table,
                            "question_note"=> $fetch2['question_note'],
                            "lecture_name"=>$fetch4['fname']
                        ];
                    }
                }
            }
            }
            $response['message'] = $data1;
        }
    }
}


echo json_encode($response);




?>