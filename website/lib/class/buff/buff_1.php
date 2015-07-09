<?php
//造成的傷害增加20%
class buff_1 extends buff_prototype{
	public $id = 1;
	public $title = '亞馬遜之力';
	public $type = 'damage';
	public $duration = 3;
	public $orgDuration = 3;

	function effect(){
		$this->char->damage = round($this->char->damage * 1.2);
	}
}

?>