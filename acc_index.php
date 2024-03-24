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
    $_SESSION['SESS_DEPARTMENT'] = 'accounting';
    $_SESSION['SESS_FORM'] = 'acc_index';

    if ($r == 'lorry') {

        header("location:sales_start.php");
    }

    include_once("sidebar.php");



    ?>


    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Home
                <small>Preview</small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">



            <?php
            include('connect.php');
            date_default_timezone_set("Asia/Colombo");
            $cash = $_SESSION['SESS_FIRST_NAME'];

            $date = date("Y-m-d");

            ?>

            <div class="row">
                <div class="col-md-3">
                    <!-- Info Boxes Style 2 -->
                    <div class="info-box bg-yellow">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-signal"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Sales Value</span>
                            <span class="info-box-number">24,587<?php // echo $date; 
                                                                ?></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                            <span class="progress-description">
                                50% Increase in 30 Days
                            </span>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <div class="col-md-3">
                    <!-- /.info-box -->
                    <div class="info-box bg-green">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">New Customer</span>
                            <span class="info-box-number">12</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 20%"></div>
                            </div>
                            <span class="progress-description">
                                20% Increase in 30 Days
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- /.info-box -->
                    <div class="info-box bg-red">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-resize-small"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Credit Recovery</span>
                            <span class="info-box-number">114,381</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                                70% Increase in 30 Days
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- /.info-box -->
                    <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-signal"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Day Average</span>
                            <span class="info-box-number">163,921</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 20%"></div>
                            </div>
                            <span class="progress-description">
                                40% Increase in 30 Days
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <!-- /.info-box -->

            </div> <!-- /.box -->


            <div class="row">
                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Credit Collection</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="lineChart1" style="height: 250px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Credit Payment</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="lineChart2" style="height: 250px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>

        </section>
    </div>
    <!-- /.content -->

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
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../../plugins/morris/morris.min.js"></script>
    <!-- ChartJS -->
    <script src="../../plugins/chartjs/Chart.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Dark Theme Btn-->
    <script src="https://dev.colorbiz.org/ashen/cdn/main/dist/js/DarkTheme.js"></script>

    <script>
        <?php
        function getPayment($month, $para)
        {
            include('connect.php');
            date_default_timezone_set("Asia/Colombo");

            $d1 = date('Y-') . $month . '-01';
            $d2 = date('Y-') . $month . '-31';

            $value = 0;
            if ($para == 'credit') {
                $result = $db->prepare("SELECT SUM(amount) FROM `payment` WHERE `pay_type` = 'credit' AND `paycose` = 'invoice_payment' AND `date` BETWEEN '$d1' AND '$d2' ");
            } else 
            if ($para == 'credit_pay') {
                $result = $db->prepare("SELECT SUM(pay_amount) FROM `payment` WHERE `pay_type` = 'credit' AND `paycose` = 'invoice_payment' AND `date` BETWEEN '$d1' AND '$d2' ");
            } else 
            if ($para == 'payment') {
                $result = $db->prepare("SELECT SUM(amount) FROM `payment` WHERE `pay_type` = 'credit_payment' AND `paycose` = 'credit' AND `date` BETWEEN '$d1' AND '$d2' ");
            }
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                if ($para == 'credit_pay') {
                    $value = $row['SUM(pay_amount)'];
                } else {
                    $value = $row['SUM(amount)'];
                }
            }

            if ($value == null) {
                $value = 0;
            }

            return $value;
        }
        ?>
        $(function() {
            var lineChartData1 = {
                labels: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                ],
                datasets: [{
                        label: "Credit",
                        fillColor: "rgba(204, 0, 0, 1)",
                        strokeColor: "rgba(204, 0, 0, 1)",
                        pointColor: "rgba(204, 0, 0, 1)",
                        pointStrokeColor: "rgba(204, 0, 0, 1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(204, 0, 0, 1)",
                        data: [
                            <?php echo getPayment('01', 'credit') ?>,
                            <?php echo getPayment('02', 'credit') ?>,
                            <?php echo getPayment('03', 'credit') ?>,
                            <?php echo getPayment('04', 'credit') ?>,
                            <?php echo getPayment('05', 'credit') ?>,
                            <?php echo getPayment('06', 'credit') ?>,
                            <?php echo getPayment('07', 'credit') ?>,
                            <?php echo getPayment('08', 'credit') ?>,
                            <?php echo getPayment('09', 'credit') ?>,
                            <?php echo getPayment('10', 'credit') ?>,
                            <?php echo getPayment('11', 'credit') ?>,
                            <?php echo getPayment('12', 'credit') ?>
                        ],
                    },
                    {
                        label: "Collection",
                        fillColor: "rgba(255,153,0,1)",
                        strokeColor: "rgba(255,153,0,1)",
                        pointColor: "rgba(255,153,0,1)",
                        pointStrokeColor: "rgba(255,153,0,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(255,153,0,1)",
                        data: [
                            <?php echo getPayment('01', 'credit_pay') ?>,
                            <?php echo getPayment('02', 'credit_pay') ?>,
                            <?php echo getPayment('03', 'credit_pay') ?>,
                            <?php echo getPayment('04', 'credit_pay') ?>,
                            <?php echo getPayment('05', 'credit_pay') ?>,
                            <?php echo getPayment('06', 'credit_pay') ?>,
                            <?php echo getPayment('07', 'credit_pay') ?>,
                            <?php echo getPayment('08', 'credit_pay') ?>,
                            <?php echo getPayment('09', 'credit_pay') ?>,
                            <?php echo getPayment('10', 'credit_pay') ?>,
                            <?php echo getPayment('11', 'credit_pay') ?>,
                            <?php echo getPayment('12', 'credit_pay') ?>
                        ],
                    },
                ],
            };
            var lineChartData2 = {
                labels: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                ],
                datasets: [{
                        label: "Credit",
                        fillColor: "rgba(204, 0, 0, 1)",
                        strokeColor: "rgba(204, 0, 0, 1)",
                        pointColor: "rgba(204, 0, 0, 1)",
                        pointStrokeColor: "rgba(204, 0, 0, 1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(204, 0, 0, 1)",
                        data: [
                            <?php echo getPayment('01', 'credit') ?>,
                            <?php echo getPayment('02', 'credit') ?>,
                            <?php echo getPayment('03', 'credit') ?>,
                            <?php echo getPayment('04', 'credit') ?>,
                            <?php echo getPayment('05', 'credit') ?>,
                            <?php echo getPayment('06', 'credit') ?>,
                            <?php echo getPayment('07', 'credit') ?>,
                            <?php echo getPayment('08', 'credit') ?>,
                            <?php echo getPayment('09', 'credit') ?>,
                            <?php echo getPayment('10', 'credit') ?>,
                            <?php echo getPayment('11', 'credit') ?>,
                            <?php echo getPayment('12', 'credit') ?>
                        ],
                    },
                    {
                        label: "Payment",
                        fillColor: "rgba(0,102,255,1)",
                        strokeColor: "rgba(0,102,255,1)",
                        pointColor: "rgba(0,102,255,1)",
                        pointStrokeColor: "rgba(0,102,255,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(0,102,255,1)",
                        data: [
                            <?php echo getPayment('01', 'payment') ?>,
                            <?php echo getPayment('02', 'payment') ?>,
                            <?php echo getPayment('03', 'payment') ?>,
                            <?php echo getPayment('04', 'payment') ?>,
                            <?php echo getPayment('05', 'payment') ?>,
                            <?php echo getPayment('06', 'payment') ?>,
                            <?php echo getPayment('07', 'payment') ?>,
                            <?php echo getPayment('08', 'payment') ?>,
                            <?php echo getPayment('09', 'payment') ?>,
                            <?php echo getPayment('10', 'payment') ?>,
                            <?php echo getPayment('11', 'payment') ?>,
                            <?php echo getPayment('12', 'payment') ?>
                        ],
                    },
                ],
            };

            var lineChartOptions = {
                //Boolean - If we should show the scale at all
                showScale: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: false,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - Whether the line is curved between points
                bezierCurve: true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension: 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot: false,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill: false,
                //String - A legend template
                legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: true,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true,
            };

            //-------------
            //- LINE CHART -
            //--------------
            var lineChart1 = new Chart($("#lineChart1").get(0).getContext("2d"));
            lineChart1.Line(lineChartData1, lineChartOptions);

            var lineChart2 = new Chart($("#lineChart2").get(0).getContext("2d"));
            lineChart2.Line(lineChartData2, lineChartOptions);
        });
    </script>
</body>

</html>