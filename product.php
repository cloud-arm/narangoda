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
  $_SESSION['SESS_FORM'] = 'product';

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
        PRODUCT
        <small>Preview</small>
      </h1>
    </section>

    <section class="content">

      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">PRODUCT Data</h3>
          <a rel="facebox" href="product_add.php">
            <button class="btn btn-info"><i class="icon-trash">Add PRODUCT</i></button></a>
        </div>
        <!-- /.box-header -->

        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">

            <thead>
              <tr>
                <th>Product_id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Price (Kaluthara)</th>
                <th>Cost Price</th>
                <th>SELL Price</th>

                <th>#</th>
              </tr>

            </thead>

            <tbody>
              <?php

              $result = $db->prepare("SELECT * FROM products ORDER by product_id ASC  ");
              $result->bindParam(':userid', $date);
              $result->execute();
              for ($i = 0; $row = $result->fetch(); $i++) {
              ?>
                <tr class="record">
                  <td><?php echo $id = $row['product_id']; ?></td>
                  <td><?php echo $row['gen_name']; ?>
                  </td>

                  <td><?php echo $row['price']; ?></td>
                  <td><?php echo $row['price2']; ?></td>
                  <td><?php echo $row['o_price']; ?></td>
                  <td><?php echo $row['sell_price']; ?></td>


                  <td>
                    <?php
                    if ($user_lewal < 3) {
                    ?>
                      <a href="#" id="<?php echo $row['product_id']; ?>" class="delbutton" title="Click to Delete">
                        <button class="btn btn-danger"><i class="icon-trash">x</i></button></a>

                      <a rel="facebox" href="product_edit.php?id=<?php echo $row['product_id']; ?>">
                        <button class="btn btn-info"><i class="icon-trash">Edit</i></button></a>
                  </td>

              <?php
                    }
                  }
              ?>
                </tr>


            </tbody>
            <tfoot>







            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
  </div>
  <!-- /.col -->





  <!-- Main content -->

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
        if (confirm("Sure you want to delete this product? There is NO undo!")) {

          $.ajax({
            type: "GET",
            url: "product_dll.php",
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