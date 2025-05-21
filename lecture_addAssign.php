<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTION,POST");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";
$database = "project_app";
$response = [];
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $descriptionQuestion = $_POST['descriptionQuestion'];
    $table_name = $_POST['table_name'];
    $response['message'] = $descriptionQuestion;
    

    $sql1 = $conn->prepare("select table_name from information_schema.tables where table_schema = ? and table_name = ? LIMIT 1 ");
    $result1 = $sql1->execute([$database,$table_name]);
    if($result1){
        $row1 = $sql1->rowCount();
        if($row1 > 0){
            $response['message'] = "Change Tag";
        }else{
            // $response['message'] = "You can proceed";
            $sql2 = $conn->prepare("create table `$table_name` (question_id INT AUTO_INCREMENT PRIMARY KEY,question_note VARCHAR(255),candidee_num VARCHAR(255),candidee_answer VARCHAR(255), candidee_level VARCHAR(255), candidee_time VARCHAR(255) ) ");
            $result2 = $sql2->execute();
            if($result2){
                $sql3 = $conn->prepare("insert into `$table_name`(question_note) values(?)");
                $result3 = $sql3->execute([$descriptionQuestion]);
                if($result3){
                    $response['message'] = "Question Uploaded";
                }
            }
        }
    }

}

echo json_encode($response);

?>