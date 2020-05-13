<?php
session_start();
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$sql='select * from goods  where is_new=1 limit 5';
$newlist=mysqli_query($con,$sql);
$sql='select * from category';
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
$woman=$obj->gettree($result,4);
$felist=[];
foreach ($woman as $value) {
	//print_r($value['cat_id']);
	$sql='select * from goods where cat_id='.$value['cat_id'];
	$f=mysqli_query($con,$sql);
	foreach ($f as $value) {
		$felist[]=$value;
	}
}
$mobj= new db();
$manlist=[];
$man=$mobj->gettree($result,1);
foreach ($man as $value) {
	//print_r($value['cat_id']);
	$sql='select * from goods where cat_id='.$value['cat_id'];
	$f=mysqli_query($con,$sql);
	foreach ($f as $value) {
		$manlist[]=$value;
	}
}
//ar_dump($catlist);
//ar_dump($find);
include('./view/front/index.html');
?>