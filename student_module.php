<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");



include "conn.php";
$response = [];


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $dataTransfered = [];
    $level_name = $_POST['level_name'];
    // $response['message'] = $level_name;
    $sql1 = $conn->prepare("select * from enrolling_table where level = ?");
    $result1 = $sql1->execute([$level_name]);
    $row1 = $sql1->rowCount();
    if($row1 == 0){
        $response['message'] = "No Modules enrolled";
    }else{
        if($result1){
        while($fetch1 = $sql1->fetch(PDO::FETCH_ASSOC)){
            $sql2 = $conn->prepare("select * from login_table where admission_number = ?");
            $result2 = $sql2->execute([$fetch1['lecture_admission']]);
            if($result2){
                while($fetch2 = $sql2->fetch(PDO::FETCH_ASSOC) ){
                    $dataTransfered[] = [
                        "module_name"=>$fetch1['module'],
                        "fname"=> $fetch2['fname']
                    ];               
                }
            }
        }
        $response['message'] = $dataTransfered;
        }
    }
}

echo json_encode($response);

?>