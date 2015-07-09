<?php
//被動技：減傷10%
class buff_3 extends buff_prototype{
	public $id = 3;
	public $title = '防禦姿態';
	public $type = 'hurt';
	public $duration = -1;

	function effect(){
		$this->char->hurt = round($this->char->hurt * 0.9);
	}
}

?>