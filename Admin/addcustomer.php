<?php 
include('top.php'); 
$name="";
$mobile="";
$address="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc($con->query("select * from customer where id='$id'"));
  $name=$row['name'];
  $mobile=$row['mobile'];
  $address=$row['address'];

}
if(isset($_POST['submit'])){
  $name=$_POST['name'];
  $mobile=$_POST['mobile'];
  $address=$_POST['address'];
  $added_on=date('Y-m-d h:m:s');
  if($id!=''){
    $con->query("update customer set name='$name', mobile='$mobile',address='$address' where id=$id");
    redirect('customer.php');  
  }
  else{
    if(mysqli_num_rows(mysqli_query($con,"select * from customer where mobile='$mobile'"))>0){
    $msg="customer already added";
  }
  else{
  $con->query("insert into customer(name,mobile,address,status,added_on) values('$name'
    ,'$mobile','$address',1,'$added_on')");
  redirect('customer.php');  
  }  
  }
}
?>
<div class="row">
  <h1 class="card-title ml10">Manage Customer</h1>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post">
                <div class="form-group">
                  <label for="exampleInputName1">Name</label>
                  <input type="textbox" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Name">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail3">Mobile</label>
                  <input type="number" class="form-control" name="mobile" value="<?php echo $mobile; ?>" placeholder="Mobile">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Address</label>
                  <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" placeholder="Address">
                </div>

                
                <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                <button class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
            
     </div>

<?php
include('footer.php');
 ?>
        
		