<?php
session_start();
include('../connect.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//echo $r_data[0];
$id=$_POST['id'];

$load_id=1;

$result = $db->prepare("SELECT * FROM loading WHERE transaction_id='$id' ");
$result->bindParam(':userid', $res);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
    $result_array[] = array (
        "name" => $row['customer_name'],
        "cus_id" => $row['customer_id'],
        "amount" => $row['amount'],
        "balance" => $row['amount']-$row['pay_amount'],
        "type" => $row['type'],
        "invoice_no"=>$row['invoice_no'],
        "date" => $row['date'],
        "id" => $row['transaction_id'],
    );
    }
 




echo (json_encode ( $result_array ));
