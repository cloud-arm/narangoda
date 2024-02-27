<!DOCTYPE html>
<html>
<?php
include("head.php");
include("connect.php");
?>

<body class="hold-transition skin-yellow sidebar-mini sidebar-collapse">
  <?php
  include_once("auth.php");
  $r = $_SESSION['SESS_LAST_NAME'];
  $_SESSION['SESS_DEPARTMENT'] = 'sales_rp';

  if ($r == 'Cashier') {

    header("location:./../../../index.php");
  }
  if ($r == 'admin') {

    include_once("sidebar.php");
  }
  if ($r == 'com') {

    include_once("sidebar.php");
  }
  ?>



  <link rel="stylesheet" href="datepicker.css" type="text/css" media="all" />
  <script src="datepicker.js" type="text/javascript"></script>
  <script src="datepicker.ui.min.js" type="text/javascript"></script>



  <style>
    th {
      vertical-align: bottom;
      text-align: center;
    }

    th span {
      -ms-writing-mode: tb-rl;
      -webkit-writing-mode: vertical-rl;
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      white-space: nowrap;
    }
  </style>

  <!-- /.sidebar -->
  </aside>


  <div class="content-wrapper">

    <section class="content">
      <div class="box box-info">

        <div class="box-body">

          <form method="get">
            <div class="row">

              <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <label>Lorry</label>
                    </div>
                    <select class="form-control select2" name="lorry" autofocus>
                      <option value="all"> All Lorry </option>

                      <?php
                      $result = $db->prepare("SELECT * FROM lorry ORDER by lorry_id ASC ");
                      $result->bindParam(':userid', $res);
                      $result->execute();
                      for ($i = 0; $row = $result->fetch(); $i++) {
                      ?>
                        <option><?php echo $row['lorry_no']; ?> </option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>


              <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <label>Filter</label>
                    </div>
                    <select class="form-control select2" name="filter" class="form-control" id="p_type" onchange="view_payment_date(this.value);">
                      <option value="">ALL CUSTOMER</option>
                      <option value="group">Customer Group</option>
                      <option value="type">Customer Type</option>
                      <option value="cus">One Customer</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <label>From :</label>
                    </div>
                    <input type="text" class="form-control" name="d1" id="datepicker" value="<?php echo $_GET['d1']; ?>" autocomplete="off" />
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <label>To:</label>
                    </div>
                    <input type="text" class="form-control" name="d2" id="datepickerd" value="<?php echo $_GET['d2']; ?>" autocomplete="off" />
                  </div>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <label>products</label>
                    </div>
                    <select class="form-control select2" name="product" autofocus>
                      <option value="all"> All Customer </option>
                      <option value="1"> Gas </option>
                      <option value="2"> Cylinder </option>
                      <option value="3"> Accessory </option>

                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-3" id="cus_view" style="display:none;">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <label>customer</label>
                    </div>
                    <select class="form-control select2" name="cus" style="width: 100%;" autofocus>

                      <?php
                      $result = $db->prepare("SELECT * FROM customer ORDER by customer_id ASC ");
                      $result->bindParam(':userid', $res);
                      $result->execute();
                      for ($i = 0; $row = $result->fetch(); $i++) {
                      ?>
                        <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_id'] . "_" . $row['customer_name']; ?> </option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-3" id="group_view" style="display:none;">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <label>Group</label>
                    </div>
                    <select class="form-control select2" name="group" style="width: 100%;" autofocus>

                      <?php
                      $result = $db->prepare("SELECT * FROM customer_category ORDER by id ASC ");
                      $result->bindParam(':userid', $res);
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
              </div>

              <div class="col-md-3" id="type_view" style="display:none;">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <b>Customer Type</b>
                    </div>
                    <select class="form-control select2" name="customer_type" style="width: 100%;">
                      <option value="1">Channel</option>
                      <option value="2">commercial</option>
                      <option value="3">Apartment</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <button class="btn btn-info" style="padding: 6px 50px;" type="submit">
                    <i class="fa fa-search"></i> Search
                  </button>
                </div>
              </div>

            </div>

          </form>

        </div>
        <!-- /.box-body -->
      </div>

      <div class="box ">
        <div class="box-header">
          <h3 class="box-title">Sales Report
            <a href="sales_rp_print.php?filter=<?php echo $_GET['filter'] ?>&d1=<?php echo $_GET['d1'] ?>&d2=<?php echo $_GET['d2'] ?>&cus=<?php echo $_GET['cus'] ?>&lorry=<?php echo $_GET['lorry'] ?>&product=<?php echo $_GET['product'] ?>&customer_type=<?php echo $_GET['customer_type'] ?>" title="Click to Print">
              <button class="btn btn-danger">Print</button></a>
          </h3>
        </div>
        <!-- /.box-header -->

        <div class="box-body">
          <table id="" class="table table-bordered table-striped">

            <thead>

              <tr>
                <th colspan="2"></th>
                <th colspan="2">12.5kg</th>
                <th colspan="2">5kg</th>
                <th colspan="2">37.5kg</th>
                <th colspan="2">2kg</th>

                <?php $id = '6756';

                $d1 = $_GET['d1'];
                $d2 = $_GET['d2'];
                $lorry = $_GET['lorry'];
                $product = $_GET['product'];
                $filter = $_GET['filter'];

                $sql1 = " SELECT *  FROM sales_list JOIN products ON sales_list.product_id = products.product_id WHERE sales_list.loading_id=:id AND products.type='accessory' AND sales_list.action = 0 GROUP BY products.product_id ";
                $sql2 = " SELECT * , sales_list.qty as qty2  FROM sales_list JOIN products ON sales_list.product_id = products.product_id WHERE sales_list.loading_id=:id AND sales_list.action='0'  ORDER BY products.product_id ";
                $sql3 = " SELECT *  FROM sales WHERE loading_id=:id AND action='1' ";
                $sql4 = " SELECT * , sum(sales_list.qty)  FROM sales_list JOIN products ON sales_list.product_id = products.product_id WHERE sales_list.loading_id=:id AND sales_list.action = 0 GROUP BY products.product_id ";
                $sql5 = " SELECT * , sum(sales_list.qty)  FROM sales_list JOIN products ON sales_list.product_id = products.product_id WHERE sales_list.loading_id=:id AND sales_list.action = 0 AND products.type='accessory' GROUP BY products.product_id ";



                $ass_list = array();
                $result = $db->prepare($sql1);
                $result->bindParam(':id', $id);
                $result->execute();
                for ($i = 0; $row = $result->fetch(); $i++) {
                  array_push($ass_list, $row['product_id']);
                ?>
                  <th class="th"><span> <?php echo $row['gen_name']; ?></span></th>
                <?php } ?>

              </tr>

              <tr>
                <th>Invoice</th>
                <th>Customer</th>
                <th>N</th>
                <th>R</th>
                <th>N</th>
                <th>R</th>
                <th>N</th>
                <th>R</th>
                <th>N</th>
                <th>R</th>

                <?php
                foreach ($ass_list as $list) { ?>
                  <th></th>
                <?php } ?>

              <tr>

            </thead>

            <tbody>

              <?php
              $sales_list = array();
              $sales = array();
              $product = array();

              $result = $db->prepare($sql2);
              $result->bindParam(':id', $id);
              $result->execute();
              for ($i = 0; $row = $result->fetch(); $i++) {

                $data = array('invo' => $row['invoice_no'], 'pid' => $row['product_id'], 'qty' => $row['qty2']);

                array_push($sales_list, $data);
              }

              $result = $db->prepare("SELECT * FROM products  ORDER BY product_id  ");
              $result->bindParam(':id', $id);
              $result->execute();
              for ($i = 0; $row = $result->fetch(); $i++) {
                array_push($product, $row['product_id']);
              }

              $result = $db->prepare($sql3);
              $result->bindParam(':id', $id);
              $result->execute();
              for ($i = 0; $row = $result->fetch(); $i++) { //row
                $invo = $row['invoice_number'];
                $cus = $row['name'];
                $sales_id = $row['transaction_id'];

                $temp = array();

                $temp['invo'] =  $sales_id;
                $temp['cus'] =  $cus;

                foreach ($product as $p_id) { //colum
                  $temp[$p_id] = '';
                }

                foreach ($sales_list as $list) {

                  if ($list['invo'] == $invo) {

                    foreach ($product as $p_id) { //colum

                      if ($p_id == $list['pid']) {
                        if ($p_id > 4) {
                          $temp[$p_id] = "<span class='pull-right badge bg-muted'> " . $list['qty'] . "</span>";
                        } else {
                          $temp[$p_id] = "<span class='pull-right badge bg-yellow'> " . $list['qty'] . "</span>";
                        }
                      } else {
                      }
                    }
                  }
                }

                array_push($sales, $temp);
              }
              ?>

              <?php foreach ($sales as $list) { ?>

                <tr>

                  <td> <?php echo $list['invo']; ?> </td>
                  <td> <?php echo $list['cus']; ?> </td>

                  <td> <?php echo $list['5']; ?></td>
                  <td> <?php echo $list['1']; ?> </td>

                  <td> <?php echo $list['6']; ?></td>
                  <td><?php echo $list['2']; ?></td>

                  <td> <?php echo $list['7']; ?></td>
                  <td><?php echo $list['3']; ?></td>

                  <td> <?php echo $list['8']; ?> </td>
                  <td> <?php echo $list['4']; ?> </td>
                  <?php foreach ($ass_list as $ass) { ?>
                    <td> <?php echo $list[$ass]; ?>
                    </td>
                  <?php } ?>

                </tr>
              <?php } ?>
            </tbody>

            <?php
            $total = array();

            foreach ($product as $p_id) {
              $total[$p_id] = '';
            }

            $result = $db->prepare($sql4);
            $result->bindParam(':id', $id);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
              $total[$row['product_id']] = $row['sum(sales_list.qty)'];
            }
            ?>

            <tfoot class=" bg-black">
              <tr>
                <td colspan="2">Total</td>

                <td> <span class="pull-right badge bg-muted"> <?php echo $total['5']; ?> </span>
                </td>
                <td> <span class="pull-right badge bg-yellow"> <?php echo $total['1']; ?> </span>
                </td>
                <td> <span class="pull-right badge bg-muted"> <?php echo $total['6']; ?> </span>
                </td>
                <td> <span class="pull-right badge bg-yellow"> <?php echo $total['2']; ?> </span>
                </td>
                <td> <span class="pull-right badge bg-muted"> <?php echo $total['7']; ?> </span>
                </td>
                <td> <span class="pull-right badge bg-yellow"> <?php echo $total['3']; ?> </span>
                </td>
                <td> <span class="pull-right badge bg-muted"> <?php echo $total['8']; ?> </span>
                </td>
                <td> <span class="pull-right badge bg-yellow"> <?php echo $total['4']; ?> </span>
                </td>

                <?php
                foreach ($total as $i => $tot) {
                  if ($i > 9  && $tot > 0) { ?>
                    <td>
                      <span class="pull-right badge bg-muted">
                        <?php
                        echo $tot;
                        ?>
                      </span>
                    </td>

                <?php }
                } ?>

              </tr>

            </tfoot>

          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
  </div>
  <!-- /.col -->





  <!-- Main content -->

  <!-- /.row -->

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
  <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="../../plugins/select2/select2.full.min.js"></script>
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
  <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- page script -->
  <script>
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

      $(".select2").select2();

    });


    $('#datepicker').datepicker({
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

    function view_payment_date(type) {
      if (type == 'group') {
        document.getElementById('group_view').style.display = 'block';
        document.getElementById('type_view').style.display = 'none';
        document.getElementById('cus_view').style.display = 'none';
      } else if (type == 'type') {
        document.getElementById('type_view').style.display = 'block';
        document.getElementById('group_view').style.display = 'none';
        document.getElementById('cus_view').style.display = 'none';
      } else if (type == 'cus') {
        document.getElementById('type_view').style.display = 'none';
        document.getElementById('group_view').style.display = 'none';
        document.getElementById('cus_view').style.display = 'block';
      } else {
        document.getElementById('type_view').style.display = 'none';
        document.getElementById('group_view').style.display = 'none';
        document.getElementById('cus_view').style.display = 'none';
      }
    }
  </script>


</body>

</html>