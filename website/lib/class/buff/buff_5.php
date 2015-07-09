<?php
//護甲值提高20%
class buff_5 extends buff_prototype{
	public $id = 5;
	public $title = '戒備戰吼';
	public $type = 'attr';
	public $duration = 3;
	public $orgDuration = 3;

	function effect(){
		$this->char->def = round($this->char->def*1.2);
	}
}

?>