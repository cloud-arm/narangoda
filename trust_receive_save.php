<?php

session_start();

include('connect.php');

date_default_timezone_set("Asia/Colombo");



$id = $_POST['id'];

$f = $_POST['location'];




$status = 'clear';



$sql = "UPDATE trust  SET status=? WHERE transaction_id=?";
$q = $db->prepare($sql);
$q->execute(array($status, $id));


$result = $db->prepare("SELECT * FROM trust WHERE  transaction_id= :id ");
$result->bindParam(':id', $id);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $qty = $row['qty'];
    $pr = $row['product'];
    $pro_id = $row['product_id'];
}


$sql = "UPDATE products  SET qty=qty+? WHERE product_id=?";
$q = $db->prepare($sql);
$q->execute(array($qty, $pro_id));

$sql = "UPDATE products  SET trust=trust-? WHERE product_id=?";
$q = $db->prepare($sql);
$q->execute(array($qty, $pro_id));


header("location: trust_view.php");
