<?php
include('../../connect.php');
include('log.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get json data
$json_data = file_get_contents('php://input');

// get values
$credit_payment = json_decode($json_data, true);

// respond init
$result_array = array();

foreach ($credit_payment as $list) {

    // get values
    $invoice = $list['invoice_no'];
    $pay_amount = $list['pay_amount'];
    $credit_amount = $list['credit_amount'];
    $pay_type = $list['pay_type'];
    $date = $list['date'];
    $cus = $list['cus_id'];
    $load = $list['loading_id'];
    $pay_id = $list['pay_id'];
    $collection = $list['collection_id'];
    $sales_id = $list['sales_id'];
    $tr_id = $list['tr_id'];
    $app_id = $list['id'];


    // get customer details
    $result = $db->prepare("SELECT * FROM customer WHERE customer_id=:id  ");
    $result->bindParam(':id', $cus);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $cus_name = $row['customer_name'];
    }
    //------------------------------------------------------------------//
    try {

        //checking duplicate
        $con = 0;
        $result = $db->prepare("SELECT * FROM credit_payment WHERE invoice_no = '$invoice' AND app_id = '$app_id' AND loading_id = '$load' ");
        $result->bindParam(':id', $cus);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $con = $row['id'];
        }

        if ($con == 0) {

            // insert query
            $sql = "INSERT INTO credit_payment (invoice_no,pay_amount,credit_amount,type,date,cus_id,cus,action,loading_id,pay_id,collection_id,sales_id,tr_id,app_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $ql = $db->prepare($sql);
            $ql->execute(array($invoice, $pay_amount, $credit_amount, $pay_type,  $date,  $cus, $cus_name, 2, $load, $pay_id, $collection, $sales_id, $tr_id, $app_id));
        }

        // get sales  data
        $result = $db->prepare("SELECT * FROM credit_payment WHERE invoice_no=:id ");
        $result->bindParam(':id', $invoice);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $id = $row['id'];
            $ap_id = $row['app_id'];
            $invo = $row['invoice_no'];
        }

        // create success respond 
        $res = array(
            "cloud_id" => $id,
            "app_id" => $ap_id,
            "invoice_no" => $invo,
            "status" => "success",
            "message" => "",
        );

        array_push($result_array, $res);

        // Create log
        $content = "cloud_id: " . $id . ", app_id: " . $ap_id . ", invoice: " . $invo . ", status: success, message: - , Date: " . date('Y-m-d') . ", Time: " . date('H:s:i');
        log_init('credit_payment', $content);
    } catch (PDOException $e) {

        // create error respond 
        $res = array(
            "cloud_id" => 0,
            "app_id" => 0,
            "invoice_no" => "",
            "status" => "failed",
            "message" => $e->getMessage(),
        );

        array_push($result_array, $res);

        // Create log
        $content = "cloud_id: 0, app_id: " . $app_id . ", invoice: " . $invoice . ", status: failed, message: " . $e->getMessage() . ", Date: " . date('Y-m-d') . ", Time: " . date('H:s:i');
        log_init('credit_payment', $content);
    }
}

// send respond
echo (json_encode($result_array));
