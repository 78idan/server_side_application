<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";
$response = [];


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $table_name = $_POST['Table_name'];
    $IpAddress = $_POST['IpAddress'];
    $details = [];
    // $response['message'] = $table_name;
    $sql1 = $conn->prepare("select * from `$table_name`");
    $result1 = $sql1->execute();
    $row1 = $sql1->rowCount();
    if($row1 < 1){
        $response['message'] = "No video Uploaded";
    }else{
        $sql2 = $conn->prepare("select * from `$table_name` where db_mg_path is NULL or db_mg_path = '' ");
        $result2 = $sql2->execute();
        $fetch2 = $sql2->fetchAll();
        if(empty($fetch2)){
            $response['message'] = "NotVideoEmpty";
            $sql3 = $conn->prepare("select * from  `$table_name` ORDER BY db_mg_id DESC ");
            $result3 = $sql3->execute();
            while($fetch3 = $sql3->fetch(PDO::FETCH_ASSOC)){
                $url = "http://".$IpAddress."/project_app/videos/";
                $actualUrl = $url.$fetch3['db_mg_path'];
                $details[] = [
                    "video_name"=> $actualUrl,
                    "video_content"=> $fetch3['db_mg_desc'],
                    "video_course"=>$fetch3['db_mg_tuto'],
                    "video_id"=> $fetch3['db_mg_id'],
                ];
            }
            $response['main'] = $details;
        }
    }
}

echo json_encode($response);

?>
