<?php
class char_15 extends character_prototype{
	public $name = "羅卡";
	public $title = "盜賊";
	public $type = 'dex';
	public $class = 2;
	public $star = 3;
	public $hp = 800;
	public $atk = 600;
	public $def = 150;
	public $strRate = array(1.98, 2.09, 2.31, 2.54, 2.78);
	public $dexRate = array(5, 5.15, 5.35, 5.55, 5.7);
	public $staRate = array(2.89, 3.01, 3.27, 3.48, 3.67);
	public $intRate = array(1.9, 2.18, 2.33, 2.58, 2.8);
	public $ultimate = array(
			'title'		=>	"背刺",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	2.5,
			'range'		=>	array(
								array(1,1,1),
								array(1,1,1),
								array(1,1,1)
							)
		);
	public $skill1 = array(
			'title'		=>	"匿蹤",
			'type'		=>	1,
			'prop'		=>	1,
			'buff'		=>	9
		);
	public $skill2 = array(
			'title'		=>	"閃避",
			'type'		=>	1,
			'prop'		=>	1,
			'buff'		=>	10
		);
	public $attackLoop = array(1, 0, 0, 2, 0, 0);
	function caseSkill1(){
		$this->cast($this, $this->skill1);
		return true;
	}

	function caseSkill2(){
		$this->cast($this, $this->skill2);
		return true;
	}
}
