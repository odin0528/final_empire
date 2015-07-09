<?php
//被動技：反彈受到傷害的20%傷害
class buff_8 extends buff_prototype{
	public $id = 8;
	public $title = '勢不可擋';
	public $type = 'attr';
	public $duration = -1;
	function effect(){
		if($this->char->isComa == true){
			$heal = round($this->char->maxHp * 0.2);
			$this->char->recovery($heal);

			$data = array(
				'prop'			=>	2,
				'targetId'		=>	$this->char->side . '-' . $this->char->charId,
				'targetTitle'	=>	$this->char->side . ' - ' . $this->char->title. $this->char->name,
				'title'			=>	$this->title,
				'heal'			=>	$this->char->recovery
			);

			battleground::addMessage('heal', $data);
		}
	}
}

?>