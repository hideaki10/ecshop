<?php

//絶対パスの初期化
//echo substr(str_replace('\\','/',__FILE__),0,-8);
//define('ROOT',dirname(str_replace('\\','/',__FILE__)).'/');
define('ROOT',dirname(str_replace('\\','/',__DIR__)).'/');
define('DEBUG',true);


require(ROOT.'include/class/db.class.php');
require(ROOT.'include/class/conf.class.php');
require(ROOT.'include/log.php');


//过滤参数 用递归方式过滤

	

//PHPエラーの種類の設定

if(defined('DEBUG')){
	error_reporting(E_ALL);
}
else{
	error_reporting(0);
}




?>