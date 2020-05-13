<?php
session_start();
//var_dump($_SESSION['cart']);
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$ky=array();
foreach ($_SESSION['cart'] as $key => $value) {
	$ky[]=$key;
}
//var_dump($ky);
//var_dump($_POST);
foreach ($ky as $key => $value) {
	$sql='select goods_number from goods where goods_id='.$value;
	$tt=mysqli_query($con,$sql);
	foreach ($tt as $key => $value) {
		//print_r($value['goods_number']);
		//var_dump($value);
		foreach ($_POST as $key => $alue) {

			if(($alue+0) !=0){
				//var_dump($alue);
				if ($alue>$value['goods_number']) {
			echo "库存不足";
	echo '<script type="text/javascript">window.alert("库存不足");</script>';
//echo '<script language="JavaScript">;alert("这是";location.href="flow.php?act=buy";</script>';
	//sleep(2);
	header("Location: flow.php?act=buy");
			header("Refresh:1;url=flow.php?act=buy");
		}else{
			//echo "库存充足";
		}
			}
			
		}
		
	}
}
foreach ($_POST as $key => $value) {
	foreach ($ky as $my => $mv) {
		if($mv==$key){
			$_SESSION['cart'][$key]['$goods_num']=(int)$value;
		}
	}
}
//var_dump($_SESSION);
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$items=[];
foreach ($ky as $value) {
	$sql='select * from goods where goods_id ='.$value;
//	var_dump($sql);
	$r=mysqli_query($con,$sql);
	foreach ($r as $value) {
		$items[]=$value;
	}
}
	$total=0;
	$market_total=0;
	foreach ($items as $value) {
	//	var_dump($value);
		$total+=$_SESSION['cart'][$value['goods_id']]['$goods_num']*$value['shop_price'];
		$market_total+=$_SESSION['cart'][$value['goods_id']]['$goods_num']*$value['market_price'];
	}
	//var_dump($market_price);
	$discount=$market_total-$total;
	if($market_total>0){
		$rate=($total/$market_total)*100;
	}else{
		$rate=0;
	}
	
	

include('./view/front/tijiao.html');
?>