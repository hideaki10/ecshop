<?php


define('key',true);
require('../include/init.php');
//データ取得
//print_r($_POST);

//
$data=array();

if(empty($_POST['cat_name'])){
	exit('商品名を入力してください');
}
$data['cat_name'] = $_POST['cat_name'];
$data['parent_id']=$_POST['parent_id'];
if($data['parent_id'] != 0){
	
// 	if(empty($_POST['num'])){
// 	exit('商品数を入力してください');
// }
}


//$data['num']=$_POST['num'];
$data['intro']=$_POST['intro'];

// print_r($data);
// exit;

// 
$CatModel = new CatModel();
if($CatModel ->add($data)){
	echo '商品名を入力しました';
}
else{
	echo '入力は失敗でした。';
}

?>