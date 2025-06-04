<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");


include "conn.php";
$response = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $candidate_num = $_POST['candidate_num'];
    $nameIdentity = $_POST['nameIdentity'];
    $valueRegion = $_POST['valueRegion'];
    $street = $_POST['street'];
    $phone = $_POST['phone'];
    $area = $_POST['area'];
      

    $sql1 = $conn->prepare("select * from report where candidates_no = ?");
    $result1 = $sql1->execute([$candidate_num]);
    if($result1){
        $row1 = $sql1->rowCount();
        if($row1 == 1){
            $response['message'] = "Report already sumbitted";
        }else{
            $sql2 = $conn->prepare("insert into report(candidates_no,name,phone_no,region,street,area_desc) values(?,?,?,?,?,?) ");
            $result2 = $sql2->execute([$candidate_num,$nameIdentity,$phone,$valueRegion,$street,$area]);
            if($result2){
                $response['message'] = "Report Submitted";
            }else{
                $response['message'] = "Query failed";
            }
        }
    }

}

echo json_encode($response);


?>