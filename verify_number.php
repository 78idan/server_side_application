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


?>