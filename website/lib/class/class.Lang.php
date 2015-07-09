<?php 
class lang
{  
	private static $_m;
	private static $_p;
  
	function m($block, $title){
		if(empty(self::$_m)){
			require(CONFIG_PATH.'/lang/'.LANGUAGE.'/_system/message.php');
			self::$_m 	= $_message;
			unset($_message);
		}
		
		if(empty(self::$_m[$block][$title]))
			return $title;
		else
			return self::$_m[$block][$title];
	}
	
	function v(){
		if(empty(self::$_p)){
			require(CONFIG_PATH.'/lang/'.LANGUAGE.'/_system/view.php');
			require(CONFIG_PATH.'/lang/'.LANGUAGE.'/'.PHP_FILE);
			self::$_p 	= $_view;
			unset($_view);
		}
		$args = func_get_args();
		$number = func_num_args();
		if($number == 1){
			$block = PHP_FILE_NAME;
			$title = $args[0];
		}elseif($number == 2){
			$block = $args[0];
			$title = $args[1];
		}
		
		if(empty(self::$_p[$block][$title]))
			return $title;
		else
			return self::$_p[$block][$title];
	}
}
?>