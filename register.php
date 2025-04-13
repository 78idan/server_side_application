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
        $courseValue = $_POST['courseValue'];
        $levelValue = $_POST['levelValue'];
        $email = $_POST['email'];
        $admission_number = $_POST['admission_number'];
        $role = $_POST['role'];
        $sql = $conn->prepare("select * from admin_table");
        $result = $sql->execute();
        if($result){
            $sql2 = $conn->prepare("select * from admin_table where admission_number = ? or email = ?");
            $result2 = $sql2->execute([$admission_number,$email]);
            $row = $sql2->rowCount();
            if($row == 0){
                $sql3 = $conn->prepare("insert into admin_table(fname,lname,sname,department,course,level,email,role,admission_number) values(?,?,?,?,?,?,?,?,?) ");
                $result3 = $sql3->execute([$fname,$lname,$sname,$departmentValue,$courseValue,$levelValue,$email,$role,$admission_number]);
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