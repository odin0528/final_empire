<?php
//閃避率增加100%
class buff_10 extends buff_prototype{
	public $id = 10;
	public $title = '閃避';
	public $type = 'attr';
	public $duration = 2;
	public $orgDuration = 2;
	function effect(){
		$this->char->dodgeRating *= 2;
	}
}

?>