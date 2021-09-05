<?php 
  include('top.php');
  if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
    $type=$_GET['type'];
    $id=$_GET['id'];
    if($type=='delete')
    {
      $con->query("delete from coupan_code where id='$id'");
      redirect('coupancode.php');

    }
    if($type=='active' || $type == 'deactive'){
      $status=1;
      if($type=='deactive'){
        $status=0;
      }
      $con->query("update coupan_code set status='$status' where id='$id'");
    }
    
  }
  $sql="select * from coupan_code order by coupan_code";
  $res=$con->query($sql);


 ?>         
          <h1 class="card-title ml10">coupan code</h1>
          <div class="card">
            <div class="card-body">
              <a href="addcoupan.php"><label class="badge badge-info cursor-hand">Add Coupan</label></a>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S No.</th>
                            <th width="10%">Coupan Code</th>
                           <th width="10%">Type</th>
                           <th width="10%">Value</th>
                           <th width="10%">Min Cart Value</th>
                           <th width="10%">Expired on</th>
                           <th width="10%">Added On</th>
                            <th width="30%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>

                  <?php echo $res->num_rows;  
                  if($res->num_rows>0){ 
                    $i=1;
                        while($row=$res->fetch_assoc()){  ?>
                            <tr>
                                <td><?php echo $i?></td>
                                <td><?php echo $row['coupan_code']?></td>
                                <td><?php echo $row['coupan_type']?></td>
                                <td><?php echo $row['coupan_value']?></td>
                                <td><?php echo $row['cart_min_value']?></td>
                                <td><?php echo date('d-m-Y',strtotime($row['expired_on']))?></td>
                                <td>
                                  <?php 
                                $datestr=strtotime($row['added_on']);

                                  echo date('d-m-Y',$datestr); ?>
                                </td>

                                <td>
                                  <a href="addcoupan.php?id=<?php echo $row['id']?>&type=edit"><label class="badge badge-info cursor-hand">Edit</label></a>
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
                                <a href="?id=<?php echo $row['id']?>&type=delete"><label class="badge badge-danger cursor-hand">Delete</label></a>
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