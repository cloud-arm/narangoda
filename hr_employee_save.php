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

$user_name = '';
$password = '';
if ($des_id == 1) {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
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


if ($id == 0) {

    $sql = "INSERT INTO employee (name,type,phone_no,nic,address,attend_date,hour_rate,des,des_id,epf_no,epf_amount,ot,well,action,user_name,password) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($name, $type, $phone_no, $nic, $address, $attend_date, $rate, $des, $des_id, $etf_no, $etf_amount, $ot, $well, 1, $user_name, $password));
} else {

    $sql = "UPDATE employee SET name = ?, address = ?, nic = ?, phone_no = ?, hour_rate = ?, des = ?, des_id = ?, epf_amount = ?, epf_no = ?, ot = ?, well = ?, user_name = ?, password = ?, type = ? WHERE id = ? ";
    $q = $db->prepare($sql);
    $q->execute(array($name, $address, $nic, $phone_no, $rate, $des, $des_id, $etf_amount, $etf_no, $ot, $well, $user_name, $password, $type, $id));
}

if (isset($_POST['end'])) {

    header("location: hr_employee_profile.php?id=$id");
} else {

    header("location: hr_employee.php");
}
