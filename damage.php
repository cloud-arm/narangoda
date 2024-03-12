﻿<!DOCTYPE html>
<html>
<?php
include("head.php");
include("connect.php");
?>

<body class="hold-transition skin-yellow sidebar-mini">
  <?php
  include_once("auth.php");
  $r = $_SESSION['SESS_LAST_NAME'];
  $_SESSION['SESS_FORM'] = 'damage';

  if ($r == 'Cashier') {

    include_once("sidebar2.php");
  }
  if ($r == 'admin') {

    include_once("sidebar.php");
  }
  date_default_timezone_set("Asia/Colombo");
  ?>


  <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Damage Form
        <small>Preview</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">New Damage</h3>
        </div>


        <div class="box-body">
          <form method="post" action="damage_save.php">

            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label>Customer</label>
                  <select class="form-control select2" name="customer" style="width:100%;">
                    <option value="0">Narangoda Group </option>

                    <?php
                    $result = $db->prepare("SELECT * FROM customer  ");
                    $result->bindParam(':userid', $res);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Product</label>
                  <select class="form-control select2" name="product" style="width:100%;">
                    <?php
                    $result = $db->prepare("SELECT * FROM products WHERE product_id > 4  ");
                    $result->bindParam(':userid', $res);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $row['product_id']; ?>"><?php echo $row['gen_name']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>


              <div class="col-md-6">
                <div class="form-group">
                  <label> Complain no.</label>
                  <input type="text" name="complain_no" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> Cylinder no.</label>
                  <input type="text" name="cylinder_no" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> Gas Weight.</label>
                  <input type="text" name="gas_weight" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Comment.</label>
                  <input type="text" name="comment" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> Reason.</label>
                  <input type="text" name="reason" class="form-control">
                </div>
              </div>

              <div class="col-md-6" style="height: 75px; display: flex; align-items: center;">
                <label style="margin-bottom: 0;">
                  <input type="checkbox" name="one2one" class="flat-red">
                  One to one Replacement
                </label>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <input class="btn btn-info" type="submit" value="Save Damage">
                </div>
              </div>

            </div>

          </form>
          <!-- /.box -->

        </div>

      </div>

    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <?php
  include("dounbr.php");
  ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 2.2.3 -->
  <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="../../plugins/select2/select2.full.min.js"></script>
  <!-- date-range-picker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- SlimScroll 1.3.0 -->
  <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="../../plugins/iCheck/icheck.min.js"></script>
  <!-- FastClick -->
  <script src="../../plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <!-- Dark Theme Btn-->
  <script src="https://dev.colorbiz.org/ashen/cdn/main/dist/js/DarkTheme.js"></script>

  <!-- Page script -->
  <script>
    $(function() {
      //Initialize Select2 Elements
      $(".select2").select2();

      //Date range picker
      $('#reservation').daterangepicker();
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        format: 'YYYY/MM/DD h:mm A'
      });
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
        format: 'yyyy/mm/dd '
      });
      $('#datepicker').datepicker({
        autoclose: true
      });

      //iCheck for checkbox and radio inputs
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
      });
      //Red color scheme for iCheck
      $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
      });
      //Flat red color scheme for iCheck
      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
      });
    });
  </script>
</body>

</html>