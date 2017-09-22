<?php

//絶対パスの初期化
//echo substr(str_replace('\\','/',__FILE__),0,-8);
//define('ROOT',dirname(str_replace('\\','/',__FILE__)).'/');

define('ROOT',dirname(str_replace('\\','/',__DIR__)).'/');
define('DEBUG',true);
defined('key') || exit('ホームページにアクセスしてください');

// require(ROOT.'include/db.class.php');

// require(ROOT.'Model/Model.class.php');
// require(ROOT.'Model/TestModel.class.php');
// require(ROOT.'include/conf.class.php');
// require(ROOT.'include/log.class.php');
require(ROOT.'include/lib_base.php');

// function __autoload($class) {
//     if(strtolower(substr($class,-5)) == 'model') {
//         require(ROOT . 'Model/' . $class . '.class.php');
//     } else {
//         require(ROOT . 'include/' . $class . '.class.php');
//     }
// }
 function __autoload($class){
 	if(strtolower(substr($class,-5)) == 'model'){
 		require(ROOT.'model/'.$class.'.class.php');
 	}
 	elseif (strtolower(substr($class,-4)) == 'tool') {
 		require(ROOT.'tool/'.$class.'.class.php');
 	}
 	else{
 		require(ROOT.'include/'.$class.'.class.php');
 	}
}
//过滤参数 用递归方式过滤
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);

//PHPエラーの種類の設定

//
session_start();

if(defined('DEBUG')){
	error_reporting(E_ALL);
}
else{
	error_reporting(0);
}




?>