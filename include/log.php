<?php 


class log{
	//logファイル
	const LOGFILE = 'curr.log'; 

	//logファイルに書き込む
	public static function write($cont){
	  $cont.="\r\n"; 	 
      $log = self::isBack();
      $fh = fopen($log, 'a');
      $fw = fwrite($fh, $cont);
      $close = fclose($fh);

	}

	//logファイルのバックアップ
	public static function back(){
		//logファイルをリネームする

		$log = ROOT.'data/log/'.self::LOGFILE;
		$bak = ROOT.'data/log/'.date('ymd').mt_rand(10000,99999).'.bak';
		return rename($log, $bak);
	}


	//logファイルのサイズを確認する
	public static function isBack()	{
		$log = ROOT.'data/log/'.self::LOGFILE;
		if(!file_exists($log)){
			touch($log);
			return $log;
		}
		
		//キャシュバを削除する
		clearstatcache($log);
		$size = filesize($log);

		//logファイルのサイズが1MBより小さい場合
		if($size <= 1024*1024){
			return $log;
		}
		//logファイルのサイズが1MBより大きい場合
		//logファイルをバックアップする
		else{
			if(!self::back()){
				return $log;
			}
			else{
				touch($log);
				return $log;
			}
		}
	}
}




?>