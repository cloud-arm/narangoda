<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$ui = $_SESSION['SESS_MEMBER_ID'];
$un = $_SESSION['SESS_FIRST_NAME'];

$date = $_POST['date'];
$time = date('H:i:s');

$unit = $_POST['unit'];

if ($unit == 1) {

    $invo = "exp" . date("ymdhis");
    $type = $_POST['type'];
    $comment = $_POST['comment'];
    $amount = $_POST['pay_amount'];
    $pay_type = $_POST['pay_type'];
    $job_no = 0;
    $util_id = 0;
    $util_date = '';
    $util_invo = '';
    $util_amount = 0;
    $util_name = '';

    $acc = 0;
    $bank = 0;

    if ($pay_type == 'cash') {
        $acc = $_POST['acc'];
    }

    if ($pay_type == 'chq') {
        $bank = $_POST['bank'];
    }


    $re = $db->prepare("SELECT * FROM expenses_types WHERE sn=:id ");
    $re->bindParam(':id', $type);
    $re->execute();
    for ($i = 0; $r = $re->fetch(); $i++) {
        $type_name = $r['type_name'];
    }

    if ($type_name == 'Utility_Bill') {
        $util_id = $_POST['util_id'];
        $util_date = $_POST['util_date'];
        $util_invo = $_POST['util_invo'];
        $util_amount = $_POST['Util_amount'];

        $re = $db->prepare("SELECT * FROM utility_bill WHERE id=:id ");
        $re->bindParam(':id', $util_id);
        $re->execute();
        for ($i = 0; $r = $re->fetch(); $i++) {
            $util_name = $r['name'];
        }
    }

    if ($pay_type == 'chq') {
        $bn_blc = 0;
        $blc = 0;
        $re = $db->prepare("SELECT * FROM bank_balance WHERE id = :id");
        $re->bindParam(':id', $bank);
        $re->execute();
        for ($k = 0; $r = $re->fetch(); $k++) {
            $blc = $r['amount'];
            $acc_name = $r['name'];
        }

        $bn_blc = $blc - $amount;

        $acc = $bank;
    }

    if ($pay_type == 'cash') {
        $cr_blc = 0;
        $blc = 0;
        $re = $db->prepare("SELECT * FROM cash WHERE id = :id");
        $re->bindParam(':id', $acc);
        $re->execute();
        for ($k = 0; $r = $re->fetch(); $k++) {
            $blc = $r['amount'];
            $acc_name = $r['name'];
        }

        $cr_blc = $blc - $amount;
    }

    $util_blc = 0;
    $util_fw_blc = 0;
    if ($type_name == 'Utility_Bill') {
        $util_blc = $util_amount - $amount;

        $sql = "UPDATE  utility_bill SET credit=credit+? WHERE id=?";
        $ql = $db->prepare($sql);
        $ql->execute(array($util_blc, $util_id));

        $re = $db->prepare("SELECT * FROM utility_bill WHERE id = :id");
        $re->bindParam(':id', $util_id);
        $re->execute();
        for ($k = 0; $r = $re->fetch(); $k++) {
            $util_fw_blc = $r['credit'];
        }
    }


    if ($pay_type == 'cash') {
        $chq_no = '';
        $chq_date = '';

        $sql = "UPDATE  cash SET amount=? WHERE id=?";
        $ql = $db->prepare($sql);
        $ql->execute(array($cr_blc, $acc));

        $sql = "INSERT INTO transaction_record (transaction_type,type,record_no,amount,action,credit_acc_no,credit_acc_type,credit_acc_name,credit_acc_balance,debit_acc_type,debit_acc_name,debit_acc_id,debit_acc_balance,date,time,user_id,user_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $ql = $db->prepare($sql);
        $ql->execute(array('expenses', 'Debit', $type, $amount, 0, $acc, 'cash', $acc_name, $cr_blc, 'cash_payment', $type_name, $type, 0, $date, $time, $ui, $un));
    }

    if ($pay_type == 'chq') {

        $chq_no = $_POST['chq_no'];
        $chq_date = $_POST['chq_date'];

        $sql = 'INSERT INTO payment (amount,pay_amount,pay_type,date,invoice_no,customer_id,chq_no,chq_bank,bank_id,chq_date,bank_name,type,action) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $q = $db->prepare($sql);
        $q->execute(array($amount, $amount, $pay_type, $date, $invo, 0, $chq_no, $acc_name, $acc, $chq_date, '', 3, 1));
    }

    $sql = "INSERT INTO expenses_records (date,type_id,type,invoice_no,acc_id,acc_name,comment,amount,user,job_no,util_id,util_name,util_date,util_invoice,util_bill_amount,util_balance,util_forward_balance,pay_type,chq_no,chq_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($date, $type, $type_name, $invo, $acc, $acc_name, $comment, $amount, $ui, $job_no, $util_id, $util_name, $util_date, $util_invo, $util_amount, $util_blc, $util_fw_blc, $pay_type, $chq_no, $chq_date));
}

if ($unit == 2) {
    $util_name = $_POST['util_name'];

    $name = strtoupper($util_name);

    $id = 0;
    $re = $db->prepare("SELECT * FROM utility_bill WHERE name=:id ");
    $re->bindParam(':id', $name);
    $re->execute();
    for ($i = 0; $r = $re->fetch(); $i++) {
        $id = $r['id'];
    }

    if ($id == 0) {
        $sql = "INSERT INTO utility_bill (name) VALUES (?) ";
        $ql = $db->prepare($sql);
        $ql->execute(array($name));
    }
}


if ($unit == 3) {
    $type = $_POST['type'];
    $id = 0;

    $name = strtoupper($type);

    if ($id == 0) {
        $sql = "INSERT INTO expenses_types (type_name) VALUES (?) ";
        $ql = $db->prepare($sql);
        $ql->execute(array($name));
    }
}

if ($unit == 4) {

    $util_name = $_POST['util_name'];
    $last_meter = $_POST['last_meter'];
    $unit_price = $_POST['unit_price'];

    $date = date('Y-m-d');
    $name = strtoupper($util_name);

    $id = 0;
    $re = $db->prepare("SELECT * FROM utility_bill WHERE name=:id ");
    $re->bindParam(':id', $name);
    $re->execute();
    for ($i = 0; $r = $re->fetch(); $i++) {
        $id = $r['id'];
    }

    if ($id == 0) {
        $sql = "INSERT INTO utility_bill  (name, action, meter, unit_price, last_date) VALUES (?,?,?,?,?) ";
        $ql = $db->prepare($sql);
        $ql->execute(array($name, 1, $last_meter, $unit_price, $date));
    }
}

$Y = date("Y");
$m = date("m");
header("location: expenses.php?year=$Y&month=$m");
