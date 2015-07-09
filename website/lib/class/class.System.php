<?php
class system{
	public function __construct(){
	
	}
	
	function redirect($url){
		header("Location: $url");
		exit;
	}
	
	function getParam($value, $type='get'){
		switch($type){
			case 'get':
				if(!empty($_GET[$value]))
					$value = $_GET[$value];
				else
					$value = null;
				break;
			case 'post':
				if(!empty($_POST[$value]))
					$value = $_POST[$value];
				else
					$value = null;
				break;
			case 'request':
				if(!empty($_REQUEST[$value]))
					$value = $_REQUEST[$value];
				else
					$value = null;
				break;
		}
		return clean_magic_quotes_gpc(strip_tags($value));
	}
	
	private function clean_magic_quotes_gpc($data){
		if (is_array($data)) {
			return (get_magic_quotes_gpc()) ? array_map_recursive('stripslashes', $data) : $data;
		} else {
			return (get_magic_quotes_gpc()) ? stripslashes($data) : $data;
		}
	}
	
	function array_map_recursive($func, $arr, $includeKey = FALSE){
		$result = array();

		foreach ($arr as $key => $value) {
			if (TRUE === $includeKey) {
				if (is_array($func)) {
					if (is_object($func[0])) {
						$key = $func[0]->$func[1]($key);
					}
					if (is_string($func[0])) {
						eval('$key = ' . $func[0] . '::' . $func[1] . '($key);');
					}
				} else {
					$key = $func($key);
				}
			}
			if (is_array($value)) {
				$result[$key] = array_map_recursive($func, $value);
			} else {
				if (is_array($func)) {
					if (is_object($func[0])) {
						$result[$key] = $func[0]->$func[1]($value);
					}
					if (is_string($func[0])) {
						eval('$result[$key] = ' . $func[0] . '::' . $func[1] . '($value);');
					}
				} else {
					$result[$key] = $func($value);
				}
			}
		}

		return $result;
	}
}

$system = new system();
?>