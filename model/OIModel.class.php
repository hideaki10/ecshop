<?php
defined('key') || exit('ホームページにアクセスしてください');
class OIModel extends Model{
	protected $table = 'orderinfo';
	protected $pk = 'order_id';
	protected $fields = ['order_id','order_sn','user_name','user_id','reciver','post','address','email','tel','best_delivery',
	'best_date','best_time','add_time','order_amount','pay'];

	protected $_auto = array( 
		array('add_time','function','time')
		);

	// order_snの作成
	public function orderSn(){
		$sn='BL'.date('Ymd').mt_rand(10000,99999);

		$sql='select count(*) from '.$this->table." where order_sn= '".$sn."'";

		if($this->db->selectOne($sql)){
				createSn();
		}
		else{
				return $sn;
		}	
	}
	public function getid($items){
		$sql= "select order_id from ".$this->table." where order_sn = '".$items['order_sn']."'";
		return $this->db->selectRow($sql);
	}

	// public function invoke($order_id){
	// 	$this->delete($order_id); // 削除orderinfo
	// 	$sql = "delete from ordergoods where order_id =".$order_id;　//削除
	// 	//return $this->db->query($sql);
	// }

	public function invoke($order_id){
		$this->delete($order_id);
	}
}


?>