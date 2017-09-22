<?php

define('key',true);
require('../include/init.php');

$data = array();

$data['cat_name'] = $_POST['cat_name'];
$data['parent_id']=$_POST['parent_id']+0;
//$data['num']=$_POST['num'];
$data['intro']=$_POST['intro'];

$cat_id=$_POST['cat_id'];




//print_r($data);
$Catedit = new CatModel();

// echo "修正したい　",$cat_id,'<br />';
// echo "そのidの親は　",$data['parent_id'],'<br />';

$tree = $Catedit->getsonTree($data['parent_id']);

$flag=true;
foreach ($tree as  $v) {
	if($v['cat_id'] == $cat_id){
		$flag=false;
		break;
	}
}

if(!$flag){
	exit('カテゴリ―を正確に選択してください');
}


if($Catedit->update($data,$cat_id)){
	echo '更新しました。';
}
else{
	echo '失敗しました。';
}


?>