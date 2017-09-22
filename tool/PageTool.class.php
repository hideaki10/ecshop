<?php
defined('key') || exit('ホームページにアクセスしてください');


class PageTool{
	protected $total = 0;
	protected $perpage = 1;
	protected $page = 9;

	public function __construct($total,$page=false,$perpage=false){
		$this->total = $total;
		if($perpage){
			$this->perpage=$perpage;
		}
		if($page){
			$this->page=$page;
		}
	} 


	public function show(){
		$cnt=ceil($this->total/$this->perpage) ;// トータルページ数
		$uri=$_SERVER['REQUEST_URI'];
		$parse=parse_url($uri);
		$param=array();
		if(isset($parse['query'])){
			parse_str($parse['query'],$param);
		}
		unset($param['page']);
		
		$url = $parse['path'].'?';
		if(!empty($param)){
			$param=http_build_query($param);
			$url.=$param.'&';
		}
		

		$nav=array();
		$nav[]='<span class="page_now">'.$this->page.'</span>';

		for($left=$this->page-1,$right=$this->page+1;($left >=1||$right<=$cnt)&& count($nav)<=$this->perpage;)
		{

			//echo $url."page =".$i,"</br>";
			if($left >= 1){
				
				array_unshift($nav, '<a href= "'.$url.'page='.$left.'">['.$left.']</a>');
				// <a href="article.php?id=3" style="padding:0 3px 0 5px"></a>
			    $left-=1;
			}

			if($right <=$cnt){
				
				array_push($nav,'<a href= "'.$url.'page='.$right.'">['.$right.']</a>');
				$right+=1;
			}

			
		}
		echo $cnt;	
		return implode(" ",$nav);
	}

}

// $p = new PageTool(20,3,6);
// echo $p->show();
?>