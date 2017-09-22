<?php

define('key',true);
require('./include/init.php');

$goods_id=isset($_GET['goods_id'])?$_GET['goods_id']+0:0;

$goods = new GoodsModel;
$gid=$goods->find($goods_id); // model.class.php 

if(empty($gid)){
	header('location:index.php');
	exit;
}

$cat = new CatModel();
// $cats = $cat->select();
$navi = $cat->getSonTree($gid['cat_id']);

include(ROOT.'view/front/shangpin.html');
?>