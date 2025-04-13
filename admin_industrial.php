<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";
$response = [];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    // $response['message'] = $_POST['LectureAdmissionNumber1'];
    
    try{
        
        $regionValue = $_POST['regionValue'];
        $LectureAdmissionNumber1 = $_POST['LectureAdmissionNumber1'];
        $LectureAdmissionNumber2 = $_POST['LectureAdmissionNumber2'];
        $LectureAdmissionNumber3 = $_POST['LectureAdmissionNumber3'];
        $sql = $conn->prepare("select * from admin_region_table");
        $result = $sql->execute();
        
        
        if($result){
            $sql2 = $conn->prepare("select * from login_table where admission_number = ?");
            $result2 = $sql2->execute([$LectureAdmissionNumber1]);
            $fetch2 = $sql2->fetch(PDO::FETCH_ASSOC);
            $row2 = $sql2->rowCount();
            if($row2 == 1 && $fetch2['role'] == "lecture" ){
                $sql3 = $conn->prepare("select * from login_table where admission_number = ?");
                $result3 = $sql3->execute([$LectureAdmissionNumber2]);
                $fetch3 = $sql3->fetch(PDO::FETCH_ASSOC);
                $row3 = $sql3->rowCount();
                if($row3 == 1 && $fetch3['role'] == "lecture" ){
                    $sql4 = $conn->prepare("select * from login_table where admission_number = ?");
                    $result4 = $sql4->execute([$LectureAdmissionNumber3]);
                    $fetch4 = $sql4->fetch(PDO::FETCH_ASSOC);
                    $row4 = $sql4->rowCount();  
                    if($row4 == 1 && $fetch4['role'] == "lecture" ){
                        $sql5 = $conn->prepare("select * from admin_region_table where region_name = ? ");
                        $result5 = $sql5->execute([$regionValue]);
                        $row5 = $sql5->rowCount();
                        if($row5 == 0){
                            $sql6 = $conn->prepare("insert into admin_region_table(region_name,lecture_admission1,lecture_admission2,lecture_admission3) values(?,?,?,?) ");
                            $result6 = $sql6->execute([$regionValue,$LectureAdmissionNumber1,$LectureAdmissionNumber2,$LectureAdmissionNumber3]);
                            if($result6){
                                $response['message'] = "supervisors enrolled";
                            }else{
                                $response['message'] = "data not inserted";
                            }
                        }else{
                            $response['message'] = "Region already assigned";
                        }
                    }else{
                        $response['message'] = "Account doesn`t exist";
                    }                                      
                }else{
                    $response['message'] = "Account doesn`t exist";
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