<?php
session_start();
include('../../connect.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$user_id = $_SESSION['SESS_MEMBER_ID'];
$user_name = $_SESSION['SESS_FIRST_NAME'];

$invo = $user_id . date("ymdhis");

$date = date('Y-m-d');

$loading_id = $_POST['id'];
$cus_id = $_POST['customer'];


$result = $db->prepare("SELECT * FROM loading WHERE transaction_id='$loading_id' AND action='load' ");
$result->bindParam(':userid', $res);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $lorry = $row['lorry_no'];;
    $root = $row['root'];;
    $u_name = $row['driver'];
    $term = $row['term'];
}



$result = $db->prepare("SELECT * FROM customer WHERE customer_id='$cus_id' ORDER by customer_id DESC ");
$result->bindParam(':userid', $res);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $cus = $row['customer_name'];
}


//------------------------------------------------------------------//


try {

    $sql = "INSERT INTO sales (invoice_number,cashier,date,name,lorry_no,loading_id,customer_id) VALUES (?,?,?,?,?,?,?)";
    $ql = $db->prepare($sql);
    $ql->execute(array($invo, $user_name, $date, $cus, $lorry, $loading_id, $cus_id));

    echo "Insert successfully";
} catch (PDOException $e) {
    echo "Insert failed: " . $e->getMessage();
}
