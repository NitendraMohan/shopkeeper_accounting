<?php
session_start();

include('db.inc.php');
include('functions.inc.php');
unset($_SESSION['IS_LOGIN']);
$role="admin";
if(isset($_POST['submit'])){
  $uname=$_POST['username'];
  $upwd=$_POST['password'];
  if(in_array("admin", $_POST['role'])){
    $qry="select * from admin where username='$uname' and password='$upwd'";  
    $role="admin";
  }
  else{
   $qry="select * from user where email='$uname' and password='$upwd' and status='1'";   
   $role="user";
  }
  echo $qry;
  $res=$con->query($qry);
  if($res->num_rows>0){
    $_SESSION['IS_LOGIN']="YES";
    $row=$res->fetch_assoc();
    $_SESSION['LOGIN_NAME']=$row['name'];

    $_SESSION['ROLE']=$role;
    redirect('index.php');
  }
  else
  {
    $msg="Please Login with correct username and password";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shopkeeper Accounting</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="sidebar-light">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo text-center text-success">
               <h1> SHOPKEEPER ACCOUNTING </h1>
                <!-- <img src="assets/images/logo.png" alt="logo"> -->
              </div>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" method="post">
                <div class="form-group">
                  <input type="textbox" class="form-control form-control-lg" id="exampleInputEmail1" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password" required>
                </div>
                
                             
                <div class="mt-3">
                  <div class="row form-group">
                    <input type="radio" name="role[]" value="admin" checked="true">admin
                    <input type="radio" name="role[]" value="user">user
                  </div>
                  <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="SIGN IN" name="submit">
                </div>
                
              </form>
              <div><?php echo $msg ?></div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <!-- plugins:js -->
  <script src="assets/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="assets/js/Chart.min.js"></script>
  <script src="assets/js/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="assets/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>
</html>