<!DOCTYPE html>
<html>
<?php
include("head.php");
include("connect.php");
?>

<body class="hold-transition skin-yellow sidebar-mini">
  <?php
  include_once("auth.php");
  $r = $_SESSION['SESS_LAST_NAME'];

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
        Loading
        <small>Preview</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">


      <div class="row">
        <div class="col-md-10">

          <div class="box box-warning ">
            <div class="box-header with-border">
              <h3 class="box-title">Add Loading Product</h3>
              <label style="margin-right: 50px;" class="pull-right"> Lorry No. <?php echo $_POST['lorry']; ?></label>
            </div>


            <div class="box-body">

              <form method="POST" action="empty_loading_save.php">
                <div class="row">

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Products</label>
                      <select class="form-control select2" name="product" style="width: 100%;" autofocus>
                        <?php
                        $result = $db->prepare("SELECT * FROM products  WHERE product_name='' AND product_id <= 8");
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

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>QTY:</label>
                      <input type="number" class="form-control" min="0" value='' name="qty">
                    </div>
                  </div>

                  <div class="col-md-3" style="margin-top: 23px;">
                    <div class="form-group">
                      <input class="btn btn-info" type="submit" disabled value="Submit">
                      <input type="hidden" value='<?php echo $lorry = $_POST['lorry']; ?>' name="lorry">
                      <input type="hidden" value='<?php echo $yard = $_POST['yard']; ?>' name="yard">
                    </div>
                  </div>



                </div>

                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Item Name</th>
                        <th>QTY</th>
                        <th>#</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $result = $db->prepare("SELECT * FROM loading WHERE action='load' AND lorry_no='$lorry' ");
                      $result->bindParam(':userid', $res);
                      $result->execute();
                      for ($i = 0; $row = $result->fetch(); $i++) {
                      ?>
                        <tr class="record">
                          <td><?php echo $row['product_name']; ?></td>
                          <td><?php echo $row['qty']; ?> </td>
                          <td> <a href="#" id="<?php echo $row['transaction_id']; ?>" name="<?php echo $_POST['yard']; ?>" class="delbutton" title="Click to Delete">
                              <button class="btn btn-danger"><i class="icon-trash">x</i></button></a></td>

                        </tr>
                      <?php
                      }
                      ?>


                    </tbody>

                  </table>
                </div>

















            </div>


            <!-- /.box -->










            </form>
            <!-- /.box -->


            <!-- /.col (left) -->



            <!-- /.box-body -->

          </div>
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col (right) -->
  </div>
  <!-- /.row -->

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
  <script src="js/jquery.js"></script>
  <!-- jQuery 2.2.3 -->
  <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="../../plugins/select2/select2.full.min.js"></script>
  <!-- InputMask -->
  <script src="../../plugins/input-mask/jquery.inputmask.js"></script>
  <script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- date-range-picker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="../../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker -->
  <script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
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




  <script type="text/javascript">
    $(function() {


      $(".delbutton").click(function() {

        //Save the link in a variable called element
        var element = $(this);

        //Find the id of the link that was clicked
        var del_id = element.attr("id");

        //Built a url to send
        var info = 'id=' + del_id;
        if (confirm("Sure you want to delete this Product? There is NO undo!")) {

          $.ajax({
            type: "GET",
            url: "loading_dll.php?yard=<?php echo $yard; ?>",
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
  </script>

  <!-- Page script -->
  <script>
    $(function() {
      //Initialize Select2 Elements
      $(".select2").select2();

      //Datemask dd/mm/yyyy
      $("#datemask").inputmask("YYYY/MM/DD", {
        "placeholder": "YYYY/MM/DD"
      });
      //Datemask2 mm/dd/yyyy
      $("#datemask2").inputmask("YYYY/MM/DD", {
        "placeholder": "YYYY/MM/DD"
      });
      //Money Euro
      $("[data-mask]").inputmask();

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

      //Colorpicker
      $(".my-colorpicker1").colorpicker();
      //color picker with addon
      $(".my-colorpicker2").colorpicker();

      //Timepicker
      $(".timepicker").timepicker({
        showInputs: false
      });
    });
  </script>


</body>

</html>