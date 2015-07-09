<?php
//降低30%命中率
class debuff_8 extends debuff_prototype{
	public $id = 8;
	public $title = '煙霧彈';
	public $type = 'attr';
	public $duration = 1;

	function effect(){
		$this->char->dodge += 30;
	}
}

?>