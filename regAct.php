<?php

define('key',true);
require('./include/init.php');



if(!array_key_exists('agreement', $_POST)){
	$msg='個人情報保護方針への同意が必要です';
	include(ROOT.'view/front/msg.html');
}
if($_POST['passwd'] !== $_POST['repasswd']){
	$msg='２回目のパスワードが違います';
	include(ROOT.'view/front/msg.html');
}

$user = new UserModel();

if($user->checkUser($_POST['username'])){
	$msg='ユーザー名が存在しました';
	include(ROOT.'view/front/msg.html');
	exit;
}
if(!$user->checkemail($_POST['email'])){
	$msg='メールアドレスが間違います';
	include(ROOT.'view/front/msg.html');
	exit;
}

$us=$user->_autoFill($_POST);
$us=$user->_facade($us);

if($user->reg($us)){
	$msg='登録しました';
}
else{
	$msg='登録は失敗しました';
}

include(ROOT.'view/front/msg.html');

?>