<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");


$product = $_POST['product'];
$lorry = $_POST['lorry'];
$qty = $_POST['qty'];
$yard = $_POST['yard'];

$date = date("Y-m-d");
$time = date("h:i:s a");

$root = "Laugfs Gas PLC";
$action = "load";
$rep = "Purchases";


$term = 0;
$result = $db->prepare("SELECT * FROM loading WHERE lorry_no= :id AND action='unload' AND date='$date' ");
$result->bindParam(':id', $lorry);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $term = $row['term'];
}

//----- edit terms --------------
if ($term >= 1) {
    $term = $term + 1;
} else {
    $term = 1;
}
//----------------------------


$empty = 0;
$result = $db->prepare("SELECT * FROM products WHERE product_id= :id");
$result->bindParam(':id', $product);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $price = $row['price'];
    $profit = $row['profit'];
    $gen_name = $row['gen_name'];
    $pro_name = $row['product_name'];
}


// -------- UPDATE lorry Action --------
$act = 'Purchases';

$sql = "UPDATE lorry  SET action=? WHERE lorry_no=?";
$q = $db->prepare($sql);
$q->execute(array($act, $lorry));
// ---------------------------------------


//--------------------------     edit qty      --------------------------
if ($yard == 1) {
    $yard = 'Kaluthara Yard';

    $sql = "UPDATE products SET qty=qty-? WHERE product_id=?";
    $q = $db->prepare($sql);
    $q->execute(array($qty, $product));
}

if ($yard == 2) {
    $yard = 'Payagala Yard';

    $sql = "UPDATE products  SET qty2=qty2-? WHERE product_id=?";
    $q = $db->prepare($sql);
    $q->execute(array($qty, $product));
}


if ($yard == 3) {
    $yard = 'Payagala Yard';

    $sql = "UPDATE products SET qty3=qty3-? WHERE product_id=?";
    $q = $db->prepare($sql);
    $q->execute(array($qty, $product));
}
//##########################################################################################


$g = $asasa;
// query
$sql = "INSERT INTO loading (root,product_code,qty,price,lorry_no,rep,term,profit,product_name,date,action,qty_sold,load_yard,loading_time) VALUES (:a,:b,:f,:g,:c,:e,:d,:h,:i,:j,:k,:f,:m,:j1)";
$q = $db->prepare($sql);
$q->execute(array($root, ':b' => $product, ':c' => $lorry, ':d' => $d, ':e' => $rep, ':f' => $qty, ':g' => $g, ':h' => $h, ':i' => $ii, ':j' => $j, ':k' => $k, ':m' => $yard1, ':j1' => $j1));

header("location: emty_loading2.php?lorry=$lorry&yard=$yard");
