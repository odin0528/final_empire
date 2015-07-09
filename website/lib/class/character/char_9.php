<?php
class char_9 extends character_prototype{
	public $name = "格羅姆";
	public $title = "守護戰士";
	public $type = 'str';
	public $class = 2;
	public $star = 3;
	public $hp = 1000;
	public $atk = 250;
	public $def = 550;
	public $strRate = array(3.28, 3.59, 3.81, 4.04, 4.28);
	public $dexRate = array(2.4, 2.64, 2.85, 3.05, 3.2);
	public $staRate = array(3.89, 4.24, 4.72, 5.18, 5.77);
	public $intRate = array(1.12, 1.34, 1.56, 1.78, 2);
	public $ultimate = array(
			'title'		=>	"盾牆",
			'type'		=>	1,
			'prop'		=>	1,
			'buff'		=>	2
		);
	public $skill1 = array(
			'title'		=>	"盾牌猛擊",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1.25,
			'range'		=>	array(
									array(1,1,1),
									array(1,1,1),
									array(1,1,1)
								),
			'debuff'	=>	1
		);
	public $skill2 = array(
			'title'		=>	"防禦姿態",
			'type'		=>	1,
			'prop'		=>	1,
			'buff'		=>	3
		);
	public $attackLoop = array(1, 0, 0, 0, 0, 0);
	function castUltimate(){
		$this->cast($this, $this->ultimate);
		return true;
	}

	function appear(){
		$this->cast($this, $this->skill2);
		return true;
	}
}
