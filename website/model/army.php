<?php 
class army extends db{
	protected $tblName = 'army';
	function init(){

	}

	function getAll(){
		return $this->select('*')->fetchAll();
    }
}
?>
