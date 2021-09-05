<?php 
  include('top.php');
  if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
    $type=$_GET['type'];
    $id=$_GET['id'];
    if($type=='active' || $type == 'deactive'){
      $status=1;
      if($type=='deactive'){
        $status=0;
      }
      $con->query("update stock set status='$status' where id='$id'");
    }
    
  }
  $sql="select id,(select dish from dish where id=product_id) as product,opening_stock,current_stock,status,added_on from stock order by product_id";
  $res=$con->query($sql);


 ?>         
          <h1 class="card-title ml10">Stock Detail</h1>
          <div class="card">
            <div class="card-body">
              <!-- <a href="addboy.php"><label class="badge badge-info cursor-hand">Add Boy</label></a> -->
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S No.</th>
                            <th width="30%">Product</th>
                           <th width="15%">Opening Stock</th>
                           <th width="15%">Current Stock</th>
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
                                <td><?php echo $row['product']?></td>
                                <td><?php echo $row['opening_stock']?></td>
                                <td><?php echo $row['current_stock']?></td>
                                <td>
                                  <?php 
                                $datestr=strtotime($row['added_on']);

                                  echo date('d-m-Y',$datestr); ?>
                                </td>

                                <td>
                                  <a href="addstock.php?id=<?php echo $row['id']?>&type=edit"><label class="badge badge-info cursor-hand">Edit</label></a>
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