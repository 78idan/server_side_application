<?php



header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS ");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json ");

include "conn.php";
$response = [];

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['image_url'])) {

    // $response['message'] = "Hello";
    
    $candidate_table = $_POST['candidate_table'];
    $week = $_POST['week'];
    $day = $_POST['day'];
    $date_time = $_POST['date_time'];
    $activityWeek = $_POST['activityWeek'];

    $sql1 = $conn->prepare("select * from `$candidate_table` where week = ? and day = ? ");
    $result1 = $sql1->execute([$week,$day]);
    // echo json_encode(["status" => "error", "message" => $activityWeek]);
    if($result1){


        $row1 = $sql1->rowCount();
        if($row1 == 1){
            echo json_encode(["status" => "error", "message" => "Already filled"]);
        } else{      

            $image_name = $_FILES['image_url']['name'];
            $image_tmp_name = $_FILES['image_url']['tmp_name'];
            $image_error = $_FILES['image_url']['error'];
            $image_size = $_FILES['image_url']['size'];
            // // $content = "How";
            // echo json_encode(["status" => "error", "message" => $image_name]);

            $imageExt = explode('.', $image_name);
            $actualExt = strtolower(end($imageExt));

            $allowed = array('jpg', 'jpeg', 'png'); // Add more formats if needed
            
            if (in_array($actualExt, $allowed)) {
                if ($image_size < 100000000) { // 100MB limit
                    if ($image_error == 0) {
                        $imageNameNew = uniqid('', true) . "." . $actualExt;
                        $destination = "photo/" . $imageNameNew;

                        if (move_uploaded_file($image_tmp_name, $destination)) {
                            $sql2 = $conn->prepare("insert into `$candidate_table`(week,day,date_time,activity,photo) values(?,?,?,?,?)");
                            $result2 = $sql2->execute([$week,$day,$date_time,$activityWeek,$imageNameNew]);
                            if($result2){
                                echo json_encode(["status"=>"Good","message"=> "Details Submitted"]);
                            }else{
                                echo json_encode(["status"=>"Good","message"=> "Query 2 failed"]);
                            }                            
                        } else {
                            echo json_encode(["status" => "error", "message" => "Failed to upload picture."]);
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "The file uploaded has an error."]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "The size of the file uploaded should be less than 100MB."]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "The file uploaded extension is invalid. Allowed formats: jph,jpeg, png."]);
            }
        }
    }


} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}


// echo json_encode($response);


?>

