<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";
$response = [];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    // $response['message'] = $_POST['LectureAdmissionNumber'];
    
    try{
        $departmentValue = $_POST['departmentValue'];
        $courseValue = $_POST['courseValue'];
        $levelValue = $_POST['levelValue'];
        $moduleValue = $_POST['moduleValue'];
        $lectureAdmissionNumber = $_POST['LectureAdmissionNumber'];
        $sql = $conn->prepare("select * from enrolling_table");
        $result = $sql->execute();
        
        if($result){
            $sql2 = $conn->prepare("select * from login_table where admission_number = ?");
            $result2 = $sql2->execute([$lectureAdmissionNumber]);
            $fetch2 = $sql2->fetch(PDO::FETCH_ASSOC);
            $row2 = $sql2->rowCount();
            if($row2 == 1 && $fetch2['role'] == "lecture" ){
                $sql3 = $conn->prepare("select * from enrolling_table where module = ? ");
                $result3 = $sql3->execute([$moduleValue]);
                $row3 = $sql3->rowCount();
                if($row3 == 0){
                    $sql4 = $conn->prepare("insert into enrolling_table(department,course,level,module,lecture_admission) values(?,?,?,?,?) ");
                    $result4 = $sql4->execute([$departmentValue,$courseValue,$levelValue,$moduleValue,$lectureAdmissionNumber]);
                    if($result4){
                        $response['message'] = "module enrolled";
                    }else{
                        $response['message'] = "data not inserted";
                    }
                }else{
                    $response['message'] = "Module already assigned";
                }
            }else{
                $response['message'] = "Account doesn`t exist";
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