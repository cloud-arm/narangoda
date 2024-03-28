<!DOCTYPE html>
<html>
<?php
include("head.php");
include("connect.php");
date_default_timezone_set("Asia/Colombo");
?>

<body class="hold-transition skin-yellow sidebar-mini ">
    <?php
    include_once("auth.php");
    $r = $_SESSION['SESS_LAST_NAME'];
    $_SESSION['SESS_FORM'] = 'target_rp';

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
                All Target
                <small>Report</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Date Selector</h3>
                        </div>

                        <div class="box-body">
                            <form action="" method="GET">
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-lg-1"></div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control " name="year" style="width: 100%;" tabindex="1" autofocus>
                                                <option> <?php echo date('Y') - 1 ?> </option>
                                                <option selected> <?php echo date('Y') ?> </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control " name="month" style="width: 100%;" tabindex="1" autofocus>
                                                <?php for ($x = 1; $x <= 12; $x++) {
                                                    $m = sprintf("%02d", $x); ?>
                                                    <option <?php if ($m == $_GET['month']) { ?> selected <?php } ?>> <?php echo $m ?> </option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input class="btn btn-info" type="submit" value="Search">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- All jobs -->

            <?php
            include("connect.php");
            date_default_timezone_set("Asia/Colombo");

            $month = $_GET['year'] . '-' . $_GET['month'];

            $sql = " SELECT * FROM `target` WHERE  month = '$month' ";
            ?>
            <div class="box box-info">

                <div class="box-header with-border">
                    <h3 class="box-title" style="text-transform: capitalize;">Target Report</h3>
                </div>

                <div class="box-body d-block">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Target</th>
                                <th>Achievement</th>
                                <th>Balance</th>
                                <th>Bonus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $a = 0;
                            $pay_total = 0;
                            $bill_total = 0;
                            $result = $db->prepare($sql);
                            $result->bindParam(':userid', $date);
                            $result->execute();
                            for ($i = 0; $row = $result->fetch(); $i++) {
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['target']; ?></td>
                                    <td><?php echo $row['achievement']; ?></td>
                                    <td><?php echo $row['balance']; ?></td>
                                    <td><?php echo $row['bonus']; ?></td>
                                </tr>
                            <?php } ?>

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
    <div class="control-sidebar-bg"></div>
    </div>

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

    <script type="text/javascript">
        $(function() {
            $("#example").DataTable();
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
                format: 'yyyy/mm/dd '
            });
            $('#datepicker').datepicker({
                autoclose: true
            });



            $('#datepickerd').datepicker({
                autoclose: true,
                datepicker: true,
                format: 'yyyy/mm/dd '
            });
            $('#datepickerd').datepicker({
                autoclose: true
            });

        });
    </script>

</body>

</html>