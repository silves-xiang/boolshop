<?php
$id=$_GET['goods_id'];
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
print_r($id);
$sql='update goods set is_delete=1 where goods_id='.$id;
var_dump($sql);
mysqli_query($con,$sql);
header("Location:goodslist.php");
?>