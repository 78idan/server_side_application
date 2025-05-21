<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

include "conn.php";

$response = [];
$modules = [];
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // $response["message"] = "hello";
    $lecture_admissionNumber = $_POST['lecture_admissionNumber'];
    // $response['message'] = $lecture_admissionNumber;
    $sql1 = $conn->prepare("select * from enrolling_table");
    $result = $sql1->execute();
    if($result){
        $sql2 = $conn->prepare("select * from enrolling_table where lecture_admission = ?");
        $result2 = $sql2->execute([$lecture_admissionNumber]);
        if($result2){
            while($fetch = $sql2->fetch(PDO::FETCH_ASSOC)){
                $sql3 = $conn->prepare("select count(*) from login_table where level = ? ");
                $result3 = $sql3->execute([$fetch['level']]);
                if($result3){
                    $count = $sql3->fetchColumn();
                    $modules[] = [
                        "modules" => $fetch['module'],
                        "count" => $count,
                    ];                
                }
            }
            $response['message'] =$modules;
        }else{
            $response['message'] = "Lecture number not found";
        }
    }else{
        $response['message'] = "Table not found";
    }

}


echo json_encode($response);


?>