<?php
class debuff_1 extends debuff_prototype{
	public $id = 1;
	public $title = '暈眩';
	public $type = 'status';
	public $duration = 1;
  
	function effect(){
		$this->char->isComa = true;
	}
}

?>