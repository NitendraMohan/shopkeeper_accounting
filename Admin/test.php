<?php 
// header('Content-type: text/plain');
// echo "*****";
// for($i=1;$i<=3;$i++){
// 	echo "\n*   *";
// }
// echo "\n*****";
//==================================
// class ArrayOperations{

// function sort(&$arr_arg){
// 	sort($arr_arg);	
// }
// }

//  $arr=array(11, -2, 4, 35, 0, 8, -9);
//  $arrOp=new ArrayOperations();
//  $arrOp->sort($arr);
//  echo '<pre>';
//  print_r($arr);
//======================================
$array1 = array(array(77, 87), array(23, 45));
$array2 = array("superHumanRace", "com");
$array3 = array_merge($array1,$array2);
echo '<pre>';
print_r($array3);

  ?>