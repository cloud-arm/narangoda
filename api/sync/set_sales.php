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
$sales = json_decode($json_data, true);

// respond init
$result_array = array();

foreach ($sales as $list) {

    // get values
    $load = $list['loading_id'];
    $cus = $list['cus_id'];
    $invoice = $list['invoice_no'];
    $amount = $list['amount'];
    $balance = $list['balance'];
    $vat_action = $list['vat_action'];
    $vat_no = $list['vat_no'];
    $date = $list['date'];
    $time = $list['time'];
    $app_id = $list['id'];


    // get loading details
    $result = $db->prepare("SELECT * FROM loading WHERE transaction_id=:id AND action='load' ");
    $result->bindParam(':id', $load);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $lorry = $row['lorry_no'];
        $root = $row['root'];
        $driver = $row['driver'];
        $term = $row['term'];
    }

    // get employee details
    $result = $db->prepare("SELECT * FROM employee WHERE id=:id  ");
    $result->bindParam(':id', $driver);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $driver_name = $row['name'];
    }

    // get customer details
    $result = $db->prepare("SELECT * FROM customer WHERE customer_id=:id  ");
    $result->bindParam(':id', $cus);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $cus_name = $row['customer_name'];
        $address = $row['address'];
    }

    // get sales details
    $result = $db->prepare("SELECT sum(cost_amount),sum(profit),sum(vat),sum(value) FROM sales_list WHERE invoice_no=:id  ");
    $result->bindParam(':id', $invoice);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $cost = $row['sum(cost_amount)'];
        $profit = $row['sum(profit)'];
        $vat = $row['sum(vat)'];
        $value = $row['sum(value)'];
    }

    //------------------------------------------------------------------//
    try {

        //checking duplicate
        $con = 0;
        $result = $db->prepare("SELECT * FROM sales WHERE invoice_number = '$invoice' AND app_id = '$app_id' AND loading_id = '$load' ");
        $result->bindParam(':id', $cus);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $con = $row['transaction_id'];
        }

        if ($con == 0) {

            // insert query
            $sql = "INSERT INTO sales (invoice_number,cashier,date,time,amount,balance,cost,profit,name,root,rep,lorry_no,term,loading_id,customer_id,action,address,vat,value,cus_vat_no,vat_action,app_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $ql = $db->prepare($sql);
            $ql->execute(array($invoice, $driver, $date, $time, $amount, $balance, $cost, $profit, $cus_name, $root, $driver_name, $lorry, $term, $load, $cus, 1, $address, $vat, $value, $vat_no, $vat_action, $app_id));

            //update vat amount
            $sql = "UPDATE vat_account SET amount = amount + ? WHERE vat_no = ?";
            $ql = $db->prepare($sql);
            $ql->execute(array($vat, $vat_no));

            // insert vat record
            $sql = "INSERT INTO vat_record (invoice_no,type,date,time,record_type,vat,value,vat_no,user_name,user_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $ql = $db->prepare($sql);
            $ql->execute(array($invoice, 'Credit', $date, $time, 'invoice', $vat, $value, $vat_no, $driver_name, $driver));
        }

        // get sales  data
        $result = $db->prepare("SELECT * FROM sales WHERE invoice_number=:id ");
        $result->bindParam(':id', $invoice);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $id = $row['transaction_id'];
            $ap_id = $row['app_id'];
            $invo = $row['invoice_number'];
        }

        // create success respond 
        $res = array(
            "cloud_id" => '"'.$id.'"',
            "app_id" => '"'.$ap_id.'"',
            "invoice_no" => $invo,
            "status" => "success",
            "message" => "",
        );

        array_push($result_array, $res);

        // Create log
        $content = "cloud_id: " . $id . ", app_id: " . $ap_id . ", invoice: " . $invo . ", status: success, message: - , Date: " . date('Y-m-d') . ", Time: " . date('H:s:i');
        log_init('sales', $content);
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
        log_init('sales', $content);
    }
}

// send respond
echo (json_encode($result_array));
