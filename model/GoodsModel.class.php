<?php

defined('key') || exit('ホームページにアクセスしてください');

class GoodsModel extends Model{
		protected $table = 'goods';
		protected $pk = 'goods_id';
		protected $fields = array('goods_id','goods_sn','cat_id','brand_id','goods_name','shop_price','market_price','goods_number','click_count','goods_weight','goods_brief','goods_desc','thumb_img','goods_img','ori_img','is_on_sale','is_delete','is_best','is_new','is_hot','add_time','last_update');
		protected $_auto = array( 
		array('is_hot','value',0),
		array('is_best','value',0),
		array('is_new','value',0),
		array('add_time','function','time')
		);



		public function trash($id){
			return $this->update(array('is_delete'=>1),$id);
		}

		//
		public function getGoods(){
			$sql = 'select * from goods where is_delete = 0';
			return $this->db->select($sql);
		}

		//ゴミ箱にいるもの
		public function getTrash(){
			$sql = 'select * from goods where is_delete = 1';
			return $this->db->select($sql);
		}

		//goods_snを自動的に生成する
		public function createSn(){
				$sn='BL'.date('Ymd').mt_rand(10000,99999);

				$sql='select count(*) from '.$this->table." where goods_sn= '".$sn."'";

				if($this->db->selectOne($sql)){
					  createSn();
				}
				else{
					return $sn;
				}
		}


}
?>