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
      $con->query("update sale_order set status='$status' where id='$id'");
    }
   
  }
  $sql="select id,(select name from customer where id=customer_id) as customer,order_number,sale_date,total_bill,status,added_on from sale_order order by order_number";
  $res=$con->query($sql);


 ?>         
          <h1 class="card-title ml10">Sale Order</h1>
          <div class="card">
            <div class="card-body">
              <a href="addsale.php"><label class="badge badge-info cursor-hand">Add Sale Order</label></a>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S No.</th>
                            <th width="20%">Customer</th>
                            <th width="20%">Order Number</th>
                            <th width="10%">Sale Date</th>
                            <th width="10%">Total Bill</th>
                            <th width="30%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>

                  <?php echo $res->num_rows;  if($res->num_rows>0){ 
                    $i=1;
                        while($row=$res->fetch_assoc()){  ?>
                            <tr>
                                <td><?php echo $i?></td>
                                <td><?php echo $row['customer']?></td>
                                <td><?php echo $row['order_number']?></td>
                               
                                <td>
                                  <?php 
                                $datestr=strtotime($row['sale_date']);

                                  echo date('d-m-Y',$datestr); ?>
                                </td>
                                <td><?php echo $row['total_bill']?></td>
                                <td>
                                  <a href="addpurchase.php?id=<?php echo $row['id']?>&type=edit"><label class="badge badge-info cursor-hand">Edit</label></a>
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