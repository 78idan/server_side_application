<?php


header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");


include "conn.php";

$response = [];

// $details = [];

if($_SERVER['REQUEST_METHOD']=="POST"){
    $table_name = $_POST['Table_name'];
    $sql1 = $conn->prepare("SELECT * FROM `$table_name` WHERE db_mg_path IS NULL OR db_mg_path = ''");
    $result1 = $sql1->execute();
    $fetchEmpty = $sql1->fetchAll();
    if(empty($fetchEmpty)){
        $response['text'] = "NotVideoEmpty";
        $sql2 = $conn->prepare("select * from `$table_name`");
        $result2 = $sql2->execute();
        if($result2){
            while($fetch2 = $sql2->fetch(PDO::FETCH_ASSOC)){
                $url = "http://192.168.249.102/project_app/videos/";
                $actual_url = $url.$fetch2['db_mg_path'];
                $details[] = [
                    "video_name"=> $actual_url,
                    "video_content"=> $fetch2['db_mg_desc'],
                    "video_course"=> $fetch2['db_mg_tuto'], 
                    "video_id"=> $fetch2['db_mg_id']
                ];
            }
        }
    }else{
        $response['message'] = "videoNotEmpty";
    }
}
$response['message'] = $details;

echo json_encode($response);

?>