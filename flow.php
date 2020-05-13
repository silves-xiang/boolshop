<?php
session_start();
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$act=isset($_GET['act'])?$_GET['act']:'buy';
//var_dump($_SESSION);
//$num=$_GET['number'];
//var_dump($num);
$items=[];
//$cat= new cartool();
//var_dump($_GET['num']);
if ($act=='buy'){
	$goods_id=isset($_GET['goods_id'])?$_GET['goods_id']+0:0;
	$num=isset($_GET['num'])?$_GET['num']+0:1;
	if($goods_id){
		//$_SESSION['cart'][$goods_id]=$goods_id;
		$_SESSION['cart'][$goods_id]['$goods_id']=$goods_id;
		$_SESSION['cart'][$goods_id]['$goods_num']=1;
		//print_r($_SESSION['cart']);
	}
	foreach ($_SESSION['cart'] as $key => $value) {
		$sql='select * from goods where goods_id='.$value['$goods_id'];
		$now=mysqli_query($con,$sql);
		foreach ($now as $value) {
			if (array_key_exists($value['goods_id'],$items)){
			$num++;
			}else{
				$items[]=$value;
			}
			
			//if($value['goods_id'] !=$items['goods_id']){
			//
			//var_dump($value);
		}
		//$items[]=$now;
	}
	//var_dump($items);
	$total=0;
	$market_total=0;
	foreach ($items as $value) {
		//var_dump($value);
		$total+=$num*$value['shop_price'];
		$market_total+=$num*$value['market_price'];
	}
	//var_dump($market_price);
	$discount=$market_total-$total;
	if ($market_total>0) {
		$rate=($total/$market_total)*100;
	}else{
		$rate=0;
	}
	

	
}
if($act=='clear'){
	$items=array();
	header("Location:inde.php");
}
include('./view/front/jiesuan.html');
?>