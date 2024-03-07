<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CLOUD arm | Unload</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->


	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body onload="window.print() " style=" font-size: 13px; font-family: arial;">
	<?php
	$sec = "1";
	?>
	<meta http-equiv="refresh" content="<?php echo $sec; ?>;URL='index.php?'">
	<div class="wrapper">
		<!-- Main content -->
		<section class="invoice">
			<!-- title row -->
			<div class="row">
				<div class="col-xs-12">
					<h2 class="page-header">
						<i class="fa fa-globe"></i> NARANGODA GROUP.

						<small class="pull-right">Date: <?php date_default_timezone_set("Asia/Colombo");
														echo date("Y-m-d  h:ia")  ?></small>
					</h2>
					<h4>
						Unloading Report
						<h4>
				</div>
				<!-- /.col -->
			</div>
			<!-- info row -->

			<!-- /.row -->
			<div class="box-body">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>

							<th>Product </th>
							<th>Load Qty</th>
							<th>Unload Qty</th>

						</tr>

					</thead>
					<tbody>
						<?php
						include("connect.php");

						$id = $_GET['id'];
						$result = $db->prepare("SELECT * FROM loading WHERE  transaction_id=$id ");
						$result->bindParam(':userid', $c);
						$result->execute();
						for ($i = 0; $row = $result->fetch(); $i++) {

							$driver = $row['driver'];
							$lorry_no = $row['lorry_no'];
							$he1 = $row['helper1'];
							$he2 = $row['helper2'];
							$date25 = $row['date'];
						}

						$result = $db->prepare("SELECT * FROM loading_list WHERE  loading_id='$id'  ORDER by transaction_id DESC");
						$result->bindParam(':userid', $date);
						$result->execute();
						for ($i = 0; $row = $result->fetch(); $i++) {



							$date = 0;
							$time = 0;
							$term = 0;
							$load_yard = 0;
							$unload_yard = 0;


						?>

							<tr>
								<td><?php echo $row['product_name']; ?></td>

								<td><?php echo $row['qty']; ?></td>
								<td><?php echo $qty = $row['unload_qty']; ?></td>


							<?php
						}
							?></td>
							</tr>
					</tbody>
					<tfoot>
					</tfoot>
				</table>
				<td> Date:
					<?php echo $date25; ?>
				</td>
				<br>

				<td> Loading ID:
					<?php echo $id; ?>
				</td>
				<br>



				<td> Lorry NO:
					<?php echo $lorry_no; ?>
				</td>
				<br>

				<td> Driver:
					<?php
					$result = $db->prepare("SELECT * FROM employee WHERE  id='$driver'  ");
					$result->bindParam(':userid', $date);
					$result->execute();
					for ($i = 0; $row = $result->fetch(); $i++) {
						echo $row['name'];
					}
					//echo $driver; 
					?>
				</td>
				<br>

				<td> Helper 1:
					<?php $result = $db->prepare("SELECT * FROM employee WHERE  id='$he1'  ");
					$result->bindParam(':userid', $date);
					$result->execute();
					for ($i = 0; $row = $result->fetch(); $i++) {
						echo $row['name'];
					} ?>
				</td>
				<br>


				<td> Helper 2:
					<?php $result = $db->prepare("SELECT * FROM employee WHERE  id='$he2'  ");
					$result->bindParam(':userid', $date);
					$result->execute();
					for ($i = 0; $row = $result->fetch(); $i++) {
						echo $row['name'];
					} ?>
				</td>
				<br>


			</div>
			<!-- Table row -->

			<!-- /.row -->














			<!------------------------------------------------------------- /.Sales view------------------------------------------------------------------------------ -->

			<div class="box-header with-border">
				<h3 class="box-title">Lorry Sales Report
					<span class="pull-right badge bg-muted">Empty</span>
					<span class="pull-right badge bg-yellow">Refill</span>
				</h3>


				<table id="" class="table table-bordered table-striped">

					<thead>

						<tr>
							<th colspan="2"></th>
							<th colspan="2">12.5kg</th>
							<th colspan="2">5kg</th>
							<th colspan="2">37.5kg</th>
							<th colspan="2">2kg</th>

							<?php
							$ass_list = array();
							$result = $db->prepare("SELECT *  FROM sales_list WHERE sales_list.loading_id=:id AND sales_list.product_id > 9 AND sales_list.action = 0 GROUP BY sales_list.product_id ");
							$result->bindParam(':id', $id);
							$result->execute();
							for ($i = 0; $row = $result->fetch(); $i++) {
								array_push($ass_list, $row['product_id']);
							?>
								<th class="th"><span> <?php echo $row['name']; ?></span></th>
							<?php } ?>

						</tr>

						<tr>
							<th>Invoice</th>
							<th>Customer</th>
							<th>N</th>
							<th>R</th>
							<th>N</th>
							<th>R</th>
							<th>N</th>
							<th>R</th>
							<th>N</th>
							<th>R</th>

							<?php
							foreach ($ass_list as $list) { ?>
								<th></th>
							<?php } ?>

						<tr>

					</thead>

					<tbody>

						<?php $id = $_GET['id'];
						$sales_list = array();
						$sales = array();
						$product = array();

						$result = $db->prepare("SELECT *  FROM sales_list WHERE sales_list.loading_id=:id AND sales_list.action='0'  ORDER BY sales_list.product_id ");
						$result->bindParam(':id', $id);
						$result->execute();
						for ($i = 0; $row = $result->fetch(); $i++) {

							$data = array('invo' => $row['invoice_no'], 'pid' => $row['product_id'], 'qty' => $row['qty']);

							array_push($sales_list, $data);
						}

						$result = $db->prepare("SELECT * FROM products  ORDER BY product_id  ");
						$result->bindParam(':id', $id);
						$result->execute();
						for ($i = 0; $row = $result->fetch(); $i++) {
							array_push($product, $row['product_id']);
						}

						$result = $db->prepare("SELECT * FROM sales WHERE loading_id=:id AND action='1' ");
						$result->bindParam(':id', $id);
						$result->execute();
						for ($i = 0; $row = $result->fetch(); $i++) { //row
							$invo = $row['invoice_number'];
							$cus = $row['name'];
							$sales_id = $row['transaction_id'];

							$temp = array();

							$temp['invo'] =  $sales_id;
							$temp['cus'] =  $cus;

							foreach ($product as $p_id) { //colum
								$temp[$p_id] = '';
							}

							foreach ($sales_list as $list) {

								if ($list['invo'] == $invo) {

									foreach ($product as $p_id) { //colum

										if ($p_id == $list['pid']) {
											if ($p_id > 4) {
												$temp[$p_id] = "<span class='pull-right badge bg-muted'> " . $list['qty'] . "</span>";
											} else {
												$temp[$p_id] = "<span class='pull-right badge bg-yellow'> " . $list['qty'] . "</span>";
											}
										} else {
										}
									}
								}
							}

							array_push($sales, $temp);
						}
						?>

						<?php foreach ($sales as $list) { ?>

							<tr>

								<td> <?php echo $list['invo']; ?> </td>
								<td> <?php echo $list['cus']; ?> </td>

								<td> <?php echo $list['5']; ?></td>
								<td> <?php echo $list['1']; ?> </td>

								<td> <?php echo $list['6']; ?></td>
								<td><?php echo $list['2']; ?></td>

								<td> <?php echo $list['7']; ?></td>
								<td><?php echo $list['3']; ?></td>

								<td> <?php echo $list['8']; ?> </td>
								<td> <?php echo $list['4']; ?> </td>

								<?php foreach ($ass_list as $ass) { ?>
									<td> <?php echo $list[$ass]; ?>
									</td>
								<?php } ?>

							</tr>
						<?php } ?>
					</tbody>

					<?php $id = $_GET['id'];
					$total = array();

					foreach ($product as $p_id) {
						$total[$p_id] = '';
					}

					$result = $db->prepare("SELECT * , sum(sales_list.qty)  FROM sales_list WHERE sales_list.loading_id=:id AND sales_list.action = 0 GROUP BY sales_list.product_id ");
					$result->bindParam(':id', $id);
					$result->execute();
					for ($i = 0; $row = $result->fetch(); $i++) {
						$total[$row['product_id']] = $row['sum(sales_list.qty)'];
					}
					?>

					<tfoot class=" bg-black">
						<tr>
							<td colspan="2">Total</td>

							<td> <span class="pull-right badge bg-muted"> <?php echo $total['5']; ?> </span>
							</td>
							<td> <span class="pull-right badge bg-yellow"> <?php echo $total['1']; ?> </span>
							</td>
							<td> <span class="pull-right badge bg-muted"> <?php echo $total['6']; ?> </span>
							</td>
							<td> <span class="pull-right badge bg-yellow"> <?php echo $total['2']; ?> </span>
							</td>
							<td> <span class="pull-right badge bg-muted"> <?php echo $total['7']; ?> </span>
							</td>
							<td> <span class="pull-right badge bg-yellow"> <?php echo $total['3']; ?> </span>
							</td>
							<td> <span class="pull-right badge bg-muted"> <?php echo $total['8']; ?> </span>
							</td>
							<td> <span class="pull-right badge bg-yellow"> <?php echo $total['4']; ?> </span>
							</td>

							<?php

							foreach ($total as $i => $tot) {
								if ($i > 9  && $tot > 0) { ?>
									<td>
										<span class="pull-right badge bg-muted">
											<?php
											echo $tot;
											?>
										</span>
									</td>

							<?php }
							} ?>

						</tr>

					</tfoot>

				</table>



				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>

							<th>Invoice no </th>
							<th>Customer</th>
							<th>Pay type</th>

							<th>Amount </th>
							<th>Chq no</th>

							<th>Chq Date</th>
							<th>Bank</th>
						</tr>




					</thead>
					<tbody>
						<?php


						$id = $_GET['id'];


						$result = $db->prepare("SELECT * FROM payment WHERE  loading_id='$id' and action>'0'  ORDER by transaction_id DESC");
						$result->bindParam(':userid', $date);
						$result->execute();
						for ($i = 0; $row = $result->fetch(); $i++) {
							$invo = $row['invoice_no'];

							$result1 = $db->prepare("SELECT * FROM sales WHERE  invoice_number=$invo and action='1' ");
							$result1->bindParam(':userid', $c);
							$result1->execute();
							for ($i = 0; $row1 = $result1->fetch(); $i++) {

								$in = $row1['transaction_id'];
								$cus = $row1['name'];
							}


						?>

							<tr>
								<td><?php echo $in; ?></td>

								<td><?php echo $cus; ?></td>
								<td><?php echo $row['type']; ?></td>
								<td><?php echo $row['amount']; ?></td>
								<td><?php echo $row['chq_no']; ?></td>
								<td><?php echo $row['chq_date']; ?></td>
								<td><?php echo $row['bank']; ?></td>
							</tr>
						<?php
						}
						//------------ Credit payment--------//

						$result1 = $db->prepare("SELECT * FROM collection WHERE  loading_id=$id and action='0' ");
						$result1->bindParam(':userid', $c);
						$result1->execute();
						for ($i = 0; $row = $result1->fetch(); $i++) {
						?>
							<tr style="background-color:#7FB3D5">
								<td><?php echo $row['invoice_no']; ?>(credit)</td>
								<td><?php echo $row['customer']; ?></td>
								<td><?php echo $row['pay_type']; ?></td>
								<td><?php echo $row['amount']; ?></td>
								<td><?php echo $row['chq_no']; ?></td>
								<td><?php echo $row['chq_date']; ?></td>
								<td><?php echo $row['bank']; ?></td>
							</tr>
						<?php   }    ?>

					</tbody>
					<tfoot>
					</tfoot>
				</table>
				<?php

				$result = $db->prepare("SELECT sum(amount) FROM payment WHERE  loading_id='$id' AND type='cash' and action >'0'  ORDER by transaction_id DESC");
				$result->bindParam(':userid', $c);
				$result->execute();
				for ($i = 0; $row = $result->fetch(); $i++) {

					$cash = $row['sum(amount)'];
				}

				$result = $db->prepare("SELECT sum(amount) FROM payment WHERE  loading_id='$id' AND type='chq' and action >'0'  ORDER by transaction_id DESC");
				$result->bindParam(':userid', $c);
				$result->execute();
				for ($i = 0; $row = $result->fetch(); $i++) {

					$chq = $row['sum(amount)'];
				}


				$result = $db->prepare("SELECT sum(amount) FROM payment WHERE  loading_id='$id' AND type='credit' and action >'0'  ORDER by transaction_id DESC");
				$result->bindParam(':userid', $c);
				$result->execute();
				for ($i = 0; $row = $result->fetch(); $i++) {

					$credit = $row['sum(amount)'];
				}

				$result = $db->prepare("SELECT sum(amount) FROM collection WHERE  loading_id='$id' AND pay_type='cash' and action ='0'  ");
				$result->bindParam(':userid', $c);
				$result->execute();
				for ($i = 0; $row = $result->fetch(); $i++) {
					$c_cash = $row['sum(amount)'];
				}

				$result = $db->prepare("SELECT sum(amount) FROM collection WHERE  loading_id='$id' AND pay_type='chq' and action ='0'  ");
				$result->bindParam(':userid', $c);
				$result->execute();
				for ($i = 0; $row = $result->fetch(); $i++) {
					$c_chq = $row['sum(amount)'];
				}
				?>

				<h3>
					Cash- Rs.<?php echo $cash + $c_cash; ?><br>
					CHQ- Rs.<?php echo $chq + $c_chq; ?><br>
					Credit- Rs.<?php echo $credit; ?><br>
				</h3>

				<div class="row">
					<div class="col-md-5">
						<h3>Remove bill</h3>
						<table id="example1" class="table table-bordered table-striped" style="width:350px">
							<thead>
								<tr>
									<th>Invoice no</th>
									<th>Type</th>
									<th>Amount (Rs.)</th>

								</tr>
							</thead>
							<tbody>

								<?php $result = $db->prepare("SELECT * FROM payment WHERE loading_id='$id' and action='0'  ");
								$result->bindParam(':userid', $date);
								$result->execute();
								for ($i = 0; $row = $result->fetch(); $i++) {
								?>
									<tr>
										<td><?php echo $row['sales_id'];   ?> </td>
										<td><?php echo $row['type'];   ?> </td>
										<td>Rs.<?php echo $row['amount'];   ?></td>

									</tr>
								<?php }   ?>

							</tbody>
						</table>
					</div>

					<div class="col-md-5">
						<h3>Expenses</h3>
						<table id="example1" class="table table-bordered table-striped" style="width:450px">
							<thead>
								<tr>
									<th>ID</th>
									<th>Type</th>
									<th>Amount (Rs.)</th>
									<th>Comment</th>






								</tr>
							</thead>
							<tbody>

								<?php $result = $db->prepare("SELECT * FROM expenses_records WHERE loading_id='$id' and dll='0'  ");

								$result->bindParam(':userid', $date);
								$result->execute();
								for ($i = 0; $row = $result->fetch(); $i++) {
								?>




									<tr class="record">




									<td><?php echo $row['id'];   ?> </td>

									<td><?php echo $row['sub_type_name'];   ?> </td>
									<td>Rs.<?php echo $row['amount'];   ?></td>
									<td><?php echo $row['comment'];   ?></td>






									</tr>


								<?php }   ?>
							</tbody>

						</table>
					</div>
				</div>



				<table id="example1" class="table table-bordered table-striped" style="width:350px">
					<thead>
						<tr>
							<th><i class="fa fa-money"></i></th>
							<th>QTY</th>
							<th>Amount</th>
							<?php

							$result = $db->prepare("SELECT * FROM loading WHERE transaction_id='$id'   ");
							$result->bindParam(':userid', $res);
							$result->execute();
							for ($i = 0; $row = $result->fetch(); $i++) {
								$tid = $row['transaction_id'];
								$tto = 0;
							?>

						</tr>
					</thead>
					<tbody>
						<tr>
							<td>5000</td>
							<td><?php echo $row['r5000']; ?></td>
							<td><?php $tto += $row['r5000'] * 5000;
								echo $row['r5000'] * 5000; ?></td>
						</tr>
						<tr>
							<td>2000</td>
							<td><?php echo $row['r2000']; ?></td>
							<td><?php $tto += $row['r2000'] * 2000;
								echo $row['r2000'] * 2000; ?></td>
						</tr>
						<tr>
							<td>1000</td>
							<td><?php echo $row['r1000']; ?></td>
							<td><?php $tto += $row['r1000'] * 1000;
								echo $row['r1000'] * 1000; ?></td>
						</tr>
						<tr>
							<td>500</td>
							<td><?php echo $row['r500']; ?></td>
							<td><?php $tto += $row['r500'] * 500;
								echo $row['r500'] * 500; ?></td>
						</tr>
						<tr>
							<td>100</td>
							<td><?php echo $row['r100']; ?></td>
							<td><?php $tto += $row['r100'] * 100;
								echo $row['r100'] * 100; ?></td>
						</tr>
						<tr>
							<td>50</td>
							<td><?php echo $row['r50']; ?></td>
							<td><?php $tto += $row['r50'] * 50;
								echo $row['r50'] * 50; ?></td>
						</tr>
						<tr>
							<td>20</td>
							<td><?php echo $row['r20']; ?></td>
							<td><?php $tto += $row['r20'] * 20;
								echo $row['r20'] * 20; ?></td>
						</tr>
						<tr>
							<td>10</td>
							<td><?php echo $row['r10']; ?></td>
							<td><?php $tto += $row['r10'] * 10;
								echo $row['r10'] * 10; ?></td>
						</tr>
						<tr>
							<td><i class="fa fa-database"></i> Coine (කාසි)</td>
							<td><?php echo $row['coins']; ?></td>
							<td><?php $tto += $row['coins'];
								echo $row['coins']; ?></td>
						</tr>


						<tr>
							<td>Total</td>
							<td><?php echo  $tto; ?></td>
						</tr>
						<tr>
							<td>Balance</td>
							<td><?php echo  $row['cash_total']; ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>


			</div>

	</div>

	<!-- /.col -->

	<!-- /.row -->
	</section>
	<!-- /.content -->
	</div>
	<!-- ./wrapper -->
</body>

</html>