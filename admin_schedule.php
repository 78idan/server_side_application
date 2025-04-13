<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";
$response = [];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    
    try{
        
        $startingDate = $_POST['startingDate'];
        $endingDate = $_POST['endingDate'];
        $sql = $conn->prepare("select * from ipt_schedule");
        $result = $sql->execute();
        
        
        if($result){            
            $sql2 = $conn->prepare("update ipt_schedule set startingDate = ?, endingDate = ? where schedule_no = 1 ");
            $result2 = $sql2->execute([$startingDate,$endingDate]);            
            if($result2){
                $response['message'] = "schedule enrolled";
            }else{
                $response['message'] = "schedule not updated";
            }
        }else{
            $response['message'] = "no database";
        }
    }catch (PDOException $alt){
        $response['message'] = $alt->getMessage();
    }
}

echo json_encode($response);
// echo "cool";


//kakq xbqh jttv nwcz


?>