<?php


define('key',true);
require('./include/init.php');


session_destroy();

$msg='ログアウトしました';
include(ROOT.'view/front/msg.html');
?>