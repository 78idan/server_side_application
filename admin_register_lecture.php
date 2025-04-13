<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization ");
header("Content-Type: application/json");

include "conn.php";
$response = [];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    try {
        $fname = $_POST['fname'];
        $sname = $_POST['sname'];
        $lname = $_POST['lname'];
        $sname = $_POST['sname'];
        $departmentValue = $_POST['departmentValue'];
        $email = $_POST['email'];
        $lectureAdmissionNumber = $_POST['lectureAdmissionNumber'];
        $role = $_POST['role'];
        $sql = $conn->prepare("select * from admin_table");
        $result = $sql->execute();
        if($result){
            $sql2 = $conn->prepare("select * from admin_table where admission_number = ? or email = ?");
            $result2 = $sql2->execute([$lectureAdmissionNumber,$email]);
            $row = $sql2->rowCount();
            if($row == 0){
                $sql3 = $conn->prepare("insert into admin_table(fname,lname,sname,department,email,role,admission_number) values(?,?,?,?,?,?,?) ");
                $result3 = $sql3->execute([$fname,$lname,$sname,$departmentValue,$email,$role,$lectureAdmissionNumber]);
                if($result3){
                    $response['message']= "Registered";
                }else{
                    $response['message']="Not registered";
                }
            }else{
                $response['message'] = "user exist";
            }
        }else{
            $response['message'] = "no database";
        }
    } catch (PDOException $alt) {
        $response['message'] = $alt->getMessage();
    }
}

echo json_encode($response);
// echo "cool";


//kakq xbqh jttv nwcz


?>