<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

// include "conn.php";
$response = [];

include "conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $candidate_table = $_POST['candidate_table'];
    $week = $_POST['week'];
    $day = $_POST['day'];
    $checkSql = $conn->prepare("select * from `$candidate_table` where week = ? and day = ? ");

    $checkResult = $checkSql->execute([$week,$day]); 
    if($checkResult){ 
        $checkFetch = $checkSql->fetch(PDO::FETCH_ASSOC);
        if(!empty($checkFetch['co_sign'])){
            // $response['message'] = "hello3";
            $response['message'] = "You can`t upload twice";
        }else{  
            
            if (isset($_FILES['signature']) && $_FILES['signature']['error'] === UPLOAD_ERR_OK) {
            
                $uploadDir = 'upload/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $fileTmpPath = $_FILES['signature']['tmp_name'];
                $fileName = uniqid('signature_', true) . '.png';
                $destination = $uploadDir . $fileName;
                $response['message'] = $destination;

                if (move_uploaded_file($fileTmpPath, $destination)) {

    //                 $response['message'] = "Thank God";
                    $sql1 = $conn->prepare("update `$candidate_table` set  co_sign = ? where week = ? and day = ? ");
                    $result1 = $sql1->execute([$fileName,$week,$day]);
                    if($result1){
                        // $response['message'] = "helloDp";
                        $response['message'] = "Signature uploaded";
                    }
                } else{
                    $response['message'] = "Error file uploading";
                }
            } else {
               $response['message'] = "Query error";
            }
        }
    }
}

echo json_encode($response);


?>