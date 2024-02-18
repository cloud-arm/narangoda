<!-- SELECT2 EXAMPLE -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">New Customer</h3>
    </div>

    <?php date_default_timezone_set("Asia/Colombo"); ?>
    <div class="box-body">
        <form method="post" action="root_customer_save.php">

            <div style="display: flex;gap: 15px; align-items: center;justify-content: center; ">

                <div class="form-group">
                    <label>Customer</label>
                    <select class="form-control select2" name="id" style="padding:4px;">
                        <?php
                        include("connect.php");
                        $result = $db->prepare("SELECT * FROM customer  ");
                        $result->bindParam(':userid', $res);
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) {
                        ?>
                            <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?> </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group" style="height: 60px;display: flex;align-items: end;">
                    <input class="btn btn-info" type="submit" value="Add">
                    <input type="hidden" name="root" value="<?php echo $_GET['id']; ?>">
                </div>
            </div>
        </form>
    </div>

</div>