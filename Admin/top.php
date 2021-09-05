<?php
session_start();
include('db.inc.php');
include('functions.inc.php');
include('constant.inc.php');
$cur_str=$_SERVER['REQUEST_URI'];
$curArr=explode('/', $cur_str);
echo $cur_path=$curArr[count($curArr)-1];
$page_title='';
if($cur_path=='' || $cur_path=='index.php'){
  $page_title='Dashboard';
}
elseif($cur_path=='category.php' || $cur_path=='addcategory.php'){
  $page_title='Category';
}
elseif($cur_path=='coupancode.php' || $cur_path=='addcoupan.php'){
  $page_title='Coupan';
}
elseif($cur_path=='product.php' || $cur_path=='addproduct.php'){
  $page_title='Dish';
}
elseif($cur_path=='stock.php' || $cur_path=='addboy.php'){
  $page_title='Delivery Boy';
}
if(!isset($_SESSION['IS_LOGIN'])){
  redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> <?php echo $page_title ?>-Shopkeeper Accounting</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.css">
  <script src="assets/js/jquery-3.6.0.js"></script>
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="sidebar-light">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
        <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">
          <li class="nav-item nav-toggler-item">
            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
          </li>
          
        </ul>
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="index.php">
            <!-- <img src="assets/images/logo.png" alt="logo"/> -->
            <h1>Shopkeeper Accounting</h1>
          </a>
          <a class="navbar-brand brand-logo-mini" href="index.php"><!-- <img src="assets/images/logo.png" alt="logo"/> -->
            <h1>Shopkeeper Accounting</h1>
          </a>
        </div>
        <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <span class="nav-profile-name"><?php echo $_SESSION['ROLE'].":".$_SESSION['LOGIN_NAME'] ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">
                <i class="mdi mdi-logout text-primary"></i>
                Logout
              </a>
            </div>
          </li>
          
          <li class="nav-item nav-toggler-item-right d-lg-none">
            <button class="navbar-toggler align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
            </button>
          </li>
        </ul>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="mdi mdi-view-quilt menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="user.php">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="category.php">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Category</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="product.php">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Product</span>
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="stock.php">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Stock</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="customer.php">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Customer</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="supplier.php">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Supplier</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="purchase_order.php">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Purchase Order</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sale_order.php">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Sale Order</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.html">
              <i class="mdi mdi-airplay menu-icon"></i>
              <span class="menu-title">Login</span>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">