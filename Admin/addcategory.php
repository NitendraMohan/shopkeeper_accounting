<?php 
include('top.php'); 
$category="";
$orderno="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc($con->query("select * from category where id='$id'"));
  $category=$row['category'];
  $orderno=$row['order_number'];

}
if(isset($_POST['submit'])){
  $category=$_POST['category'];
  $orderno=$_POST['orderno'];
  $added_on=date('Y-m-d h:m:s');
  if($id!=''){
    $con->query("update category set category='$category',order_number=$orderno where id=$id");
    redirect('category.php');  
  }
  else{
    if(mysqli_num_rows(mysqli_query($con,"select * from category where category='$category'"))>0){
    $msg="Category already added";
  }
  else{
  $con->query("insert into category(category,order_number,status,added_on) values('$category'
    ,'$orderno',1,'$added_on')");
  redirect('category.php');  
  }  
  }
}
?>
<div class="row">
  <h1 class="card-title ml10">Manage Category</h1>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post">
                <div class="form-group">
                  <label for="exampleInputName1">Category</label>
                  <input type="textbox" class="form-control" name="category" value="<?php echo $category; ?>" placeholder="Category">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Order Number</label>
                  <input type="textbox" class="form-control" name="orderno" value="<?php echo $orderno; ?>" placeholder="Order Number">
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
        
		