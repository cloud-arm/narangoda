





	



<div style="width: 550px">
    

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">New Customer</h3>

          
        <!-- /.box-header -->
		<div class="form-group">
              
		<form method="post" action="save_customer.php">
		
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>customer</label>
                <input type="text" value='' id="datepicker" name="customer_name" class="form-control pull-right" >
				</div>
              </div>
			   <?php date_default_timezone_set("Asia/Colombo"); ?>
			  
			  

                <div class="col-md-6">
              <div class="form-group">
                <label>	Addrss</label>
                <input type="text" name="address" class="form-control pull-right"  >
                  
                  </div>
				</div>
				
        
		
        </div>
      </div>
	  
	  
	   <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Contact no</label>
                <input type="tel" value='' id="datepicker" name="contact" class="form-control pull-right" >
				</div>
              </div>
			   <?php date_default_timezone_set("Asia/Colombo"); ?>
			  
			  

                <div class="col-md-6">
              <div class="form-group">
                <label>Root</label>
                  <select class="form-control" name="root"  >
                    <?php
					include("connect.php");
                $result = $db->prepare("SELECT * FROM root  ");
		$result->bindParam(':userid', $res);
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
	?>
		<option value="<?php echo $row['root_name'];?>"><?php echo $row['root_name']; ?>    </option>
	<?php
				}
			?>
                    
                  </select>
                  </div>
				</div>
				
        
		
        </div>
        
         <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <b>Type</b>
                                                </div>
                                                <select class="form-control select2" name="type"
                                                    class="form-control pull-right">
                                                    <option value="1"> Channel </option>
                                                    <option value="2"> Commercial</option>
                                                    <option value="3">Apartment</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    </div>
        
      </div>
	   				  
											  
      <!-- /.box -->
<div class="form-group">
              

			  
			  
			  
			  <input class="btn btn-info" type="submit" value="Add" >
			  
			  </form>
          <!-- /.box -->

        </div>
        <!-- /.col (left) -->
       

        
            <!-- /.box-body -->
            
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col (right) -->
      </div>
      <!-- /.row -->

    
   
