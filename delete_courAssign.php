<?php
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,OPTIONS,POST ");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json");


include "conn.php";
$reponse = [];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $tableOfName = $_POST['tableOfName'];
    // $reponse['message'] = $tableOfName;
    $sql1 = $conn->prepare("DROP TABLE `$tableOfName`");
    $result1 = $sql1->execute();
    if($result1){
        $reponse['message'] = "Table deleted";
    }else{
        $reponse['message'] = "Table not found";
    }
}

echo json_encode($reponse);


?>