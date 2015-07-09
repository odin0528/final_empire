<?php
//造成的傷害減少50%
class debuff_7 extends debuff_prototype{
	public $id = 7;
	public $title = '挫志怒吼';
	public $type = 'damage';
	public $duration = 1;

	function effect(){
		$this->char->damage = round($this->char->damage*0.5);
	}
}

?>