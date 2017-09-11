<?php
define('key',true);
require('../include/init.php');


$catelist = new CatModel();

$list=$catelist->select();
$list=$catelist->getCatTree($list);

include(ROOT.'view/admin/templates/goodsadd.html');

?>