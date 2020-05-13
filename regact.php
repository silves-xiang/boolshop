<?php
//print_r($_POST);
$con=mysqli_connect('localhost','root','');
$sql='use bool';
mysqli_query($con,$sql);
$data=$_POST;
$data['regtime']=time();
//var_dump($data);
$data['username']=addslashes($data['username']);
$data['passwd']=addslashes($data['passwd']);
$data['email']=addslashes($data['email']);
$data['passwd']=md5($data['passwd']);
$data['repasswd']=md5($data['repasswd']);
if($data['email'] !=''){

}
$len=strlen($data['username']);
//echo $len;
if ($len>15){
	echo '<script type="text/javascript">window.alert("用户名不能超过15个字符");</script>';
	header("Refresh:1;url=reg.php");
}else{
	if ($data['passwd'] !=$data['repasswd']) {
	echo '<script type="text/javascript">window.alert("两次密码不一致");</script>';
	header("Refresh:1;url=reg.php");
}
else{
	$sq="select username from user where username='".$data['username']."'";
	//var_dump($sq);
	$result=mysqli_query($con,$sq);
	//var_dump($result);
	if (mysqli_num_rows($result)) {
		echo '<script type="text/javascript">window.alert("用户名不能重复");</script>';
		header("Refresh:1;url=reg.php");
	}else{$r=filter_var($data['email'],FILTER_VALIDATE_EMAIL);
		if(!$r){
			echo '<script type="text/javascript">window.alert("email格式错误");</script>';
	header("Refresh:1;url=reg.php");
		}else{
	$sql="insert into user (username,email,passwd,regtime) values('".$data['username']."','".$data['email']."','".$data['passwd']."',".$data['regtime'].")";
	if(mysqli_query($con,$sql)){
	$msg='注册成功';
}else{
	$msg='注册失败';
}
include('./view/front/msg.html');}
	//header("Refresh:1;url=reg.php");
//var_dump($sql);
//var_dump($sql);

}
}
}


?>