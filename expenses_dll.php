<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$ui = $_SESSION['SESS_MEMBER_ID'];
$un = $_SESSION['SESS_FIRST_NAME'];

$date = date("Y-m-d");
$time = date('H:i:s');

$id = $_GET['id'];

$result = $db->prepare("SELECT * FROM expenses_records WHERE id=:id ");
$result->bindParam(':id', $id);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $acc_id = $row['acc_id'];
    $amount = $row['amount'];
    $type = $row['type'];
    $util_id = $row['util_id'];
    $util_blc = $row['util_balance'];
    $pay_type = $row['pay_type'];
    $chq_no = $row['chq_no'];
    $invo = $row['invoice_no'];
}

$cr_blc = 0;
$blc = 0;
$re = $db->prepare("SELECT * FROM cash WHERE id=:id ");
$re->bindParam(':id', $acc_id);
$re->execute();
for ($k = 0; $r = $re->fetch(); $k++) {
    $blc = $r['amount'];
    $acc_name = $r['name'];
}

$cr_blc = $blc + $amount;

if ($pay_type == 'cash') {

    $sql = "UPDATE  cash SET amount=? WHERE id=?";
    $ql = $db->prepare($sql);
    $ql->execute(array($cr_blc, $acc_id));
} else {
    
    $sql = "DELETE FROM payment  WHERE invoice_no =?";
    $ql = $db->prepare($sql);
    $ql->execute(array($invo));
}

$sql = "INSERT INTO transaction_record (transaction_type,type,record_no,amount,action,credit_acc_no,credit_acc_type,credit_acc_name,credit_acc_balance,debit_acc_type,debit_acc_name,debit_acc_id,debit_acc_balance,date,time,user_id,user_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$ql = $db->prepare($sql);
$ql->execute(array('expenses_payment_delete', 'Credit', $id, $amount, 0, $acc_id, 'Payment Delete', $acc_name, $cr_blc, 'Expenses Delete', $type, $id, 0, $date, $time, $ui, $un));

$sql = "UPDATE  expenses_records SET dll=?, amount=? WHERE id=?";
$ql = $db->prepare($sql);
$ql->execute(array(1, 0, $id));


$sql = "UPDATE  utility_bill SET credit=credit-? WHERE id=?";
$ql = $db->prepare($sql);
$ql->execute(array($util_blc, $util_id));
