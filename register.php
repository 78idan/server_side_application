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
                    $candidate_table = $admission_number."_book";
                    $candidate_college = $admission_number."_college";
                    $candidate_industry = $admission_number."_industry";
                    $candidate_report = $admission_number."_report";
                    $candidate_marker = $admission_number."_marker";
                    $sql4 = $conn->prepare("create table `$candidate_table`(book_id INT AUTO_INCREMENT PRIMARY KEY,week VARCHAR(255) NOT NULL,day VARCHAR(255) NOT NULL,date_time VARCHAR(255) NOT NULL, activity VARCHAR(255) NOT NULL,photo VARCHAR(255) NULL, id_sign VARCHAR(255) NULL, co_sign VARCHAR(255)  NULL  )" );
                    $result4 = $sql4->execute();

                    //start of create college table
                    $sql5 = $conn->prepare( "create table `$candidate_college` (college_id INT AUTO_INCREMENT PRIMARY KEY, company VARCHAR(255) , supervisor VARCHAR(255) , student_name VARCHAR(255) , admin_no VARCHAR(255) , management_score VARCHAR(255) , student_score VARCHAR(255) , log_score VARCHAR(255) , problem_student VARCHAR(255) , problem_management VARCHAR(255) , view VARCHAR(255) , calendar VARCHAR(255) , signature VARCHAR(255)  ) " );
                    $result5 = $sql5->execute();

                    $insertSql5 = $conn->prepare("insert into `$candidate_college` () values () ");
                    $resultInsertSql5 = $insertSql5->execute();
                    //end of create college table

                    //start of create industrial table
                    $sql6 = $conn->prepare( "create table `$candidate_industry` (industry_id INT AUTO_INCREMENT PRIMARY KEY, company VARCHAR(255) , supervisor VARCHAR(255) , student_name VARCHAR(255) , admin_no VARCHAR(255) , level VARCHAR(255) , department VARCHAR(255) , program VARCHAR(255), asses_score VARCHAR(255) , report_date VARCHAR(255) , finish_date VARCHAR(255) , permission_with VARCHAR(255) , permission_without VARCHAR(255) , opinion_skill VARCHAR(255) , opinion_adequacy VARCHAR(255) , calendar VARCHAR(255) , signature VARCHAR(255)  ) " );
                    $result6 = $sql6->execute();

                    $insertSql6 = $conn->prepare("insert into `$candidate_industry` () values () ");
                    $resultInsertSql6 = $insertSql6->execute();                    
                    //end of create industrial table

                    //start of technical report
                    $sql7 = $conn->prepare( "create table `$candidate_report` (technical_id INT AUTO_INCREMENT PRIMARY KEY, student_name VARCHAR(255) , admin_no VARCHAR(255) ,  technical_report VARCHAR(255) ) " );
                    $result7 = $sql7->execute();

                    $insertSql7 = $conn->prepare("insert into `$candidate_report` () values () ");
                    $resultInsertSql7 = $insertSql7->execute();                     
                    //end of technical report

                    //start of marker_table
                    $sql8 = $conn->prepare( "create table `$candidate_marker` (marker_id INT AUTO_INCREMENT PRIMARY KEY, technical_report VARCHAR(255) , total VARCHAR(255) ) " );
                    $result8 = $sql8->execute();

                    $insertSql8 = $conn->prepare("insert into `$candidate_marker` () values () ");
                    $resultInsertSql8 = $insertSql8->execute();                     
                    //end of marker_table

                    if($resultInsertSql8){
                        $response['message']= "Registered"; 
                    }
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