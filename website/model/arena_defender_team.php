<?php 
class arena_defender_team extends db{
	protected $tblName = 'arena_defender_team';
	function init(){
		// $this->tblName .= '_'.LANGUAGE;
	}
	
	function getTeam($player_id){
		$charRowset = $this->select('char_id')->where('player_id = ?', $player_id)->fetchAll();
		$team = array();
		foreach($charRowset as $row){
			$team[] = $row['char_id'];
		}
		return $team;
	}
}
?>
