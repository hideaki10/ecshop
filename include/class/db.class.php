<?php


abstract class db {
	//DBへの接続
	abstract public  function connect($h,$u,$p); 
	//sql文の実行
	abstract public  function query($sql); 
	
	//select文の実行（一行)
	abstract public  function exec($sql);

	//select文の実行(複数行)
	abstract public  function execall($sql);

	//select文の実行(一つカラム)
	abstract public  function execone($sql);
}



?>