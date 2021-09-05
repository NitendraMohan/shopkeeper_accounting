<?php 
include('top.php'); 
include('constant.inc.php');
$category_id="";
$customer_id="";
$order_number="";
$order_date="";
$total_bill=0;
$dish="";
$price=0;
$qty=0;
$amount=0;
$type="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc($con->query("select * from sale_order where id='$id'"));
  $order_number=$row['order_number'];
  $customer_id=$row['customer_id'];
  $sale_date=strtotime($row['sale_date']);
  $order_date=date('d-m-Y',$sale_date);
  // $dish=$row['dish'];
  // $dish_detail=$row['dish_detail'];
  // $row_detail=mysqli_fetch_assoc($con->query("select * from dish_detail where dish_id='$id'"));
} 
if(isset($_POST['cancel'])){
  redirect('sale_order.php');
}
if(isset($_POST['submit'])){
  $order_number=$_POST['order_number'];
  $order_date=$_POST['order_date'];
  $customer_id=$_POST['customer_id'];
   
  $added_on=date('Y-m-d h:m:s');
  
  if($id!=''){
    // $con->query("update sale_order set category_id='$category_id',dish='$dish',dish_detail='$dish_detail' $image_status where id='$id'");
    // redirect('purchase_order.php'); 
  }
  else{
    if(mysqli_num_rows(mysqli_query($con,"select * from sale_order where order_number='$order_number'"))>0){
    $msg="This Order Number already added";
  }
  else{
  $dishArr=$_POST['dish'];
  $priceArr=$_POST['price'];
  $qtyArr=$_POST['qty'];
  foreach ($priceArr as $key=>$value) {
    $price=$value;
    $qty=$qtyArr[$key];
    $amount=$price*$qty;
    $total_bill=$total_bill+$amount;

  }

  $con->query("insert into sale_order(customer_id, order_number, sale_date, total_bill, status, added_on) values('$customer_id','$order_number','$order_date','$total_bill',1,'$added_on')");
  
  $lastid=mysqli_insert_id($con);
  foreach($dishArr as $key=>$val){
    $dish=$val;
    $price=$priceArr[$key];
    $qty=$qtyArr[$key];
    $amount=$price*$qty;
    $con->query("insert into sale_order_detail(sale_order_id, product_id, product_qty, rate, price, status, added_on) values('$lastid','$dish','$qty','$price', '$amount',1 ,'$added_on')");
    $con->query("update stock set current_stock=current_stock-'$qty' where product_id='$dish'");
  }
  redirect('sale_order.php');
  }  
  }  
  }

$res_cat=$con->query("select * from category where status='1'");
$res_customer=$con->query("select * from customer where status='1'");
?>
<div class="row">
  <h1 class="card-title ml10">Manage Sale Order</h1>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputEmail3">Order Number</label>
                  <input type="textbox" class="form-control" name="order_number" value="<?php echo $order_number ?>" placeholder="Order Number"  required></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Order Date</label>
                  <input type="date" class="form-control" name="order_date" value="<?php echo $order_date ?>" placeholder="Order Date"  required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Customer Name</label>
                  <select class="form-control" name="customer_id" id="supplier" placeholder="Customer Name">
                      <option value="">Select Customer</option>
                      <?php 
                        while ($s_row=$res_customer->fetch_assoc()) {
                          if($s_row['id']==$customer_id){
                          echo "<option value='".$s_row['id']."'' selected>".$s_row['name']."</option>";  
                          }
                          echo "<option value='".$s_row['id']."''>".$s_row['name']."</option>";
                        }
                       ?>
                  </select>
                </div>
                <div class="form-group" id="more_detail">
                  <label for="exampleInputEmail3">Products Detail</label>
                  <div id="new_product">
                  <div class="row">
                    <div class="col-2 form-group">
                       <select class="form-control" onchange="getproducts(this)" name="category_id[]" id="category_id1" placeholder="Category">
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
                    <div class="col-2">
                      <select name="dish[]" id="dish1" class="form-control" onchange="get_product_detail(this)">
                      <option value="nodata">Select Product</option>
                      </select>
                    </div>
                    <div class="col-2">
                      <input type="textbox" class="form-control" name="stock[]" id="stock1" value="" placeholder="Current Stock"  disabled="true">   
                    </div>
                    <div class="col-2">
                      <input type="textbox" class="form-control" name="price[]" id="price1" value="" placeholder="Price">
                    </div>
                    <div class="col-2">
                      <input type="number" class="form-control" name="qty[]" id="qty1" value=""  placeholder="Qty">
                    </div>
                    <div class="col-2">
                      <input type="number" class="form-control" name="amount[]" id="amount1" value=""  placeholder="Amount">
                    </div>
                  </div>
                  </div>
                </div>
                <button type="button" class="btn btn-danger mr-2" id="addmore" onclick="add_more()">Add More</button>
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
 $('#new_product').clone(true).attr('id','new_product'+boxid).appendTo('#more_detail');
 $('#new_product'+boxid).find('#category_id1').attr('id','category_id'+boxid);
 $('#new_product'+boxid).find('#dish1').attr('id','dish'+boxid).html('<option value="nodata">Select Product</option>');
 $('#new_product'+boxid).find('#stock1').attr('id','stock'+boxid).val("");
 $('#new_product'+boxid).find('#price1').attr('id','price'+boxid).val("");
 $('#new_product'+boxid).find('#qty1').attr('id','qty'+boxid).val("");
 $('#new_product'+boxid).find('#amount1').attr('id','amount'+boxid).val("");
 $('#more_detail').append('<button type="button" class="btn btn-danger mr-2" id="removebox" onclick=remove_box("'+boxid+'")>Remove</button>');
//var str='<div class="row" id="box'+boxid+'"><div class="col-2 form-group"><select class="form-control" onchange="getproducts(this.value)" name="category_id[]" id="category_id'+boxid+'" placeholder="Category"><option value="">Select Category</option><?php while ($c_row=$res_cat->fetch_assoc()){if($c_row['id']==$category_id){echo "<option value='".$c_row['id']."'' selected>".$c_row['category']."</option>";}echo "<option value='".$c_row['id']."''>".$c_row['category']."</option>";}?></select></div><div class="col-2"><select name="dish[]" class="form-control" id="dish'+boxid+'" onchange="get_product_detail(this.value)"><option value="nodata">Select Product</option></select></div><div class="col-2"><input type="textbox" class="form-control" name="stock[]" id="stock'+boxid+'" value="" placeholder="Current Stock"  disabled="true"></div><div class="col-2"><input type="textbox" class="form-control" name="price[]" id="price'+boxid+'" value="" placeholder="Price" disabled="true"></div><div class="col-2"><input type="textbox" class="form-control" name="qty[]" id="qty'+boxid+'" value=""  placeholder="Qty"></div><div class="col-2"><input type="textbox" class="form-control" name="amount[]" id="amount'+boxid+'" value=""  placeholder="Amount"></div> <button type="button" class="btn btn-danger mr-2" id="removebox" onclick=remove_box("'+boxid+'")>Remove</button></div></div>';
//jQuery('#more_detail').append(str);  
}
function remove_box(boxid){
  jQuery('#new_product'+boxid).remove();
  boxid--;
  $('#box_id').val(boxid);
}
function getproducts(datav){
  $('#dish'+datav.id.substr(-1)).html('<option value="nodata">Select Product</option>')
  jQuery.ajax({
    url:'getproducts.php',
    type: 'GET',
    data: 'datavalue='+datav.value,
    success: function(result){
      //alert(datav.id.substr(-1));
      $('#dish'+datav.id.substr(-1)).append(result);
    }
  });
}
function get_product_detail(datav){
     
     $('#price'+datav.id.substr(-1)).val("0");
     $('#stock'+datav.id.substr(-1)).val("0");
  jQuery.ajax({
    url:'getproductdetail.php',
    type: 'GET',
    data: 'datavalue='+datav.value,
    datatype: 'text json',
    success: function(result){
     var obj=jQuery.parseJSON(result);
     
     $('#price'+datav.id.substr(-1)).val(obj.price);
     $('#stock'+datav.id.substr(-1)).val(obj.current_stock);
    }
  });
}
</script>
<?php
include('footer.php');
 ?>
        
		