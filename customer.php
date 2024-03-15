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
          <small class="btn btn-info mx-2" style="padding: 5px 10px;" title="Add Customer" onclick="click_open(1)">Add Customer</small>
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
                <th>Vat No:</th>
                <th>Group</th>
                <th>#</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $result = $db->prepare("SELECT * FROM customer  ORDER BY customer_id DESC LIMIT 100 ");
              $result->bindParam(':userid', $date);
              $result->execute();
              for ($i = 0; $row = $result->fetch(); $i++) {
              ?>
                <tr class="record">
                  <td><?php echo $row['customer_id']; ?></td>
                  <td><?php echo $row['customer_name']; ?>
                    <?php $type = $row['type'];
                    if ($type == '1') { ?><span style="font-size: 12px" class="label label-warning">Channel</span><?php } ?>
                    <?php if ($type == '2') { ?><span style="font-size: 12px" class="label label-info">Commercial</span><?php } ?>
                    <?php if ($type == '3') { ?><span style="font-size: 12px" class="label label-primary">Apartment</span><?php } ?>
                  </td>
                  <td><?php echo $row['address']; ?></td>
                  <td><?php echo $row['contact']; ?></td>
                  <td>
                    <?php $pd = $row['credit_period'];
                    if ($pd > 0) {
                      echo '<span style="font-size: 15px" class="label label-primary">' . $pd . ' Day</span>';
                    } ?>
                  </td>
                  <td>
                    <?php
                    $cus_cus = $row['customer_id'];
                    $result12 = $db->prepare("SELECT * FROM special_price WHERE customer_id='$cus_cus'  ");
                    $result12->bindParam(':userid', $date);
                    $result12->execute();
                    for ($i = 0; $row12 = $result12->fetch(); $i++) {
                      $cus_id_1 = $row12['customer_id'];
                      if ($cus_id_1 > '1') { ?>
                        <span style="font-size: 12px" class="label label-danger">special_price</span>
                      <?php } ?>
                    <?php } ?>

                    <?php
                    $cus_cus = $row['customer_id'];
                    $result13 = $db->prepare("SELECT * FROM sales WHERE customer_id='$cus_cus'  ");
                    $result13->bindParam(':userid', $date);
                    $result13->execute();
                    for ($i = 0; $row13 = $result13->fetch(); $i++) {
                      $cus_id_2 = $row13['customer_id'];
                    }
                    if ($cus_id_2 > '1') { ?>
                      <span class="label label-success" style="font-size: 12px">Bill</span>
                    <?php } ?>

                  </td>
                  <td>
                    <?php $group_id = $row['category'];
                    $result222 = $db->prepare("SELECT * FROM customer_category WHERE id='$group_id' ");

                    $result222->bindParam(':userid', $d2);
                    $result222->execute();
                    for ($i = 0; $row222 = $result222->fetch(); $i++) {


                      echo '<span style="font-size: 15px" class="label label-info">' . $row222['name'] . '</span>';
                    } ?>
                  </td>

                  <td>
                    <a href="customer_dll.php?id=<?php echo $row['customer_id']; ?>" title="Click to Delete">
                      <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </a>

                    <a rel="facebox" href="customer_edit.php?id=<?php echo $row['customer_id']; ?>" class="btn btn-primary "><i class="fa fa-pencil"></i></a>
                  </td>

                </tr>

              <?php } ?>

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
  <!-- page script -->
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
    $(function() {


      $(".delbutton").click(function() {

        //Save the link in a variable called element
        var element = $(this);

        //Find the id of the link that was clicked
        var del_id = element.attr("id");

        //Built a url to send
        var info = 'id=' + del_id;
        if (confirm("Sure you want to delete this customer? There is NO undo!")) {

          $.ajax({
            type: "GET",
            url: "customer_dll.php",
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
</body>

</html>