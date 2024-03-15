<?php
session_start();
include('connect.php');

$id = $_POST['id'];
$name = $_POST['name'];
$address = $_POST['address'];
$contact = $_POST['contact'];
$root = $_POST['root'];

$result = $db->prepare("SELECT * FROM root WHERE  root_id= :id ");
$result->bindParam(':id', $root);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $area = $row['root_area'];
    $root_name = $row['root_name'];
}

$type = 1;

if ($id == 0) {

    $sql = "INSERT INTO customer (customer_name,address,contact,area,root,root_id,type) VALUES (?,?,?,?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($name, $address, $contact, $area, $root_name, $root, $type));

    header("location: gps2.php");
} else {
}
