<?php
session_start();
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$id=$_GET['goods_id'];
$sql='select * from goods where goods_id='.$id;
$good=mysqli_query($con,$sql);
foreach ($good as $value) {
	$good=$value['cat_id'];
	//print_r($value['goods_name']);
}
//var_dump($good);
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
 	//var_dump($tree);
    return $tree;

}
$nav=[];
$sql='select * from category';
//var_dump($good);
$nav=mysqli_query($con,$sql);
$nav=familytree($nav,$good);
//var_dump($nav);
$sql='select * from goods where goods_id='.$id;
$gs=mysqli_query($con,$sql);
foreach ($gs as $value) {
	$g=$value;
}
include('./view/front/shangpin.html');
?>