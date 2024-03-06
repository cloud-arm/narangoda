<?php
include('../../connect.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$time = date('H:i');

// get values
$load = $_POST['load_id'];
$cus = $_POST['customer'];
$invoice = $_POST['invoice'];
$amount = $_POST['amount'];
$vat_action = $_POST['vat_action'];
$vat_no = $_POST['vat_no'];
$date = $_POST['date'];
$app_id = $_POST['app_id'];

// get loading details
$result = $db->prepare("SELECT * FROM loading WHERE transaction_id=:id AND action='load' ");
$result->bindParam(':id', $load);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $lorry = $row['lorry_no'];
    $root = $row['root'];;
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

    // insert query
    $sql = "INSERT INTO sales (invoice_number,cashier,date,time,amount,cost,profit,name,root,rep,lorry_no,term,loading_id,customer_id,action,address,vat,value,cus_vat_no,vat_action,app_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $ql = $db->prepare($sql);
    $ql->execute(array($invoice, $driver, $date, $time, $amount, $cost, $profit, $cus_name, $root, $driver_name, $lorry, $term, $load, $cus, 1, $address, $vat, $value, $vat_no, $vat_action, $app_id));

    // get sales  id
    $result = $db->prepare("SELECT * FROM sales WHERE invoice_number=:id ");
    $result->bindParam(':id', $invoice);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $id = $row['transaction_id'];
        $ap_id = $row['app_id'];
    }

    // create success respond 
    $result_array[] = array(
        "cloud_id" => $id,
        "app_id" => $ap_id,
        "status" => "success",
        "message" => ""
    );

    // send respond
    echo (json_encode($result_array));
} catch (PDOException $e) {

    // create error respond 
    $result_array[] = array(
        "cloud_id" => 0,
        "app_id" => 0,
        "status" => "failed",
        "message" => $e->getMessage()
    );

    // send respond
    echo (json_encode($result_array));
}
