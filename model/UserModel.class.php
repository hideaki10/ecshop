<?php
defined('key') || exit('ホームページにアクセスしてください');

class UserModel extends Model {
	protected $table = 'user';
	protected $pk = 'user_id';
	protected $fields = ['user_id','username','email','passwd','regtime','lastlogin'];

	// protected $_validate = [
	// ['username',1,'ユーザー名','length','4,16'],
	// ['passwd',1,'']
	// ]
	/*
	ユーザー登録
	*/
	protected function encPasswd($p){
		return md5($p);
	}

	public function reg($data){
		if($data['passwd']){
			$data['passwd']=$this->encPasswd($data['passwd']);
		}
		return $this->add($data);
	}


    /*
    ユーザー名
    */
    public function checkUser($username,$passwd=''){
    	if($passwd == ''){
    		$sql = 'select count(*) from '.$this->table." where username = '".$username."'";
    		return $this->db->selectOne($sql);
    	}
    	else{
    		$sql='select user_id,username,email,passwd from '.$this->table." where username = '".$username."'";
    		$row=$this->db->selectRow($sql);

    		if(empty($row)){
                return false;
            }
            if($row['passwd'] != $this->encPasswd($passwd)){
                return false;
            }
            unset($row['passwd']);
    		return $row;
    	}
    }

// public function checkUser($username,$passwd=''){
// 	if($passwd = ''){
//              $sql = 'select * from '.$this->table." where username = '".$username."'";
//              return $this->db->selectOne($sql);
// 	}
// 	else{
// 		$sql = 'select user_id,username,email,passwd from '.$this->table." where username = '".$username."'";
// 		$row = $this->db->selectRow($sql);

// 		if(empty($row)){
// 			return false;
// 		}

// 		echo $this->encPasswd($passwd);
// 		return $row;
// 	}
// }

    // public function checkUser($username,$passwd=''){
    // 	//echo $passwd;
    // 	if($passwd = ''){
    // 		  	$sql = 'select * from '.$this->table." where username = '".$username."'";
    // 	        return $this->db->selectOne($sql);
    // 	}
    // 	else{
    //             $sql = 'select user_id,username,email,passwd from '.$this->table." where username = '".$username."'";
    //             $row = $this->db->selectRow($sql);

    //             if(empty($row)){
    //             	return false;
    //             }
    //             if($row['passwd'] != $this->encPasswd($passwd)){
    //             	echo $this->encPasswd($passwd);
    //             	return false;
    //             }
    //             unset($row['passwd']);
    //             return $row;
    // 	}
    // }

    /*
    e-mail
    */

    public function checkemail($email){
    	$rs = filter_var($email,FILTER_VALIDATE_EMAIL);
    	if($rs !== false){
    		return $rs;
    	}
    	else{
    		return false;
    	}
    }
}

?>