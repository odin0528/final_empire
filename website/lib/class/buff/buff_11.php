<?php
//劍刃亂舞：攻擊對象改為射程內所有敵人
class buff_11 extends buff_prototype{
	public $id = 11;
	public $title = '劍刃亂舞';
	public $type = 'attr';
	public $duration = 5;
	public $orgDuration = 5;
	function effect(){
		$this->char->attack['type'] = 2;
	}
}

?>