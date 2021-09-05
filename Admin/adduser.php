<?php 
include('top.php'); 
$name="";
$mobile="";
$email="";
$password="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc($con->query("select * from user where id='$id'"));
  $name=$row['name'];
  $email=$row['email'];
  $mobile=$row['mobile'];
  $password=$row['password'];

}
if(isset($_POST['submit'])){
  $name=$_POST['name'];
  $email=$_POST['email'];
  $mobile=$_POST['mobile'];
  $password=$_POST['password'];
  $added_on=date('Y-m-d h:m:s');
  if($id!=''){
    $con->query("update user set name='$name',email=$email, mobile='$mobile',password='$password' where id=$id");
    redirect('user.php');  
  }
  else{
    if(mysqli_num_rows(mysqli_query($con,"select * from user where email='$email'"))>0){
    $msg="user already added";
  }
  else{
  $con->query("insert into user(name,email,mobile,password,status,added_on) values('$name'
    ,'$email','$mobile','$password',1,'$added_on')");
  redirect('user.php');  
  }  
  }
}
?>
<div class="row">
  <h1 class="card-title ml10">Manage User</h1>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post">
                <div class="form-group">
                  <label for="exampleInputName1">Name</label>
                  <input type="textbox" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Email</label>
                  <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Mobile</label>
                  <input type="number" class="form-control" name="mobile" value="<?php echo $mobile; ?>" placeholder="Mobile">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Password</label>
                  <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" placeholder="Password">
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
        
		