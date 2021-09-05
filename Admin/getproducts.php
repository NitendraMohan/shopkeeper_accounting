
<?php 
include('db.inc.php');
include('functions.inc.php');
include('constant.inc.php');
$data=$_GET['datavalue'];
$sql="select * from dish where category_id='$data' and status='1'";
$res=$con->query($sql);

if($res->num_rows>0){
	while($row=$res->fetch_assoc()){
		$id=$row['id'];
		$dish=$row['dish'];
		echo "<option value='$id'>$dish</option>";
	
	}
}


 ?>