<?php
class debuff_4 extends debuff_prototype{
	public $id = 4;
	public $title = '流血';
	public $type = 'end';
	public $duration = 2;
	public $orgDuration = 2;

	function effect(){
		$damage = round($this->caster->atk * 0.8);
		$damage = $this->caster->calcDamage($damage, $this->char, 2);

		$this->char->dot($damage, 1);	//dot傷害第三個值要帶true

		$data = array(
			'prop'			=>	1,
			'targetId'		=>	$this->char->side . '-' . $this->char->charId,
			'targetTitle'	=>	$this->char->side . ' - ' . $this->char->title. $this->char->name,
			'title'			=>	$this->title,
			'damage'		=>	$this->char->hurt
		);
		battleground::addMessage('damage', $data);
	}
}

?>