<?php

defined('key') || exit('ホームページにアクセスしてください');
class CartTool{
	private static $ins = null;
	private $items = array();
	//private $sign = 0;

	final protected function __construct(){}

	final protected function __clone(){}

	protected static function getIns(){
		if(!self::$ins instanceof self){
			self::$ins= new CartTool();
		}
		return self::$ins;
	}

	public static function getCart(){
		if (!isset($_SESSION['cart']) || (!$_SESSION['cart'] instanceof self)) { // セッションの中にcartがない、またcartが自分のオブジェクトではない場合
				 $_SESSION['cart'] = self::getIns(); //オブジェクトを作成して、cartに与える。
		}
     	return $_SESSION['cart'];
    }

 	public function addItem($id,$name,$price,$num=1){ //カートに商品を追加
 		if($this->hasItem($id)){                      //カートに商品が存在している場合、商品の数を追加
 			$this->incNum($id,$num);
 			return;
 		}
 		$items=array();
 		$items['name']=$name;
 		$items['price']=$price;
 		$items['num']=$num;

 		$this->items[$id]=$items;
 	}

 	// public function clear(){　　　　　　　　　　　　　　　　　　　//　カートに存在する商品を削除
 	// 	$this->items= array();　
 	// }
 	public function clear(){
 		$this->items=array();
 	}

 	public function hasItem($id){                 //カートに商品が存在するかどうかの確認
 		return array_key_exists($id, $this->items);
 	}

 	public function modNum($id,$num){               // カートに存在する商品の数を修正
 		if(!$this->hasItem($id)){
 			return false;
 		}
 		$this->items[$id]['num']=$num;
 	}

 	public function incNum($id,$num=1){                     // カートに存在する商品の数を追加
 		if($this->hasItem($id)){
 			$this->items[$id]['num']+=$num;
 		}
 	}

	public function decNum($id,$num=1){                     // カートに存在する商品の数を削除
 		if($this->hasItem($id)){
 			$this->items[$id]['num']-=$num;
 		}
 		if($this->items[$id]['num']<1){
 			$this->delItem($id);
 		}
 	}

 	public function delItem($id){               // カートに存在する商品を削除
 		unset($this->items[$id]);
 	}

 	public function getCnt(){                       // カートに存在する商品のid確認
 		return count($this->items);
 	}

 	public function getNum(){                   //カートに存在する商品の数を確認
 		if($this->getCnt() == 0){
 			return 0; 
 		}
 		$sum = 0;

 		foreach ($this->items as $v){
 			$sum+=$v['num'];
 		}
 		return $sum;
 	}

 	public function getPrice(){                         // カートに存在する商品の価格を確認
 		if($this->getCnt() == 0){
 			return 0;
 		}

 		$price = 0.0;
 		foreach ($this->items as $v) {
 			$price+= $v['num']*$v['price'];
 		}
 		return $price;
 	}    

 	public function retItems(){                          //カートに存在する商品をreturn
 		return $this->items;
 	}     

 }

//  $cart = CartTool::getCart();
// if(!isset($_GET['test'])){
// 	$_GET['test']='';
// }

// if($_GET['test'] == 'add'){
// 	$cart->addItem(1,'woqu',33.4,1);
// 	echo "ok";	
// }
// else if($_GET['test'] == 'addji'){
// 	$cart->addItem(2,'ji',100.4,2);
// 	echo "ok";	
// }
// else if($_GET['test'] == 'clear'){
// 	$cart->clear();
// 	echo "del";
// }
// else if($_GET['test'] == 'show'){
// 	print_r($cart->retItems());
// 	echo '<br />';
// 	echo '共',$cart->getCnt(),'zhong',$cart->getNum(),'个商品<br />';
// 	echo '共',$cart->getPrice(),'円';
// }
// else{
// 	print_r($cart);
// }

?>