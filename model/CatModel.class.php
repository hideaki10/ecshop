<?php
defined('key') || exit('ホームページにアクセスしてください');
class CatModel extends Model{
	protected $table = 'category';

	public function add($data){
		return $this->db->insert($this->table,$data);
	}

	
	//項目の表示
	public function select(){
		$sql='select cat_id,cat_name,num,intro,parent_id from category';
		return $this->db->select($sql);
	}

	public function find($cat_id){
		$sql='select * from category where cat_id = '.$cat_id;
		return $this->db->selectRow($sql);
	}


	public function getCatTree($arr,$id=0,$lev=0){
			$tree = array();

			foreach ($arr as  $v) {
				if($v['parent_id'] == $id){
					$v['lev']=$lev;
					$tree[]=$v;
					//$this->getCatTree($arr,$v['id']);
					$tree=array_merge($tree,$this->getCatTree($arr,$v['cat_id'],$lev+1));
					
				}
			}
			return $tree;
	}

	public function getSon($id){
		$sql = 'select cat_id,cat_name,parent_id from '.$this->table.' where parent_id = '.$id;

		return $this->db->select($sql);
	}

	public function getsonTree($id=0){
		$tree = array();
		$cats = $this->select();
		while($id>0){
			foreach ($cats as $v) {
			if($v['cat_id']==$id){
				$tree[]=$v;
				
				$id=$v['parent_id'];
				break;
			}
		}			
		}
		return $tree;
	}

	//項目の削除
	public function delete($cat_id = 0){
		$sql = 'delete from '.$this->table.' where cat_id='.$cat_id;
		$stmt = $this->db->query($sql);
		return $this->db->rowCount($stmt);

	}

	//項目の更新
    public function update($data,$cat_id = 0){
    	 $stmt=$this->db->update($this->table,$data,$cat_id);
    	 return $this->db->rowCount($stmt);
    }


}

?>