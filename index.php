<?php
define('key',true);
require('./include/init.php');



$goods = new GoodsModel();
$goodslist = $goods->getNew(5);

//食品&酒
$food_id=4;
$foodlist=$goods->catGoods($food_id);

//ホーム&キッチン
$home_id=10;
$homelist=$goods->catGoods($home_id);


include(ROOT.'view/front/index.html');

?>