<?php
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$id=$_GET['cat_id']+0;
//var_dump($id);

$sql='select * from category where cat_id='.$id;
$catlist=mysqli_query($con,$sql);
foreach ($catlist as $value) {
	$intro=$value;
}
//print_r($intro['cat_name']);
$sql='select * from category';
//$catlist=mysqli_query($con,$sql);
$catlist=mysqli_query($con,$sql);
//ar_dump($catlist);
$result = array();
if($catlist) {
	//转化为数组
	while($value = $catlist->fetch_array()) {
		$result[] = $value;
	}
}
//ar_dump($result);
class db{
	public function gettree($arr,$id = 0,$lev = 0){
		$tree = array();
		foreach($arr as $v){
			if($v['parent_id'] == $id){
				$v['lev']=$lev;
				$tree[] = $v;
//				var_dump($tree);
				$tree = array_merge($tree,$this->gettree($arr,$v['cat_id'],$lev+1));
			}
		}
//		var_dump($tree);
		return $tree;
	}
}

//include('.iew/admin/templates/catelist.html');
$obj= new db();
//ar_dump($result);
$catlist=$obj->gettree($result,0);
$result=array();
foreach ($catlist as $value) {
	$result[]=$value;
}
include('./view/admin/templates/catedit.html');
?>