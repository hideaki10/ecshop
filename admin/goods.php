<?php

define('key',true);
require('../include/init.php');



$goods_id=$_GET['goods_id']+0;

$goods=new GoodsModel();
$goodlist = $goods->find($goods_id);

if(empty($goodlist)){
	echo "空商品です";
}

print_r($goodlist);



?>