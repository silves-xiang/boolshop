<?php
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$id=$_GET['cat_id']+0;
$sql='select * from category where parent_id='.$id;
//var_dump($sql);
$re=mysqli_query($con,$sql);
if (mysqli_num_rows($re)<1){
	$sql='delete from category where cat_id='.$id;
//	var_dump($sql);
	mysqli_query($con,$sql);
	print_r('删除成功');
}else{
	exit('有子栏目，不允许');
}
//var_dump($sql);

//mysql_query($con,)
include('./catelist.php');
?>