<?php
session_start();
$id=$_GET['goods_id'];
$all=$_SESSION['cart'];
foreach ($all as $value) {
	foreach ($value as $vale) {
		if ($id==$vale){
		unset($_SESSION['cart'][$vale]);
		echo "成功";
		header("Location:flow.php?act=buy");
	}
	}
	
}
var_dump($_SESSION);
?>