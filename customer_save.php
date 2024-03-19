<?php
session_start();
include('connect.php');

$id = $_POST['id'];
$name = $_POST['name'];
$address = $_POST['address'];
$contact = $_POST['contact'];
$root = $_POST['root'];
$type = $_POST['type'];


if ($id > 0) {
    $acc_name = $_POST['acc_name'];
    $acc_no = $_POST['acc_no'];
    $group = $_POST['group'];
    $credit = $_POST['credit'];
    $vat_no = $_POST['vat_no'];
    $g12 = $_POST['g12'];
    $g5 = $_POST['g5'];
    $g37 = $_POST['g37'];
}

$result = $db->prepare("SELECT * FROM root WHERE  root_id= :id ");
$result->bindParam(':id', $root);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $area = $row['root_area'];
    $root_name = $row['root_name'];
}

if ($type == 1) {
    // $type = 'Channel';
}
if ($type == 2) {
    // $type = 'Commercial';
}
if ($type == 3) {
    // $type = 'Apartment';
}

if ($id == 0) {

    $sql = "INSERT INTO customer (customer_name,address,contact,area,root,root_id,type) VALUES (?,?,?,?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($name, $address, $contact, $area, $root_name, $root, $type));
} else {

    $sql = "UPDATE customer
        SET customer_name=?, address=?, contact=?, area=?, root=?, root_id=?, acc_name=?, acc_no=?, type=?, credit_period=?, category=?, price_12=?, price_5=?, price_37=?
		WHERE customer_id=?";
    $q = $db->prepare($sql);
    $q->execute(array($name, $address, $contact, $area, $root_name, $root, $acc_name, $acc_no, $type, $credit, $group, $g12, $g5, $g37, $id));
}

header("location: customer.php");
