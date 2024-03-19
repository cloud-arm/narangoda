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
  $_SESSION['SESS_DEPARTMENT'] = 'hr';
  $_SESSION['SESS_FORM'] = 'hr_index';

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
        <div class="pull-right hidden" style="margin-right: 25px;">
          <span style="font-size:15px;"><i class="fa fa-circle text-yellow"></i> Driver</span>
          <span style="font-size:15px;"><i class="fa fa-circle text-green"></i> Helper</span>
        </div>
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

      <div class="row hidden">
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
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow">
              <div class="info-box-img">
                <img src="<?php //echo $driver_pic; 
                          ?>" alt="">
              </div>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Driver</span>
              <span class="info-box-number" style="margin-top: 10px;"><?php echo '$driver'; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.info-box -->

      </div> <!-- /.box -->

      <div class="row">
        <?php
        $result = $db->prepare("SELECT  * FROM employee ORDER BY des_id  ");
        $result->bindParam(':id', $date);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
          $cl1 = 'bg-gray';
          $id = $row['id'];
          $res = $db->prepare("SELECT  * FROM attendance WHERE emp_id=:id AND date = '$date' ");
          $res->bindParam(':id', $id);
          $res->execute();
          for ($i = 0; $ro = $res->fetch(); $i++) {
            $cl1 = 'bg-teal';
            if ($row['des_id'] == 1) {
              $cl1 = 'bg-yellow';
            }
            if ($row['des_id'] == 2) {
              $cl1 = 'bg-olive';
            }
            if ($row['des_id'] == 3) {
              $cl1 = 'bg-maroon';
            }
            if ($row['des_id'] == 4) {
              $cl1 = 'bg-blue';
            }
          }
        ?>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box <?php echo $cl1; ?>">
              <span class="info-box-icon">
                <?php if ($row['pic'] != '') { ?>
                  <div class="info-box-img">
                    <img src="<?php echo $row['pic']; ?>" alt="">
                  </div>
                <?php } else { ?>
                  <i class="glyphicon glyphicon-user" style="color:rgb(var(--bg-light-100))"></i>
                <?php } ?>
              </span>

              <div class="info-box-content">
                <span class="info-box-text" style="font-size: 12px; text-align: end; padding-right: 5px;"><?php echo ucfirst($row['des']) ?></span>
                <span class="info-box-number" style="font-size: 20px;"><?php echo ucfirst($row['username']); ?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 0"></div>
                </div>
                <span class="progress-description">
                  <?php echo $row['phone_no']; ?>
                </span>
              </div>
            </div>
          </div>
        <?php } ?>
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
  <!-- FastClick -->
  <script src="../../plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <!-- Dark Theme Btn-->
  <script src="https://dev.colorbiz.org/ashen/cdn/main/dist/js/DarkTheme.js"></script>
  <!-- page script -->


</body>

</html>