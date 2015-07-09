<?php
//攻擊力提高20%
class buff_6 extends buff_prototype{
	public $id = 6;
	public $title = '戰爭怒吼';
	public $type = 'attr';
	public $duration = 3;
	public $orgDuration = 3;

	function effect(){
		$this->char->atk = round($this->char->atk*1.20);
	}
}

?>