<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$id = $_GET['id'];


$sql = "UPDATE customer  SET category=? WHERE customer_id=?";
$q = $db->prepare($sql);
$q->execute(array(0, $id));
