<?php
class char_8 extends character_prototype{
	public $name = "格羅姆";
	public $title = "武器戰士";
	public $type = 'str';
	public $class = 2;
	public $star = 3;
	public $hp = 500;
	public $atk = 550;
	public $def = 150;
	public $strRate = array(3.98, 4.09, 4.31, 4.54, 4.78);
	public $dexRate = array(3, 3.15, 3.35, 3.55, 3.7);
	public $staRate = array(3.89, 4.01, 4.27, 4.48, 4.67);
	public $intRate = array(0.9, 1.18, 1.33, 1.58, 1.8);
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
	public $skill2 = array(
			'title'		=>	"致死打擊",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1.8,
			'range'		=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0)
								),
			'debuff'	=>	5
		);
	public $attackLoop = array(1, 0, 2, 0, 0);
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
