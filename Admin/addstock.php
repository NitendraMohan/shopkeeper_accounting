<?php 
include('top.php'); 
$product_id="";
$opening_stock="";
$current_stock="";
$product="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc($con->query("select *,(select dish from dish where id=product_id) as product from stock where id='$id'"));
  $opening_stock=$row['opening_stock'];
  $current_stock=$row['current_stock'];
  $product=$row['product'];
}
if(isset($_POST['cancel'])){
  redirect('stock.php');
}
if(isset($_POST['submit'])){
  $opening_stock=$_POST['opening_stock'];
  $current_stock=$_POST['current_stock'];
  $added_on=date('Y-m-d h:m:s');
  if($id!=''){
    $con->query("update stock set opening_stock='$opening_stock',current_stock='$current_stock' where id='$id'");
    redirect('stock.php');  
  }
  
}
?>
<div class="row">
  <h1 class="card-title ml10">Manage Stock</h1>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post">
                <div class="form-group">
                  <label for="exampleInputName1">Product</label>
                  <input type="textbox" class="form-control" name="product" value="<?php echo $product; ?>" placeholder="Product" disabled="true">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Opening Stock</label>
                  <input type="number" class="form-control" name="opening_stock" value="<?php echo $opening_stock; ?>" placeholder="Opening Stock">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Current Stock</label>
                  <input type="number" class="form-control" name="current_stock" value="<?php echo $current_stock; ?>" placeholder="Current Stock">
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
        
		