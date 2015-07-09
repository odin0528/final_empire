<?php
class PageBreak {

	private $requestName;		#REQUEST的page變數名
	private $itemCount;			#總筆數
	private $pageCount;			#總頁數
	private $pageLimit;			#要顯示出的頁碼
	private $url;				#生成的網址
	public $currentPage;		#當前頁數	
	public $pageBar;
	
	public function PageBreak($RowNum,$PageBreak=RESULT_PER_PAGE,$requestName='page',$pageLimit=10) {
		$this->queryString= $_SERVER['QUERY_STRING'];
		$this->requestName= $requestName;
		$this->itemCount = $RowNum;
		$this->pageCount = floor(($RowNum-1)/$PageBreak+1);
		$this->pageLimit = $pageLimit;
		$this->currentPage = (empty($_REQUEST[$this->requestName]))?1:$_REQUEST[$this->requestName];
		$this->init();
	}
	
	private function init(){
		$this->setBaseUrl();
	}
	
	//建立分頁的基礎網址
	public function setBaseUrl($Url=NULL) {
		//如果沒有設定url就設為自已
		if(empty($Url))$Url=$_SERVER['PHP_SELF'];

		$query = preg_replace("/[&]?{$this->requestName}={$this->currentPage}/","",$this->queryString);
		if(empty($query))
			$this->url = "{$Url}?{$this->requestName}=";
		else
			$this->url = "{$Url}?{$query}&{$this->requestName}=";
	}
	
	//取得pagebar
	public function getPageBar(){
		$first=$this->getFirstNum();
		$last=($this->pageCount>$first+$this->pageLimit-1)?$first+$this->pageLimit-1:$this->pageCount;
		$this->pageBar=array(
			'current'	=>	$this->currentPage,
			'itemCount'	=>	$this->itemCount,
			'pageCount'	=>	$this->pageCount,
			'first'		=>	$this->url.(1),
			'last'		=>	$this->url.($this->pageCount),
			'prev'		=>	$this->url.(($this->currentPage==1)?$this->currentPage:$this->currentPage-1),
			'next'		=>	$this->url.(($this->currentPage==$this->pageCount)?$this->pageCount:$this->currentPage+1),
			'prevTen'	=>	$this->url.(($this->currentPage==1)?$this->currentPage:$this->currentPage-10),
			'nextTen'	=>	$this->url.(($this->currentPage==$this->pageCount)?$this->pageCount:$this->currentPage+10),
			'loop'		=>	array()
		);
		for($i=$first;$i<=$last;$i++){
			$this->pageBar['loop'][$i]['num']=$i;
			$this->pageBar['loop'][$i]['current']=($this->currentPage==$i)?true:false;
			$this->pageBar['loop'][$i]['url']="{$this->url}$i";
		}
		return $this->pageBar;
	}
	
	private function getFirstNum(){
		if($this->currentPage<=$this->pageLimit/2 || $this->pageCount <= $this->pageLimit)
			$first=1;
		elseif($this->pageCount-$this->currentPage<$this->pageLimit/2)
			$first=$this->pageCount-$this->pageLimit+1;
		else
			$first=$this->currentPage-$this->pageLimit/2;
			
		return $first;
	}
}
?>
