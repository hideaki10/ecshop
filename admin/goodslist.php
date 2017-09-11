<?php

define('key',true);
require('../include/init.php');







$goods = new GoodsModel();
$goodslist=$goods->getGoods();

include(ROOT.'/view/admin/templates/goodslist.html');

?>