<?php 
  include('top.php');
  
  if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
    $type=$_GET['type'];
    $id=$_GET['id'];
    if($type=='delete'){
        $sql="delete from category where id='$id'";
        $con->query($sql);
        redirect('category.php');
    }


    else if($type=='active' || $type == 'deactive'){
      $status=1;
      if($type=='deactive'){
        $status=0;
      }
      $con->query("update category set status='$status' where id='$id'");
      
      
    }
  }
  $sql="select * from category order by order_number";
  $res=$con->query($sql);


 ?>         
          <h1 class="card-title ml10">Category</h1>
          <div class="card">
            <div class="card-body">
              
              <a href="addcategory.php"><label class="badge badge-info">Add Category</label></a>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S No.</th>
                            <th width="40%">Category</th>
                            <th width="20%">Order Number</th>
                           
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
                                <td><?php echo $row['order_number']?></td>
                                <td>
                                    <a href="addcategory.php?id=<?php echo $row['id'] ?>"><label class="badge badge-info cursor-hand">Edit</label></a>
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
                                    
                                    &nbsp;
                                    <a href="?id=<?php echo $row['id']?>&type=delete"><label class="badge badge-danger cursor-hand delete-bg">Delete</label></a>
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