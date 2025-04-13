<?php
// require 'db_connection.php'; // Include your database connection file

include "conn.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json ");

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['video_path'])) {
    
    $table_name = $_POST['table_name'];
    $video_desc = $_POST['video_desc'];
    $video_tuto = $_POST['video_tuto'];
    // echo json_encode(["message" => $video_tuto]);
    // Check if admin exists
    
    $sel_admin = $conn->prepare("SELECT * FROM `$table_name` ");
    
    // echo json_encode(["message" => "Thank God2" ]);
    $sel_admin->execute();
    
    


        

            $video_name = $_FILES['video_path']['name'];
            $video_tmp_name = $_FILES['video_path']['tmp_name'];
            $video_error = $_FILES['video_path']['error'];
            $video_size = $_FILES['video_path']['size'];
            $content = "How";

            $videoExt = explode('.', $video_name);
            $actualExt = strtolower(end($videoExt));

            $allowed = array('mp4', 'avi', 'mov'); // Add more formats if needed
            
            if (in_array($actualExt, $allowed)) {
                if ($video_size < 100000000) { // 100MB limit
                    if ($video_error == 0) {
                        $videoNameNew = uniqid('', true) . "." . $actualExt;
                        $destination = "videos/" . $videoNameNew;

                        if (move_uploaded_file($video_tmp_name, $destination)) {
                            $insert_video = $conn->prepare(
                                "INSERT INTO `$table_name` (db_mg_desc,db_mg_tuto,db_mg_path) 
                                 VALUES (?,?,?)"
                            );
                            $result_insertVideo = $insert_video->execute([$video_desc,$video_tuto, $videoNameNew]);

                            if ($result_insertVideo) {
                                echo json_encode(["status" => "success", "message" => "Video uploaded successfully!", "video_path" => $destination]);
                            } else {
                                echo json_encode(["status" => "error", "message" => "Failed to save video in the database."]);
                            }
                        } else {
                            echo json_encode(["status" => "error", "message" => "Failed to upload video."]);
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "The file uploaded has an error."]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "The size of the file uploaded should be less than 100MB."]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "The file uploaded extension is invalid. Allowed formats: mp4, avi, mov."]);
            }


} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
