<?php
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET,POST,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type,Authorization");
header("Content-Type: application/json");

include "conn.php";
$response = [];


if($_SERVER['REQUEST_METHOD'] == "POST"){
  $check = $_POST['check'];
//   $response['message'] = $check;
  $sqlCheckIpt = $conn->prepare("select * from ipt_schedule"); 
  $resultCheckIpt = $sqlCheckIpt->execute();
  if($resultCheckIpt){
    $fetchCheckIpt = $sqlCheckIpt->fetch(PDO::FETCH_ASSOC);
    $response['message'] = "chosen ipt";
    $response['start'] = $fetchCheckIpt['startingDate'];
    $response['end'] = $fetchCheckIpt['endingDate'];
  }   
}






echo json_encode($response);

?>