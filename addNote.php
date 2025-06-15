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
    
    $sql1 = $conn->prepare("select * from `$Table_name` where note_name = ? ");
    $result1 = $sql1->execute([$file_name]);

    if($result1){

        $row1 = $sql1->rowCount();
        if($row1 == 1){
            echo json_encode(["status" => "error", "message" => "File name exist"]);
        }else{

            $fileExt = explode('.', $file_name);
            $actualExt = strtolower(end($fileExt));
            $allowed = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'csv');
            
            if (in_array($actualExt, $allowed)) {
                if ($file_size < 10485760) { // 10MB limit (10 * 1024 * 1024)
                    if ($file_error == 0) {
                        // Keep original filename exactly as is
                        $destination = "notes/".$file_name;
                        

                        
                        if (move_uploaded_file($file_tmp_name, $destination)) {
                            
                           $sql2 = $conn->prepare("insert into `$Table_name`(note_name) values(?)");
                           $result2 = $sql2->execute([$file_name]);
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

