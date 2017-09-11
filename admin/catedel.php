<?php

define('key',true);
require('../include/init.php');

$cat_id=$_GET['cat_id']+0;




$del=new CatModel();

$sons=$del->getSon($cat_id);


if(!empty($sons)){
	exit('削除できないです');
}
if($del->delete($cat_id)){
	echo '削除しました';
}
else{
	echo '失敗しました';
}

?>