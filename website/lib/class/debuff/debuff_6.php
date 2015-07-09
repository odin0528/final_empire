<?php
//受到的傷害增加50%
class debuff_6 extends debuff_prototype{
	public $id = 6;
	public $title = '狂暴';
	public $type = 'hurt';
	public $duration = 5;
	public $orgDuration = 5;

	function effect(){
		$this->char->hurt = round($this->char->hurt*1.5);
	}
}

?>