<?php


define('key',true);
require('../include/init.php');
$cat_id = $_GET['cat_id']+0;

$cat = new CatModel();

$catinfo=$cat->find($cat_id);

$list=$cat->select();
$list=$cat->getCatTree($list);

//print_r($catinfo);
include(ROOT.'view/admin/templates/catedit.html');
?>