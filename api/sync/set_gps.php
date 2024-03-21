<?php
include('../../connect.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



// respond init
$result_array = array();

    $id = $_POST['user_id'];
    $lat = $_POST['lat'];
    $lng= $_POST['lng'];


    //------------------------------------------------------------------//
    try {

        // unloading
        $sql = "UPDATE user SET   lat = ?, lng = ? WHERE EmployeeId = ? ";
        $q = $db->prepare($sql);
        $q->execute(array( $lat,$lng, $id));

        // create success respond 
        $res = array(
            "status" => "success",
            "message" => "",
        );

        array_push($result_array, $res);
    } catch (PDOException $e) {

        // create error respond 
        $res = array(
            "status" => "failed",
            "message" => $e->getMessage(),
        );

        array_push($result_array, $res);
    }


// send respond
echo (json_encode($result_array));
