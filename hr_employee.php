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
    $_SESSION['SESS_FORM'] = 'hr_employee';

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
                Employee
                <small>Preview</small>
            </h1>
        </section>
        <section class="content">


            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Employee Data</h3>
                    <small class="btn btn-info mx-2" style="padding: 5px 10px;" title="Add Employee" onclick="click_open(1)">Add Employee</small>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone NO</th>
                                <th>NIC</th>
                                <th>EPF</th>
                                <th>EPF No</th>
                                <th>Designation</th>
                                <th>Hour Rate</th>
                                <th>#</th>

                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $result = $db->prepare("SELECT * FROM employee   ");
                            $result->bindParam(':userid', $date);
                            $result->execute();
                            for ($i = 0; $row = $result->fetch(); $i++) {    ?>
                                <tr>
                                    <td><?php echo $id = $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $vehi = $row['phone_no']; ?></td>
                                    <td><?php echo $row['nic']; ?></td>
                                    <td>Rs.<?php echo $row['epf_amount']; ?></td>
                                    <td><?php echo $row['epf_no']; ?></td>
                                    <td><?php echo $row['des']; ?></td>
                                    <td>Rs.<?php echo $row['hour_rate']; ?></td>
                                    <td><a href="hr_employee_profile.php?id=<?php echo $id; ?>"><button class="btn btn-info"><i class="fa fa-user"></i></button></a></td>

                                </tr>
                            <?php  }  ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
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

    <div class="container-up d-none" id="container_up">
        <div class="container-close" onclick="click_close()"></div>
        <div class="row">
            <div class="col-md-6 with-scroll">

                <div class="box box-success popup d-none" id="popup_1">
                    <div class="box-header with-border">
                        <h3 class="box-title w-100">
                            New Employee Add
                            <i onclick="click_close()" class="btn p-0 me-2 pull-right fa fa-remove" style="font-size: 25px"></i>
                        </h3>
                    </div>

                    <div class="box-body d-block">
                        <form method="POST" action="hr_employee_save.php">

                            <div class="row" style="display: block;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input class="form-control" type="text" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone No</label>
                                        <input class="form-control" type="text" name="phone_no">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIC</label>
                                        <input class="form-control" type="text" name="nic">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input class="form-control" type="text" name="address">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hour Rate</label>
                                        <input class="form-control" type="text" name="rate">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <select class="form-control" onchange="des_select(this.options[this.selectedIndex].getAttribute('value'))" name="type">
                                            <?php
                                            $result = $db->prepare("SELECT * FROM employees_des ");
                                            $result->bindParam(':userid', $res);
                                            $result->execute();
                                            for ($i = 0; $row = $result->fetch(); $i++) {
                                            ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 drive_sec" style="display: block;">
                                    <div class="form-group">
                                        <label>Lorry No</label>
                                        <select class="form-control" name="lorry">
                                            <?php
                                            $result = $db->prepare("SELECT * FROM lorry ");
                                            $result->bindParam(':userid', $res);
                                            $result->execute();
                                            for ($i = 0; $row = $result->fetch(); $i++) {
                                            ?>
                                                <option value="<?php echo $row['lorry_id']; ?>"><?php echo $row['lorry_no']; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>EPF NO <span id="epf_err" style="color: #ff0000;display: none">* This number is duplicate !!</span></label>
                                        <input class="form-control" onkeyup="epf_get()" id="epf_txt" type="text" name="etf_no">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>EPF Amount</label>
                                        <input class="form-control" type="text" name="etf_amount">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>OT</label>

                                        <select class="form-control" name="ot" id="">
                                            <option value="1">Eligible</option>
                                            <option value="2">Not Eligible</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Welfare Amount</label>
                                        <input class="form-control" type="text" name="well_amount">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="emp_save" type="submit" style="margin-top: 23px;" value="Save" class="btn btn-info w-100">
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

        function des_select(id) {
            if (id == 1) {
                $('.drive_sec').css('display', 'block');
            } else {
                $('.drive_sec').css('display', 'none');
            }
        }
    </script>

    <script>
        function epf_get() {

            var val = document.getElementById('epf_txt').value;


            fetch("hr_epf_get.php?id=" + val)
                .then((response) => response.json())
                .then((json) => console.log(json));

            var info = 'id=' + val;
            $.ajax({
                type: "GET",
                url: "hr_epf_get.php",
                data: info,
                success: function(resp) {
                    if (resp == '1') {
                        document.getElementById("epf_err").style.display = "inline";
                        document.getElementById("emp_save").setAttribute("disabled", "");
                    }
                    if (!resp) {
                        document.getElementById("epf_err").style.display = "none";
                        document.getElementById("emp_save").removeAttribute("disabled");
                    }
                }
            });


        }

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
</body>

</html>