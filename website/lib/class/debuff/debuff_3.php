<?php
class debuff_3 extends debuff_prototype{
	public $id = 3;
	public $title = '破甲';
	public $type = 'attr';
	public $duration = 3;
	public $orgDuration = 3;

	function effect(){
		$this->char->def = round($this->char->def*0.7);
	}
}

?>