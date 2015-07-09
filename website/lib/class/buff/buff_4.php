<?php
//造成的傷害增加100%
class buff_4 extends buff_prototype{
	public $id = 4;
	public $title = '狂暴';
	public $type = 'damage';
	public $duration = 3;
	public $orgDuration = 3;

	function effect(){
		$this->char->damage = round($this->char->damage * 2);
	}
}

?>