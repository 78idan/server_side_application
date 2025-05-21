<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS ");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json");

include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $table_name = $_POST['table_name'];
    $question_note = $_POST['question_note'];
    $candidee_num = $_POST['candidee_num'];
    $answer_controller = $_POST['answer_controller'];
    $candidee_level = $_POST['candidee_level'];
    $candidee_time = $_POST['candidee_time'];
    // $response['message'] = $table_name;
    
    if(!empty($answer_controller)){
        $sqlAnswer1 = $conn->prepare("select * from `$table_name` where candidee_num = ? ");
        $resultAnswer1 = $sqlAnswer1->execute([$candidee_num]);
        $rowAnswer1 = $sqlAnswer1->rowCount();

        if($rowAnswer1 == 1 ){
            $response['message'] = "You can not submit twice";
        }else{
            // $response['message'] = "You Can submit";
            $sqlAnswer2 = $conn->prepare("insert into `$table_name`(question_note,candidee_num,candidee_answer,candidee_level,candidee_time) values(?,?,?,?,?)");
            $resultAnswer2 = $sqlAnswer2->execute([$question_note,$candidee_num,$answer_controller,$candidee_level,$candidee_time]);
            if($resultAnswer2){
                $response['message'] = "You have submitted";
            }else{
                $response['message'] = "There is a problem";
            }
        }
    }else{
        $response['message'] = "Answer field is empty";
    }

}


echo json_encode($response);



?>