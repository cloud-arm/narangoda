<?php
include('../../connect.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get json data
$json_data = file_get_contents('php://input');

// get values
$sales_list = json_decode($json_data, true);

// respond init
$result_array = array();

foreach ($sales_list as $list) {

    $invoice = $list['invoice_no'];
    $pid = $list['product_id'];
    $name = $list['product_name'];
    $qty = $list['qty'];
    $price = $list['price'];
    $load = $list['loading_id'];
    $date = $list['date'];
    $cus = $list['cus_id'];
    $price_id = $list['price_id'];
    $app_id = $list['id'];

    //checking duplicate
    $con = 0;
    $result = $db->prepare("SELECT * FROM sales_list WHERE invoice_no = '$invoice' AND app_id = '$app_id' AND loading_id = '$load' ");
    $result->bindParam(':id', $cus);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $con = $row['id'];
    }

    if ($con == 0) {

        $cost_amount = 0;
        // inventory records -----

        $id = $pid;

        $temp_qty = $qty;

        do {
            if (isset($id)) {
            } else {
                $id = 0;
            }
            $qty_blc = 0;
            $temp_sell = 0;
            $temp_cost = 0;
            $st_id = 0;
            $re = $db->prepare("SELECT * FROM stock WHERE product_id=:id AND qty_balance>0  ORDER BY id ASC LIMIT 1 ");
            $re->bindParam(':id', $id);
            $re->execute();
            for ($k = 0; $r = $re->fetch(); $k++) {
                $st_qty = $r['qty_balance'];
                $st_id = $r['id'];
                $temp_sell = $r['sell'];
                $temp_cost = $r['cost'];

                if ($st_qty < $temp_qty) {

                    $temp_qty = $temp_qty - $st_qty;

                    $sql = "UPDATE stock SET qty=?, qty_balance=? WHERE id=?";
                    $ql = $db->prepare($sql);
                    $ql->execute(array($st_qty, 0, $st_id));

                    $sql = "INSERT INTO inventory (product_id,name,invoice_no,type,balance,qty,date,sell,cost,stock_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
                    $ql = $db->prepare($sql);
                    $ql->execute(array($id, $name, $invoice, 'out', 0, $st_qty, $date, $temp_sell, $temp_cost * $temp_qty, $st_id));
                } else {

                    $qty_blc = $st_qty - $temp_qty;

                    $sql = "UPDATE stock SET qty=?, qty_balance=? WHERE id=?";
                    $ql = $db->prepare($sql);
                    $ql->execute(array($temp_qty, $qty_blc, $st_id));

                    $sql = "INSERT INTO inventory (product_id,name,invoice_no,type,balance,qty,date,sell,cost,stock_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
                    $ql = $db->prepare($sql);
                    $ql->execute(array($id, $name, $invoice, 'out', $qty_blc, $temp_qty, $date, $temp_sell, $temp_cost * $temp_qty, $st_id));

                    $temp_qty = 0;
                }
            }
            if ($st_id == 0) {
                $temp_qty = 0;
            }
        } while ($temp_qty > 0);
    }
    // ------------

    // get cost amount
    $result = $db->prepare("SELECT sum(cost) FROM inventory WHERE invoice_no=:id ");
    $result->bindParam(':id', $invoice);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {
        $cost_amount = $row['sum(cost)'];
    }

    // amount
    $amount = $price * $qty;

    // vat value
    $vat = ($amount / 118) * 18;

    // without vat amount
    $value = ($amount / 118) * 100;

    // profit
    $profit = $value - $cost_amount;
    $profit = number_format($profit, 2, ".", "");

    //------------------------------------------------------------------------------//
    try {

        //checking duplicate
        $con = 0;
        $result = $db->prepare("SELECT * FROM sales_list WHERE invoice_no = '$invoice' AND app_id = '$app_id' AND loading_id = '$load' ");
        $result->bindParam(':id', $cus);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $con = $row['id'];
        }

        if ($con == 0) {

            // insert query
            $sql = "INSERT INTO sales_list (invoice_no,product_id,name,amount,cost_amount,qty,price,profit,date,loading_id,action,cus_id,price_id,vat,value,app_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $ql = $db->prepare($sql);
            $ql->execute(array($invoice, $pid, $name, $amount, $cost_amount, $qty, $price, $profit, $date, $load, 0, $cus, $price_id, $vat, $value, $app_id));
        }

        // get sales list id
        $result = $db->prepare("SELECT * FROM sales_list WHERE invoice_no=:id AND product_id = $pid ");
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