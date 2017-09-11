<?php 

define('key',true);
require('../include/init.php');

//同じphpを利用できるようになるため、$_GETの値を判する。ゴミ箱の中にある商品を表示させたい場合、getTrash()。ゴミ箱に入れよう場合、trash()。
if(isset($_GET['act']) && $_GET['act'] == 'show'){
	$goods = new GoodsModel();
	$goodslist = $goods->getTrash();

	include(ROOT.'view/admin/templates/goodslist.html');

}
else{
	$goods_id = $_GET['goods_id']+0;

	$goods = new GoodsModel();
	if($goods->trash($goods_id)){
	echo "成功しました";
	}
	else{
	echo "失敗しました";
	}
}

?>