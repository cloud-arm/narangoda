<!DOCTYPE html>
<html>
<?php
include("head.php");
include("connect.php");
date_default_timezone_set("Asia/Colombo");
?>

<body class="hold-transition skin-yellow sidebar-mini">
  <?php
  include_once("auth.php");
  $r = $_SESSION['SESS_LAST_NAME'];
  $_SESSION['SESS_FORM'] = 'expenses';

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
        Expenses
        <small>Preview</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-6 model_add_1" style="display: none;">
          <div class="box box-primary model_add_1">
            <div class="box-header with-border">
              <h3 class="box-title">New Utility Type</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" onclick="model_cl(1)" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">

              <form method="POST" action="expenses_save.php">

                <div class="row" style="display: flex; align-items: end;">
                  <div class="col-md-9">
                    <div class="form-group">
                      <label>Utility Name</label>
                      <input type="text" name="util_name" value="" class="form-control" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="hidden" name="unit" value="2">
                      <input type="submit" value="Save" class="btn btn-info">
                    </div>
                  </div>
                </div>

              </form>

            </div>
          </div>
        </div>

        <div class="col-md-6 model_add_2" style="display: none;">
          <div class="box box-primary model_add_2">
            <div class="box-header with-border">
              <h3 class="box-title">New Expenses Type</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" onclick="model_cl(2)" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">

              <form method="POST" action="expenses_save.php">

                <div class="row" style="display: flex; align-items: end;">
                  <div class="col-md-9">
                    <div class="form-group">
                      <label>Expenses Type</label>
                      <input type="text" name="type" value="" class="form-control" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="hidden" name="unit" value="3">
                      <input type="submit" value="Save" class="btn btn-info">
                    </div>
                  </div>
                </div>

              </form>

            </div>
          </div>
        </div>


        <div class="col-md-12 model_add_3" style="display: none;">
          <div class="box box-primary model_add_3">
            <div class="box-header with-border">
              <h3 class="box-title">New Meter Reading Bill</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" onclick="model_cl(3)" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">

              <form method="POST" action="expenses_save.php">

                <div class="row" style="display: flex; align-items: end;">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Utility Name</label>
                      <input type="text" name="util_name" value="" class="form-control" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Last Meter</label>
                      <input type="text" name="last_meter" value="" class="form-control" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Unit Price</label>
                      <input type="number" name="unit_price" value="" class="form-control" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="hidden" name="unit" value="4">
                      <input type="submit" value="Save" class="btn btn-info">
                    </div>
                  </div>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Expenses
            <span class="btn btn-success" id="model_btn_1" onclick="model_btn(1)" style="margin: 10px 20px;">Add Utility Bill</span>
            <span class="btn btn-success" id="model_btn_2" onclick="model_btn(2)" style="margin: 10px 20px;">Add Expenses Type</span>
            <span class="btn btn-success hidden" id="model_btn_3" onclick="model_btn(3)" style="margin: 10px 20px;">Add Meter Reading Utility Bill</span>
          </h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body d-block">
          <form method="post" action="expenses_save.php">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Date</label>
                  <input type="text" id="datepicker_set" value="<?php echo date('Y-m-d') ?>" name="date" class="form-control" tabindex="9" autocomplete="off">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Expenses Type</label>
                  <select class="form-control" name="type" style="width: 100%;" id="ex_type" onchange="select_type()" tabindex="1">

                    <?php
                    $result = $db->prepare("SELECT * FROM expenses_types ");
                    $result->bindParam(':userid', $ttr);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $id = $row['sn']; ?>"> <?php echo $row['type_name']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>

                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Pay Type</label>
                  <select class="form-control " id="pay_type" name="pay_type" onchange="select_pay()" style="width: 100%;" tabindex="2">
                    <option value="cash"> Cash </option>
                    <option value="chq"> Chq </option>
                    <option value="bank" disabled> Bank </option>
                  </select>
                </div>
              </div>

              <div class="col-md-3" id="acc_sec">
                <div class="form-group">
                  <label>Account</label>
                  <select class="form-control " name="acc" style="width: 100%;" tabindex="3">
                    <?php
                    $result = $db->prepare("SELECT * FROM cash ");
                    $result->bindParam(':userid', $ttr);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $id = $row['id']; ?>" <?php if ($id == 1) { ?> selected <?php } ?>> <?php echo $row['name']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-md-3 bank_sec" style="display: none;">
                <div class="form-group">
                  <label>Account</label>
                  <select class="form-control " name="bank" style="width: 100%;" tabindex="4">

                    <?php
                    $result = $db->prepare("SELECT * FROM bank_balance ");
                    $result->bindParam(':userid', $ttr);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $id = $row['id']; ?>" <?php if ($id == 1) { ?> selected <?php } ?>> <?php echo $row['name'] . '__' . $row['dep_name']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>

                </div>
              </div>

              <div class="col-md-3 bank_sec" style="display: none;">
                <div class="form-group">
                  <label>Chq No:</label>
                  <input type="text" name="chq_no" class="form-control" tabindex="5" autocomplete="off">
                </div>
              </div>

              <div class="col-md-3 bank_sec" style="display: none;">
                <div class="form-group">
                  <label>Chq Date</label>
                  <input type="text" name="chq_date" id="datepicker" class="form-control" tabindex="6" autocomplete="off">
                </div>
              </div>

              <div class="col-md-3 util_sec" style="display: block;">
                <div class="form-group">
                  <label>Utility Bill</label> <span id="blc" class="badge bg-red"></span>
                  <select class="form-control select2" name="util_id" style="width: 100%;" tabindex="8" onchange="select_bill(this.options[this.selectedIndex].getAttribute('balance'))">
                    <option value="0" balance=""></option>
                    <?php
                    $result = $db->prepare("SELECT * FROM utility_bill  ");
                    $result->bindParam(':userid', $ttr);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $row['id']; ?>" balance="<?php echo $row['credit']; ?>"> <?php echo $row['name']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>

                </div>
              </div>

              <div class="col-md-3 util_sec" style="display: block;">
                <div class="form-group">
                  <label>Utility Date</label>
                  <input type="text" id="datepickerd" name="util_date" class="form-control" tabindex="9" autocomplete="off">
                </div>
              </div>

              <div class="col-md-3 util_sec" style="display: block;">
                <div class="form-group">
                  <label>Invoice No:</label>
                  <input type="text" name="util_invo" class="form-control" tabindex="10" autocomplete="off">
                </div>
              </div>

              <div class="col-md-3 util_sec" style="display: block;">
                <div class="form-group">
                  <label>Bill Amount</label>
                  <input type="text" name="Util_amount" step=".01" class="form-control" tabindex="11" autocomplete="off">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Pay Amount</label>
                  <input type="text" name="pay_amount" step=".01" class="form-control" tabindex="12" autocomplete="off">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Comment</label>
                  <input type="text" value='' name="comment" class="form-control" tabindex="13" autocomplete="off">
                </div>
              </div>

              <div class="col-md-1 pe-2 me-2" style="height: 70px;display: flex;align-items: end;" id="btn_sub">
                <div class="form-group">
                  <input class="btn btn-info" type="submit" value="Submit">
                  <input name="unit" type="hidden" value="1">
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
    </section>


    <!-- /.box -->

    <section class="content">

      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Expenses List</h3>
        </div>

        <form action="" method="POST">
          <div class="row" style="margin-top: 20px;display: flex;align-items: center;">
            <div class="col-lg-3"></div>
            <div class="col-md-2">
              <div class="form-group">
                <select class="form-control " name="year" style="width: 100%;" tabindex="1">
                  <option> <?php echo date('Y') - 1 ?> </option>
                  <option selected> <?php echo date('Y') ?> </option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <select class="form-control " name="month" style="width: 100%;" tabindex="1">
                  <?php for ($x = 1; $x <= 12; $x++) {
                    $mo = sprintf("%02d", $x); ?>
                    <option <?php if (isset($_POST['year'])) {
                              if ($mo == $_GET['month']) {
                                echo 'selected';
                              }
                            } else {
                              if ($mo == date('m')) {
                                echo 'selected';
                              }
                            } ?>> <?php echo $mo; ?> </option>
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

        <?php
        include("connect.php");
        date_default_timezone_set("Asia/Colombo");

        $d1 = date('Y') . '-' . date('m') . '-01';
        $d2 = date('Y') . '-' . date('m') . '-31';

        if (isset($_POST['year'])) {

          $d1 = $_POST['year'] . '-' . $_POST['month'] . '-01';
          $d2 = $_POST['year'] . '-' . $_POST['month'] . '-31';
        }

        $sql = " SELECT * FROM expenses_records  WHERE  date BETWEEN '$d1' AND '$d2' ";


        ?>

        <div class="box-body d-block">
          <table id="example" class="table table-bordered " style="border-radius: 0;">
            <thead>
              <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Type</th>
                <th>Comment</th>
                <th>Pay Type</th>
                <th>Chq No</th>
                <th>Chq Date</th>
                <th>Amount (Rs.)</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody>

              <?php $tot = 0;
              $result = $db->prepare($sql);
              $result->bindParam(':userid', $date);
              $result->execute();
              for ($i = 0; $row = $result->fetch(); $i++) {
                $dll = $row['dll'];
                $type = $row['type_id'];
                if ($dll == 1) {
                  $style = 'opacity: 0.5;cursor: default;';
                } else {
                  $style = '';
                }
              ?>

                <tr class="record" style="<?php echo $style; ?>">
                  <td><?php echo $row['id'];   ?> </td>
                  <td><?php echo $row['date'];   ?> </td>
                  <td><?php if ($row['util_id'] > 0) {
                        echo $row['util_name'];
                      } else {
                        echo $row['type'];
                      }  ?> </td>
                  <td><?php echo $row['comment'];   ?></td>
                  <td><?php echo $row['pay_type'];   ?></td>
                  <td><?php echo $row['chq_no'];   ?></td>
                  <td><?php echo $row['chq_date'];   ?></td>
                  <td>Rs.<?php echo $row['amount'];
                          $tot += $row['amount'];  ?></td>
                  <td> <?php if ($dll == 0) { ?> <a href="#" id="<?php echo $row['id']; ?>" class="delbutton btn btn-danger" title="Click to Delete">
                        <i class="icon-trash">x</i></a><?php } ?>
                  </td>
                </tr>
              <?php }   ?>
            </tbody>
          </table>
          <h4>Total: <small class="ms-2">Rs.</small><?php echo number_format($tot, 2); ?> </h4>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <?php include("dounbr.php"); ?>

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
    function select_bill(val) {
      $('#blc').text(val);
      if (val == '') {
        $('#btn').attr('disabled', '');
      } else {
        $('#btn').removeAttr('disabled');
      }
    }

    function model_btn(i) {
      $('#model_btn_' + i).css('display', 'none');
      $('.model_add_' + i).css('display', 'block');
    }

    function model_cl(i) {
      $('#model_add_' + i).css('display', 'none');
      $('#model_btn_' + i).css('display', 'inline-block');
    }

    function select_pay() {
      let val = $('#pay_type').val();

      if (val == 'cash') {
        $('#acc_sec').css('display', 'block');
      } else {
        $('#acc_sec').css('display', 'none');
      }
      if (val == 'chq') {
        $('.bank_sec').css('display', 'block');
      } else {
        $('.bank_sec').css('display', 'none');
      }

    }

    function select_type() {
      let val = $('#ex_type').val();

      if (val == 1) {
        $('.util_sec').css('display', 'block');
      } else {
        $('.util_sec').css('display', 'none');
      }
    }

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
            url: "expenses_dll.php",
            data: info,
            success: function() {}
          });
          $(this).parents(".record").css({
            'opacity': '0.5',
            'cursor': 'default'
          })
          $(this).remove();

        }

        return false;

      });

    });



    $(function() {
      $("#example1").DataTable();
      $('#example').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": true
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