<div class="wrapper" style="overflow-y: hidden;">
  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>arm</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><i class="fa fa-cloud"></i><b>CLOUD ARM</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <?php
      include('connect.php');
      date_default_timezone_set("Asia/Colombo");

      $date =  date("Y-m-d");
      $dep = $_SESSION['SESS_DEPARTMENT'];
      $f = $_SESSION['SESS_FORM'];
      ?>
      <div class="navbar-menu">
        <ul class="nav navbar-nav">
          <li class="<?php if ($dep == 'logistic') {
                        echo 'open';
                      } ?>">
            <a href="index.php">Logistic</a>
          </li>
          <li class="<?php if ($dep == 'hr') {
                        echo 'open';
                      } ?>">
            <a href="hr_index.php">HR</a>
          </li>
          <li class="<?php if ($dep == 'accounting') {
                        echo 'open';
                      } ?>">
            <a href="acc_index.php">Accounting</a>
          </li>
          <li class="<?php if ($dep == 'management') {
                        echo 'open';
                      } ?>">
            <a href="manage_index.php">Management</a>
          </li>
        </ul>
      </div>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <?php
          $uname = $_SESSION['SESS_MEMBER_ID'];
          $result1 = $db->prepare("SELECT * FROM user WHERE id='$uname' ");
          $result1->bindParam(':userid', $res);
          $result1->execute();
          for ($i = 0; $row1 = $result1->fetch(); $i++) {
            $upic1 = $row1['upic'];
          }

          ?>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $upic1; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['SESS_FIRST_NAME']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $upic1; ?>" class="img-circle" alt="User Image">

                <p> <?php echo $_SESSION['SESS_FIRST_NAME']; ?> - <?php echo $_SESSION['SESS_LAST_NAME']; ?>
                  <small>Member -2020</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href=" ../../../index.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

      <div class="navbar-search">
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="" id="search-txt" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form>
      </div>
    </nav>
  </header>



  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>



        <!-- <span class="pull-right-container">
          <i class="fa fa-spinner fa-spin pull-right"></i>
        </span> -->


        <!-- -------------------- Logistic Section ----------------------- -->
        <?php if ($dep == 'logistic') { ?>

          <li class="<?php if ($f == 'index') {
                        echo 'active';
                      } ?>">
            <a href="index.php">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

          <li class="<?php if ($f == 'map') {
                        echo 'active';
                      } ?>">
            <a href="map.php">
              <i class="fa fa-solid fa-map-location-dot"></i> <span>MAP</span>
            </a>
          </li>

          <?php $co = '';
          if ($f == 'loading' || $f == 'unloading' || $f == 'empty_loading' || $f == 'loading_view' || $f == 'lorry_sales_view') {
            $co = 'active';
          } ?>

          <li class="treeview <?php echo $co; ?>">
            <a href="#">
              <i class="fa fa-truck"></i>
              <span>Loading</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <ul class="treeview-menu">

              <li class="<?php if ($f == 'loading') {
                            echo 'active';
                          } ?>"><a href="loading.php"><i class="fa fa-circle-o text-aqua "></i> New Loading</a></li>

              <li class="hidden <?php if ($f == 'empty_loading') {
                                  echo 'active';
                                } ?>"><a href="empty_loading.php"><i class="fa fa-circle-o text-aqua "></i> Empty Loading</a></li>

              <li class="<?php if ($f == 'unloading') {
                            echo 'active';
                          } ?>"><a href="unloading.php"><i class="fa fa-circle-o text-aqua "></i> Unloading</a></li>

              <li class="<?php if ($f == 'loading_view') {
                            echo 'active';
                          } ?>"><a href="loading_view.php?id=0"><i class="fa fa-circle-o text-aqua "></i> View Loading</a></li>

              <li class="<?php if ($f == 'lorry_sales_view') {
                            echo 'active';
                          } ?>"><a href="lorry_sales_view.php?d1=<?php echo $date; ?>&lorry=0"><i class="fa fa-circle-o text-aqua "></i> View Lorry Sales</a></li>

            </ul>
          </li>

          <li class="<?php if ($f == 'grn') {
                        echo 'active';
                      } ?>">
            <a href="grn.php?id=<?php echo date("ymdhis"); ?>">
              <i class="fa fa-cubes"></i> <span>Purchases</span>
            </a>
          </li>




        <?php } ?>




        <!-- -------------------- HR Section ----------------------- -->

        <?php if ($dep == 'hr') { ?>

          <li class="<?php if ($f == 'hr_index') {
                        echo 'active';
                      } ?>">
            <a href="hr_index.php">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

          <?php $co = '';
          $co0 = '';
          $dis = 'none';
          if ($f == 'hr_employee' || $f == 'hr_attendance' || $f == 'hr_allowances' || $f == 'hr_salary_advance' || $f == 'hr_payroll' || $f == 'hr_pay_out' || $f == 'hr_salary_rp' || $f == 'hr_epf_rp' || $f == 'hr_etf_rp') {
            $co = 'active';
            $co0 = 'menu-open';
            $dis = 'block';
          } ?>


          <li class="<?php if ($f == 'hr_employee') {
                        echo 'active';
                      } ?>"><a href="hr_employee.php"><i class="fa fa-user"></i> <span>Employee</span> </a></li>
          <li class="<?php if ($f == 'hr_attendance') {
                        echo 'active';
                      } ?>"><a href="hr_attendance.php"><i class="fa  fa-500px"></i> <span>Attendance</span> </a></li>
          <!-- <li class="<?php if ($f == 'hr_allowances') {
                            echo 'active';
                          } ?>"><a href="hr_allowances.php"><i class="fa fa-star-o"></i>Allowances</a></li> -->
          <li class="<?php if ($f == 'hr_salary_advance') {
                        echo 'active';
                      } ?>"><a href="hr_salary_advance.php"><i class="fa fa-money"></i> <span>Advance</span> </a></li>
          <li class="<?php if ($f == 'hr_payroll') {
                        echo 'active';
                      } ?>"><a href="hr_payroll.php"><i class="fa fa-list-alt "></i> <span>Payroll</span> </a></li>
          <!-- <li class="<?php if ($f == 'hr_pay_out') {
                            echo 'active';
                          } ?>"><a href="hr_pay_out.php?date=<?php echo date('Y-m'); ?>"><i class="fa fa-list-alt"></i> <span>Pay Out</span>  </a></li> -->

          <?php $co = '';
          if ($f == 'hr_salary_rp' || $f == 'hr_epf_rp' || $f == 'hr_etf_rp') {
            $co = 'active';
          } ?>
          <li class="treeview <?php echo $co; ?>">

            <a href="#">
              <i class="fa fa-line-chart"></i>
              <span>Report</span>
              <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>

            <ul class="treeview-menu">

              <li class="<?php if ($f == 'hr_salary_rp') {
                            echo 'active';
                          } ?>"><a href="#hr_salary_rp.php?date=<?php echo date('Y-m') ?>"><i class="fa fa-circle-o  text-aqua"></i> Salary Summery
                  <span class="pull-right-container">
                    <i class="fa fa-spinner fa-spin pull-right"></i>
                  </span></a></li>
              <li class="<?php if ($f == '#hr_epf_rp') {
                            echo 'active';
                          } ?>"><a href="hr_epf_rp.php"><i class="fa fa-circle-o text-aqua"></i> EPF
                  <span class="pull-right-container">
                    <i class="fa fa-spinner fa-spin pull-right"></i>
                  </span></a></li>
              <li class="<?php if ($f == '#hr_etf_rp') {
                            echo 'active';
                          } ?>"><a href="hr_etf_rp.php"><i class="fa fa-circle-o text-aqua"></i> ETF
                  <span class="pull-right-container">
                    <i class="fa fa-spinner fa-spin pull-right"></i>
                  </span></a></li>
              <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Welfare</a></li> -->

            </ul>
          </li>



        <?php } ?>





        <?php if ($dep == 'accounting') { ?>

          <li class="<?php if ($f == 'acc_index') {
                        echo 'active';
                      } ?>">
            <a href="acc_index.php">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

          <li class="<?php if ($f == 'expenses') {
                        echo 'active';
                      } ?>">
            <a href="expenses.php">
              <i class="fa fa-suitcase"></i> <span>Expenses</span>
            </a>
          </li>

          <li class="<?php if ($f == 'credit_collection') {
                        echo 'active';
                      } ?>">
            <a href="credit_collection.php">
              <i class="fa fa-usd"></i> <span>Credit Collection</span>
            </a>
          </li>

          <li class="<?php if ($f == 'acc_transfer') {
                        echo 'active';
                      } ?>">
            <a href="acc_transfer.php">
              <i class="fa fa-exchange"></i> <span> Account Transfer</span>
            </a>
          </li>

          <li class="<?php if ($f == 'acc_bank_transfer') {
                        echo 'active';
                      } ?>">
            <a href="acc_bank_transfer.php">
              <i class="fa fa-bank"></i> <span> Bank Transfer</span>
            </a>
          </li>

          <li class="<?php if ($f == 'acc_bank_loan') {
                        echo 'active';
                      } ?>">
            <a href="acc_bank_loan.php"><i class="fa fa-money"></i> <span>Bank Loan</span>
            </a>
          </li>

          <li class="<?php if ($f == 'acc_chq_realizing') {
                        echo 'active';
                      } ?>">
            <a href="acc_chq_realizing.php"><i class="fa fa-random"></i> <span>Chq Realizing</span>
            </a>
          </li>

          <?php $co = '';
          if ($f == 'acc_regeneration' || $f == 'acc_bank_regeneration' || $f == 'acc_vat_regeneration') {
            $co = 'active';
          } ?>
          <li class="treeview <?php echo $co; ?>">
            <a href="#">
              <i class="fa fa-line-chart"></i>
              <span>Report</span>
              <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>

            <ul class="treeview-menu">

              <li class="<?php if ($f == 'acc_regeneration') {
                            echo 'active';
                          } ?>"><a href="acc_regeneration.php?dates=<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>-<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>&account=1"><i class="fa fa-circle-o text-red"></i> Transfer Recode</a></li>

              <li class="<?php if ($f == 'acc_bank_regeneration') {
                            echo 'active';
                          } ?>"><a href="acc_bank_regeneration.php?dates=<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>-<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>&bank=1"><i class="fa fa-circle-o text-red"></i> Bank Reconciliation</a></li>

              <li class="<?php if ($f == 'acc_vat_regeneration') {
                            echo 'active';
                          } ?>"><a href="acc_vat_regeneration.php?dates=<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>-<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>&account=1"><i class="fa fa-circle-o text-red"></i> Vat Reconciliation</a></li>

            </ul>
          </li>

        <?php } ?>





        <?php if ($dep == 'management') { ?>
          <li class="<?php if ($f == 'manage_index') {
                        echo 'active';
                      } ?>">
            <a href="manage_index.php">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

          <li class="<?php if ($f == 'expenses') {
                        echo 'active';
                      } ?>">
            <a href="expenses.php">
              <i class="fa fa-suitcase"></i> <span>Expenses</span>
            </a>
          </li>

          <li class="<?php if ($f == 'target') {
                        echo 'active';
                      } ?>">
            <a href="target.php">
              <i class="fa fa-bar-chart"></i> <span>Target</span>
            </a>
          </li>

          <?php $co = '';
          $co0 = '';
          $dis = 'none';
          if ($f == 'hr_employee' || $f == 'hr_attendance' || $f == 'hr_allowances' || $f == 'hr_salary_advance' || $f == 'hr_payroll' || $f == 'hr_pay_out' || $f == 'hr_salary_rp' || $f == 'hr_epf_rp' || $f == 'hr_etf_rp') {
            $co = 'active';
            $co0 = 'menu-open';
            $dis = 'block';
          } ?>

          <li class="treeview <?php echo $co; ?>">
            <a href="#">
              <i class="fa fa-user"></i> <span>HR</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <ul class="treeview-menu  <?php echo $co0; ?>" style="display:  <?php echo $dis; ?>;">

              <li class="<?php if ($f == 'hr_employee') {
                            echo 'active';
                          } ?>"><a href="hr_employee.php"><i class="fa fa-user text-yellow"></i>Employee</a></li>
              <li class="<?php if ($f == 'hr_attendance') {
                            echo 'active';
                          } ?>"><a href="hr_attendance.php"><i class="fa  fa-500px text-yellow"></i>Attendance</a></li>
              <!-- <li class="<?php if ($f == 'hr_allowances') {
                                echo 'active';
                              } ?>"><a href="hr_allowances.php"><i class="fa fa-star-o text-yellow"></i>Allowances</a></li> -->
              <li class="<?php if ($f == 'hr_salary_advance') {
                            echo 'active';
                          } ?>"><a href="hr_salary_advance.php"><i class="fa fa-money text-yellow"></i>Advance</a></li>
              <li class="<?php if ($f == 'hr_payroll') {
                            echo 'active';
                          } ?>"><a href="hr_payroll.php"><i class="fa fa-list-alt text-red"></i>Payroll </a></li>
              <!-- <li class="<?php if ($f == 'hr_pay_out') {
                                echo 'active';
                              } ?>"><a href="hr_pay_out.php?date=<?php echo date('Y-m'); ?>"><i class="fa fa-list-alt text-yellow"></i>Pay Out </a></li> -->

              <?php $co = '';
              if ($f == 'hr_salary_rp' || $f == 'hr_epf_rp' || $f == 'hr_etf_rp') {
                $co = 'active';
              } ?>
              <li class="treeview <?php echo $co; ?>">

                <a href="#">
                  <i class="fa fa-line-chart text-blue"></i>
                  <span>Report</span>
                  <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>

                <ul class="treeview-menu">

                  <li class="<?php if ($f == 'hr_salary_rp') {
                                echo 'active';
                              } ?>"><a href="#hr_salary_rp.php?date=<?php echo date('Y-m') ?>"><i class="fa fa-circle-o"></i> Salary Summery
                      <span class="pull-right-container">
                        <i class="fa fa-spinner fa-spin pull-right"></i>
                      </span></a></li>
                  <li class="<?php if ($f == 'hr_epf_rp') {
                                echo 'active';
                              } ?>"><a href="#hr_epf_rp.php"><i class="fa fa-circle-o"></i> EPF
                      <span class="pull-right-container">
                        <i class="fa fa-spinner fa-spin pull-right"></i>
                      </span></a></li>
                  <li class="<?php if ($f == 'hr_etf_rp') {
                                echo 'active';
                              } ?>"><a href="#hr_etf_rp.php"><i class="fa fa-circle-o"></i> ETF
                      <span class="pull-right-container">
                        <i class="fa fa-spinner fa-spin pull-right"></i>
                      </span></a></li>
                  <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Welfare</a></li> -->

                </ul>
              </li>
            </ul>
          </li>

          <?php $co = '';
          $co0 = '';
          $dis = 'none';
          if ($f == 'grn' || $f == 'grn_credit_note' || $f == 'grn_supply' || $f == 'grn_payment' || $f == 'grn_return' || $f == 'grn_order' || $f == 'grn_rp' || $f == 'grn_payment_rp' || $f == 'grn_transport_rp' || $f == 'grn_order_rp') {
            $co = 'active';
            $co0 = 'menu-open';
            $dis = 'block';
          } ?>

          <li class="treeview <?php echo $co; ?>">
            <a href="#"><i class="fa fa-cubes"></i><span>Purchases</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu  <?php echo $co0; ?>" style="display:  <?php echo $dis; ?>;">

              <li class="<?php if ($f == 'grn') {
                            echo 'active';
                          } ?>"><a href="grn.php?id=<?php echo date("ymdhis"); ?>"><i class="fa fa-circle-o text-aqua"></i> GRN</a></li>

              <li class="<?php if ($f == 'grn_credit_note') {
                            echo 'active';
                          } ?>"><a href="grn_credit_note.php"><i class="fa fa-circle-o text-aqua"></i> Credit Note</a></li>

              <li class="<?php if ($f == 'grn_supply') {
                            echo 'active';
                          } ?>"><a href="grn_supply.php?id=0"><i class="fa fa-circle-o text-aqua"></i> Suppliers</a></li>

              <li class="<?php if ($f == 'grn_payment') {
                            echo 'active';
                          } ?>"><a href="grn_payment.php"><i class="fa fa-circle-o text-aqua"></i> Payment</a></li>

              <!-- <li class="<?php if ($f == 'grn_return') {
                                echo 'active';
                              } ?>"><a href="grn_return.php?id=<?php echo date("ymdhis"); ?>"><i class="fa fa-circle-o text-aqua"></i> GRN Return</a></li> -->
              <!-- <li class="<?php if ($f == 'grn_order') {
                                echo 'active';
                              } ?>"><a href="grn_order.php?id=<?php echo date("ymdhis"); ?>"><i class="fa fa-circle-o text-aqua"></i> Purchase Order</a></li> -->

              <?php $co = '';
              if ($f == 'grn_rp' || $f == 'grn_payment_rp' || $f == 'grn_transport_rp' || $f == 'grn_order_rp') {
                $co = 'active';
              } ?>

              <li class="treeview <?php echo $co; ?>">
                <a href="#">
                  <i class="fa fa-line-chart"></i>
                  <span>Report</span>
                  <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>

                <ul class="treeview-menu">
                  <li class="<?php if ($f == 'grn_rp') {
                                echo 'active';
                              } ?>"><a href="grn_rp.php?year=<?php echo date("Y"); ?>&month=<?php echo date("m"); ?>"><i class="fa fa-circle-o text-red"></i> GRN Record</a></li>

                  <li class="<?php if ($f == 'grn_payment_rp') {
                                echo 'active';
                              } ?>"><a href="grn_payment_rp.php?dates=<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>-<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>"><i class="fa fa-circle-o text-red"></i> Payment Record</a></li>

                  <li class="<?php if ($f == 'grn_transport_rp') {
                                echo 'active';
                              } ?>"><a href="grn_transport_rp.php?dates=<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>-<?php echo date("Y") . '/' . date("m") . '/' . date("d"); ?>"><i class="fa fa-circle-o text-red"></i> Transport Record</a></li>
                  <!-- <li class="<?php if ($f == 'grn_order_rp') {
                                    echo 'active';
                                  } ?>"><a href="grn_order_rp.php?year=<?php echo date("Y"); ?>&month=<?php echo date("m"); ?>"><i class="fa fa-circle-o text-red"></i> Order Record</a></li> -->
                </ul>
              </li>
            </ul>
          </li>

          <li class="treeview hidden">
            <a href="#">
              <i class="fa fa-bank"></i>
              <span>Bank</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="deposit.php"><i class="fa fa-circle-o text-aqua "></i>Deposit</a></li>
              <li><a href="withdraw.php"><i class="fa fa-circle-o text-red "></i>Withdraw </a></li>
              <li><a href="chq_return.php"><i class="fa fa-circle-o text-red "></i>CHQ Return </a></li>
              <li><a href="chq_action.php"><i class="fa fa-circle-o text-red "></i>CHQ Realiz </a></li>
            </ul>
          </li>

          <?php $co = '';
          $co0 = '';
          $dis = 'none';
          if ($f == 'damage' || $f == 'damage_view') {
            $co = 'active';
            $co0 = 'menu-open';
            $dis = 'block';
          } ?>

          <li class="treeview <?php echo $co; ?>">
            <a href="#">
              <i class="fa fa-exclamation-triangle"></i>
              <span>Damage</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <ul class="treeview-menu  <?php echo $co0; ?>" style="display:  <?php echo $dis; ?>;">
              <li class="<?php if ($f == 'damage') {
                            echo 'active';
                          } ?>"><a href="damage.php"><i class="fa fa-circle-o text-aqua "></i> Add New Damage</a></li>
              <li class="<?php if ($f == 'damage_view') {
                            echo 'active';
                          } ?>"><a href="damage_view.php"><i class="fa fa-circle-o text-aqua "></i> View Damage</a></li>
              </a>
            </ul>
          </li>

          <?php $co = '';
          $co0 = '';
          $dis = 'none';
          if ($f == 'customer' || $f == 'product' || $f == 'rep' || $f == 'lorry' || $f == 'root') {
            $co = 'active';
            $co0 = 'menu-open';
            $dis = 'block';
          } ?>

          <li class="treeview <?php echo $co; ?>">
            <a href="#">
              <i class="fa fa-group"></i>
              <span>Profile</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <ul class="treeview-menu  <?php echo $co0; ?>" style="display:  <?php echo $dis; ?>;">
              <li class="<?php if ($f == 'customer') {
                            echo 'active';
                          } ?>"><a href="customer.php"><i class="fa fa-circle-o text-aqua "></i> Customer</a></li>
              <li class="<?php if ($f == 'product') {
                            echo 'active';
                          } ?>"><a href="product.php"><i class="fa fa-circle-o text-aqua "></i> Product</a></li>
              <li class="<?php if ($f == 'lorry') {
                            echo 'active';
                          } ?>"><a href="lorry.php"><i class="fa fa-circle-o text-aqua "></i>Lorry </a></li>
              <li class="<?php if ($f == 'root') {
                            echo 'active';
                          } ?>"><a href="root.php"><i class="fa fa-circle-o text-aqua "></i>Root</a></li>
              </a>
            </ul>
          </li>

          <?php $co = '';
          $co0 = '';
          $dis = 'none';
          if ($f == 'customer_category' || $f == 'bill_return' || $f == 'special_price' || $f == 'trust' || $f == 'trust_view') {
            $co = 'active';
            $co0 = 'menu-open';
            $dis = 'block';
          } ?>

          <li class="treeview <?php echo $co; ?>">

            <a href="#">
              <i class="fa fa-exchange"></i>
              <span>SUB Menu</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <ul class="treeview-menu  <?php echo $co0; ?>" style="display:  <?php echo $dis; ?>;">

              <li class="<?php if ($f == 'customer_category') {
                            echo 'active';
                          } ?>"> <a href="customer_category.php"><i class="fa fa-circle-o text-aqua"></i> Customer Category</a></li>

              <li class="<?php if ($f == 'bill_return') {
                            echo 'active';
                          } ?>"><a href="new/go/bill_return.php"><i class="fa fa-circle-o text-aqua"></i> <span>Product Return</span></a></li>

              <li class="<?php if ($f == 'special_price') {
                            echo 'active';
                          } ?>"><a href="special_price.php"> <i class="fa fa-circle-o text-aqua"></i> <span>Special Price</span></a></li>

              <?php $co = '';
              if ($f == 'trust' || $f == 'trust_view') {
                $co = 'active';
              } ?>

              <li class="treeview <?php echo $co; ?>">
                <a href="#">
                  <i class="fa fa-random"></i>
                  <span>Trust</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>

                <ul class="treeview-menu">
                  <li class="<?php if ($f == 'trust') {
                                echo 'active';
                              } ?>"><a href="trust.php"><i class="fa fa-circle-o text-red "></i> Add New Trust</a></li>
                  <li class="<?php if ($f == 'trust_view') {
                                echo 'active';
                              } ?>"><a href="trust_view.php"><i class="fa fa-circle-o text-red "></i> View Trust</a></li>
                  </a>
                </ul>
              </li>
            </ul>
          </li>

          <?php $co = '';
          $co0 = '';
          $dis = 'none';
          if ($f == 'sales_rp' || $f == 'target_rp') {
            $co = 'active';
            $co0 = 'menu-open';
            $dis = 'block';
          } ?>

          <li class="treeview <?php echo $co; ?>">
            <a href="#">
              <i class="fa fa-line-chart"></i>
              <span>Report</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <ul class="treeview-menu  <?php echo $co0; ?>" style="display:  <?php echo $dis; ?>;">
              <li class="<?php if ($f == 'sales_rp') {
                            echo 'active';
                          } ?>"><a href="sales_rp.php?d1=<?php echo date("Y-m-d"); ?>&d2=<?php echo date("Y-m-d"); ?>&cus=all&lorry=all&filter=all&product=all&root=all"><i class="fa fa-circle-o text-aqua "></i> Sales Report</a></li>

              <li class="<?php if ($f == 'target_rp') {
                            echo 'active';
                          } ?>"><a href="target_rp.php?year=<?php echo date("Y"); ?>&month=<?php echo date("m"); ?>"><i class="fa fa-circle-o text-aqua"></i> Target Report</a></li>
            </ul>
          </li>

        <?php }
        if (false) { ?>
















          <li class="treeview">
            <a href="#">
              <i class="fa fa-line-chart"></i>
              <span>Report</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>



            <ul class="treeview-menu">


              <li><a href="sales_credit.php"><i class="fa fa-circle-o text-aqua "></i> Credit Report</a></li>
              <li><a href="sales_credit_pay.php?d1=<?php echo date("Y-m-d"); ?>&d2=<?php echo date("Y-m-d"); ?>&cus=all"><i class="fa fa-circle-o text-aqua "></i> Credit Payment Report</a></li>

              <li><a href="bank_rp.php?d1=<?php echo date("Y-m-d"); ?>&d2=<?php echo date("Y-m-d"); ?>"><i class="fa fa-circle-o text-aqua "></i> Bank Report</a></li>

              <li><a href="pay_sum.php"><i class="fa fa-circle-o text-aqua "></i>Payment Summary </a></li>
              <li><a href="loding_list.php?id=<?php echo $date; ?>&lorry=0"><i class="fa fa-circle-o text-aqua "></i> Loading Report</a></li>
              <li><a href="expenses_sum.php?d1=<?php echo $date; ?>"><i class="fa fa-circle-o text-aqua "></i> Expenses Report </a></li>
              <li><a href="stock_rp.php?d1=<?php echo date("Y-m-d"); ?>&d2=<?php echo date("Y-m-d"); ?>"><i class="fa fa-circle-o text-aqua "></i> Stock Report</a></li>

              <li>
                <a href="#"><i class="fa fa-line-chart text-red"></i>Sub Report
                  <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="sales_rp_special.php?d1=<?php echo date("Y-m-d"); ?>&d2=<?php echo date("Y-m-d"); ?>&cus=all"><i class="fa fa-circle-o text-aqua "></i>Special Price Sales</a></li>
                  <li><a href="sales_all_rp.php?d1=<?php echo $date; ?>"><i class="fa fa-circle-o text-aqua "></i> Day End Report </a></li>
                  <li><a href="damage_view.php"><i class="fa fa-circle-o text-aqua "></i> Damage Report</a></li>
                  <li><a href="stock_error.php"><i class="fa fa-circle-o text-aqua "></i> Stock Error</a></li>
                  <li><a href="purchase_view.php?d1=<?php echo $date; ?>&d2=<?php echo $date; ?>"><i class="fa fa-circle-o text-aqua "></i> Purchase Report</a></li>
                  <li><a href="purchase_pay_rp.php?d1=<?php echo $date; ?>&d2=<?php echo $date; ?>"><i class="fa fa-circle-o text-aqua "></i> Purchase Pay Report</a></li>
                  <li><a href="sales_dll_rp.php?d1=<?php echo $date; ?>&d2=<?php echo $date; ?>&cus=all"><i class="fa fa-circle-o text-aqua "></i> Sales Delete Report</a></li>
                  <li><a href="new/go/bill_return_rp.php"><i class="fa fa-circle-o text-aqua "></i> Products Return Report</a></li>
                  <li><a href="sales_rp_month.php?d1=<?php echo $date; ?>&d2=<?php echo $date; ?>"><i class="fa fa-circle-o text-aqua "></i> Sales Month Report</a></li>
                </ul>
              </li>

              <li>
                <a href="#"><i class="fa fa-line-chart text-red"></i>Back Date Report
                  <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="sales_credit_back_date.php"><i class="fa fa-circle-o text-aqua "></i> Credit Report</a></li>

                </ul>
              </li>

              </a>
          </li>
      </ul>
      </li>

      <li class="header">SUB NAVIGATION</li>
      <?php if ($user_lewal == 3) { ?>
        <li>
          <a href="bulk_payment.php">
            <i class="fa fa-usd"></i> <span>Credit Payment</span>
            <span class="pull-right-container">

            </span>
          </a>
        </li>
      <?php } ?>


      <?php if ($user_lewal < 5) { ?>
        <li>
          <a href="credit_collection.php">
            <i class="fa fa-usd"></i> <span>Credit Collection</span>
            <span class="pull-right-container">

            </span>
          </a>
        </li>

        <li>
          <a href="bill_remove.php">
            <i class="fa fa-usd"></i> <span>Invoice Removal</span>
            <span class="pull-right-container">

            </span>
          </a>
        </li>



      <?php } ?>
      <?php if ($user_lewal == 4) { ?>
        <li>
          <a href="stock_adjust.php">
            <i class="fa fa-cubes"></i> <span>STOCK Adjustment</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
      <?php } ?>

      <li class="treeview">

        <a href="#">
          <i class="fa fa-exchange"></i>
          <span>SUB Menu</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>




        <ul class="treeview-menu">
          <li><a href="customer_category.php"><i class="fa fa-usd"></i> Customer Category</a></li>




          <li>
            <a href="new/go/bill_return.php">
              <i class="fa fa-level-down"></i> <span>Product Return</span>
              <span class="pull-right-container">

              </span>
            </a>
          </li>

          <li>
            <a href="special_price.php">
              <i class="fa fa-usd"></i> <span>Special Price</span>
              <span class="pull-right-container">

              </span>
            </a>
          </li>


          <li class="treeview">
            <a href="#">
              <i class="fa fa-retweet text-white"></i>
              <span>Trust</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="trust.php"><i class="fa fa-circle-o text-aqua "></i> Add New Trust</a></li>
              <li><a href="trust_view.php"><i class="fa fa-circle-o text-aqua "></i> View Trust</a></li>
              </a>
            </ul>
          </li>



          <li class="treeview">
            <a href="#">
              <i class="fa fa-exclamation-triangle text-yellow"></i>
              <span>Damage</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>



            <ul class="treeview-menu">

              <li><a href="damage.php"><i class="fa fa-circle-o text-aqua "></i> Add New Damage</a></li>
              <li><a rel="facebox" href="damage_company.php"><i class="fa fa-circle-o text-aqua "></i> Sent Damage to Company</a></li>
              <li><a rel="facebox" href="damage_receive.php"><i class="fa fa-circle-o text-aqua "></i> Damage Receive</a></li>
              <li><a rel="facebox" href="damage_customer.php"><i class="fa fa-circle-o text-aqua "></i> Sent Damage to Customer</a></li>
              <li><a href="damage_view.php"><i class="fa fa-circle-o text-aqua "></i> View Damage</a></li>
              </a>
            </ul>
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-gift text-red"></i>
              <span>Gift Voucher</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>



            <ul class="treeview-menu">

              <li><a href="gift.php"><i class="fa fa-circle-o text-aqua "></i> Add New Gift Voucher</a></li>
              <li><a rel="facebox" href="gift_company.php"><i class="fa fa-circle-o text-aqua "></i> Sent Voucher to Company</a></li>
              <li><a rel="facebox" href="gift_receive.php"><i class="fa fa-circle-o text-aqua "></i> Voucher Receive</a></li>

              <li><a href="gift_view.php"><i class="fa fa-circle-o text-aqua "></i> View Gift Voucher</a></li>
              </a>
            </ul>
          </li>









        </ul>
      </li>




      <li class="treeview">
        <a href="#">
          <i class="fa fa-group"></i>
          <span>Profile</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>



        <ul class="treeview-menu">

          <li><a href="customer.php"><i class="fa fa-circle-o text-aqua "></i> Customer</a></li>
          <li><a href="product.php"><i class="fa fa-circle-o text-aqua "></i> Product</a></li>
          <li><a href="rep.php"><i class="fa fa-circle-o text-aqua "></i> Rep</a></li>
          <li><a href="lorry.php"><i class="fa fa-circle-o text-aqua "></i>Lorry </a></li>
          <li><a href="root.php"><i class="fa fa-circle-o text-aqua "></i>Root</a></li>
          </a>
        </ul>
      </li>


    <?php } ?>

    </ul>
    </section>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
      window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')
    </script>
    <script src="js/main.js"></script>


    <!-- <div id="loader-wrapper">
      <div id="loader"></div>

      <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>

    </div> -->