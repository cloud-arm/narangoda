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
    $_SESSION['SESS_FORM'] = 'hr_attendance';

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
                Attendance
                <small>Preview</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content" style="min-height: max-content;">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Today Attendance</h3>
                </div>

                <div class="box-body">

                    <div class="row" id="attendance"></div>

                </div>
            </div>

        </section>
        <!-- /.content -->

        <section class="content">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Attendance List</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <select class="form-control select2" name="id" style="width: 100%;" tabindex="1" autofocus>
                                        <option value="0">All</option>
                                        <?php
                                        $result = $db->prepare("SELECT * FROM employee ");
                                        $result->bindParam(':userid', $date);
                                        $result->execute();
                                        for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                            <option value="<?php echo $row['id']; ?>">
                                                <?php echo $row['name']; ?>

                                            </option>
                                        <?php    } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control select2 hidden-search" name="year" style="width: 100%;" tabindex="1" autofocus>
                                        <option> <?php echo date('Y') - 1 ?> </option>
                                        <option selected> <?php echo date('Y') ?> </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control select2 hidden-search" name="month" style="width: 100%;" tabindex="1" autofocus>
                                        <?php for ($x = 1; $x <= 12; $x++) {
                                            $month = date('m');
                                            if (isset($_GET['month'])) {
                                                $month = $_GET['month'];
                                            }
                                            $mo = sprintf("%02d", $x); ?>
                                            <option <?php if ($mo == $month) {
                                                        echo 'selected';
                                                    } ?>> <?php echo $mo; ?> </option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <input class="btn btn-info" type="submit" value="Filter">
                                </div>
                            </div>

                        </div>
                    </form>

                    <table id="example" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>#</th>
                            </tr>

                        </thead>

                        <tbody id="att_table">
                            <?php
                            $date = date('Y-m-d');

                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $d1 = $_GET['year'] . "-" . $_GET['month'] . "-01";
                                $d2 = $_GET['year'] . "-" . $_GET['month'] . "-31";
                                if ($id == 0) {
                                    $result = $db->prepare("SELECT * FROM attendance WHERE  date BETWEEN '$d1' AND '$d2' ORDER BY id DESC LIMIT 50");
                                } else {
                                    $result = $db->prepare("SELECT * FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id DESC");
                                }
                            } else {
                                $result = $db->prepare("SELECT * FROM attendance  WHERE date = '$date' ORDER BY id  ");
                            }

                            $result->bindParam(':userid', $date);
                            $result->execute();
                            for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                <tr class="record">
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['date'] ?></td>
                                    <td style="width: 5%;">
                                        <a href="#" id="<?php echo $row['id']; ?>" class="delbutton btn btn-danger btn-sm" title="Click to Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php    } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </section>
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
    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
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
        function save_attendance(id) {
            var info = 'id=' + id;
            $.ajax({
                type: "GET",
                url: "hr_attendance_save.php",
                data: info,
                success: function() {}
            });
            get_attendance();
            get_table();
        }

        function get_attendance() {
            var info = 'unit=1';
            $.ajax({
                type: "GET",
                url: "hr_attendance_get.php",
                data: info,
                success: function(res) {
                    $('#attendance').empty();
                    $('#attendance').append(res);
                }
            });
        }

        function get_table() {
            var info = 'unit=2';
            $.ajax({
                type: "GET",
                url: "hr_attendance_get.php",
                data: info,
                success: function(res) {
                    $('#att_table').empty();
                    $('#att_table').append(res);
                }
            });
        }

        $(function() {

            get_attendance();

            $(".delbutton").click(function() {

                //Save the link in a variable called element
                var element = $(this);

                //Find the id of the link that was clicked
                var del_id = element.attr("id");

                //Built a url to send
                var info = 'id=' + del_id;
                if (confirm("Sure you want to delete this Collection? There is NO undo!")) {

                    $.ajax({
                        type: "GET",
                        url: "hr_attendance_dll.php",
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

                    get_attendance();
                }

                return false;

                get_attendance();
            });

        });


        $(function() {

            $('#example').DataTable();
            //Initialize Select2 Elements
            $(".select2").select2();
            $('.select2.hidden-search').select2({
                minimumResultsForSearch: -1
            });

            //Date range picker
            $('#reservation').daterangepicker();

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                datepicker: true,
                format: 'yyyy-mm-dd '
            });
            $('#datepicker').datepicker({
                autoclose: true
            });

            //Date picker
            $('#datepic').datepicker({
                autoclose: true,
                datepicker: true,
                format: 'yyyy-mm-dd '
            });

            $('#datepic2').datepicker({
                autoclose: true,
                datepicker: true,
                format: 'yyyy-mm-dd '
            });

            $('#datepic').datepicker({
                autoclose: true
            });


        });
    </script>
</body>

</html>