<?php

defined('key') || exit('ホームページにアクセスしてください');
// $conf = conf::getIns();
// abstract class db {
// 	//DBへの接続
// 	abstract public  function connect($h,$u,$p); 
// 	//sql文の実行
// 	abstract public  function query($sql); 
	
// 	//select文の実行（一行)
// 	abstract public  function exec($sql);

// 	//select文の実行(複数行)
// 	abstract public  function execall($sql);

// 	//select文の実行(一つカラム)
// 	abstract public  function execone($sql);
// }
class db {
  protected  static $ins = null;
  //定数の宣言
  private $HOST;
  private $DB_NAME;
  private $UTF;
  private $USER;
  private $PASS;

   protected function __construct(){

    include(ROOT.'include/config.class.php');
    $this->HOST =$_CFG['host'];
    $this->DB_NAME =$_CFG['db_name'];
    $this->UTF =$_CFG['utf'];
    $this->USER =$_CFG['user'];
    $this->PASS =$_CFG['password'];
     
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
  //DBへの接続
  public function pdo(){
    $dsn="mysql:dbname=".$this->DB_NAME.";host=".$this->HOST.";charset=".$this->UTF;
    $user=$this->USER;
    $pass=$this->PASS;
    try{
      $pdo=new PDO($dsn,$user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$this->UTF));
    }catch(Exception $e){
      echo 'error' .$e->getMesseage;
      die();
    }
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    return $pdo;
  }

  //sql文の実行
  public function query($sql){
    $db=$this->pdo();
    $stmt=$db->query($sql);
    log::write($sql);
    return $stmt;
  }
  //select文の実行（一行)
  public function select($sql){
    $stmt=$this->query($sql);
    $reslut=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $reslut;
  }
  //select文の実行(複数行)
  public function selectRow($sql){
    $stmt=$this->query($sql);
    $reslut=$stmt->fetch(PDO::FETCH_ASSOC);
    return $reslut;
  }
  //select文の実行(一つカラム)
  public function selectOne($sql){
    $stmt=$this->query($sql);
    $reslut=$stmt->fetch(PDO::FETCH_NUM);
    return $reslut[0];
  }

  public function insert($table,$data){
    // $sql='insert into '.$table;
    // $sql.='( '.implode(",",array_keys($data)).')';
    // $sql.=" value ('";
    // $sql.=implode(",", array_values($data));
    // $sql.="')";

    $sql = 'insert into ' . $table . ' (' . implode(',',array_keys($data)) . ')';
    $sql .= ' values (\'';
    $sql .= implode("','",array_values($data));
    $sql .= '\')';
    $stmt=$this->query($sql);
    return $stmt;
  }

  public function update($table,$data,$id){
    $sql = 'update '.$table.' set ';
    foreach($data as $k=>$v){
    $sql.=$k.' = '."'".$v."'".', ';    
    }
    $sql=substr($sql,0,-2);
    $sql.=$id;
    $stmt=$this->query($sql);
    return $stmt;
  }

  //INSERT,UPDATE,DELETE文の時に使用する関数。
  public function plural($sql){
    $stmt=$this->query($sql);
    return $stmt;
  }

  public function getLastId(){
    $hoge=$this->pdo();
    $id=$hoge->lastInsertId();
    return $id;
  }

  //行数をカウントする
  public function rowCount($stmt){
    //$hoge=$this->pdo();
    $count=$stmt->rowCount();
    return $count;
  }
}


?>