<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$name = $_POST['name'];
$phone_no = $_POST['phone_no'];
$address = $_POST['address'];
$nic = $_POST['nic'];
$etf_no = $_POST['epf_no'];
$etf_amount = $_POST['epf_amount'];
$des_id = $_POST['des'];
$rate = $_POST['rate'];
$well = $_POST['well'];
$ot = $_POST['ot'];
$id = $_POST['id'];

$lorry = 0;
if ($des_id == 1) {
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


if ($id == 0) {
    
    $sql = "INSERT INTO employee (name,type,phone_no,nic,address,attend_date,hour_rate,des,des_id,epf_no,epf_amount,ot,well,action,lorry_id,lorry_no) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($name, $type, $phone_no, $nic, $address, $attend_date, $rate, $des, $des_id, $etf_no, $etf_amount, $ot, $well, 1, $lorry, $lorry_no));
} else {

    $sql = "UPDATE employee SET name = ?, address = ?, nic = ?, phone_no = ?, hour_rate = ?, des = ?, des_id = ?, epf_amount = ?, epf_no = ?, ot = ?, well = ?, lorry_id = ?, lorry_no = ?, type = ? WHERE id = ? ";
    $q = $db->prepare($sql);
    $q->execute(array($name, $address, $nic, $phone_no, $rate, $des, $des_id, $etf_amount, $etf_no, $ot, $well, $lorry, $lorry_no, $type, $id));
}

if (isset($_POST['end'])) {

    header("location: hr_employee_profile.php?id=$id");
} else {

    header("location: hr_employee.php");
}
