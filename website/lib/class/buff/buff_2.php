<?php
//減傷50%
class buff_2 extends buff_prototype{
	public $id = 2;
	public $title = '盾牆';
	public $type = 'hurt';
	public $duration = 2;
	public $orgDuration = 2;

	function effect(){
		$this->char->hurt = round($this->char->hurt * 0.5);
	}
}

?>