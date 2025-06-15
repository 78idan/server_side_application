<?php
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");
include "conn.php";

$response = [];

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['note_file'])) {
    
    $file_name = $_FILES['note_file']['name'];
    $file_tmp_name = $_FILES['note_file']['tmp_name'];
    $file_error = $_FILES['note_file']['error'];
    $file_size = $_FILES['note_file']['size'];
    $Table_name = $_POST['Table_name'];
    $candidate_num = $_POST['candidate_num'];
    $student_name = $_POST['student_name'];
    $technical_id = 1;
    
    $sql1 = $conn->prepare("select * from `$Table_name` where technical_id = ? ");
    $result1 = $sql1->execute([$technical_id]);

    if($result1){

        $fetch1 = $sql1->fetch(PDO::FETCH_ASSOC);
        if(!empty($fetch1['technical_report'])){
            echo json_encode(["status" => "error", "message" => "You can not upload twice"]);
        }else{

            $fileExt = explode('.', $file_name);
            $actualExt = strtolower(end($fileExt));
            $allowed = array('pdf', 'doc', 'docx');
            
            if (in_array($actualExt, $allowed)) {
                if ($file_size < 10485760) { // 10MB limit (10 * 1024 * 1024)
                    if ($file_error == 0) {
                        // Keep original filename exactly as is
                        $destination = "technicalReport/".$file_name;
                        

                        
                        if (move_uploaded_file($file_tmp_name, $destination)) {
                            
                           $sql2 = $conn->prepare("update `$Table_name` set student_name = ?, admin_no = ?, technical_report = ?  where  technical_id = ? ");
                           $result2 = $sql2->execute([$student_name,$candidate_num,$file_name,$technical_id]);
                           if($result2){
                            echo json_encode(["status" => "error", "message" => "document uploaded"]);
                           }else{
                            echo json_encode(["status" => "error", "message" => "document not uploaded"]);
                           }
                            
                        } else {
                            echo json_encode(["status" => "error", "message" => "Failed to upload document."]);
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "The file uploaded has an error."]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "The size of the file uploaded should be less than 10MB."]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "The file uploaded extension is invalid. Allowed formats: pdf, doc, docx, xls, xlsx, ppt, pptx, csv."]);
            }
        }
    }else{
        echo json_encode(["status" => "error", "message" => "Query failed"]); 
    }
    
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request or no file uploaded."]);
}

?>

