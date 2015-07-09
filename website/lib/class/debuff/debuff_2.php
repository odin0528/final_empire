<?php
class debuff_2 extends debuff_prototype{
	public $id = 2;
	public $title = '燃燒';
	public $type = 'end';
	public $duration = 3;
	public $orgDuration = 3;
	public $isStacked = true;
	public $stackMaxCount = 3;

	function effect(){
		$damage = round($this->caster->mp * 0.7) * $this->stackCount;
		$damage = $this->caster->calcDamage($damage, $this->char, 2);
		$this->char->dot($damage, 2);	//dot傷害第二個值要帶true

		$data = array(
			'prop'			=>	2,
			'targetId'		=>	$this->char->side . '-' . $this->char->charId,
			'targetTitle'	=>	$this->char->side . ' - ' . $this->char->title. $this->char->name,
			'title'			=>	$this->title,
			'damage'		=>	$this->char->hurt
		);
		battleground::addMessage('damage', $data);
	}
}

?>