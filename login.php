<?php



define('key',true);
require('./include/init.php');



if(isset($_POST['act'])){
	$u = $_POST['username'];
	$p = $_POST['passwd'];

	$user = new UserModel();

	$row = $user->checkUser($u,$p);

	if(empty($row)){
		$msg='ユーザー名またはパスワードが違います';
	}
	else{
		$msg='成功しました';
		session_start();
		$_SESSION=$row;
		if(isset($_POST['remember'])){
			setcookie('remuser',$u,time()+14*24*3600);
		}
		else{
			setcookie('remuser','',0);
		}
		
	}
	include(ROOT.'view/front/msg.html');
	exit;

}
else{
	$remuser = isset($_COOKIE['remuser'])?$_COOKIE['remuser']:'';
	include(ROOT.'view/front/denglu.html');
}

?>