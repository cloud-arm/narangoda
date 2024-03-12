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
                    <h3 class="box-title">Add New Attendance</h3>
                </div>

                <div class="box-body">
                    <form method="post" action="hr_attendance_save.php">

                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="form-control select2" name="id" style="width: 100%;" tabindex="1" autofocus>

                                                <?php
                                                $result = $db->prepare("SELECT * FROM employee ");
                                                $result->bindParam(':userid', $res);
                                                $result->execute();
                                                for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                                    <option value="<?php echo $row['id']; ?>">
                                                        <?php echo $row['name']; ?>

                                                    </option>
                                                <?php    } ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <label>Date</label>
                                                </div>
                                                <input type="text" class="form-control" name="date" value="<?php echo date('Y-m-d') ?>" id="datepicker" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <label>In Time (<b style="color:brown">HH.mm</b>)</label>
                                                </div>
                                                <input type="text" class="form-control " name="in_time" value="<?php echo date('H.i') ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <label>Out Time (<b style="color:brown">HH.mm</b>)</label>
                                                </div>
                                                <input type="text" class="form-control " name="out_time" value="<?php echo date('H.i') ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <input class="btn btn-info" type="submit" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

                                        <?php
                                        $result = $db->prepare("SELECT * FROM employee ");
                                        $result->bindParam(':userid', $res);
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
                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>name</th>
                                <th>Date</th>
                                <th>IN</th>
                                <th>OUT</th>
                                <th>Hour count</th>
                                <th>OT</th>
                                <th>#</th>
                            </tr>

                        </thead>

                        <tbody>
                            <?php
                            $d1 = date('Y-m') . "-01";
                            $d2 = date('Y-m') . "-31";

                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $d1 = $_GET['year'] . "-" . $_GET['month'] . "-01";
                                $d2 = $_GET['year'] . "-" . $_GET['month'] . "-31";
                                
                                $result = $db->prepare("SELECT * FROM attendance WHERE emp_id='$id' AND date BETWEEN '$d1' AND '$d2' ORDER BY id DESC LIMIT 50");
                            } else {
                                $result = $db->prepare("SELECT * FROM attendance  WHERE date BETWEEN '$d1' AND '$d2' ORDER BY id DESC LIMIT 50");
                            }

                            $result->bindParam(':userid', $date);
                            $result->execute();
                            for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                <tr class="record">
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['date'] ?></td>
                                    <td><?php echo $row['IN_time']; ?></td>
                                    <td><?php echo $row['OUT_time']; ?></td>
                                    <td><?php echo $row['deff_time'] ?></td>
                                    <td><?php echo $row['ot'] ?></td>
                                    <td style="width: 5%;">
                                        <a href="#" id="<?php echo $row['id']; ?>" class="delbutton btn btn-danger" title="Click to Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                <?php    } ?>
                                </tr>
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

                }

                return false;

            });

        });


        $(function() {
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