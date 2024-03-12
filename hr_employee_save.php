<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$name = $_POST['name'];
$phone_no = $_POST['phone_no'];
$address = $_POST['address'];
$nic = $_POST['nic'];
$etf_no = $_POST['etf_no'];
$etf_amount = $_POST['etf_amount'];
$des_id = $_POST['type'];
$rate = $_POST['rate'];
$well = $_POST['well_amount'];
$ot = $_POST['ot'];

$lorry = 0;
if ($des == 1) {
    $lorry = $_POST['lorry'];
}

$attend_date = date('Y-m-d');
$type = '1';

$result = $db->prepare("SELECT * FROM employees_des WHERE id=:id ");
$result->bindParam(':id', $des_id);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $des_id = $row['id'];
    $des = $row['name'];
    $type = $row['type'];
}

$lorry_no = '';
$result = $db->prepare("SELECT * FROM lorry WHERE lorry_id=:id ");
$result->bindParam(':id', $lorry);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $lorry_no = $row['lorry_no'];
}



$sql = "INSERT INTO employee (name,type,phone_no,nic,address,attend_date,hour_rate,des,des_id,epf_no,epf_amount,ot,well,action,lorry_id,lorry_no) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$q = $db->prepare($sql);
$q->execute(array($name, $type, $phone_no, $nic, $address, $attend_date, $rate, $des, $des_id, $etf_no, $etf_amount, $ot, $well, 1, $lorry, $lorry_no));


header("location: hr_employee.php");
