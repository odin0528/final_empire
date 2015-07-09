<?php
//霸氣 - 提高5級的閃避等級
class buff_12 extends buff_prototype{
	public $id = 12;
	public $title = '霸氣';
	public $type = 'attr';
	public $duration = -1;

	function effect(){
		$this->char->dodgeRating = $this->char->dodgeRating + $this->char->lv * LEVEL_TO_DODGE_REDUCTION * 5 ;
	}
}

?>