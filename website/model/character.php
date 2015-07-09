<?php 
class character extends db{
	protected $tblName = 'character';
	function init(){

	}

	function getChar($id){
		$id = intval($id);
		return $this->select('*')->where('id = ?', $id)->fetch();
	}
	
	function getAll(){
		return $this->select('*')->fetchAll();
    }
}
?>
