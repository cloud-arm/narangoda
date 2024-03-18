<?php
session_start();
date_default_timezone_set("Asia/Colombo");
include('connect.php');
$comment = $_POST['comment'];
$cus_id = $_POST['customer'];
$type = $_POST['type'];
$pro_id = $_POST['product'];
$end_date = $_POST['date'];

$date = date("Y-m-d");
$qty = $_POST['qty'];


$result = $db->prepare("SELECT * FROM customer WHERE customer_id='$cus_id' ");
$result->bindParam(':userid', $res);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
	$cus_name = $row['customer_name'];
}

$result = $db->prepare("SELECT * FROM products WHERE product_id='$pro_id' ");
$result->bindParam(':userid', $res);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
	$product = $row['gen_name'];
}

$sql = "UPDATE products  SET trust=trust+? WHERE product_id=?";
$q = $db->prepare($sql);
$q->execute(array($qty, $pro_id));

$sql = "UPDATE products  SET qty=qty-? WHERE product_id=?";
$q = $db->prepare($sql);
$q->execute(array($qty, $pro_id));


$status = 'active';


$sql = "INSERT INTO trust (customer_name,product,date,end_date,comment,type,status,qty,customer_id,product_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
$q = $db->prepare($sql);
$q->execute(array($cus_name, $product, $date, $end_date, $comment, $type, $status,  $qty,  $cus_id,  $pro_id));


header("location: trust_view.php");
