<?php
class view{
	private $_view;
	private $_layout_path = '_layout';
	private $_view_path = '_view';
	private $_base_url;
	private $_url;
	private $_folder;
	private $_disable_layout;
	private $_data = array();
	private $_css = array();
	private $_js = array();
	
	public function __construct(){
		$this->_folder = PHP_PATH;
		$this->_base_url = BASE_URL;
		$this->_url = BASE_URL . "/" . PHP_PATH;
		unset($folder);
	}
	
	protected function _transformVariable($variable)
    {
        if (!is_string($variable)) {
            throw new Exception('Specified variable is not a string');
        }
        return $variable;
    }
	
	public function __get($variable)
    {
        $variable = $this->_transformVariable($variable);
        return $this->_data[$variable];
    }

    public function __set($variable, $value)
    {
        $variable = $this->_transformVariable($variable);
        $this->_data[$variable] = $value;
    }

    public function __unset($variable)
    {
        $variable = $this->_transformVariable($variable);
        unset($this->_data[$variable]);
        return $this;
    }

    public function __isset($variable)
    {
        $variable = $this->_transformVariable($variable);
        return isset($this->_data[$variable]);
    }
	
	public function disableLayout(){
		$this->_disable_layout = 1;
		return $this;
	}
	
	public function show($page=PHP_FILE){
		if(!$this->_disable_layout){
			$this->_view = $page;
			include($this->getLayoutPath() . '/layout.php');
			exit;
		}else{
			include($this->getViewPath() . '/'.$page);
			exit;
		}
	}
	
	private function baseUrl(){
		return $this->_base_url;
	}
	
	private function url(){
		return $this->_url;
	}

	private function folder(){
		return $this->_folder;
	}
	
	private function getLayoutPath(){
		return ROOT_PATH . BASE_URL. "/{$this->_layout_path}" . PHP_PATH;
	}
	
	private function getViewPath(){
		return ROOT_PATH . BASE_URL . "/{$this->_view_path}" . PHP_PATH;
	}
	
	public function appendCss($path,$outside = false){
		$this->_css[] = array($path,$outside);
		return $this;
	}
	
	public function appendJs($path,$outside = false){
		$this->_js[] = array($path,$outside);
		return $this;
	}
	
	public function getCss(){
		$script = '';
		foreach($this->_css as $css){
			$script .= '<link href="'.(($css[1])?$css[0]:$this->baseUrl().$css[0]).'" rel="stylesheet" media="all" />';
		}
		return $script;
	}
	
	public function getJs(){
		$script = '';
		foreach($this->_js as $js){
			$script .= '<script type="text/javascript" src="'.(($js[1])?$js[0]:$this->baseUrl().$js[0]).'"></script>';
		}
		return $script;
	}
}
?>