<?php
include('connect.php');

// Assuming you have a table named 'gps_data' with columns 'lat' and 'lng'
// Fetch GPS data from the database


$result = $db->prepare("SELECT * FROM loading WHERE action='load'   ");
$result->bindParam(':id', $res);
$result->execute();
$gpsData = $result->fetchAll();


// Output GPS data as JSON
header('Content-Type: application/json');
echo json_encode($gpsData);
?>
