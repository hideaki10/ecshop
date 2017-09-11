<?php

define('key',true);
require('../include/init.php');

// print_r($_POST);


/*
$data['goods_name'] = trim($_POST['goods_name']);

if($data['goods_name'] == " "){
	echo '商品名を入力してください';
	exit;
}

$data['goods_sn'] = trim($_POST['goods_sn']);

$data['cat_id'] = $_POST['cat_id']+0;
$data['shop_price'] = $_POST['shop_price']+0;
$data['market_price'] = $_POST['market_price']+0;
$data['goods_desc'] = $_POST['goods_desc'];
$data['goods_weight'] = $_POST['goods_weight']*$_POST['weight_unit'];
$data['is_best'] = isset($_POST['is_best'])?1:0;
$data['is_new'] = isset($_POST['is_new'])?1:0;
$data['is_hot'] = isset($_POST['is_hot'])?1:0;
$data['is_on_sale'] = isset($_POST['is_on_sale'])?1:0;



$data['goods_brief'] = trim($_POST['goods_brief']);

$data['add_time']=time();
*/


$goods = new GoodsModel();

$data = array();

$data['goods_weight'] = $_POST['goods_weight']*$_POST['weight_unit'];

$data = $goods->_facade($_POST); //自动过滤

$data= $goods->_autoFill($data); //自动填充



if(empty($data['goods_sn'])){
	$data['goods_sn']=$goods->createSn();	
}

$uptool = new UpTool();
$ori_img = $uptool->up('ori_img');

if($ori_img){
	$data['ori_img']=$ori_img;
}


//缩略图 $ori_imgから作成　 300*400
$ori_img = ROOT.$ori_img;//絶対パス
$goods_img=dirname($ori_img).'/goods_'.basename($ori_img);
$image = new ImageTool();

if($image::thumb($ori_img,$goods_img,300,400))
{
	$data['goods_img']=str_replace(ROOT,'',$goods_img);
}



// 160*220

$thumb_img=dirname($ori_img).'/thumb_'.basename($ori_img);
//$image = new ImageTool();

if($image::thumb($ori_img,$thumb_img,160,200)){
	$data['thumb_img']=str_replace(ROOT,'',$thumb_img);
}


if($goods->add($data)){
	echo '成功しました';
}
else{
	echo '失敗しました';
}
?>
