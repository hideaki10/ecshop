<?php

defined('key') || exit('ホームページにアクセスしてください');
function _addslashes($arr){

	foreach ($arr as $k => $v){
		if(is_string($v)){
			$arr[$k]=addslashes($v);
		}
		if(is_array($v)){
			$arr[$k]=isArray($v);
		}

	}

  return $arr;
}

?>