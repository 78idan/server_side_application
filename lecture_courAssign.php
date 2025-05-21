<?php

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json");


include "conn.php";
$response = []; 
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $table_name = $_POST['table_name'];
    $table_schema = "project_app";
    
    
    $sql1 = $conn->prepare("select table_name from information_schema.tables where table_schema = ? and table_name like '$table_name%' ");
    $result1 = $sql1->execute([$table_schema]);
    // $fetch1 = $sql1->fetchAll();
    $row1 = $sql1->rowCount();
    // $row1 = 5;
    

    if($result1){
        
    //     
        if($row1 < 1){
            
            $response['message'] = "No question uploaded";
    //         // $response['row'] = $row1;
        }else{
            
            $originalData = [];
            $fetchTable = $sql1->fetchAll(PDO::FETCH_ASSOC);
            // $response['message'] = $fetchTable;
            foreach($fetchTable as $fetchTable2){
                $tableName = $fetchTable2['table_name'];
                // $response['message'] = $tableName;
                $sql2 = $conn->prepare("select question_note from `$tableName` where candidee_num IS NULL and candidee_answer IS NULL and candidee_level IS NULL and candidee_time IS NULL");
                $result2 = $sql2->execute();
                $fetch2 = $sql2->fetch(PDO::FETCH_ASSOC);

                $sql3 = $conn->prepare("select * from `$tableName` where candidee_num IS NOT NULL and candidee_answer IS NOT NULL and candidee_level IS NOT NULL and candidee_time IS NOT NULL ");
                $result3 = $sql3->execute();
                $dataNotNull = [];
                while($fetch3 = $sql3->fetch(PDO::FETCH_ASSOC) ){
                    $dataNotNull[] = [
                        "candidee_num" => $fetch3['candidee_num'],
                        "candidee_answer"=> $fetch3['candidee_answer'],
                    ];
                }
                $count = count($dataNotNull);

                if(!empty($fetch2)){
                    $originalData[] = [
                        "table_name"=> $tableName,
                        "question_note"=> $fetch2['question_note'],
                        "count"=>$count
                    ];
                }

            }
            $response['message'] = $originalData;
        }
    }else{
        $response['message'] = "Query error";
    }
}

echo json_encode($response);




?>