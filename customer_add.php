<!-- SELECT2 EXAMPLE -->
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">New Customer</h3>
  </div>

  <?php date_default_timezone_set("Asia/Colombo"); ?>
  <div class="box-body">
    <form method="post" action="customer_save.php">

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>customer</label>
            <input type="text"  name="name" class="form-control pull-right">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label> Address</label>
            <input type="text" name="address" class="form-control pull-right">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Contact no</label>
            <input type="tel" name="contact" class="form-control pull-right">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Root</label>
            <select class="form-control" name="root" style="width:123px; padding:4px;">
              <?php
              include("connect.php");
              $result = $db->prepare("SELECT * FROM root  ");
              $result->bindParam(':userid', $res);
              $result->execute();
              for ($i = 0; $row = $result->fetch(); $i++) {
              ?>
                <option value="<?php echo $row['root_id']; ?>"><?php echo $row['root_name']; ?> </option>
              <?php
              }
              ?>

            </select>
          </div>
        </div>

        <div class="form-group">
          <input class="btn btn-info" type="submit" value="Add">
          <input type="hidden" name="id" value="0">
        </div>
      </div>
    </form>
  </div>

</div>