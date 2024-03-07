<?php
include('../../connect.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get json data
$json_data = file_get_contents('php://input');

// get values
$payment = json_decode($json_data, true);

// respond init
$result_array = array();

foreach ($payment as $list) {

    // get values
    $invoice = $list['invoice_no'];
    $amount = $list['amount'];
    $pay_type = $list['pay_type'];
    $date = $list['date'];
    $app_id = $list['id'];
    $chq_no = $list['chq_no'];
    $bank = $list['bank'];
    $chq_date = $list['chq_date'];
    $time = $list['time'];
    $load = $list['loading_id'];
    $cus = $list['cus_id'];


    $sales_id = 0;

    $action = 0;
    $credit = 0;
    $pay_amount = 0;

    if ($pay_type == 'credit') {

        $credit = $amount;
        $pay_amount = 0;
        $action = 2;
    } else

    if ($pay_type == 'chq') {

        $credit = 0;
        $pay_amount = 0;
        $action = 2;
    } else {

        $credit = 0;
        $action = 1;
        $pay_amount = $amount;
    }

    //------------------------------------------------------------------//
    try {

        //checking duplicate
        $con = 0;
        $result = $db->prepare("SELECT * FROM payment WHERE invoice_no = '$invoice' AND app_id = '$app_id' AND loading_id = '$load' ");
        $result->bindParam(':id', $cus);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $con = $row['transaction_id'];
        }

        if ($con == 0) {

            // insert query
            $sql = "INSERT INTO payment (invoice_no,pay_amount,amount,type,date,time,chq_no,bank_name,chq_date,chq_action,action,sales_id,customer_id,loading_id,pay_type,chq_bank,credit_balance,app_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $ql = $db->prepare($sql);
            $ql->execute(array($invoice, $pay_amount, $amount, $pay_type, $date, $time, $chq_no, '', $chq_date, 0, $action, $sales_id, $cus, $load, $pay_type, $bank, $credit, $app_id));
        }

        // get sales  data
        $result = $db->prepare("SELECT * FROM payment WHERE invoice_no=:id ");
        $result->bindParam(':id', $invoice);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $id = $row['transaction_id'];
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
    }
}

// send respond
echo (json_encode($result_array));
