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

  <style>
    .d-none {
      display: none !important;
    }

    .mx-2 {
      margin-left: 10px;
      margin-right: 10px;
    }

    .w-100 {
      width: 100%;
    }

    .fa-remove {
      font-size: 20px !important;
      padding: 0;
    }

    .container-up {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      width: 100%;
      background-color: rgb(0, 0, 0, 0.3);
    }

    .container-up .container-close {
      position: absolute;
      width: 100%;
      height: 100%;
    }

    .container-up .box {
      padding: 7px 15px;
    }
  </style>

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

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Expenses</h3>
          <small class="btn btn-success mx-2" style="padding: 5px 10px;" title="Add Expenses Type" onclick="click_open(1)">Add Expenses Type</small>
          <small class="btn btn-success mx-2 util_sec" style="padding: 5px 10px;" title="Add Utility Bill" onclick="click_open(2)">Add Utility Bill</small>
          <small class="btn btn-success mx-2 load_sec" style="display: none;padding: 5px 10px;" title="Add Root Expenses Sub Type" onclick="click_open(3)">Add Root Expenses</small>
          <small class="btn btn-success mx-2 pur_sec" style="display: none;padding: 5px 10px;" title="Add Purchase Expenses Sub Type" onclick="click_open(4)">Add Purchase Expenses</small>
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
                  <select class="form-control select2" name="type" style="width: 100%;" id="ex_type" onchange="select_type()" tabindex="1">

                    <?php
                    $result = $db->prepare("SELECT * FROM expenses_types ");
                    $result->bindParam(':id', $ttr);
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
                  <select class="form-control select2 hidden-search" id="pay_type" name="pay_type" onchange="select_pay()" style="width: 100%;" tabindex="2">
                    <option id="pay_cash" value="cash"> Cash </option>
                    <option id="pay_chq" value="chq"> Chq </option>
                    <option value="bank" disabled> Bank </option>
                  </select>
                </div>
              </div>

              <div class="col-md-3" id="acc_sec">
                <div class="form-group">
                  <label>Account</label>
                  <select class="form-control select2 hidden-search" name="acc" style="width: 100%;" tabindex="3">
                    <?php
                    $result = $db->prepare("SELECT * FROM cash ");
                    $result->bindParam(':id', $ttr);
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
                  <select class="form-control select2 hidden-search" name="bank" style="width: 100%;" tabindex="4">

                    <?php
                    $result = $db->prepare("SELECT * FROM bank_balance ");
                    $result->bindParam(':id', $ttr);
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

              <div class="col-md-3 load_sec" style="display: none;">
                <div class="form-group">
                  <label>Loading ID</label>
                  <select class="form-control select2" name="load_id" style="width: 100%;" tabindex="8">
                    <option value="0" disabled selected></option>
                    <?php
                    $result = $db->prepare("SELECT * FROM loading WHERE  action='load'  ");
                    $result->bindParam(':id', $res);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $row['transaction_id']; ?>"><?php echo $row['lorry_no']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>

                </div>
              </div>

              <div class="col-md-3 pur_sec" style="display: none;">
                <div class="form-group">
                  <label>Lorry No</label>
                  <select class="form-control select2" name="lorry" style="width: 100%;" tabindex="8">
                    <option value="0" disabled selected></option>
                    <?php
                    $result = $db->prepare("SELECT * FROM lorry  WHERE type = '0' ");
                    $result->bindParam(':id', $res);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $row['lorry_id']; ?>"><?php echo $row['lorry_no']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>

                </div>
              </div>

              <div class="col-md-3 load_sec" style="display: none;">
                <div class="form-group">
                  <label>Sub Type</label>
                  <select class="form-control select2" name="sub_type" id="load_sec" style="width: 100%;" tabindex="8">
                    <option value="0" disabled selected></option>
                    <?php
                    $result = $db->prepare("SELECT * FROM expenses_sub_type WHERE type_id = 2 ");
                    $result->bindParam(':id', $res);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>

                </div>
              </div>

              <div class="col-md-3 pur_sec" style="display: none;">
                <div class="form-group">
                  <label>Sub Type</label>
                  <select class="form-control select2" name="sub_type" id="pur_sec" style="width: 100%;" tabindex="8">
                    <option value="0" disabled selected></option>
                    <?php
                    $result = $db->prepare("SELECT * FROM expenses_sub_type WHERE type_id = 3 ");
                    $result->bindParam(':id', $res);
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> </option>
                    <?php
                    }
                    ?>
                  </select>

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
                  <input type="text" name="util_amount" step=".01" class="form-control" tabindex="11" autocomplete="off">
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
                <select class="form-control select2 hidden-search" name="year" style="width: 100%;" tabindex="1">
                  <option> <?php echo date('Y') - 1 ?> </option>
                  <option selected> <?php echo date('Y') ?> </option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <select class="form-control select2 hidden-search " name="month" style="width: 100%;" tabindex="1">
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
                <th>Chq Details</th>
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
                  <td>
                    <?php if ($row['util_id'] > 0) {
                      echo $row['util_name'];
                    } else if ($row['sub_type'] > 0) {
                      echo $row['sub_type_name'];
                    } else {
                      echo $row['type'];
                    }  ?>
                    <?php if ($type == 2) { ?> <br> <span class="badge bg-blue">Loading ID: <?php echo $row['loading_id']; ?> </span> <br> <span class="badge bg-green"><?php echo $row['lorry_no']; ?> </span> <?php } ?>
                    <?php if ($type == 3) { ?> <br> <span class="badge bg-green"><?php echo $row['lorry_no']; ?> </span> <?php } ?>
                  </td>
                  <td>
                    <?php if ($type == 1) { ?> <span class="badge bg-blue"> Utility </span> <br> <?php } else 
                     if ($type == 2) { ?> <span class="badge bg-green"> Root </span> <br> <?php } else  
                     if ($type == 3) { ?> <span class="badge bg-yellow"> Purchase </span> <br> <?php } else {  ?> <span class="badge bg-red"> Expenses </span> <br> <?php } ?>
                    <?php echo $row['comment'];   ?>
                  </td>
                  <td><?php echo $row['pay_type'];   ?></td>
                  <td>
                    NO: <span class="badge bg-blue"><?php echo $row['chq_no']; ?> </span> <br>
                    Date: <span class="badge bg-green"><?php echo $row['chq_date']; ?> </span> <br>
                  </td>
                  <td>Rs.<?php echo $row['amount'];
                          $tot += $row['amount'];  ?> <br>
                    <?php if ($type == 1) { ?>Balance: <?php echo $row['util_balance']; ?> <br> <?php } ?>
                  <?php if ($type == 1) { ?>Forward Balance: <?php echo $row['util_forward_balance']; ?> <?php } ?>
                  </td>
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

  <div class="container-up d-none" id="container_up">
    <div class="container-close" onclick="click_close()"></div>
    <div class="row">
      <div class="col-md-12">

        <div class="box box-success popup d-none" id="popup_1" style="width: 450px;">
          <div class="box-header with-border">
            <h3 class="box-title w-100">
              New Expenses Type
              <i onclick="click_close()" class="btn p-0 me-2 pull-right fa fa-remove" style="font-size: 25px"></i>
            </h3>
          </div>

          <div class="box-body d-block">
            <form method="POST" action="expenses_save.php">

              <div class="row" style="display: block;">
                <div class="col-md-9">
                  <div class="form-group">
                    <label>Expenses Type</label>
                    <input type="text" name="type" value="" class="form-control" autocomplete="off">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <input type="hidden" name="unit" value="3">
                    <input type="submit" style="margin-top: 23px;" value="Save" class="btn btn-info">
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>

        <div class="box box-success popup d-none" id="popup_2" style="width: 450px;">
          <div class="box-header with-border">
            <h3 class="box-title w-100">
              New Utility Type
              <i onclick="click_close()" class="btn p-0 me-2 pull-right fa fa-remove" style="font-size: 25px"></i>
            </h3>
          </div>

          <div class="box-body d-block">
            <form method="POST" action="expenses_save.php">

              <div class="row" style="display: block;">
                <div class="col-md-9">
                  <div class="form-group">
                    <label>Utility Name</label>
                    <input type="text" name="util_name" value="" class="form-control" autocomplete="off">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <input type="hidden" name="unit" value="2">
                    <input type="submit" style="margin-top: 23px;" value="Save" class="btn btn-info">
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>

        <div class="box box-success popup d-none" id="popup_3" style="width: 450px;">
          <div class="box-header with-border">
            <h3 class="box-title w-100">
              New Root Expenses Sub Type
              <i onclick="click_close()" class="btn p-0 me-2 pull-right fa fa-remove" style="font-size: 25px"></i>
            </h3>
          </div>

          <div class="box-body d-block">
            <form method="POST" action="expenses_save.php">

              <div class="row" style="display: block;">
                <div class="col-md-9">
                  <div class="form-group">
                    <label>Sub Type Name</label>
                    <input type="text" name="name" value="" class="form-control" autocomplete="off">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <input type="hidden" name="unit" value="4">
                    <input type="hidden" name="typeid" value="2">
                    <input type="submit" style="margin-top: 23px;" value="Save" class="btn btn-info">
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>

        <div class="box box-success popup d-none" id="popup_4" style="width: 450px;">
          <div class="box-header with-border">
            <h3 class="box-title w-100">
              New Purchase Expenses Sub Type
              <i onclick="click_close()" class="btn p-0 me-2 pull-right fa fa-remove" style="font-size: 25px"></i>
            </h3>
          </div>

          <div class="box-body d-block">
            <form method="POST" action="expenses_save.php">

              <div class="row" style="display: block;">
                <div class="col-md-9">
                  <div class="form-group">
                    <label>Sub Type Name</label>
                    <input type="text" name="name" value="" class="form-control" autocomplete="off">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <input type="hidden" name="unit" value="4">
                    <input type="hidden" name="typeid" value="3">
                    <input type="submit" style="margin-top: 23px;" value="Save" class="btn btn-info">
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

  <script>
    function click_open(i) {
      $("#popup_" + i).removeClass("d-none");
      $("#container_up").removeClass("d-none");
    }

    function click_close() {
      $(".popup").addClass("d-none");
      $("#container_up").addClass("d-none");
    }
  </script>

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
        $('.util_sec.btn').css('display', 'inline-block');
        $('.load_sec').css('display', 'none');
        $('.pur_sec').css('display', 'none');
      } else
      if (val == 2) {
        $('.util_sec').css('display', 'none');
        $('.pur_sec').css('display', 'none');
        $('.load_sec').css('display', 'block');
        $('.load_sec.btn').css('display', 'inline-block');
        $('#pay_chq').attr('disabled', '');
        $('#load_sec').removeAttr('disabled');
        $('#pur_sec').attr('disabled', '');
      } else
      if (val == 3) {
        $('.util_sec').css('display', 'none');
        $('.load_sec').css('display', 'none');
        $('.pur_sec').css('display', 'block');
        $('.pur_sec.btn').css('display', 'inline-block');
        $('#pay_chq').attr('disabled', '');
        $('#pur_sec').removeAttr('disabled');
        $('#load_sec').attr('disabled', '');
      } else {
        $('.util_sec').css('display', 'none');
        $('.load_sec').css('display', 'none');
        $('.pur_sec').css('display', 'none');
        $('#pay_chq').removeAttr('disabled');
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
      $('.select2.hidden-search').select2({
        minimumResultsForSearch: -1
      });

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