<?php
defined('key') || exit('ホームページにアクセスしてください');

class OGModel extends Model {

	protected $table = 'ordergoods';
	protected $pk = 'og_id';

	public function addOG($data){
		if($this->add($data)){
			$sql = "update goods set goods_number = goods_number - ".$data['goods_number']." where goods_id = ".$data['goods_id'];
			return $this->db->query($sql); //goods_number ;
		}
			return false;
	}
}
?>