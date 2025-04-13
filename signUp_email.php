<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET,OPTIONS ');
header('Access-Control-Allow-Headers: Content-Type,Authorization ');
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\src;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

$mail = new PHPMailer();
$response = [];
include "conn.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $email = $_POST['email'];
    $character = "abcdefghijklmnopqrstuvwxyz1234567890";

    function getcodeForgot($input,$string = 4){
      $input_length = strlen($input);
      $random_character = "";
      for($i = 0 ;$i<$string;$i++){
        $random_string = $input[mt_rand(0,$input_length-1)];
        $random_character .= $random_string;
      }
      return $random_character;
    }
    $otp = getcodeForgot($character);
    
    try{
        $sql1 = $conn->prepare("select * from login_table");
        $result1 = $sql1->execute();
        if($result1){
            $sql2 = $conn->prepare("update login_table set reg_otp = ? where email = ?");
            $result2 = $sql2->execute([$otp,$email]);
            if($result2){
                try{
                    //smtp server settings 
                  
                    $mail->isSMTP();
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPAuth = "true";
                    $mail->Username = "idanbertam@gmail.com";
                    // $mail->Password = "dgfhpwhnisseyuwt";
                    $mail->addAddress('idanbertam@gmail.com');
                    $mail->Password='kakqxbqhjttvnwcz';
                    $mail->SMTPSecure = "PHPMiler::ENCRYPTION_STARTTLS";
                    $mail->Port = 587;
                    // receipt
                  
                    $mail->setFrom("idanbertam@gmail.com","REGISTER OTP");
                    $mail->addAddress($email);
                  
                    $mail->isHTML(true);
                    $mail->Subject = "REGISTER OTP";
                    $mail->Body =  "Copy these otp $otp";
                  
                    if($mail->send()){
                      $response['message'] = "otp sent";
                    }
                  }catch(Exception $alt ){
                      $response['message'] = $mail->ErrorInfo;
                  }
            }else{
                $response['message']= "has not been sent";
            }
        }else{
            $response['message'] = "Table doesn`t";
        }
    }catch(PDOException $alt){
        $response['message'] = $alt->getMessage();
    }
}

echo json_encode($response); 

?>