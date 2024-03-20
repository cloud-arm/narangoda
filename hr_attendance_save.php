<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$time = date('H.i');
$date = date('Y-m-d');


if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $result = $db->prepare("SELECT * FROM employee WHERE id ='$id' ");
    $result->bindParam(':userid', $res);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $name = $row['name'];
    }


    $sql = "INSERT INTO attendance (emp_id,name,date,time) VALUES (?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($id, $name, $date, $time));
} else {

    $id = $_GET['dll'];

    $result = $db->prepare("DELETE FROM attendance WHERE  id= :id  ");
    $result->bindParam(':id', $id);
    $result->execute();
}

// header("location: hr_attendance.php");
