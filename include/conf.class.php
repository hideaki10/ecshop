<?php
defined('key') || exit('ホームページにアクセスしてください');
class conf {
	protected  static $ins = null;
	protected $data = array();
	final protected function __construct(){

		// 一次性把配置文件信息，读过来，付给data 
		// 这样就直接可以找从data里找配置属性了
		include(ROOT.'/include/config.class.php');
		$this-> data =$_CFG;
	}

	final protected function __clone(){

	}

	public static function getIns(){
		if(self::$ins instanceof self){
			return self::$ins;
		}
		else{
			self::$ins = new self();
			return self::$ins;
		}
	}

	//マジックメソッドで　定義値を読み取る
	public function __get($key){
		if(array_key_exists($key,$this->data)){
			return $this->data[$key];
		}
		else{
			return null;
		}
	}

	//マジックメソッドで　定義値を修正、追加
	public function __set($key,$value){
		$this->data[$key] = $value;
	}
}



?>