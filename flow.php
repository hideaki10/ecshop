<?php

/*
购物流程页面

*/
define('key',true);
require('./include/init.php');

//　ゲストの動作をゲットする。買うか住所を書くかなど
$act = isset($_GET['act'])?$_GET['act']:'buy';

//
$cart = CartTool::getCart();
$goods = new GoodsModel();
if($act == 'buy'){
	$goods_id = isset($_GET['goods_id'])?$_GET['goods_id']+0:0;
		$num = isset($_GET['num'])?$_GET['num']+0:1;
	if($goods_id){
		$goodslist = $goods->find($goods_id);
		if(!empty($goodslist)){

			if($goodslist['is_delete'] == 1 || $goodslist['is_on_sale'] == 0){
				$msg ='商品が完売しました';
				include(ROOT.'view/front/msg.html');
				exit;
			}
			$cart->addItem($goods_id,$goodslist['goods_name'],$goodslist['market_price'],$num);	
			$items=$cart->retItems();
			if($items[$goods_id]['num'] > $goodslist['goods_number']){
				$cart->decNum($goods_id,$num);
				$msg ='在庫切れ';
				include(ROOT.'view/front/msg.html');
				exit;
			}

		}
		
		
		$items=$cart->retItems();
		
		if(empty($items)){
			header('location:index.php');
			exit;
		}

		$items = $goods->getCartGoods($items); // 全て商品を読み取る
		$total = $cart->getPrice();
		$market_total = 0.0;
		foreach ($items as  $v) {
			$market_total+=$v['shop_price']*$v['num'];
		}
		$discount =  $market_total-$total;
		$rate=round(($discount/$total)*100,2);
		//$rate=($discount/$total)*100;
		 include(ROOT.'view/front/jiesuan.html');
	}



}
elseif($act == 'clear'){
	$cart->clear();
	$msg='カートに商品はありません';
	include(ROOT.'view/front/msg.html');
	exit;
}
elseif($act == 'submit'){
		$items=$cart->retItems();
		$items = $goods->getCartGoods($items); // 全て商品を読み取る
		$total = $cart->getPrice();
		$market_total = 0.0;
		foreach ($items as  $v) {
			$market_total+=$v['shop_price']*$v['num'];
		}
		$discount =  $market_total-$total;
		$rate=round(($discount/$total)*100,2);

	include(ROOT.'view/front/tijiao.html');
}
elseif($act == 'done'){
	//注文
 	
    $OI = new OIModel();
     
    $data = $OI->_facade($_POST);

    $data = $OI->_autoFill($data);

    $totalprice=$data['order_amount']=$cart->getPrice(); //価格
    $data['user_id']=isset($_SESSION['user_id'])?$_SESSION['user_id']+0:0; //user_id
    $data['user_name']=isset($_SESSION['username'])?$_SESSION['username']:'名無し'; //user_name
    $ordersn = $data['order_sn']=$OI->ordersn(); //order_sn



    if(!$OI->add($data)){
    	$msg='ご注文が出来ませんでした';
    	include(ROOT.'view/front/msg.html');
    	exit;
    }
    //order_id 


    $orderid=$OI->getid($data);


    $items=$cart->retItems();

    $OG = new OGModel(); // ordergoods の商品を追加
    $cnt = 0;
    foreach ($items as $k => $v) {
    	$data = array();

      

    	
    	$data['order_id']=$orderid['order_id'];
    	$data['order_sn ']=$ordersn;
    	$data['goods_id']=$k;
    	$data['goods_name']=$v['name'];
    	$data['goods_number']=$v['num'];
    	$data['shop_price']=$v['price'];
    	$data['subtotal']=$v['price']*$v['num'];

    	

    	if($OG->addOG($data)){ 
    		$cnt+=1; //每插入一条 就加一
    	}
    
    }
 

    	if (count($items) !== $cnt){
    		$OI->invoke($orderid['order_id']);
    		$msg='カートに商品はありません';
    		include(ROOT.'view/front/msg.html');
			exit;
    	}

		//購入成功　  カートをクリア
		$cart->clear();
		include(ROOT.'view/front/order.html');

    }
    
	//print_r($_POST);

	//include();







?>

