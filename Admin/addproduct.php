<?php 
include('top.php'); 
include('constant.inc.php');
$category_id="";
$dish="";
$dish_detail="";
$image="";
$image_status="required";
$type="";
$id="";
$image_error="";
if(isset($_GET['id']) && $_GET['id']>0){
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc($con->query("select * from dish where id='$id'"));
  $category_id=$row['category_id'];
  $dish=$row['dish'];
  $dish_detail=$row['dish_detail'];
  $image=$row['image'];
  $row_detail=mysqli_fetch_assoc($con->query("select * from dish_detail where dish_id='$id'"));
  $attr=$row_detail['attribute'];
  $price=$row_detail['price'];
}
if(isset($_POST['cancel'])){
  redirect('product.php');
}
if(isset($_POST['submit'])){
  $category_id=$_POST['category_id'];
  $dish=$_POST['dish'];
  $dish_detail=$_POST['dish_detail'];
  $image=$_POST['image'];
  $added_on=date('Y-m-d h:m:s');
  if($id!=''){
    $image_status='';
    if($_FILES['image']['name']!=''){
      $type=$_FILES['image']['type'];
    if($type!='image/jpeg' && $type!='image/png'){
      $image_error="Invalid Image Format";
    }
    else{
      $image=$_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE.$_FILES['image']['name']);      
      $image_status=", image='$image'";
    
    $con->query("update dish set category_id='$category_id',dish='$dish',dish_detail='$dish_detail' $image_status where id='$id'");
    redirect('product.php'); 
    }
    } 
  }
  else{
    if(mysqli_num_rows(mysqli_query($con,"select * from dish where dish='$dish' and category_id='$category_id'"))>0){
    $msg="Dish already added";
  }
  else{
    $type=$_FILES['image']['type'];
    if($type!='image/jpeg' && $type!='image/png'){
      $image_error="Invalid Image Format";
    }
    else{
      $attributeArr=$_POST['attribute'];
      $priceArr=$_POST['price'];

    $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE.$image);

  $con->query("insert into dish(category_id,dish,dish_detail,image,status,added_on) values('$category_id','$dish','$dish_detail','$image',1,'$added_on')");

  
  
  $lastid=mysqli_insert_id($con);
  foreach($attributeArr as $key=>$val){
    $attr=$val;
    $price=$priceArr[$key];
    $con->query("insert into dish_detail(dish_id,attribute,price,status,added_on) values('$lastid','$attr','$price',1 ,'$added_on')");
    $con->query("insert into stock(product_id,opening_stock,current_stock,status,added_on) values('$lastid',0,0,1,'$added_on')");
  }
  redirect('product.php');
  }  
  }  
  }
}
$res_cat=$con->query("select * from category where status='1'");
?>
<div class="row">
  <h1 class="card-title ml10">Manage Product</h1>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputName1">Category</label>
                  <select class="form-control" name="category_id" placeholder="Category">
                      <option value="">Select Category</option>
                      <?php 
                        while ($c_row=$res_cat->fetch_assoc()) {
                          if($c_row['id']==$category_id){
                          echo "<option value='".$c_row['id']."'' selected>".$c_row['category']."</option>";  
                          }
                          echo "<option value='".$c_row['id']."''>".$c_row['category']."</option>";
                        }
                       ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Product</label>
                  <input type="textbox" class="form-control" name="dish" value="<?php echo $dish; ?>" placeholder="Product">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Product Detail</label>
                  <textarea class="form-control" name="dish_detail" value="<?php echo $dish_detail; ?>" placeholder="Product Detail"></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Image</label>
                  <input type="file" class="form-control" name="image"  placeholder="Image">
                  <div><?php echo $image_error ?></div>
                </div>
                <div class="form-group" id="more_detail">
                  <label for="exampleInputEmail3">More Detail</label>
                  <div class="row mt-8">
                    <div class="col-5">
                      <input type="textbox" class="form-control" name="attribute[]"  value="<?php echo $attr; ?>"placeholder="Unit">    
                    </div>
                    <div class="col-5">
                      <input type="textbox" class="form-control" name="price[]" value="<?php echo $price; ?>"  placeholder="Price">
                    </div>
                    
                  </div>
                </div>
                <!-- <button type="button" class="btn btn-danger mr-2" id="addmore" onclick="add_more()">Add More</button> -->
                <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                <button type="submit" class="btn btn-light mr-2" name="cancel">Cancel</button>
                
              </form>
            </div>
          </div>
        </div>
            
     </div>
     <input type="hidden" id="box_id" value="1"/>
<script>

//alert(boxid);
function add_more(){
  var boxid=$('#box_id').val();
  boxid++;
  jQuery('#box_id').val(boxid);
var str='<div class="row" id="box'+boxid+'"><div class="col-5"><input type="textbox" class="form-control" name="attribute[]"  placeholder="Attribute"></div><div class="col-5"><input type="textbox" class="form-control" name="price[]"  placeholder="Price"></div><div class="col-2"><button type="button" class="btn btn-danger mr-2" id="removebox" onclick=remove_box("'+boxid+'")>Remove</button></div></div>';
jQuery('#more_detail').append(str);  
}
function remove_box(boxid){
  jQuery('#box'+boxid).remove();
  boxid--;
  $('#box_id').val(boxid);
}

</script>
<?php
include('footer.php');
 ?>
        
		