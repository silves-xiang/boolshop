<?php
//print_r($_POST)
//include('./catmodel.php');
$data=array();
$cat_name=$_POST['cat_name'];
$intro=$_POST['intro'];
$data['cat_name']=$cat_name;
$data['intro']=$intro;
$cat_id=$_POST['parent_id'];
print_r($data);
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
function insert($name,$intro,$id,$con){
	$sql="insert into category (cat_name,intro,parent_id) values ('".$name."','".$intro."',".$id.")";
	var_dump($sql);
	mysqli_query($con,$sql);
}
insert($cat_name,$intro,$cat_id,$con);
header("location:catelist.php");

?>