<?php
session_start();
date_default_timezone_set("Asia/Colombo");
include('connect.php');

$complain_no = $_POST['complain_no'];
$customer = $_POST['customer'];
$cylinder_no = $_POST['cylinder_no'];
$product = $_POST['product'];
$reason = $_POST['reason'];
$gas_weight = $_POST['gas_weight'];
$comment = $_POST['comment'];

$date = date("Y-m-d");
$invoice = date('ymdhis');

$one2one = false;
if (isset($_POST['one2one'])) {
    $one2one = true;
}


$type = 'damage';
$action = "register";


if ($customer == 0) {

    $customer_name = 'Narangoda Group';
} else {
    $result = $db->prepare("SELECT * FROM customer WHERE customer_id = '$customer' ");
    $result->bindParam(':userid', $res);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $customer_name = $row['customer_name'];
    }
}


$result = $db->prepare("SELECT * FROM products WHERE product_id = '$product' ");
$result->bindParam(':userid', $res);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $product_name = $row['gen_name'];
}


$sql = "UPDATE products  SET damage = damage + ? WHERE product_id = ?";
$q = $db->prepare($sql);
$q->execute(array(1, $product));


if ($one2one) {
    $sql = "UPDATE stock  SET qty_balance = qty_balance - ? WHERE product_id = ? ";
    $q = $db->prepare($sql);
    $q->execute(array(1, $product));
}


$sql = "INSERT INTO damage (complain_no,customer_id,customer_name,product_id,cylinder_no,cylinder_type,reason,date,action,gas_weight,comment,type,location,invoice_no,position) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$q = $db->prepare($sql);
$q->execute(array($complain_no, $customer, $customer_name, $product, $cylinder_no, $product_name, $reason, $date, $action, $gas_weight, $comment, $type, 'Yard', $invoice, 1));


$sql = "INSERT INTO damage_order (complain_no,date,action,type,location) VALUES (?,?,?,?,?)";
$q = $db->prepare($sql);
$q->execute(array($complain_no, $date, $action, $type, 'Yard'));

header("location: damage_view.php");
