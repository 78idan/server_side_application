<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");
include "conn.php";

$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $Table_name = $_POST['Table_name'];
    $IpAddress = $_POST['IpAddress'];
    $details = [];
    $sql1 = $conn->prepare("select * from `$Table_name`");
    $result1 = $sql1->execute();
    if($result1){
        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(empty($fetch1['technical_report'])){
            $response['message'] = "report empty";
        }else{
            $sql3 = $conn->prepare("select * from `$Table_name` ORDER BY technical_id DESC ");
            $result3 = $sql3->execute();
            $technicalUrl = "http://".$IpAddress."/project_app/technicalReport/".$fetch1['technical_report'];
            while($fetch3 = $sql3->fetch(PDO::FETCH_ASSOC)){
                $details[] = [
                    "technical_report"=> $fetch3['technical_report'],
                    "technical_path"=>$technicalUrl,
                    "technical_id"=> $fetch3['technical_id'],
                ];
            }
            $response['note'] = $details;
        }
    }

}

echo json_encode($response);


?>