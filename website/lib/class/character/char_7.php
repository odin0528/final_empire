<?php
class char_7 extends character_prototype{
	public $name = "格羅姆";
	public $type = 'str';
	public $star = 3;
	public $hp = 600;
	public $atk = 400;
	public $def = 200;
	public $strRate = array(1.98, 2.09, 2.31, 2.54, 2.78);
	public $dexRate = array(1, 1.15, 1.35, 1.55, 1.7);
	public $staRate = array(1.89, 2.01, 2.27, 2.48, 2.67);
	public $intRate = array(0.6, 0.7, 0.81, 0.98, 1.1);
	public $ultimate = array(
			'title'		=>	"斬殺",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	2.5,
			'range'		=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0)
								)
		);
	public $skill1 = array(
			'title'		=>	"撕裂",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1,
			'range'		=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0)
								),
			'debuff'	=>	4
		);
	public $attackLoop = array(1, 0, 0, 0, 0);
	function castUltimate(){
		$target = $this->getTarget($this->ultimate);
		if(!empty($target)){
			if($target[0]->hp / $target[0]->maxHp * 100 < 30)
				$this->ultimate['rate'] = 30;
			$this->damage($target, $this->ultimate);
			return true;
		}
		return false;
	}
}
