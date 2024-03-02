<?php
session_start();
include('../connect.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//echo $r_data[0];
$user=$_POST['user'];
$password=$_POST['password'];

$result = $db->prepare("SELECT * FROM user WHERE username='$user' AND password='$password' ");
$result->bindParam(':userid', $res);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
    $result_array[] = array (
        "position" => $row['position'],
        'name' => $row['name'],
        "action"=>'ok',
        "user_id"=>$row['EmployeeId'],
        "key" => "0000"
    );
    }
 




echo (json_encode ( $result_array ));
