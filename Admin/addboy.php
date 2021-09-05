<?php 
include('top.php'); 
$name="";
$mobile="";
$password="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc($con->query("select * from delivery_boy where id='$id'"));
  $name=$row['name'];
  $mobile=$row['mobile'];
  $password=$row['password'];
}
if(isset($_POST['cancel'])){
  redirect('stock.php');
}
if(isset($_POST['submit'])){
  $name=$_POST['name'];
  $mobile=$_POST['mobile'];
  $password=$_POST['password'];
  $added_on=date('Y-m-d h:m:s');
  if($id!=''){
    $con->query("update delivery_boy set name='$name',mobile='$mobile',password='$password' where id='$id'");
    redirect('stock.php');  
  }
  else{
    if(mysqli_num_rows(mysqli_query($con,"select * from delivery_boy where mobile='$mobile'"))>0){
    $msg="Boy already added";
  }
  else{
  $con->query("insert into delivery_boy(name,mobile,password,status,added_on) values('$name'
    ,'$mobile','$password',1,'$added_on')");
  redirect('stock.php');  
  }  
  }
}
?>
<div class="row">
  <h1 class="card-title ml10">Manage Delivery Boy</h1>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post">
                <div class="form-group">
                  <label for="exampleInputName1">Name</label>
                  <input type="textbox" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Mobile Number</label>
                  <input type="textbox" class="form-control" name="mobile" value="<?php echo $mobile; ?>" placeholder="Mobile Number">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Password</label>
                  <input type="textbox" class="form-control" name="password" value="<?php echo $password; ?>" placeholder="Password">
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
        
		