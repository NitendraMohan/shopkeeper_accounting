<?php 
  include('top.php');
  include('constant.inc.php');
  if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
    $type=$_GET['type'];
    $id=$_GET['id'];
    if($type=='active' || $type == 'deactive'){
      $status=1;
      if($type=='deactive'){
        $status=0;
      }
      $con->query("update dish set status='$status' where id='$id'");
    }
    
  }
  $sql="select id,(select category from category where id=category_id) as category,dish,image,status,added_on from dish order by dish";
  $res=$con->query($sql);
  
 ?>         
          <h1 class="card-title ml10">Product</h1>
          <div class="card">
            <div class="card-body">
              <a href="addproduct.php"><label class="badge badge-info cursor-hand">Add Product</label></a>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S No.</th>
                            <th width="20%">Category</th>
                            <th width="20%">Product</th>
                            <th width="10%">Image</th>
                            <th width="10%">Added On</th>
                            <th width="30%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>

                  <?php echo $res->num_rows;  if($res->num_rows>0){ 
                    $i=1;
                        while($row=$res->fetch_assoc()){  ?>
                            <tr>
                                <td><?php echo $i?></td>
                                <td><?php echo $row['category']?></td>
                                <td><?php echo $row['dish']?></td>
                                <td><img src="<?php echo SITE_DISH_IMAGE.$row['image']?>"/> </td>

                                <td>
                                  <?php 
                                $datestr=strtotime($row['added_on']);

                                  echo date('d-m-Y',$datestr); ?>
                                </td>

                                <td>
                                  <a href="addproduct.php?id=<?php echo $row['id']?>&type=edit"><label class="badge badge-info cursor-hand">Edit</label></a>
                                  &nbsp;
                                    <?php 
                                    if($row['status']==1){?>
                                      <a href="?id=<?php echo $row['id']?>&type=deactive"><label class="badge badge-success cursor-hand">Active</label></a>
                                    <?php } 
                                    else{ ?>
                                      <a href="?id=<?php echo $row['id']?>&type=active"><label class="badge badge-success cursor-hand">Deactive</label></a>  
                                    <?php
                                    }
                                    ?>
                                </td>
                                
                            </tr>    
                      <?php
                      $i++;
                       }} ?>  
                    
                      </tbody>
                    </table>
                  </div>
		        		</div>
              </div>
            </div>
          </div>
<?php 
  include('footer.php');
 ?>