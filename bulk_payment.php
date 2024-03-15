<!DOCTYPE html>
<html>
<?php
include("head.php");
include("connect.php");
date_default_timezone_set("Asia/Colombo");
?>

<body class="hold-transition skin-yellow sidebar-mini">
  <?php
  include_once("auth.php");
  $r = $_SESSION['SESS_LAST_NAME'];
  $user_lewal = $_SESSION['USER_LEWAL'];
  $_SESSION['SESS_FORM'] = 'credit_collection';

  if ($r == 'Cashier') {

    include_once("sidebar2.php");
  }
  if ($r == 'admin') {

    include_once("sidebar.php");
  }
  ?>


  <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payment
        <small>Preview</small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">CHQ</h3>
        </div>


        <?php if (isset($_GET['id'])) { ?>
          <!-- /.box -->
          <div class="box-body">

            <div class="row">

              <?php
              $pay_id = $_GET['id'];
              $result = $db->prepare("SELECT * FROM payment WHERE  transaction_id=:id ");
              $result->bindParam(':id', $pay_id);
              $result->execute();
              for ($i = 0; $row = $result->fetch(); $i++) {
                $chq_amount = $row['amount']; ?>

                <div class="col-md-7">

                  <div class="row" style="display: flex;flex-direction: column;justify-content: space-between;">

                    <div class="col-md-12">

                      <form method="post" action="bulk_payment_bill_add.php">

                        <div class="row">

                          <div class="col-md-10">
                            <div class="form-group">
                              <label>Invoice NO</label>
                              <select class="form-control select2" name="invo" style="width: 100%;" autofocus>
                                <?php
                                $res = $db->prepare("SELECT * FROM payment WHERE type='credit' AND action='2' AND credit_balance > 0 ");
                                $res->bindParam(':id', $ttr);
                                $res->execute();
                                for ($j = 0; $ro = $res->fetch(); $j++) {
                                  $customer_id = $ro['customer_id'];

                                  $res1 = $db->prepare("SELECT * FROM customer WHERE customer_id =:id ");
                                  $res1->bindParam(':id', $customer_id);
                                  $res1->execute();
                                  for ($k = 0; $ro1 = $res1->fetch(); $k++) {
                                    $name = $ro1['customer_name'];
                                  }
                                ?>
                                  <option value="<?php echo $ro['transaction_id']; ?>"><?php echo $ro['sales_id']; ?> __ <?php echo $name; ?> __Rs.<?php echo $ro['credit_balance']; ?> </option>
                                <?php
                                }
                                ?>
                                <option value="qb">Old Bill Payment (QB System) </option>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Pay Amount</label>
                              <input type="number" step=".01" name="amount" class="form-control " tabindex="4" autocomplete="off">
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group" style="margin-top: 23px;">
                              <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                              <button type="submit" class="btn btn-info btn-flat">Add to list</button>
                            </div>
                          </div>

                        </div>

                      </form>

                    </div>

                    <div class="col-md-8" style="margin-top: 20px;">
                      <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                        Please click process button to complete the process.
                      </div>
                    </div>

                    <div class="col-md-12" style="margin-top: 20px;">
                      <?php
                      $res = $db->prepare("SELECT sum(pay_amount) FROM credit_payment WHERE pay_id='$pay_id' AND action='2' AND dll = 0 ");
                      $res->bindParam(':userid', $ttr);
                      $res->execute();
                      for ($a = 0; $ro = $res->fetch(); $a++) {
                        $pay_tot = $ro['sum(pay_amount)'];
                      }
                      $balance = $chq_amount - $pay_tot;

                      if ($balance < 0) { ?>

                        <h1 style='color:red !important;'>
                        <?php } else { ?>

                          <h1 style='color:green  !important;'>
                          <?php } ?>

                          Balance: <small>Rs.</small> <?php echo number_format($balance, 2); ?></h1>


                    </div>

                  </div>

                </div>

                <?php $type = $row['type'];
                if ($type == "chq") { ?>

                  <div class="col-md-5">
                    <div class="callout callout-warning">
                      <h4 class="pull-left"><?php echo $row['chq_bank']; ?></h4>
                      <h4 class="pull-right"><?php echo $row['chq_date']; ?></h4>
                      <br><br>
                      <h4>Narangoda Enterprises (Pvt.) Ltd </h4>
                      <hr style="margin-bottom: 10px;">
                      <button type="button" class="btn btn-default btn-lg pull-right">Rs. <?php echo $row['amount']; ?></button>
                      <br><br>
                      <hr>
                      <center>
                        <h4>
                          <?php echo $row['chq_no']; ?> -xxxxx': xxxxxxxx;'
                        </h4>
                      </center>
                    </div>
                  </div>

                <?php }

                if ($type == "bank") { ?>

                  <div class="col-md-5">
                    <div class="callout callout-success">
                      <h2>Bank Transfer</h2>
                      <table class="table table-bordered table-striped">
                        <thead>

                          <tr>
                            <th>Reference No.</th>
                            <th><?php echo $row['chq_no']; ?></th>
                          </tr>

                          <tr>
                            <th>Bank</th>
                            <th><?php echo $row['chq_bank']; ?></th>
                          </tr>

                          <tr>
                            <th>Date</th>
                            <th><?php echo $row['chq_date']; ?></th>
                          </tr>

                          <tr>
                            <th>Amount</th>
                            <th><?php echo $row['amount']; ?></th>
                          </tr>

                        </thead>
                      </table>

                    </div>
                  </div>

                <?php }

                if ($type == "cash") { ?>

                  <div class="col-md-5">
                    <div class="callout callout-default">

                      <img src="icon/money.png" alt="" style="width:130px">

                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Type</th>
                            <th>Cash</th>
                          </tr>

                          <tr>
                            <th>Amount</th>
                            <th><?php echo $row['amount']; ?></th>
                          </tr>

                        </thead>
                      </table>

                    </div>
                  </div>

              <?php }
              } ?>


            </div>

            <form action="bulk_payment_process.php" method="POST" id="process-form">
              <input type="hidden" name="pay_id" value="<?php echo $_GET['id']; ?>">
            </form>

            <a class="btn btn-lg btn-danger pull-right" onclick="process()">
              <i class="fa fa-connectdevelop fa-info"></i> Process
            </a>

          </div>

          <div class="box-body">

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Invoice no</th>
                  <th>Customer</th>
                  <th>Credit Amount (Rs.)</th>
                  <th>Pay Amount (Rs.)</th>
                  <th>#</th>

                </tr>
              </thead>
              <tbody>

                <?php $id = $_GET['id'];
                $result = $db->prepare("SELECT * FROM credit_payment WHERE pay_id='$id' AND action='2' ");
                $result->bindParam(':userid', $date);
                $result->execute();
                for ($i = 0; $row = $result->fetch(); $i++) {  ?>
                  <tr class="record">
                    <td><?php echo $row['id'];   ?> </td>
                    <td><?php echo $row['sales_id'];   ?> </td>
                    <td><?php echo $row['cus'];   ?> </td>
                    <td>Rs.<?php echo $row['credit_amount'];   ?></td>
                    <td><?php echo $row['pay_amount'];   ?></td>
                    <td>

                      <a href="bulk_payment_list_dll.php?id=<?php echo $row['id'];   ?>&pay_id=<?php echo $_GET['id'];   ?>" title="Click to Delete">
                        <button class="btn btn-danger"><i class="icon-trash">x</i></button>
                      </a>

                    </td>
                  </tr>

                <?php }   ?>
              </tbody>

            </table>

          </div>

        <?php  } else {
        ?>

          <div class="box-body">

            <select name="p_type" style="width: 190px;  " class="form-control" id="p_type" onchange="view_payment_date(this.value);">
              <option>payment type</option>
              <option value="cash">Cash</option>
              <option value="chq">Cheque</option>
              <option value="bank">Bank Transfer</option>
              <option value="coupon">Coupon</option>
              <option value="2kg">2kg to 5kg promotion</option>
            </select>




            <div class="form-group" id='chq_pay' style="display:none;">
              <form method="post" action="bulk_payment_save.php">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>CHQ NO</label>
                      <input type="text" name="chq_no" class="form-control pull-right" value="">

                    </div>
                  </div>



                  <div class="col-md-6">
                    <div class="form-group">


                      <label> Amount</label>
                      <input type="text" value='' name="amount" class="form-control pull-right" tabindex="2">

                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Bank</label>
                      <input type="text" value='' name="bank" class="form-control pull-right" tabindex="3">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label> Date</label>
                      <input type="text" value='<?php echo date("Y-m-d"); ?> ' id="datepicker" name="date" class="form-control pull-right" tabindex="4">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                </div>
                <input type="hidden" name="type" value="chq">
                <input class="btn btn-info" type="submit" value="Submit">
              </form>
            </div>



            <div class="form-group" id='bank_pay' style="display:none;">
              <form method="post" action="bulk_payment_save.php">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Reference NO</label>
                      <input type="text" name="chq_no" class="form-control pull-right" value="">

                    </div>
                  </div>



                  <div class="col-md-6">
                    <div class="form-group">


                      <label> Amount</label>
                      <input type="text" value='' name="amount" class="form-control pull-right" tabindex="2">

                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Bank</label>
                      <input type="text" value='' name="bank" class="form-control pull-right" tabindex="3">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label> Date of Transfer</label>
                      <input type="text" value='<?php echo date("Y-m-d"); ?> ' id="datepicker_2end" name="date" class="form-control pull-right" tabindex="4">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                </div>
                <input type="hidden" name="type" value="bank">
                <input class="btn btn-info" type="submit" value="Submit">
              </form>
            </div>



          </div>

        <?php } ?>

      </div>
    </section>
    <!-- /.box -->
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <?php
  include("dounbr.php");
  ?>

  <?php
  $error_id = 0;
  $unit = 0;
  $err = 'd-none';
  if (isset($_GET['error'])) {
    $error_id = $_GET['error'];
    $unit = $_GET['unit'];
    $err = '';
  } ?>

  <div class="container-up <?php echo $err; ?>" id="container_up">
    <div class="container-close" onclick="click_close()"></div>
    <div class="row">
      <div class="col-md-12">

        <div class="box box-success popup <?php echo $err; ?>" id="popup_1" style="padding: 5px;border: 0;">
          <div class="alert alert-danger alert-dismissible" style="width: 350px;margin: 0;">
            <button type="button" class="close" onclick="click_close()" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <?php

            if ($unit == 1) {
              if ($error_id == 1) {
                echo "The amount paid is more than the credit amount ..!";
              } else {
                echo "This Bill already ADD ..!";
              }
            }

            if ($unit == 2) {
              echo "Unbalance CHQ amount to Payment total ..!";
            }

            ?>
          </div>
        </div>

        <div class="box box-success popup d-none" id="popup_2" style="padding: 5px;border: 0;">
          <div class="alert alert-danger alert-dismissible" style="width: 350px;margin: 0;">
            <button type="button" class="close" onclick="click_close()" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            Unbalance CHQ amount to Payment total
          </div>
        </div>

        <div class="box box-success popup d-none" id="popup_3" style="width: 358px;display: flex;flex-direction: column;justify-content: space-between;">

          <h4>Sure you want to process this ? </h4>
          <hr style="margin: 10px 0;border-color:#999;">
          <div style="display: flex;align-items:center;justify-content:space-around;margin:10px 0;">
            <button onclick="check_process('cancel')" class="btn btn-primary">Cancel</button>
            <button onclick="check_process('process')" class="btn btn-danger">Process</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>


  <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->


  <!-- jQuery 2.2.3 -->
  <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="../../plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <!-- Select2 -->
  <script src="../../plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- bootstrap color picker -->

  <script>
    function click_open(i) {
      $("#popup_" + i).removeClass("d-none");
      $("#container_up").removeClass("d-none");
    }

    function click_close() {
      $(".popup").addClass("d-none");
      $("#container_up").addClass("d-none");
    }
  </script>

  <script>
    function process() {
      let balance = <?php echo $balance; ?>;

      if (balance > 0) {
        $("#popup_2").removeClass("d-none");
        $("#container_up").removeClass("d-none");
      } else {
        $("#popup_3").removeClass("d-none");
        $("#container_up").removeClass("d-none");
      }
    }

    function check_process(val) {
      if (val == 'process') {
        $('#process-form').submit();
      }
      if (val == 'cancel') {
        $(".popup").addClass("d-none");
        $("#container_up").addClass("d-none");
      }
    }
  </script>

  <script type="text/javascript">
    $(function() {
      $(".delbutton").click(function() {
        //Save the link in a variable called element
        var element = $(this);
        //Find the id of the link that was clicked
        var del_id = element.attr("id");
        //Built a url to send
        var info = 'id=' + del_id;
        if (confirm("Sure you want to delete this ? There is NO undo!")) {
          $.ajax({
            type: "GET",
            url: "bulk_payment_list_dll.php?pay_id=<?php echo $_GET['id']; ?>",
            data: info,
            success: function() {

            }
          });
          $(this).parents(".record").animate({
              backgroundColor: "#fbc7c7"
            }, "fast")
            .animate({
              opacity: "hide"
            }, "slow");

        }

        return false;

      });

    });



    $(function() {
      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });
  </script>


  <!-- Page script -->
  <script>
    $(function() {
      //Initialize Select2 Elements
      $(".select2").select2();


      //Date range picker
      $('#reservation').daterangepicker();
      //Date range picker with time picker
      //$('#datepicker').datepicker({datepicker: true,  format: 'yyyy/mm/dd '});
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
      );

      //Date picker
      $('#datepicker').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd '
      });
      $('#datepicker').datepicker({
        autoclose: true
      });



      $('#datepicker_2end').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd '
      });
      $('#datepicker_2end').datepicker({
        autoclose: true
      });

    });


    function view_payment_date(type) {
      if (type == 'bank') {
        document.getElementById('chq_pay').style.display = 'none';
        document.getElementById('bank_pay').style.display = 'block';
        document.getElementById('cash_pay').style.display = 'none';
        document.getElementById('coupon').style.display = 'none';
        document.getElementById('2kg').style.display = 'none';
      } else if (type == 'chq') {
        document.getElementById('chq_pay').style.display = 'block';
        document.getElementById('bank_pay').style.display = 'none';
        document.getElementById('cash_pay').style.display = 'none';
        document.getElementById('coupon').style.display = 'none';
        document.getElementById('2kg').style.display = 'none';
      } else if (type == 'cash') {
        document.getElementById('chq_pay').style.display = 'none';
        document.getElementById('bank_pay').style.display = 'none';
        document.getElementById('cash_pay').style.display = 'block';
        document.getElementById('coupon').style.display = 'none';
        document.getElementById('2kg').style.display = 'none';
      } else if (type == 'coupon') {
        document.getElementById('chq_pay').style.display = 'none';
        document.getElementById('bank_pay').style.display = 'none';
        document.getElementById('cash_pay').style.display = 'none';
        document.getElementById('2kg').style.display = 'none';
        document.getElementById('coupon').style.display = 'block';
      } else if (type == '2kg') {
        document.getElementById('chq_pay').style.display = 'none';
        document.getElementById('coupon').style.display = 'none';
        document.getElementById('bank_pay').style.display = 'none';
        document.getElementById('cash_pay').style.display = 'none';
        document.getElementById('2kg').style.display = 'block';
      } else {
        document.getElementById('chq_pay').style.display = 'none';
        document.getElementById('bank_pay').style.display = 'none';
        document.getElementById('cash_pay').style.display = 'none';
        document.getElementById('coupon').style.display = 'none';
        document.getElementById('2kg').style.display = 'none';
      }
    }
  </script>
</body>

</html>