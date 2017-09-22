<?php
defined('key') || exit('ホームページにアクセスしてください');
class Model{
	protected $table = NUll;
	protected $db = NULL;
	protected $pk = '';
	protected $fields = array();
	protected $_auto = array();



	//初期化
	public function __construct(){
		$this->db = db::getIns();
	}
	// public function table($table){
	// 	$this->table=$table;
	// }

	//自动过滤
	public function _facade($array){
		//print_r($array);
		$data = array();
		foreach ($array as $k => $v) {
			if(in_array($k,$this->fields)){
				$data[$k] = $v;
			}
		}
		return $data;
	}



	public function _autoFill($data){
		foreach ($this->_auto as  $v) {
			if(!array_key_exists($v[0], $data)){
				switch ($v[1]) {
					case 'value':
						$data[$v[0]]=$v[2];		
						break;
					
					case 'function':
						$data[$v[0]]=call_user_func($v[2]); //time()関数を呼び出す
						break;
				}
				
			}
		}
		return $data;

	}


	//親クラスで追加、削除、更新
	public function add($data){
		return $this->db->insert($this->table,$data);
	}

	public function delete($id){
		$sql = 'delete from '.$this->table.' where '.$this->pk.' = '.$id;
		$stmt = $this->db->query($sql);
		if($stmt){
			return $this->db->rowCount($stmt);	
		}
		else{
			return false;
		}
	}

	 public function update($data,$id){
	 	 $id=' where '.$this->pk.' = '.$id;
    	 $stmt=$this->db->update($this->table,$data,$id);
    	 if($stmt){
    	 	return $this->db->rowCount($stmt);	
    	 }
    	 else{
    	 	return false;
    	 }
    	 
    }


    public function select(){
    	$sql = 'select * from '.$this->table;
    	return $this->db->select($sql);  	
    }

    public function find($id){
    	$sql='select * from '.$this->table.' where '.$this->pk.' = '.$id;
		return $this->db->selectRow($sql);
    }

    public function insert_id(){
    	return $this->db->getLastId();
    }
}

?>