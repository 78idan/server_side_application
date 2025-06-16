<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json");

include "conn.php";
$response = [];
$details = [];
if($_SERVER['REQUEST_METHOD']=="POST"){
    // $region = $_POST['region'];
    $candidate_num = $_POST['candidate_num'];
    $check_num1 = $conn->prepare("select * from admin_region_table  where lecture_admission1 = ? ");
    $resultCheck_num1 = $check_num1->execute([$candidate_num]);
    $rowCheck_num1 = $check_num1->rowCount();
    if($rowCheck_num1 == 1){
        $fetchCheck_num1 = $check_num1->fetch(PDO::FETCH_ASSOC);    
        $region = $fetchCheck_num1['region_name'];
        $regionSql = $conn->prepare("select * from report where region = ?");
        $regionResult = $regionSql->execute([$region]);
        if($regionResult){
                while($fetchRegion = $regionSql->fetch(PDO::FETCH_ASSOC)){
                    $details[] = [
                        "candidates_no"=>$fetchRegion['candidates_no'],
                        "name"=> $fetchRegion['name'],
                    ];
                }
                $response['message'] = $details;
        }else{
            $response['message'] = "The query problem";
        }            
    }else{
        $check_num2 = $conn->prepare("select * from admin_region_table  where lecture_admission2 = ? ");
        $resultCheck_num2 = $check_num2->execute([$candidate_num]);
        $rowCheck_num2 = $check_num2->rowCount();  
        if($rowCheck_num2 == 1){
            $fetchCheck_num2 = $check_num2->fetch(PDO::FETCH_ASSOC);    
            $region = $fetchCheck_num2['region_name'];
            $regionSql = $conn->prepare("select * from report where region = ?");
            $regionResult = $regionSql->execute([$region]);
            if($regionResult){
                    while($fetchRegion = $regionSql->fetch(PDO::FETCH_ASSOC)){
                        $details[] = [
                            "candidates_no"=>$fetchRegion['candidates_no'],
                            "name"=> $fetchRegion['name'],
                        ];
                    }
                    $response['message'] = $details;
            }else{
                $response['message'] = "The query problem";
            }             
        }else{
            $check_num3 = $conn->prepare("select * from admin_region_table  where lecture_admission3 = ? ");
            $resultCheck_num3 = $check_num3->execute([$candidate_num]);
            $rowCheck_num3 = $check_num3->rowCount();  
            if($rowCheck_num3 == 1){
                $fetchCheck_num3 = $check_num3->fetch(PDO::FETCH_ASSOC);    
                $region = $fetchCheck_num3['region_name'];
                $regionSql = $conn->prepare("select * from report where region = ?");
                $regionResult = $regionSql->execute([$region]);
                if($regionResult){
                        while($fetchRegion = $regionSql->fetch(PDO::FETCH_ASSOC)){
                            $details[] = [
                                "candidates_no"=>$fetchRegion['candidates_no'],
                                "name"=> $fetchRegion['name'],
                            ];
                        }
                        $response['message'] = $details;
                }else{
                    $response['message'] = "The query problem";
                }             
            }            
        }      
    }
}
    


echo json_encode($response);

?>