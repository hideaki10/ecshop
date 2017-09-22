<?php

define('key',true);
require('./include/init.php');


$cat_id=isset($_GET['cat_id'])?$_GET['cat_id']+0:0;
$page=isset($_GET['page'])?$_GET['page']+0:1;


// echo $pagecode;
// exit;

$cat = new CatModel();
$catgory = $cat->find($cat_id);
if(empty($catgory)){
	header('location:index.php');//ホームページに転送する
	exit;
}





//取出树状导航
$cats = $cat->select();
$sort = $cat->getCatTree($cats,0,1);



//分页




$total=$cat->count($cats,$cat_id);
$perpage = 2;

if($page < 1){
	$page = 1;
}
elseif($page>ceil($total/$perpage)){
	$page = 1;
}


$offset = ($page-1)*$perpage;

$pagetool = new PageTool($total,$page,$perpage);
$pagecode=$pagetool->show(); 



//面包屑
$navi = $cat->getSonTree($cat_id);


//
$goods  = new GoodsModel();
$goodslist = $goods->catGoods($cat_id,$offset,$perpage);
include(ROOT.'view/front/lanmu.html');

?>