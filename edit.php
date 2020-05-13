<?php
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$data['cat_name']=$_POST['cat_name'];
$data['parent_id']=$_POST['parent_id']+0;
$data['intro']=$_POST['intro'];
$data['cat_id']=$_POST['cat_id']+0;
print_r($data);
//var_dump($data['cat_id']);
$sql="update category set cat_name='".$data['cat_name']."',parent_id=".$data['parent_id'].",intro='".$data['intro']."' where cat_id=".$data['cat_id'];
//print_r($sql);
$sql='select * from category where parent_id='.$data['cat_id'];
//var_dump($sql);
$result=mysqli_query($con,$sql);
//print_r($_POST);
//print_r($sql);
//mysqli_query($con,$sql);

//print_r($tree);
if (!mysqli_num_rows($result)){
	$sql="update category set cat_name='".$data['cat_name']."',parent_id=".$data['parent_id'].",intro='".$data['intro']."' where cat_id=".$data['cat_id'];
	//var_dump($sql);
	mysqli_query($con,$sql);
	echo "修改成功";
}else{
foreach ($result as $value) {
	//print_r($value);
	if ($value['parent_id']==$data['cat_id']) {
		echo "修改失败";
	}
}}
header("Location:catelist.php");
?>