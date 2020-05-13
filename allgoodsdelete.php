<?php
session_start();
$id=$_GET['goods_id'];
$all=$_SESSION['cart'];
foreach ($all as $value) {
	foreach ($value as $vale) {
		unset($_SESSION['cart'][$vale]);
		echo "成功";
		header("Location:inde.php");
	}
	
}
var_dump($_SESSION);
?>