<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$time = date('H.i');

$id = $_POST['id'];
$date = $_POST['date'];
$in_time = $_POST['in_time'];
$out_time = $_POST['out_time'];

$result = $db->prepare("SELECT * FROM employee WHERE id ='$id' ");
$result->bindParam(':userid', $res);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $name = $row['name'];
}


if ($in_time < 8) {
    $in_ti = "8.00";
} else {
    $in_ti = $in_time;
}
$out_ti = $out_time;


list($out_h, $out_m) = explode('.', $out_ti);
list($in_h, $in_m) = explode('.', $in_ti);

$deff_h = $out_h - $in_h;
$deff_m = $out_m - $in_m;
if ($deff_m < 0) {
    $deff_m = $deff_m + 60;
    $deff_h = $deff_h - 1;
}

$deff = $deff_h . "." . sprintf("%02d", $deff_m);

if ($deff_h >= 10) {
    $work_time = '10.00';
} else {
    $work_time = $deff;
}

if ($deff_h < 10) {
    $wh = 9;
    $wm = 60;

    $ot_h = $deff_h - $wh;
    $ot_m = $wm - $deff_m;
    // $ot='-'.$ot_h.'.'.sprintf("%02d",$ot_m);
    $ot = 0.00;
}
if ($deff_h >= 10) {
    $wh = 10;

    $ot_h = $deff_h - $wh;
    $ot_m = $deff_m;

    $ot = $ot_h . '.' . sprintf("%02d", $ot_m);
}

$sql = "INSERT INTO attendance (emp_id,name,date,time,IN_time,OUT_time,deff_time,ot,work_time) VALUES (?,?,?,?,?,?,?,?,?)";
$q = $db->prepare($sql);
$q->execute(array($id, $name, $date, $time, $in_time, $out_time, $deff, $ot, $work_time));

header("location: hr_attendance.php");
