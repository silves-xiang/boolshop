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
	//var_dump($save);
}
$save=$dir."/".$newname;
$data['ori_img']=$save;
$data['goods_img']=$save;
var_dump($save);
//var_dump($dir);
//var_dump($img);
//var_dump($_POST);
//var_dump($data);
var_dump($dir);
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
class imagetool{
	public static function imageinfo($image){
		if(!file_exists($image)){
			return false;
		}
		$info=getimagesize($image);
		//var_dump($info);
		if($info==false){
			return false;
		}
		$img['width']=$info[0];
		$img['height']=$info[1];
		$img['ext']=substr($info['mime'],strpos($info['mime'],'/')+1);
		return $img;
	}
	public static function water($dst,$water,$save_path=NULL,$pos=2,$alpha=50){
		$dinfo=self::imageinfo($dst);
		$winfo=self::imageinfo($water);
		if($winfo['height']>$dinfo['height'] || $winfo['width']>$dinfo['height']){

			return false;
		}
		$dfunc='imagecreatefrom'.$dinfo['ext'];
		$wfunc='imagecreatefrom'.$winfo['ext'];
		if (!function_exists($dfunc) || !function_exists($wfunc)){
			print_r($dfunc);
			print_r($wfunc);
			return false;
		}

		$dim=$dfunc($dst);
		$wim=$wfunc($water);
		switch ($pos) {
			case '0':
				$posx=0;
				$posy=0;
				break;
			case '1':
				$posx=$dinfo['width']-$winfo['width'];
				$posy=0;
				break;
			case '3':
				$posx=0;
				$posy=$dinfo['height']-$winfo['height'];
				break;
			default:
				$posx=$dinfo['width']-$winfo['width'];
				$posy=$dinfo['height']-$winfo['height'];
				break;
		}
		imagecopymerge($dim,$wim,$posx,$posy,0,0,$winfo['width'],$winfo['height'],$alpha);
		if(!$save_path){
			$save_path=$dst;
			unlink($dst);
		}
		$createfunc='image'.$dinfo['ext'];
		//var_dump($createfunc);
		$createfunc($dim,$save_path);
		imagedestroy($dim);
		imagedestroy($wim);
		return true;
	}
	public static function thumb($dst,$save_path=NULL,$width=200,$height=300){
		$dinfo=self::imageinfo($dst);
		if ($dinfo == false){
			return false;
		}
		$mw=$width/$dinfo['width'];
		$mh=$height/$dinfo['height'];

		$calc=min($mw,$mh);
		echo $calc;
		$dfunc='imagecreatefrom'.$dinfo['ext'];
		$dim=$dfunc($dst);
		$time=imagecreatetruecolor($width,$height);
		$white=imagecolorallocate($time,255,255,255);
		imagefill($time,0,0,$white);
		$dwidth=(int)$dinfo['width']*$calc;
		$dheight=(int)$dinfo['height']*$calc;
		$paddingx=(int)($width-$dwidth)/2;
		$paddingy=(int)($height-$dheight)/2;

		imagecopyresampled($time,$dim,$paddingx,$paddingy,0,0,$dwidth,$dheight,$dinfo['width'],$dinfo['height']);
		if(!$save_path){
			$save_path=$dst;
			unlink($dst);
		} 
		$createfunc='image'.$dinfo['ext'];
		$createfunc($time,$save_path);
		//echo "成功";
		return true;
		imagedestroy($time);
	}
}
//print_r(imagetool::imageinfo('./font.jpg'));
//imagetool::water('./font.jpg','./01.png','./home.jpg',1);
var_dump($save);
var_dump($dir."_thumbimg/");
if (!file_exists($dir."_thumbimg/")) {
	mkdir($dir."_thumbimg/");
}
imagetool::thumb($save,$dir."_thumbimg/".$newname,74,74);
$data['thumb_img']=$dir."_thumbimg/".$newname;
$re=new goodssn();
$data['goods_sn']=$re->creatsn($con);
$sql="INSERT INTO goods (cat_id,goods_name,shop_price,market_price,goods_number,goods_weight,goods_brief,goods_desc,is_on_sale,is_best,is_new,is_hot,add_time,ori_img,goods_img,thumb_img,goods_sn) VALUES (".$data['cat_id'].",'".$data['goods_name']."',".$data['shop_price'].",".$data['market_price'].",".$data['goods_number'].",".$data['goods_weight'].",'".$data['goods_brief']."','".$data['goods_desc']."',".$data['is_on_sale'].",".$data['is_best'].",".$data['is_new'].",".$data['is_hot'].",".$data['add_time'].",'".$data['ori_img']."','".$data['goods_img']."','".$data['thumb_img']."','".$data['goods_sn']."')";
$result=mysqli_query($con,$sql);
//var_dump($result);
//var_dump($sql);
header("Location:goodslist.php");
?>