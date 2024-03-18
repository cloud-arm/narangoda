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
    $_SESSION['SESS_FORM'] = 'acc_chq_realizing';
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
                Chq Realizing
                <small>Preview</small>
            </h1>

        </section>
        <!-- Main content -->
        <section class="content">
            <!-- SELECT2 EXAMPLE -->
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Deposit Chq</h3>
                            <!-- /.box-header -->
                        </div>
                        <div class="form-group">
                            <div class="box-body d-block">
                                <table id="example" class="table table-bordered table-hover" style="border-radius: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Acc no</th>
                                            <th>Chq No</th>
                                            <th>Chq Bank</th>
                                            <th>Chq Date</th>
                                            <th>Amount (Rs.)</th>
                                            <th>Realize</th>
                                            <th>Return</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0;
                                        $style = "";
                                        $result = $db->prepare("SELECT *, bank_balance.ac_no AS sn, payment.transaction_id AS pid , payment.amount AS payamount FROM payment JOIN bank_balance ON payment.bank_id = bank_balance.id WHERE payment.chq_action = 1 AND payment.type = 1 AND payment.pay_type='chq' ORDER BY payment.chq_date ASC ");
                                        $result->bindParam(':userid', $res);
                                        $result->execute();
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                            $depart = $row['dep_id'];
                                            $dep_tag = '';

                                            if ($depart == 1) {
                                                $dep_tag = '<span class="badge bg-olive"> Work Shop </span>';
                                            }
                                            if ($depart == 2) {
                                                $dep_tag = '<span class="badge bg-maroon"> Paint DP </span>';
                                            }
                                            if ($depart == 3) {
                                                $dep_tag = '<span class="badge bg-aqua"> Spare Part DP </span>';
                                            }
                                        ?>
                                            <tr id="re_<?php echo $row['pid']; ?>">
                                                <td><?php echo $row['pid']; ?></td>
                                                <td>
                                                    <?php echo $row['sn']; ?><br>
                                                    <?php //echo $dep_tag; 
                                                    ?>
                                                </td>
                                                <td><?php echo $row['chq_no']; ?></td>
                                                <td><?php echo $row['chq_bank']; ?></td>
                                                <td><?php echo $row['chq_date']; ?></td>
                                                <td><?php echo $row['payamount']; ?></td>
                                                <td align="center"> <a href="#" id="<?php echo $row['pid']; ?>" class="dep_realize_btn btn btn-success" title="Click to Realize"> <i class="fa-solid fa-money-bill-transfer"></i></a></td>
                                                <td align="center"> <a href="#" id="<?php echo $row['pid']; ?>" class="dep_return_btn btn btn-danger" title="Click to Return"> <i class="fa-solid fa-rotate-left"></i> </a></td>
                                                <?php $total += $row['amount']; ?>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>

                                </table>
                                <h4>Total Rs <b><?php echo number_format($total, 2); ?></h4>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Expenses Issue Chq</h3>
                            <!-- /.box-header -->
                        </div>
                        <div class="form-group">
                            <div class="box-body d-block">
                                <table id="example" class="table table-bordered table-hover" style="border-radius: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Acc no</th>
                                            <th>Chq No</th>
                                            <th>Chq Bank</th>
                                            <th>Chq Date</th>
                                            <th>Issue</th>
                                            <th>Amount (Rs.)</th>
                                            <th>Realize</th>
                                            <th>Return</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0;
                                        $style = "";
                                        $result = $db->prepare("SELECT *,bank_balance.ac_no AS sn, payment.amount AS pamount,payment.transaction_id AS pid FROM payment JOIN bank_balance ON payment.bank_id = bank_balance.id WHERE  payment.chq_action = 1 AND payment.type = 3 AND payment.pay_type='chq'  ORDER BY payment.chq_date ASC ");
                                        $result->bindParam(':userid', $res);
                                        $result->execute();
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                            $date1 = date_create(date('Y-m-d'));
                                            $date2 = date_create($row['chq_date']);
                                            $date_diff = date_diff($date1, $date2);
                                            $date_diff = $date_diff->format("%R%a");

                                            $note = '';
                                            $result2 = $db->prepare('SELECT * FROM expenses_records WHERE  invoice_no=:id ');
                                            $result2->bindParam(':id', $row['invoice_no']);
                                            $result2->execute();
                                            for ($i = 0; $row2 = $result2->fetch(); $i++) {
                                                $note = $row2['comment'];
                                            }

                                            $depart = $row['dep_id'];
                                            $dep_tag = '';

                                            if ($depart == 1) {
                                                $dep_tag = '<span class="badge bg-olive"> Work Shop </span>';
                                            }
                                            if ($depart == 2) {
                                                $dep_tag = '<span class="badge bg-maroon"> Paint DP </span>';
                                            }
                                            if ($depart == 3) {
                                                $dep_tag = '<span class="badge bg-aqua"> Spare Part DP </span>';
                                            }
                                        ?>
                                            <tr id="re_<?php echo $row['pid']; ?>">
                                                <td><?php echo $row['pid']; ?></td>
                                                <td>
                                                    <?php echo $row['sn']; ?><br>
                                                    <?php //echo $dep_tag; 
                                                    ?>
                                                </td>
                                                <td><?php echo $row['chq_no']; ?></td>
                                                <td><?php echo $row['chq_bank']; ?></td>
                                                <td><?php echo $row['chq_date']; ?><span class="badge bg-blue"><?php echo $date_diff; ?></span></td>
                                                <td><?php echo $note; ?></td>
                                                <td><?php echo $row['pamount']; ?></td>
                                                <?php if ($date_diff <= 0) { ?>
                                                    <td align="center"> <a href="#" id="<?php echo $row['pid']; ?>" unit="exp" class="iss_realize_btn btn btn-success" title="Click to Realize"> <i class="fa-solid fa-money-bill-transfer"></i></a></td>
                                                    <td align="center"> <a href="#" id="<?php echo $row['pid']; ?>" unit="exp" class="iss_return_btn btn btn-danger" title="Click to Return"> <i class="fa-solid fa-rotate-left"></i> </a></td>
                                                <?php } else { ?>
                                                    <td align="center" colspan="2"> <span class="badge bg-yellow">Pending</span> </td>

                                                <?php }
                                                $total += $row['pamount']; ?>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>

                                </table>
                                <h4>Total Rs <b><?php echo number_format($total, 2); ?></h4>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">GRN Issue Chq</h3>
                            <!-- /.box-header -->
                        </div>
                        <div class="form-group">
                            <div class="box-body d-block">
                                <table id="example" class="table table-bordered table-hover" style="border-radius: 0;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Acc no</th>
                                            <th>Chq No</th>
                                            <th>Chq Bank</th>
                                            <th>Chq Date</th>
                                            <th>Issue</th>
                                            <th>Amount (Rs.)</th>
                                            <th>Realize</th>
                                            <th>Return</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0;
                                        $style = "";
                                        $result = $db->prepare("SELECT *,bank_balance.ac_no AS sn,supply_payment.id AS pid,supply_payment.amount AS pamount FROM supply_payment JOIN bank_balance ON supply_payment.bank_id = bank_balance.id WHERE  supply_payment.action = 1 AND supply_payment.pay_type='Chq'  ORDER BY supply_payment.chq_date ASC ");
                                        $result->bindParam(':userid', $res);
                                        $result->execute();
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                            $date1 = date_create(date('Y-m-d'));
                                            $date2 = date_create($row['chq_date']);
                                            $date_diff = date_diff($date1, $date2);
                                            $date_diff = $date_diff->format("%R%a");

                                            $depart = $row['dep_id'];
                                            $dep_tag = '';

                                            if ($depart == 1) {
                                                $dep_tag = '<span class="badge bg-olive"> Work Shop </span>';
                                            }
                                            if ($depart == 2) {
                                                $dep_tag = '<span class="badge bg-maroon"> Paint DP </span>';
                                            }
                                            if ($depart == 3) {
                                                $dep_tag = '<span class="badge bg-aqua"> Spare Part DP </span>';
                                            }

                                        ?>
                                            <tr id="re_<?php echo $row['pid']; ?>">
                                                <td><?php echo $row['pid']; ?></td>
                                                <td>
                                                    <?php echo $row['sn']; ?><br>
                                                    <?php //echo $dep_tag; 
                                                    ?>
                                                </td>
                                                <td><?php echo $row['chq_no']; ?></td>
                                                <td><?php echo $row['chq_bank']; ?></td>
                                                <td><?php echo $row['chq_date']; ?><span class="badge bg-blue"><?php echo $date_diff; ?></span></td>
                                                <td><?php echo $row['supply_name']; ?></td>
                                                <td><?php echo $row['pamount']; ?></td>
                                                <?php if ($date_diff <= 0) { ?>
                                                    <td align="center"> <a href="#" id="<?php echo $row['pid']; ?>" unit="grn" class="iss_realize_btn btn btn-success" title="Click to Realize"> <i class="fa-solid fa-money-bill-transfer"></i></a></td>
                                                    <td align="center"> <a href="#" id="<?php echo $row['pid']; ?>" unit="grn" class="iss_return_btn btn btn-danger" title="Click to Return"> <i class="fa-solid fa-rotate-left"></i> </a></td>
                                                <?php } else { ?>
                                                    <td align="center" colspan="2"> <span class="badge bg-yellow">Pending</span> </td>

                                                <?php }
                                                $total += $row['pamount']; ?>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>

                                </table>
                                <h4>Total Rs <b><?php echo number_format($total, 2); ?></h4>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
    <!-- /.content-wrapper -->
    <?php include("dounbr.php"); ?>

    <div class="control-sidebar-bg"></div>
    </div>


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
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- bootstrap color picker -->
    <!-- Dark Theme Btn-->
    <script src="https://dev.colorbiz.org/ashen/cdn/main/dist/js/DarkTheme.js"></script>


    <script type="text/javascript">
        $(".dep_realize_btn").click(function() {
            var element = $(this);
            var id = element.attr("id");
            var info = 'type=dep_realize&id=' + id;

            $.ajax({
                type: "POST",
                url: "acc_bank_transfer_save.php",
                data: info,
                success: function(res) {
                    $('#re_' + res).animate({
                            backgroundColor: "#fbc7c7"
                        }, "fast")
                        .animate({
                            opacity: "hide"
                        }, "slow");
                }
            });

        });

        $(".iss_realize_btn").click(function() {
            var element = $(this);
            var id = element.attr("id");
            var unit = element.attr("unit");
            var info = 'type=iss_realize&id=' + id + '&unit=' + unit;
            console.log(info);
            $.ajax({
                type: "POST",
                url: "acc_bank_transfer_save.php",
                data: info,
                success: function(res) {
                    console.log(res);
                    $('#re_' + res).animate({
                            backgroundColor: "#fbc7c7"
                        }, "fast")
                        .animate({
                            opacity: "hide"
                        }, "slow");
                }
            });

        });

        $(".dep_return_btn").click(function() {
            var element = $(this);
            var id = element.attr("id");
            var info = 'type=dep_return&id=' + id;

            $.ajax({
                type: "POST",
                url: "acc_bank_transfer_save.php",
                data: info,
                success: function(res) {
                    $('#re_' + res).animate({
                            backgroundColor: "#fbc7c7"
                        }, "fast")
                        .animate({
                            opacity: "hide"
                        }, "slow");
                }
            });

        });

        $(".iss_return_btn").click(function() {
            var element = $(this);
            var id = element.attr("id");
            var unit = element.attr("unit");
            var info = 'type=iss_return&id=' + id + '&unit=' + unit;

            $.ajax({
                type: "POST",
                url: "acc_bank_transfer_save.php",
                data: info,
                success: function(res) {
                    console.log(res);
                    $('#re_' + res).animate({
                            backgroundColor: "#fbc7c7"
                        }, "fast")
                        .animate({
                            opacity: "hide"
                        }, "slow");
                }
            });

        });

        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
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


            //Date picker
            $('#datepicker1').datepicker({
                autoclose: true,
                datepicker: true,
                format: 'yyyy-mm-dd '
            });
            $('#datepicker').datepicker({
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