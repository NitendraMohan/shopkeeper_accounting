
<?php 
include('db.inc.php');
include('functions.inc.php');
include('constant.inc.php');
$data=$_GET['datavalue'];
$sql="select dish,(select attribute from dish_detail where dish_id=dish.id) as unit,(select price from dish_detail where dish_id=dish.id) as price,(select current_stock from stock where product_id=dish.id) as current_stock from dish where dish.id='$data'";

$res=$con->query($sql);

if($res->num_rows>0){
	$row=$res->fetch_assoc();
	echo json_encode($row);
	
}


 ?>