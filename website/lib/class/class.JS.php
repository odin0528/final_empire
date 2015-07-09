<?php
class js{
	private $_agent;
	private $_version;
	private $_script = array();	//搜尋欄位
	
	public function __construct(){
		//偵測瀏覽器  
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($agent,"MSIE 9.0")){
			$this->_agent = 'ie';
			$this->_version = '9.0';
		}elseif(strpos($agent,"MSIE 8.0")){
			$this->_agent = 'ie';
			$this->_version = '8.0';
		}elseif(strpos($agent,"MSIE 7.0")){
			$this->_agent = 'ie';
			$this->_version = '7.0';
		}elseif(strpos($agent,"MSIE 6.0")){
			$this->_agent = 'ie';
			$this->_version = '6.0';
		}elseif(strpos($agent,"Firefox")){
			$this->_agent = 'firefox';
		}elseif(strpos($agent,"Chrome")){
			$this->_agent = 'chrome';
		}elseif(strpos($agent,"Safari")){
			$this->_agent = 'safari';
		}elseif(strpos($agent,"Opera")){
			$this->_agent = 'opera';
		} 
	}
	
	public function getAgent(){
		return $this->_agent;
	}
	
	public function getVersion(){
		return $this->_version;
	}
	
	public function alert($msg){
		$this->_script[] = 'alert("'.$msg.'");';
		return $this;
	}
	
	public function reload($url){
		$this->_script[] = "location.reload();";
		return $this;
	}
	
	public function redirect($url){
		$this->_script[] = "location.href='{$url}';";
		return $this;
	}
	
	public function back(){
		$this->_script[] = 'history.back();';
		return $this;
	}
	
	public function execute(){
		$html = "<script language='javascript'>";
		
		$size = sizeof($this->_script);
		for ($i=0; $i<$size; $i++)
			$html .= $this->_script[$i];

		$html .= "</script>";
		echo $html;
		exit;
	}
}
?>