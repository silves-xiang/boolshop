<?php
$con=mysqli_connect('localhost','root','');
mysqli_query($con,'use bool');
$data=$_POST;
$data['add_time']=time();
$data['is_best']=isset($_POST['is_best'])?1:0;
$data['is_new']=isset($_POST['is_new'])?1:0;
$data['is_hot']=isset($_POST['is_hot'])?1:0;
$data['is_on_sale']=isset($_POST['is_on_sale'])?1:0;
$file=$_FILES;
$allowext='jpg,jpeg,gif,bmp,png';
var_dump($file);
$path=getcwd();
function getext($file){
	$temp=explode('.',$file);
	return end($temp);
	//查找后缀
}
function isallow($ext,$allowext){
	return in_array(strtolower($ext),explode(',',$allowext));
//检查后缀
}
function is_allow_size($size){
	$max_size=1;
	if ($size<=$max_size*1024*1024) {
		return true;
	}else{
		return false;
	}
}
function make_dir($path){
	$dir='./data/images/'.date('Ym/d');
	if (is_dir($dir) || mkdir($dir,0777,true)){
		return $dir;
	}else{
		return false;
	}
}
function randname($length){
	$str='abcdefghigklmnopqrstuvwxyz23456789';
	return substr(str_shuffle($str),0,$length);
}
$f=$_FILES['ori_img'];
$ext=getext($f['name']);
if(!isallow($ext,$allowext)){
	return false;
}
if(!is_allow_size($f['size'])){
	return false;
}
$dir=make_dir($path);
if($dir==false){
	echo "创建失败";
}
$newname=randname(5).".".$ext;
if(!move_uploaded_file($f['tmp_name'],$dir.'/'.$newname)){
	echo 'false';
}
else{
	var_dump($f['tmp_name']);
	var_dump($dir."/".$newname);
}
$save=$dir."/".$newname;
$data['ori_img']=$save;
$data['goods_img']=$save;
$data['thumb_img']=$save;
//var_dump($dir);
//var_dump($img);
//var_dump($_POST);
//var_dump($data);

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
$re=new goodssn();
$data['goods_sn']=$re->creatsn($con);
$sql="INSERT INTO goods (cat_id,goods_name,shop_price,market_price,goods_number,goods_weight,goods_brief,goods_desc,is_on_sale,is_best,is_new,is_hot,add_time,ori_img,goods_img,thumb_img,goods_sn) VALUES (".$data['cat_id'].",'".$data['goods_name']."',".$data['shop_price'].",".$data['market_price'].",".$data['goods_number'].",".$data['goods_weight'].",'".$data['goods_brief']."','".$data['goods_desc']."',".$data['is_on_sale'].",".$data['is_best'].",".$data['is_new'].",".$data['is_hot'].",".$data['add_time'].",'".$data['ori_img']."','".$data['goods_img']."','".$data['thumb_img']."','".$data['goods_sn']."')";
$result=mysqli_query($con,$sql);
//var_dump($result);
//var_dump($sql);
//header("Location:goodslist.php");
?>