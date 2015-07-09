<?php
//每回合受到魔法傷害
class debuff_9 extends debuff_prototype{
	public $id = 9;
	public $title = '中毒';
	public $type = 'end';
	public $duration = 3;
	public $orgDuration = 3;

	function effect(){
		$damage = round($this->caster->atk * 0.5);
		$damage = $this->caster->calcDamage($damage, $this->char, 2);	//以魔法傷害計算
		$this->char->dot($damage);

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