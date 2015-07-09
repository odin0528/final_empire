<?php 
class arena extends db{
	protected $tblName = 'arena';
	function init(){
		// $this->tblName .= '_'.LANGUAGE;
	}
	
	function addArena($data){
		$row['created_at'] = '~NOW()';
		$row = array(
			'offensive_id'	=>	$data['offensive_id'],
			'defender_id'	=>	$data['defender_id'],
			'created_at'	=>	'~NOW()'
		);
		$id = $this->insert($row);
		return $id;
	}
}
?>
