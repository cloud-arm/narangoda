<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$date = date("Y-m-d");
$time = date('H:i:s');


$pay_id = $_POST['pay_id'];


$result = $db->prepare("SELECT * FROM payment WHERE  transaction_id=:id  ");
$result->bindParam(':id', $pay_id);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
  $chq_amount = $row['amount'];
  $pay_action = $row['action'];
  $chq_no = $row['chq_no'];
  $chq_date = $row['chq_date'];
  $chq_bank = $row['chq_bank'];
  $chq_no = $row['chq_no'];
}

$result = $db->prepare("SELECT sum(pay_amount) FROM credit_payment WHERE  pay_id=:id AND action='2'  ");
$result->bindParam(':id', $pay_id);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
  $pay_tot = $row['sum(pay_amount)'];
}


if ($chq_amount == $pay_tot) {

  $result = $db->prepare("SELECT * FROM credit_payment WHERE  pay_id='$pay_id' AND action='2' ");
  $result->bindParam(':id', $invo);
  $result->execute();
  for ($i = 0; $row = $result->fetch(); $i++) {
    $pay_amount = $row['pay_amount'];
    $tr_id = $row['tr_id'];
    $credit_id = $row['id'];
    $type = $row['type'];
    $id = $row['collection_id'];


    if ($type == "qb") {
      // code...
    } else {


      $sql = "UPDATE payment SET pay_amount = pay_amount + ?, credit_balance = credit_balance - ?, credit_pay_id = ? WHERE transaction_id = ? ";
      $q = $db->prepare($sql);
      $q->execute(array($pay_amount, $pay_amount, $pay_id, $tr_id));


      $res = $db->prepare("SELECT * FROM payment  WHERE transaction_id=:id   ");
      $res->bindParam(':id', $tr_id);
      $res->execute();
      for ($i = 0; $row = $res->fetch(); $i++) {
        $balance = $row['pay_amount'];
        $amount = $row['amount'];
        $loading_id = $row['loading_id'];
        $sales_id = $row['sales_id'];
        $customer_id = $row['customer_id'];
        $credit = $row['credit_balance'];
        $invoice_no = $row['invoice_no'];
      }

      if ($amount <= $balance) {

        $sql = "UPDATE payment SET action=? WHERE transaction_id=?";
        $q = $db->prepare($sql);
        $q->execute(array(1, $tr_id));

        if ($credit == 0) {
          $set_off = date('Y-m-d');

          $sql = "UPDATE payment SET set_off_date = ? WHERE transaction_id=?";
          $q = $db->prepare($sql);
          $q->execute(array($set_off, $tr_id));
        }
      }

      // $sql = "UPDATE payment SET customer_id=? WHERE transaction_id=?";
      // $q = $db->prepare($sql);
      // $q->execute(array($cus_id, $pay_id));


      $sql = "INSERT INTO payment (collection_id,pay_amount,amount,type,pay_type,date,chq_no,chq_date,chq_bank,sales_id,customer_id,pay_credit,action,loading_id,credit_balance,time,paycose,invoice_no) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $q = $db->prepare($sql);
      $q->execute(array($id, $pay_amount, $pay_amount, 'credit_payment', 'credit_payment', $date, $chq_no, $chq_date, $chq_bank, $sales_id, $customer_id, 1, 1, $loading_id, $credit, $time, 'credit', $invoice_no));


      $set_off = date('Y-m-d');

      $sql = "UPDATE payment SET pay_amount = pay_amount + ?, set_off_date = ? WHERE transaction_id = ? ";
      $q = $db->prepare($sql);
      $q->execute(array($pay_amount, $set_off, $pay_id));
    }

    $sql = "UPDATE credit_payment SET action=? WHERE id=?";
    $q = $db->prepare($sql);
    $q->execute(array(0, $credit_id));
  }

  // $sql = "UPDATE payment SET action = ? WHERE transaction_id = ?";
  // $q = $db->prepare($sql);
  // $q->execute(array(2, $pay_id));

  $sql = "UPDATE collection SET type=?  WHERE pay_id=?";
  $q = $db->prepare($sql);
  $q->execute(array(2, $pay_id));


  header("location: bulk_payment_print.php?id=$pay_id");
} else {

  header("location: bulk_payment.php?id=$pay_id&unit=2&error");
}
