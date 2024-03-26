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
  $_SESSION['SESS_FORM'] = 'customer';

  if ($r == 'Cashier') {

    header("location:./../../../index.php");
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
        CUSTOMER
        <small>Preview</small>
      </h1>
    </section>

    <section class="content">

      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Customer Data</h3>
          <small class="btn btn-success btn-sm mx-2" style="padding: 5px 10px;" title="Add Customer" onclick="click_open(1)">Add Customer</small>
        </div>
        <!-- /.box-header -->

        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">

            <thead>
              <tr>
                <th>id</th>
                <th>Name</th>
                <th>Address</th>
                <th>Contact No</th>
                <th>Credit Period</th>
                <th>VAT No.</th>
                <th>Group</th>
                <th>#</th>
              </tr>

            </thead>

            <tbody>
              <?php

              $result = $db->prepare("SELECT * FROM customer   ");
              $result->bindParam(':userid', $date);
              $result->execute();
              for ($i = 0; $row = $result->fetch(); $i++) {
              ?>
                <tr class="record_<?php echo $row['customer_id']; ?>">
                  <td><?php echo $row['customer_id']; ?></td>
                  <td><?php echo $row['customer_name']; ?><br>
                    <?php $type = $row['type'];
                    if ($type == '1') { ?><span class="badge bg-yellow">Channel</span><?php } ?>
                    <?php if ($type == '2') { ?><span class="badge bg-info">Commercial</span><?php } ?>
                    <?php if ($type == '3') { ?><span class="badge bg-primary">Apartment</span><?php } ?>
                  </td>
                  <td>
                    <?php echo $row['address']; ?><br>
                    <span class="badge bg-olive"><?php echo $row['area']; ?></span>
                  </td>
                  <td><?php echo $row['contact']; ?></td>
                  <td><?php $pd = $row['credit_period'];
                      if ($pd > 0) {
                        echo '<span style="font-size: 15px" class="badge bg-primary">' . $pd . ' Day</span>';
                      }
                      ?></td>
                  <td> <?php echo $row['vat_no'];  ?>
                  </td>
                  <td><?php $group_id = $row['category'];
                      $result222 = $db->prepare("SELECT * FROM customer_category WHERE id='$group_id' ");
                      $result222->bindParam(':userid', $d2);
                      $result222->execute();
                      for ($i = 0; $row222 = $result222->fetch(); $i++) { ?>
                      <span style="font-size: 15px" class="badge bg-info"><?php echo $row222['name']; ?></span>
                    <?php } ?>
                  </td>

                  <td style="display: flex; gap:5px;">
                    <a href="#" onclick="customer_dll('<?php echo $row['customer_id']; ?>')" title="Click to Delete" class="btn btn-danger btn-sm btn_dll"><i class="fa fa-trash"></i></a>
                    <a href="customer.php?id=<?php echo $row['customer_id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                    <a href="customer_qrcode.php?id=<?php echo $row['customer_id']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-qrcode"></i></a>
                  </td>

                <?php
              }

                ?>
                </tr>


            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
  include("dounbr.php");
  ?>
  <?php
  $con = 'd-none';
  if (isset($_GET['id'])) {
    $con = '';
  }
  ?>
  <div class="container-up <?php echo $con; ?>" id="container_up">
    <div class="container-close" onclick="click_close()"></div>
    <div class="row">
      <div class="col-md-12">

        <div class="box box-success popup d-none" id="popup_1" style="width: 600px;">
          <div class="box-header with-border">
            <h3 class="box-title w-100">
              New Customer
              <i onclick="click_close()" class="btn me-2 pull-right fa fa-remove" style="font-size: 25px"></i>
            </h3>
          </div>

          <div class="box-body d-block">
            <form method="POST" action="customer_save.php">

              <div class="row" style="display: block;">

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label> Address</label>
                    <input type="text" name="address" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Contact no</label>
                    <input type="tel" name="contact" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Root</label>
                    <select class="form-control select2 " name="root" style="width: 100%;">
                      <?php
                      include("connect.php");
                      $result = $db->prepare("SELECT * FROM root  ");
                      $result->bindParam(':userid', $res);
                      $result->execute();
                      for ($i = 0; $row = $result->fetch(); $i++) {
                      ?>
                        <option value="<?php echo $row['root_id']; ?>"><?php echo $row['root_name']; ?> </option>
                      <?php
                      }
                      ?>

                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label> Area</label>
                    <select class="form-control select2 hidden-search" name="area" style="width: 100%;">
                      <option> Galle </option>
                      <option> Mathara </option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Type</label>
                    <select class="form-control select2 hidden-search" name="type" style="width: 100%;">
                      <option value="1"> Channel </option>
                      <option value="2"> Commercial </option>
                      <option value="3"> Apartment </option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <input type="hidden" name="id" value="0">
                    <input type="submit" style="margin-top: 23px;width: 100%;" value="Save" class="btn btn-info">
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>

        <div class="box box-success popup <?php echo $con; ?> with-scroll" id="popup_2" style="max-width: 600px;overflow-x: hidden;">
          <div class="box-header with-border">
            <h3 class="box-title w-100">
              Edit Customer
              <i onclick="click_close()" class="btn me-2 pull-right fa fa-remove" style="font-size: 25px"></i>
            </h3>
          </div>

          <?php
          if (isset($_GET['id'])) {
            include('connect.php');
            $id = $_GET['id'];
            $result = $db->prepare("SELECT * FROM customer WHERE customer_id=:id ");
            $result->bindParam(':id', $id);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {

              $name = $row['customer_name'];
              $address = $row['address'];
              $vat_no = $row['vat_no'];
              $acc_name = $row['acc_name'];
              $acc_no = $row['acc_no'];
              $root = $row['root_id'];
              $area = $row['area'];
              $contact = $row['contact'];
              $credit = $row['credit_period'];
              $cat_id = $row['category'];
              $type = $row['type'];
              $g12 = $row['price_12'];
              $g5 = $row['price_5'];
              $g37 = $row['price_37'];
            }
          }
          ?>
          <div class="box-body d-block">
            <form method="POST" action="customer_save.php">

              <div class="row" style="display: block;">

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $name ?>" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label> Address</label>
                    <input type="text" name="address" value="<?php echo $address ?>" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Contact no</label>
                    <input type="tel" name="contact" value="<?php echo $contact ?>" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Accounted Name</label>
                    <input type="text" name="acc_name" value="<?php echo $acc_name ?>" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Contact no (acc)</label>
                    <input type="text" name="acc_no" value="<?php echo $acc_no ?>" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Root</label>
                    <select class="form-control select2 " name="root" style="width: 100%;">
                      <?php
                      include("connect.php");
                      $result = $db->prepare("SELECT * FROM root  ");
                      $result->bindParam(':userid', $res);
                      $result->execute();
                      for ($i = 0; $row = $result->fetch(); $i++) {
                      ?>
                        <option <?php if ($row['root_id'] == $root) {
                                  echo 'selected';
                                } ?> value="<?php echo $row['root_id']; ?>"><?php echo $row['root_name']; ?> </option>
                      <?php
                      }
                      ?>

                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Area</label>
                    <select class="form-control select2 hidden-search" name="area" style="width: 100%;">
                      <option <?php if ($area == 'Galle') {
                                echo 'selected';
                              } ?>> Galle </option>
                      <option <?php if ($area == 'Mathara') {
                                echo 'selected';
                              } ?>> Mathara </option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Type</label>
                    <select class="form-control select2 hidden-search" name="type" style="width: 100%;">
                      <option <?php if ($type == 'Channel') {
                                echo 'selected';
                              } ?> value="1"> Channel </option>
                      <option <?php if ($type == 'Commercial') {
                                echo 'selected';
                              } ?> value="2"> Commercial </option>
                      <option <?php if ($type == 'Apartment') {
                                echo 'selected';
                              } ?> value="3"> Apartment </option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Group</label>
                    <select class="form-control select2 " name="group" style="width: 100%;">
                      <?php
                      include("connect.php");
                      $result = $db->prepare("SELECT * FROM customer_category  ");
                      $result->bindParam(':userid', $res);
                      $result->execute();
                      for ($i = 0; $row = $result->fetch(); $i++) {
                      ?>
                        <option <?php if ($row['id'] == $cat_id) {
                                  echo 'selected';
                                } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> </option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Credit Period</label>
                    <input type="text" name="credit" value="<?php echo $credit ?>" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>VAT no.</label>
                    <input type="text" name="vat_no" value="<?php echo $vat_no ?>" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>12.5kg price</label>
                    <select class="form-control select2 hidden-search" name="g12" style="width: 100%;">
                      <option <?php if ($g12 == '1') {
                                echo 'selected';
                              } ?> value="1"> Sell </option>
                      <option <?php if ($g12 == '0') {
                                echo 'selected';
                              } ?> value="0"> Dealer </option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>5kg price</label>
                    <select class="form-control select2 hidden-search" name="g5" style="width: 100%;">
                      <option <?php if ($g5 == '1') {
                                echo 'selected';
                              } ?> value="1"> Sell </option>
                      <option <?php if ($g5 == '0') {
                                echo 'selected';
                              } ?> value="0"> Dealer </option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>37.5kg price</label>
                    <select class="form-control select2 hidden-search" name="g37" style="width: 100%;">
                      <option <?php if ($g37 == '1') {
                                echo 'selected';
                              } ?> value="1"> Sell </option>
                      <option <?php if ($g37 == '0') {
                                echo 'selected';
                              } ?> value="0"> Dealer </option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" style="margin-top: 23px;width: 100%;" value="Save" class="btn btn-info">
                  </div>
                </div>
              </div>

            </form>
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
  <!-- Select2 -->
  <script src="../../plugins/select2/select2.full.min.js"></script>
  <!-- DataTables -->
  <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
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
  <!-- page script -->
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
  <script type="text/javascript">
    function customer_dll(id) {

      var info = 'id=' + id;
      if (confirm("Sure you want to delete this customer? There is NO undo!")) {

        $.ajax({
          type: "GET",
          url: "customer_dll.php",
          data: info,
          success: function() {}
        });
        $(".record_" + id).animate({
            backgroundColor: "#fbc7c7"
          }, "fast")
          .animate({
            opacity: "hide"
          }, "slow");

      }

      return false;

    }
  </script>
  <script>
    $(function() {
      //Initialize Select2 Elements
      $(".select2").select2();
      $('.select2.hidden-search').select2({
        minimumResultsForSearch: -1
      });

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


      $('#datepicker_set').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd '
      });
      $('#datepicker_set').datepicker({
        autoclose: true
      });


      $('#datepickerd').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd '
      });
      $('#datepickerd').datepicker({
        autoclose: true
      });


    });
  </script>
</body>

</html>