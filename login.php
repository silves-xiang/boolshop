<?php
$con=mysqli_connect('localhost','root','');
$sql='use bool';
mysqli_query($con,$sql);
session_start();
if(isset($_POST['act'])){
if($_POST['act'] == 'act_login'){
	$data=$_POST;
	$data['username']=addslashes($data['username']);
	$data['passwd']=addslashes($data['passwd']);
	$sql="select * from user where username='".$data['username']."'";
	$people=mysqli_query($con,$sql);
	$re=mysqli_num_rows($people);
	if($re){
		foreach ($people as $value) {
		if ($value['passwd'] !=md5($data['passwd'])){
			$msg='登录失败,密码错误';
			header("Refresh:1;url=login.php");
			echo $msg;
		}else{
			$msg='登录成功';
			$_SESSION=$value;
			if(isset($_POST['remember'])){
				setcookie('remuser',$data['username'],time()+14*24*3600);
			}else{
				setcookie('remuser','',0);
			}

			header("Refresh:1;url=inde.php");
			echo $msg;
		}
	}
}else{
	echo "未找到此用户";
	header("Refresh:1;url=login.php");
}
}}else{
	$remuser=isset($_COOKIE['remuser'])?$_COOKIE['remuser']:'';
	include('./view/front/denglu.html');
}
?>