<?php

include "conn.php";


// $level = "Level 5";

// $lecture_admissionNumber = "22050513037";

// $sql1 = $conn->prepare("select * from enrolling_table");
// $result = $sql1->execute();
// if($result){
//     $sql2 = $conn->prepare("select * from enrolling_table where lecture_admission = ?");
//     $result2 = $sql2->execute([$lecture_admissionNumber]);
//     if($result2){
//         while($fetch = $sql2->fetch(PDO::FETCH_ASSOC)){
//             $sql3 = $conn->prepare("select count(*) from login_table where level = ? ");
//             $result3 = $sql3->execute([$fetch['level']]);
//             if($result3){
//                 $count = $sql3->fetchColumn();
//                 $modules[] = [
//                     "modules" => $fetch['module'],
//                     "count" => $count,
//                 ];                
//             }
//         }
//         print_r($modules);
//     }
// }


// $sql4 = $conn->prepare("SELECT * FROM `Database Management_video` WHERE db_mg_path IS NULL OR db_mg_path = ''");
// $result4 = $sql4->execute();

// $fetchEmpty = $sql4->fetchAll();

// if (empty($fetchEmpty)) {
//     echo "Late";
// } else {
//     foreach ($fetchEmpty as $row) {
//         echo "db_mg_path: " . $row['db_mg_path'] . "<br>";
//     }
// }


// $table_name = "Database Management_video";
// $sel_admin = $conn->prepare("SELECT * FROM `$table_name` ");
    
// // echo json_encode(["message" => "Thank God2" ]);
// $sel_admin->execute();


// $sql = $conn->prepare("select * from question where candidee_num IS NOT NULL and candidee_answer IS NOT NULL");
// $result = $sql->execute();
// $response = [];
// if ($result){
//     while($fetch = $sql->fetch(PDO::FETCH_ASSOC)){
//         $response[] = [
//             "candidee_num" => $fetch['candidee_num'],
//             "candidee_answer"=> $fetch['candidee_answer']
//         ];
//     }
    
// }

// echo count($response);
// for ($i = 0;)

// $sql = $conn->prepare("select * from information_schema.tables where table_schema = ? and table_name =? LIMIT 1 ");
// $result = $sql->execute([$table_schema,$table_name]);
// if($result){
//     $row = $sql->rowCount();
//     if($row > 0){
//         echo "table exists";
//     }
// }


// $table_name = "Database Management_qu";
// $table_schema = "project_app";
// $data = [];
// $sql = $conn->prepare("SELECT table_name 
//                        FROM information_schema.tables 
//                        WHERE table_schema = ? 
//                          AND table_name LIKE '$table_name%' ");
// $sql->execute([$table_schema]);

// $fetchTable = $sql->fetchAll(PDO::FETCH_ASSOC);

// foreach($fetchTable as $fetchTable2){
//     $tableName = $fetchTable2['table_name']; // ✅ get actual table name string

//     // Prepare the query using the correct table name
//     $sql2 = $conn->prepare("SELECT question_note, question_id 
//                             FROM `$tableName` 
//                             WHERE candidee_num IS NULL 
//                               AND candidee_answer IS NULL");
//     $sql2->execute();
//     $rowsFetch  = $sql2->fetch(PDO::FETCH_ASSOC);
//     $sql10 = $conn->prepare("select * from `$tableName` where candidee_num IS NOT NULL and candidee_answer IS NOT NULL");
//     $result10 = $sql10->execute();
//     $response = [];
//     while($fetchNotNull = $sql10->fetch(PDO::FETCH_ASSOC)){
//         $response[] = [
//             "candidee_answer" => $fetchNotNull['candidee_answer'],
//             "candidee_num" => $fetchNotNull['candidee_num']
//         ];
//     }
//     $count =  count($response);
//     if (!empty($rowsFetch)) {
//         echo "<h3>Table: $tableName</h3>";
//         echo $rowsFetch['question_note'];
//         $data[] = [
//             "table_name" => $tableName,
//             "question_note"=>$rowsFetch['question_note'],
//             "count"=> $count,
//         ];
//         // print_r($rowsFetch);
//         // foreach ($rowsFetch as $row) {
//         //     echo "Question ID with NULL values: " . $row['question_id'] . "<br>";
//         //     echo "Question Note: " . $row['question_note'] . "<br><br>";
//         // }
//     } 
       
// }

// print_r($data);


// echo $fetchTable;


// header("Access-Control-Allow-Origin: * ");
// header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
// header("Access-Control-Allow-Headers: Content-Type,Authorization");
// header("Content-Type: application/json");


include "conn.php";
// $response = []; 
// // if($_SERVER['REQUEST_METHOD'] == "POST"){
//     // $table_name = $_POST['table_name'];
//     $table_name = "DataBase Management_qu";
//     $table_schema = "project_app";
    
    
//     $sql1 = $conn->prepare("select table_name from information_schema.tables where table_schema = ? and table_name like '$table_name%' ");
//     $result1 = $sql1->execute([$table_schema]);
//     // $fetch1 = $sql1->fetchAll();
//     // $row1 = $sql1->rowCount();
//     $row1 = 5;
    

//     if($result1){
        
//     //     
//         if($row1 < 1){
            
//             echo "No question uploaded";
//     //         // $response['row'] = $row1;
//         }else{
            
//             $originalData = [];
//             $fetchTable = $sql1->fetchAll(PDO::FETCH_ASSOC);
//             // $response['message'] = $fetchTable;
//             print_r($fetchTable);
//             // echo "1";
//             foreach($fetchTable as $fetchTable2){
//                 $tableName = $fetchTable2['table_name'];
//                 // $response['message'] = $tableName;
//                 // $sql2 = $conn->prepare("select question_note from `$tableName` where candidee_num IS NULL and candidee_answer IS NULL and candidee_level IS NULL and candidee_time IS NULL");
//                 // $result2 = $sql2->execute();
//                 // $fetch2 = $sql2->fetch(PDO::FETCH_ASSOC);

//                 // $sql3 = $conn->prepare("select * from `$tableName` where candidee_num IS NOT NULL and candidee_answer IS NOT NULL and candidee_level IS NOT NULL and candidee_time IS NOT NULL ");
//                 // $result3 = $sql3->execute();
//                 // $dataNotNull = [];
//                 // while($fetch3 = $sql3->fetch(PDO::FETCH_ASSOC) ){
//                 //     $dataNotNull[] = [
//                 //         "candidee_num" => $fetch3['candidee_num'],
//                 //         "candidee_answer"=> $fetch3['candidee_answer'],
//                 //     ];
//                 // }
//                 // $count = count($dataNotNull);

//                 // if(!empty($fetch2)){
//                 //     $originalData[] = [
//                 //         "table_name"=> $tableName,
//                 //         "question_note"=> $fetch2['question_note'],
//                 //         "count"=>$count
//                 //     ];
//                 // }

//             }
//             // $response['message'] = $originalData;
//         }
//     }else{
//         echo "Query error";
//     }
// }

// if($_SERVER['REQUEST_METHOD']=="POST"){
    // $table_name = "Ethical planing_video";
    // $sql = $conn->prepare("select * from `$table_name`");
    // $result = $sql->execute();
    // if($result){
    //     $row = $sql->rowCount();
    //     // echo $row;
    //     if($row < 1){
    //     //    $response['text'] = "No video Uploaded";
    //     echo "not Good";
    //     }else{
    //         $response['message'] = $table_name;
    //         $sql1 = $conn->prepare("SELECT * FROM `$table_name` WHERE db_mg_path IS NULL OR db_mg_path = ''");
    //         $result1 = $sql1->execute();
    //         $fetchEmpty = $sql1->fetchAll();
    //         // echo "Good";
    //         // print_r($fetchEmpty);
            
    //         if(empty($fetchEmpty)){
    //             $response['text'] = "NotVideoEmpty";
    //             $sql2 = $conn->prepare("select * from `$table_name` ORDER BY db_mg_id DESC ");
    //             $result2 = $sql2->execute();
    //             if($result2){
    //                 while($fetch2 = $sql2->fetch(PDO::FETCH_ASSOC)){
    //                     $url = "http://192.168.33.102/project_app/videos/";
    //                     $actual_url = $url.$fetch2['db_mg_path'];
    //                     $details[] = [
    //                         "video_name"=> $actual_url,
    //                         "video_content"=> $fetch2['db_mg_desc'],
    //                         "video_course"=> $fetch2['db_mg_tuto'], 
    //                         "video_id"=> $fetch2['db_mg_id']
    //                     ];
    //                 }
            
    //             }
    //         }else{
    //             $response['text'] = "videoNotEmpty";
    //         }            
    //     }
    // }
// }

// // if($_SERVER['REQUEST_METHOD'] == "POST"){
//     $dataTransfered = [];
//     // $level_name = $_POST['level_name'];
//     $level_name = "Level 8";
//     // $response['message'] = $level_name;
//     $sql1 = $conn->prepare("select * from enrolling_table where level = ?");
//     $result1 = $sql1->execute([$level_name]);
//     $row1 = $sql1->rowCount();
//     if($row1 == 0){
//         // $response['message'] = "No module enrolled";
//         echo "No module enrolled";
//     }else{
//         if($result1){
//         while($fetch1 = $sql1->fetch(PDO::FETCH_ASSOC)){
//             $sql2 = $conn->prepare("select * from login_table where admission_number = ?");
//             $result2 = $sql2->execute([$fetch1['lecture_admission']]);
//             if($result2){
//                 while($fetch2 = $sql2->fetch(PDO::FETCH_ASSOC) ){
//                     $dataTransfered[] = [
//                         "module_name"=>$fetch1['module'],
//                         "fname"=> $fetch2['fname']
//                     ];               
//                 }
//             }
//         }
//         print_r($dataTransfered);
//         }
//     }
// }

// $d=mktime(11, 14, 54, 8, 12, 2014);
date_default_timezone_set('Africa/Dar_es_Salaam');
echo "Created date is " . date("H:i:s");
$time = date("H:i:sa");

if($time < "23:00:00"){
    echo "Good Morning";
}else{
    echo  "Good Night";
}




?>