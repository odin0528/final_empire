<?php 
class player extends db{
	protected $tblName = 'player';
	function init(){

	}
	
	function get($fbID){
		return $this->select('id,account,password')->where('fb_id = ?',$fbID)->fetch();
	}

	function getByUserId($userId){
		return $this->select('id,name')->where('user_id = ?',$userId)->fetch();
	}
}
?>
