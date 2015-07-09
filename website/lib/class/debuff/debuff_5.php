<?php
//治療量減半
class debuff_5 extends debuff_prototype{
	public $id = 5;
	public $title = '致死打擊';
	public $type = 'recovery';
	public $duration = 3;
	public $orgDuration = 3;

	function effect(){
		$this->char->recovery = round($this->char->recovery*0.5);
	}
}

?>