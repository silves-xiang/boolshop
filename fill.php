<?php
session_start();
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
//var_dump($_POST);
$session=$_SESSION;
$items=[];
$num=1;
$time=time();
class goodssn{
	public function creatsn($con){
	//$con=mysqli_connect('localhost','root','');
	//mysqli_query($con,'use bool');
	$sn='BL'.date('Ymd').rand(10000,99999);
	$sql="select goods_sn from goods where goods_sn='".$sn."'";
	$tt=mysqli_query($con,$sql);
	$rew=mysqli_num_rows($tt);
	if ($rew){
		$this->creatsn($con);
	}
	return $sn;
	}
}
$sn=new goodssn();
$goodsn=$sn->creatsn($con);
//var_dump($goodsn);
foreach ($_SESSION['cart'] as $value) {
	$sql='select * from goods where goods_id ='.$value['$goods_id'];
	//var_dump($sql);
	$r=mysqli_query($con,$sql);
	foreach ($r as $value) {
		$items[]=$value;
	}
}
	$total=0;
	$market_total=0;
	foreach ($items as $value) {
		//var_dump($value);
		$total+=1*$value['shop_price'];
		$market_total+=1*$value['market_price'];
	}
	//var_dump($market_price);
	$discount=$market_total-$total;
	$rate=($total/$market_total)*100;

	$sql="insert into orderinfo (order_sn,user_id,username,zone, address,zipcode,reciver,email,tel,mobile,building,best_time, add_time,pay,order_amount) values ('".$goodsn."',".$session['user_id'].",'".$session['username']."','"."黑龙江"."','".$_POST['address']."','".$_POST['zipcode']."','".$session['username']."','".$_POST['email']."','".$_POST['tel']."',".$_POST['mobile'].",'".$_POST['building']."','".$_POST['best_time']."','".$time."',".$_POST['pay'].",".$total.")";
//var_dump($sql);
mysqli_query($con,$sql);
//var_dump($items);
foreach ($items as $value) {
$sql="insert into ordergoods (order_id,order_sn,goods_id,goods_name,goods_number,shop_price,subtotal) values (".$session['user_id'].",'".$goodsn."',".$value['goods_id'].",'".$value['goods_name']."',".$num.",".$value['shop_price'].",".$total.")";
mysqli_query($con,$sql);
//var_dump($sql);
}
//var_dump($sql);
$all=$_SESSION['cart'];
foreach ($all as $value) {
	//print_r($value);
	$sql='select goods_number from goods where goods_id='.$value['$goods_id'];
	//var_dump($sql);
	$ty=mysqli_query($con,$sql);
	$gnum=mysqli_fetch_array($ty);
	$sqlt='update goods set goods_number='.($gnum['goods_number']-$value['$goods_num']).' where goods_id='.$value['$goods_id'];
	//var_dump($sqlt);
	mysqli_query($con,$sqlt);
}
foreach ($all as $value) {
		unset($_SESSION['cart']);
		$msg='您已成功购买，订单号为'.$goodsn;
		
}
include('./view/front/msg.html');
//header("Location:inde.php");
?>