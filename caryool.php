<?php
session_start();
class cartool{
	private static $ins=null;
	private  $items=array();
	//final protected function __construct(){

	//}
	//protected static function getins(){
	//	if(!(self::$ins instanceof self)){
	//		self::$ins = new self;
	//	}
	//	return self::$ins;
	//}
	//public static function getcart(){
		//if(!isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof self)){
	//		$_SESSION['cart']=self::getins();
	//	}
	//	return $_SESSION['cart'];
	//}
	public function additem($id,$name,$price,$num=1,$thumb_img,$mprice){
		if ($this->hasitem($id)){
			$this->incrnum($id,$num);
		}
		$item=array();
		//$item[$id]=array();
		//$item['goods_id']=$id;
		$item['name']=$name;
		$item['price']=$price;
		$item['num']=$num;
		$item['thumb_img']=$thumb_img;
		$item['market_price']=$mprice;
		//var_dump($item);
		$this->items=$item;
		//var_dump($this->items);
		$_SESSION['cart']['a']=1;
		var_dump($_SESSION);
		return $this->items;
	}
	public function clear(){
		$this->items=arrray();
	}
	public function hasitem($id){
		return array_key_exists($id,$this->items);
	}
	public function modnum($id,$num=1){
		if(!$this->hasitem($id)){
			return false;
		}
		$this->items[$id]['num']=$num;
	}
	public function incrnum($id,$num=1){
		if($this->hasitem($id)){
			$this->items[$id]['num']+=$num;
		}
	}
	public function deleteitem($id,$num=1){
		unset($this->items[$id]);
	}
	public function decnum($id){
		if($this->hasitem($id)){
			$this->items[$id]['num']-=$num;
			if($this->items[$id]['num']<1){
				$this->deleteitem($id);
			}
		}
	}
	public function getcnt(){
		return count($this->items);
	}
	public function getnum(){
		if($this->getcnt()==0){
			return 0;
		}
		$sum=0;
		foreach ($this->items as $value) {
			$sum+=$value['num'];
		}
		return $sum;
	}
	public function getprice(){
		if($this->getcnt()==0){
			return 0;
		}
		$price=0.0;
		foreach ($this->items as $value) {
			$price+=$value['num']*$value['price'];
		}
		return $price;
	}
	public function all(){
		return $this->items;
	}

}
//$r=cartool::getcart();
//var_dump($r);

?>