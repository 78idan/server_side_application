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
        if(empty($fetch1['note_name'])){
            $response['message'] = "notes empty";
        }else{
            $sql3 = $conn->prepare("select * from `$Table_name` ORDER BY notes_id DESC ");
            $result3 = $sql3->execute();
            $noteUrl = "http://".$IpAddress."/project_app/notes/".$fetch1['note_name'];
            while($fetch3 = $sql3->fetch(PDO::FETCH_ASSOC)){
                $details[] = [
                    "note_name"=> $fetch3['note_name'],
                    "note_path"=>$noteUrl,
                    "note_id"=> $fetch3['notes_id'],
                ];
            }
            $response['note'] = $details;
        }
    }

}

echo json_encode($response);


?>