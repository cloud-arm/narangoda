<!DOCTYPE html>
<html>
<?php
include("head.php");
include("connect.php");
?>

<body class="hold-transition skin-blue sidebar-mini">
    <?php
    include_once("auth.php");
    $r = $_SESSION['SESS_LAST_NAME'];

    if ($r == 'Cashier') {

        header("location:./../../../index.php");
    }
    if ($r == 'admin') {

        include_once("sidebar.php");
    }
    ?>

    <style>
        .popup .content {
            min-height: unset;
        }
    </style>



    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Root Details
                <small>Preview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Forms</a></li>
                <li class="active">Root</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Root Customer</h3>
                    <a rel="facebox" href="root_customer_add.php?id=<?php echo $_GET['id']; ?>">
                        <button class="btn btn-info">Add Customer</button>
                    </a>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>ID.</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>contact</th>
                                <th>#</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $result = $db->prepare("SELECT * FROM customer  WHERE root_id = :id ");
                            $result->bindParam(':id', $_GET['id']);
                            $result->execute();
                            for ($i = 0; $row = $result->fetch(); $i++) {
                            ?>
                                <tr class="record">
                                    <td><?php echo $row['customer_id']; ?></td>
                                    <td><?php echo $row['customer_name']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td><?php echo $row['contact']; ?></td>
                                    <td>
                                        <a href="#" id="<?php echo $row['customer_id']; ?>" class="delbutton" title="Click to Delete">
                                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </a>
                                    </td>
                                </tr>
                            <?php  } ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

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
            $("#example1").DataTable({
                "language": {
                    "paginate": {
                        "next": "<i class='fa fa-angle-double-right'></i>",
                        "previous": "<i class='fa fa-angle-double-left'></i>"
                    }
                }
            });
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
                if (confirm("Sure you want to delete this Root? There is NO undo!")) {

                    $.ajax({
                        type: "GET",
                        url: "root_customer_dll.php",
                        data: info,
                        success: function(res) {
                            console.log(res);
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