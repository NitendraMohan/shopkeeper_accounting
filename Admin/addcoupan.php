<?php 
include('top.php'); 
$coupan_code="";
$coupan_type="";
$coupan_value="";
$cart_min_value="";
$expired_on="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc($con->query("select * from coupan_code where id='$id'"));
  $coupan_code=$row['coupan_code'];
  $coupan_type=$row['coupan_type'];
  $coupan_value=$row['coupan_value'];
  $cart_min_value=$row['cart_min_value'];
  $expired_on=$row['expired_on'];
}
if(isset($_POST['cancel'])){
  redirect('coupancode.php');
}
if(isset($_POST['submit'])){
  $coupan_code=$_POST['coupan_code'];
  $coupan_type=$_POST['coupan_type'];
  $coupan_value=$_POST['coupan_value'];
  $cart_min_value=$_POST['cart_min_value'];
  $expired_on=$_POST['expired_on'];
  $added_on=date('Y-m-d h:m:s');
  if($id!=''){
    $con->query("update coupan_code set coupan_code='$coupan_code',coupan_type='$coupan_type',coupan_value='$coupan_value',cart_min_value=$cart_min_value, expired_on=$expired_on where id='$id'");
    redirect('coupancode.php');  
  }
  else{
    if(mysqli_num_rows(mysqli_query($con,"select * from coupan_code where coupan_code='$coupan_code'"))>0){
    $msg="coupan already added";
  }
  else{
  $con->query("insert into coupan_code(coupan_code,coupan_type,coupan_value,cart_min_value,expired_on,status,added_on) values('$coupan_code'
    ,'$coupan_type','$coupan_value','$cart_min_value','$expired_on',1,'$added_on')");
  redirect('coupancode.php');  
  }  
  }
}
?>
<div class="row">
  <h1 class="card-title ml10">Manage Coupan Code</h1>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post">
                <div class="form-group">
                  <label for="exampleInputName1">Coupan Code</label>
                  <input type="textbox" class="form-control" name="coupan_code" value="<?php echo $coupan_code; ?>" placeholder="Coupan Code">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Coupan Type</label>
                  <select class="form-control" required name="coupan_type" >
                    <option value="">Select Type</option>
                    <?php 
                      $arr= array('P' =>'Percentage' ,'F'=>'Fixed');
                      foreach ($arr as $key => $value) {
                        if($key==$coupan_type){
                          echo "<option value='".$key."' selected>".$value."</option>";
                        }
                        else{
                         echo "<option value='".$key."'>".$value."</option>"; 
                        }
                      }
                     ?>
                  </select>   
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Coupan Value</label>
                  <input type="textbox" class="form-control" name="coupan_value" value="<?php echo $coupan_value; ?>" placeholder="Coupan Value">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Cart Min Value</label>
                  <input type="textbox" class="form-control" name="cart_min_value" value="<?php echo $cart_min_value; ?>" placeholder="Cart Min Value">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Expired On</label>
                  <input type="date" class="form-control" name="expired_on" value="<?php echo $expired_on; ?>" placeholder="dd-MM-YYYY">
                </div>
                <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                <button type="submit" class="btn btn-light mr-2" name="cancel">Cancel</button>
              </form>
            </div>
          </div>
        </div>
            
     </div>

<?php
include('footer.php');
 ?>
        
		