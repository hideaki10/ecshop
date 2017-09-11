<?php

defined('key') || exit('ホームページにアクセスしてください');

class UpTool{
	protected $allowExt = 'jpg,jpeg,gif,bmp,png'; //ファイルの
	protected $maxSize =1;//フィアルの最大サイズ
	protected $file = NULL; // ファイルのプロパティ
	protected $errnum = 0;
	protected $error = array(
		0=>'エラー無し',
		1=>'ファイルは、php.ini の upload_max_filesize ディレクティブの値を超えています',
		2=>'ファイルは、HTML フォームで指定された MAX_FILE_SIZE を超えています',
		3=>'ファイルは一部のみしかアップロードされていません',
		4=>'ファイルはアップロードされませんでした',
		6=>'テンポラリフォルダがありません',
		7=>'ディスクへの書き込みに失敗しました',
		8=>'拡張子は間違いました',
		9=>'ファイルサイズは設定値を超えています',
		10=>'ディレクトリの作成は失敗しました',
		11=>'ファイルの移動は失敗しました',
		12=>'keyは間違いました'
	);


	public function up($key){
		if(!isset($_FILES[$key])){
			$this->errnum=12;
			return false;
		}
		else{
			$this->getFile($key);
		}
		if($this->file['error']){
			$this->errnum=$this->file['error'];
			return false;
		}
		$ext=$this->getExt($this->file['name']);
		if(!$this->isAllowExt($ext)){
			$this->errnum=8;
			return false;
		}

		if(!$this->isAllowSize($this->file['size'])){
			$this->errnum=9;
			return false;
		}

		 $dir = $this->mk_dir();

         if($dir == false) {
             $this->errnum=10;
             return false;
		 }

		$newname = $this->randname().'.'.$ext;

		if(!move_uploaded_file($this->file['tmp_name'], $dir.'/'.$newname)){
			$this->errnum=11;
			return false;
		}

		return str_replace(ROOT,'',$dir.'/'.$newname);
	}


    public function getError(){
    	return $this->error[$this->errnum];
    }
	/*
		parm String $key
		return String $file

	*/
    public function setExt($exts){
    		$this->allowExt = $exts;
    }

    public function setSize($num){
    	$this->maxSize = $num;
    }
	/*
		parm String $key
		return String $file

	*/
	protected function getFile($key){
		$this->file = $_FILES[$key];
	}




	/*
		parm String $file
		return String $ext

	*/
	protected function getExt($file){
		$tmp = explode(".",$file);
		return end($tmp);
	}


	/*
		parm String $ext
		return bool

	*/
	protected function isAllowExt($ext){
		$ext=strtolower($ext);
		$all=strtolower($this->allowExt);
		return in_array($ext, explode(",",$all));
	}

	/*
		parm String $ext
		return bool

	*/
	protected function isAllowSize($size){
		return $size <= $this->maxSize*1024*1024;
	}

	/*
		ディレクトリ作成
		return String $dir
	*/
	protected function mk_dir(){
		$dir = ROOT.'data/image/'.date('Ym/d');

		if(is_dir($dir) || mkdir($dir,0777,true)){
				return $dir;
		}
		else{
			return false;
		}
	} 


	/*
		ランダムファイル名の作成
		parm String $length
		return String str

	*/
    protected function randname($length = 6){
    	$str = 'abcdefghijklmnopqrstuvwxyz123456789';
    	return substr(str_shuffle($str),0,$length);
    }

}




?>