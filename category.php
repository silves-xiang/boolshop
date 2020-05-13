<?php
session_start();
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
//var_dump($_GET['page']);
//var_dump($_GET['cat_id']);
$page=isset($_GET['page'])?$_GET['page']+0:1;
if ($page<1){
	$page=1;
}
//var_dump($page);
$perpage=2;
$cperpage=0;
$offset=($page-1)*$perpage;
$sql='select * from category';
$catlist=mysqli_query($con,$sql);
//ar_dump($catlist);
$result = array();
$cat_id=isset($_GET['cat_id'])?$_GET['cat_id']+0:0;
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
function familytree($arr,$id) {
    $tree = array();
     
    foreach($arr as $v) {
        if($v['cat_id'] == $id) {// 判断要不要找父栏目
            if($v['parent_id'] > 0) { // parnet>0,说明有父栏目
                $tree = array_merge($tree,familytree($arr,$v['parent_id']));
            }
 
            $tree[] = $v; // 以找到上地为例
        }
    }
 
    return $tree;
}
$nav=familytree($result,$cat_id);
//var_dump($r);	
//var_dump($cat_id);
//var_dump($nav);
$obj= new db();
//ar_dump($result);
$sort=$obj->gettree($result,0);
//var_dump($cat_id);
$i=1;
$n=1;
$zon=0;
$goodsn=new db();
$goodslists=$goodsn->gettree($result,$cat_id);
if(!empty($goodslists)){
	$goodslist=[];
foreach ($goodslists as $value) {
	$sqli='select * from goods where cat_id='.$value['cat_id'];
	//var_dump($sqli);
	$reslt=mysqli_query($con,$sqli);
	$zon+=mysqli_num_rows($reslt);
	//var_dump($value['cat_id']);

	while ($row=mysqli_fetch_assoc($reslt)) {
		
		$goodslits[$n]=$row;
		$n++;
	}

	}
$pge=$page*2;
//var_dump($goodslits);
$goodslist[]=$goodslits[$pge-1];
if(isset($goodslits[$pge])){
	$goodslist[]=$goodslits[$pge];
}
}
	//var_dump($page);
//unset($goodslists);

if(empty($goodslists)){
	$goodslist=[];
	$d=($page*$perpage)-1;
	//var_dump($d-1);
	$sql='select * from goods where cat_id='.$cat_id.' limit '.((($page-1)*$perpage)).','.$perpage;
	//var_dump($sql);
	$sqli='select * from goods where cat_id='.$cat_id;
	$reslt=mysqli_query($con,$sqli);
	$zon+=mysqli_num_rows($reslt);
	$goodslist=mysqli_query($con,$sql);
}
$pagecode=ceil($zon/$perpage);
include('./view/front/lanmu.html');
?>