<?php
class char_17 extends character_prototype{
	public $name = "羅卡";
	public $title = "霸主";
	public $type = 'dex';
	public $class = 3;
	public $star = 3;
	public $hp = 3000;
	public $atk = 1400;
	public $def = 800;
	public $strRate = array(3.4, 3.64, 3.85, 4.05, 4.2);
	public $dexRate = array(7.28, 7.59, 7.81, 8.04, 8.28);
	public $staRate = array(4.89, 5.24, 5.42, 5.58, 5.77);
	public $intRate = array(2.12, 2.34, 2.56, 2.78, 3);
	public $ultimate = array(
			'title'		=>	"無情打擊",
			'type'		=>	1,
			'prop'		=>	3,	//無視防的真傷
			'rate'		=>	1.5,
			'range'		=>	array(
								array(1,1,1),
								array(1,1,1),
								array(1,1,1)
							)
		);

	public $skill1 = array(
			'title'		=>	"腎擊",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1.75,
			'range'		=>	array(
									array(1,1,1),
									array(1,1,1),
									array(1,1,1)
								),
			'debuff'	=>	1
		);
	public $skill2 = array(
			'title'		=>	"霸氣",
			'type'		=>	1,
			'prop'		=>	1,
			'buff'		=>	12
		);
	public $skill3 = array(
			'title'		=>	"伺機而動",
			'type'		=>	1,
			'prop'		=>	1,
		);
	public $attackLoop = array(3, 0, 1, 0, 0, 0);

	function appear(){
		$this->cast($this, $this->skill2);
		return true;
	}

	function caseSkill3(){
		$this->cast($this, $this->skill3);
		$this->energyPool += 45;
		return true;
	}
}
