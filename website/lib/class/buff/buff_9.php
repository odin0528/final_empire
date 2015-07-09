<?php
//一回合內不會被敵方發現
class buff_9 extends buff_prototype{
	public $id = 9;
	public $title = '匿蹤';
	public $type = 'status';
	public $duration = 1;
	function effect(){
		$this->char->isVisible = false;
	}
}

?>