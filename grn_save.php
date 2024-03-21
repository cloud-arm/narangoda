<?php
session_start();
include('connect.php');

$ui = $_SESSION['SESS_MEMBER_ID'];
$un = $_SESSION['SESS_FIRST_NAME'];

$invo = $_POST['id'];
$type = $_POST['type'];
$sup = $_POST['supply'];
$sup_invo = $_POST['sup_invoice'];
$note = $_POST['note'];

$pay_amount = 0;
if ($type != 'Order') {
    $pay_amount = $_POST['amount'];
}

$pay_type = '';
$acc_no = '';
$bank = 0;
$bank_name = '';
$acc = 0;
$chq_no = '';
$chq_bank = '';
$chq_date = '';
$lorry_no = '';
if ($type == 'GRN') {

    $lorry = $_POST['lorry'];
    $pay_type = $_POST['pay_type'];
    $transport = $_POST['transport'];

    if ($pay_type == 'Bank') {
        $acc_no = $_POST['acc_no'];
        $bank_name = $_POST['bank_name'];
    }

    if ($pay_type == 'Chq') {
        $bank = $_POST['acc'];
        $chq_no = $_POST['chq_no'];
        $chq_date = $_POST['chq_date'];

        $re = $db->prepare("SELECT * FROM bank_balance WHERE id = :id");
        $re->bindParam(':id', $bank);
        $re->execute();
        for ($k = 0; $r = $re->fetch(); $k++) {
            $chq_bank = $r['name'];
        }
    }
}

$dic = 0;

$result = $db->prepare("SELECT * FROM supplier WHERE supplier_id=:id ");
$result->bindParam(':id', $sup);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $sup_name = $row['supplier_name'];
}

$result = $db->prepare("SELECT * FROM lorry WHERE lorry_id=:id ");
$result->bindParam(':id', $lorry);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $lorry_no = $row['lorry_no'];
}

$result = $db->prepare("SELECT sum(amount),sum(discount) FROM purchases_item WHERE invoice=:id ");
$result->bindParam(':id', $invo);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $amount = $row['sum(amount)'];
    $dic = $row['sum(discount)'];
}

$date = date("Y-m-d");
$time = date('H:i:s');

if ($invo != '') {
    $sql = "INSERT INTO purchases (invoice_number,amount,remarks,date,supplier_id,supplier_name,supplier_invoice,pay_type,pay_amount,discount,type,user_id,transport,lorry_id,lorry_no,chq_no,chq_date,chq_amount) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $re = $db->prepare($sql);
    $re->execute(array($invo, $amount, $note, $date, $sup, $sup_name, $sup_invo, $pay_type, $pay_amount, $dic, $type, $ui, $transport, $lorry, $lorry_no, $chq_no, $chq_date, $pay_amount));

    //---Transport details ------
    $sql = "INSERT INTO transport_record (invoice_no,amount,date,supplier_id,supplier_name,type,user_id,lorry_id,lorry_no,time) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $re = $db->prepare($sql);
    $re->execute(array($invo, $transport, $date, $sup, $sup_name, 0, $ui, $lorry, $lorry_no, $time));

    $cr_id = 3;

    $cash_blc = 0;
    $blc = 0;
    $re = $db->prepare("SELECT * FROM cash WHERE id = $cr_id ");
    $re->bindParam(':id', $res);
    $re->execute();
    for ($k = 0; $r = $re->fetch(); $k++) {
        $blc = $r['amount'];
        $cr_name = $r['name'];
    }

    $cash_blc = $blc + $transport;

    $cr_type = 'grn_transport';

    $sql = "INSERT INTO transaction_record (transaction_type,type,record_no,amount,action,credit_acc_no,credit_acc_type,credit_acc_name,credit_acc_balance,debit_acc_type,debit_acc_name,debit_acc_id,debit_acc_balance,date,time,user_id,user_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $ql = $db->prepare($sql);
    $ql->execute(array('transport', 'Credit', $invo, $transport, 0, $cr_id, $cr_type, $cr_name, $cash_blc, 'transport', 'Transport', 0, 0, $date, $time, $ui, $un));

    $sql = "UPDATE  cash SET amount=? WHERE id=?";
    $ql = $db->prepare($sql);
    $ql->execute(array($cash_blc, $cr_id));

    //-------------------


    if ($type == 'GRN') {

        $sql = "UPDATE  purchases_item SET action=? WHERE invoice=?";
        $ql = $db->prepare($sql);
        $ql->execute(array('active', $invo));


        if ($amount > $pay_amount) {

            $credit = $amount - $pay_amount;

            $sql = 'INSERT INTO supply_payment (amount,pay_amount,pay_type,date,invoice_no,supply_id,supply_name,supplier_invoice,type,credit_balance) VALUES (?,?,?,?,?,?,?,?,?,?)';
            $q = $db->prepare($sql);
            $q->execute(array($amount, '0', 'Credit', $date, $invo, $sup, $sup_name, $sup_invo, $type, $credit));
        }

        if ($pay_amount > 0) {

            if ($pay_type == 'Chq') {
                $sql = 'INSERT INTO supply_payment (amount,pay_amount,pay_type,date,invoice_no,supply_id,supply_name,supplier_invoice,type,chq_no,chq_bank,chq_date,bank_id,bank_name,acc_no,action) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                $q = $db->prepare($sql);
                $q->execute(array($pay_amount, $pay_amount, $pay_type, $date, $invo, $sup, $sup_name, $sup_invo, $type, $chq_no, $chq_bank, $chq_date, $bank, $bank_name, $acc_no, 1));
            } else {
                $sql = 'INSERT INTO supply_payment (amount,pay_amount,pay_type,date,invoice_no,supply_id,supply_name,supplier_invoice,type,bank_id,bank_name,acc_no) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
                $q = $db->prepare($sql);
                $q->execute(array($pay_amount, $pay_amount, $pay_type, $date, $invo, $sup, $sup_name, $sup_invo, $type, $bank, $bank_name, $acc_no));
            }
        }

        $result = $db->prepare("SELECT * FROM purchases_item WHERE invoice = '$invo' ");
        $result->bindParam(':id', $res);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $p_id = $row['product_id'];
            $name = $row['name'];
            $qty = $row['qty'];
            $date = $row['date'];
            $sell = $row['sell'];
            $cost = $row['cost'];

            $qty_blc = 0;
            $re = $db->prepare("SELECT * FROM products WHERE product_id = '$p_id' ");
            $re->bindParam(':id', $res);
            $re->execute();
            for ($k = 0; $r = $re->fetch(); $k++) {
                $st_qty = $r['qty'];
                $code = $r['product_code'];
            }

            $qty_blc = $st_qty + $qty;

            $sql = "UPDATE  products SET qty = ?, cost = ? WHERE product_id=?";
            $ql = $db->prepare($sql);
            $ql->execute(array($qty_blc, $cost, $p_id));

            $sql = "INSERT INTO inventory (product_id,name,invoice_no,type,balance,qty,date,cost,sell) VALUES (?,?,?,?,?,?,?,?,?)";
            $ql = $db->prepare($sql);
            $ql->execute(array($p_id, $name, $invo, 'in', $qty_blc, $qty, $date, $cost, $sell));

            $qty_blc = 0;
            $con = 0;
            $re = $db->prepare("SELECT * FROM stock ");
            $re->bindParam(':id', $res);
            $re->execute();
            for ($k = 0; $r = $re->fetch(); $k++) {
                $st_qty = $r['qty_balance'];
                $st_sell = $r['sell'];
                $st_cost = $r['cost'];
                $st_p = $r['product_id'];
                $st_sup = $r['supply_id'];
                $st_id = $r['id'];

                if ($st_qty == '') {
                    $st_qty = 0;
                }

                $qty_blc = $st_qty + $qty;

                if ($sell == $st_sell & $cost == $st_cost & $sup == $st_sup & $p_id == $st_p) {

                    $sql = "UPDATE stock SET qty=?, qty_balance=? WHERE id=?";
                    $ql = $db->prepare($sql);
                    $ql->execute(array($qty, $qty_blc, $st_id));
                    $con = 1;
                }
            }

            if ($con == 0) {

                $sql = "INSERT INTO stock (product_id,code,name,invoice_no,qty_balance,qty,date,supply_id,supply_name,sell,cost) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                $ql = $db->prepare($sql);
                $ql->execute(array($p_id, $code, $name, $invo, $qty, $qty, $date, $sup, $sup_name, $sell, $cost));
            }
        }


        if ($pay_type == 'Cash') {

            $cr_id = 1;

            $cash_blc = 0;
            $blc = 0;
            $re = $db->prepare("SELECT * FROM cash WHERE id = $cr_id ");
            $re->bindParam(':id', $res);
            $re->execute();
            for ($k = 0; $r = $re->fetch(); $k++) {
                $blc = $r['amount'];
                $cr_name = $r['name'];
            }

            $cash_blc = $blc - $pay_amount;

            $cr_type = 'grn_payment';

            $sql = "INSERT INTO transaction_record (transaction_type,type,record_no,amount,action,credit_acc_no,credit_acc_type,credit_acc_name,credit_acc_balance,debit_acc_type,debit_acc_name,debit_acc_id,debit_acc_balance,date,time,user_id,user_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $ql = $db->prepare($sql);
            $ql->execute(array('grn', 'Debit', $invo, $pay_amount, 0, 0, $cr_type, 'GRN Payment', 0, $cr_type, $cr_name, $cr_id, $cash_blc, $date, $time, $ui, $un));

            $sql = "UPDATE  cash SET amount=? WHERE id=?";
            $ql = $db->prepare($sql);
            $ql->execute(array($cash_blc, $cr_id));
        }
    } else

    if ($type == 'Return') {

        $sql = "UPDATE  purchases_item SET action=? WHERE invoice=?";
        $ql = $db->prepare($sql);
        $ql->execute(array('close', $invo));

        $sql = 'INSERT INTO supply_payment (amount,pay_amount,pay_type,date,invoice_no,supply_id,supply_name,supplier_invoice,type,credit_balance) VALUES (?,?,?,?,?,?,?,?,?,?)';
        $q = $db->prepare($sql);
        $q->execute(array($amount, 0, 'Credit_note', $date, $invo, $sup, $sup_name, $sup_invo, $type, $amount));

        $result = $db->prepare("SELECT * FROM purchases_item WHERE invoice = '$invo' ");
        $result->bindParam(':id', $res);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $p_id = $row['product_id'];
            $name = $row['name'];
            $qty = $row['qty'];
            $date = $row['date'];
            $st_id = $row['stock_id'];

            $qty_blc = 0;
            $re = $db->prepare("SELECT * FROM products WHERE product_id = '$p_id' ");
            $re->bindParam(':id', $res);
            $re->execute();
            for ($k = 0; $row0 = $re->fetch(); $k++) {
                $st_qty = $row0['qty'];
            }

            $qty_blc = $st_qty - $qty;

            $sql = "UPDATE  products SET qty=? WHERE product_id=?";
            $ql = $db->prepare($sql);
            $ql->execute(array($qty_blc, $p_id));

            $sql = "INSERT INTO inventory (product_id,name,invoice_no,type,balance,qty,date) VALUES (?,?,?,?,?,?,?)";
            $ql = $db->prepare($sql);
            $ql->execute(array($p_id, $name, $invo, 'out', $qty_blc, $qty, $date));

            $qty_blc = 0;
            $res = $db->prepare("SELECT * FROM stock WHERE id = :id ");
            $res->bindParam(':id', $st_id);
            $res->execute();
            for ($k = 0; $row0 = $res->fetch(); $k++) {
                $st_qty = $row0['qty_balance'];
            }

            $qty_blc = $st_qty - $qty;

            $sql = "UPDATE stock SET qty=?, qty_balance=? WHERE id=?";
            $ql = $db->prepare($sql);
            $ql->execute(array($qty, $qty_blc, $st_id));
        }
    } else

    if ($type == 'Order') {

        $sql = "UPDATE  purchases_item SET action=? WHERE invoice=?";
        $ql = $db->prepare($sql);
        $ql->execute(array('pending', $invo));
    }
}

$invo = date("ymdhis");
$y = date("Y");
$m = date("m");
if ($type == 'GRN') {

    header("location: grn_rp.php?year=$y&month=$m");
}

if ($type == 'Return') {
    header("location: grn_return.php?id=$invo");
}

if ($type == 'Order') {
    header("location: grn_order.php?id=$invo");
}
