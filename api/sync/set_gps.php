<?php
include('../../connect.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get json data
$json_data = file_get_contents('php://input');

// get values
$unloading = json_decode($json_data, true);

// respond init
$result_array = array();

    $load = $list['loading_id'];
    $lat = $list['lat'];
    $lng= $list['lng'];


    //------------------------------------------------------------------//
    try {

        // unloading
        $sql = "UPDATE loading SET   lat = ?, lng = ? WHERE transaction_id = ? ";
        $q = $db->prepare($sql);
        $q->execute(array( $lat,$lng, $load));

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
