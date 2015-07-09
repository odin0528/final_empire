<?php
class char_16 extends character_prototype{
	public $name = "羅卡";
	public $title = "義賊";
	public $type = 'dex';
	public $class = 2;
	public $star = 3;
	public $hp = 800;
	public $atk = 580;
	public $def = 170;
	public $hitRating = 50;
	public $strRate = array(2.18, 2.29, 2.51, 2.74, 2.98);
	public $dexRate = array(4.95, 5.05, 5.25, 5.45, 5.6);
	public $staRate = array(2.89, 3.01, 3.27, 3.48, 3.67);
	public $intRate = array(1.9, 2.18, 2.33, 2.58, 2.8);
	public $ultimate = array(
			'title'		=>	"劍刃亂舞",
			'type'		=>	1,
			'prop'		=>	1,
			'buff'		=>	11

		);
	public $skill1 = array(
			'title'		=>	"匿蹤",
			'type'		=>	1,
			'prop'		=>	1,
			'buff'		=>	9
		);
	public $skill2 = array(
			'title'		=>	"飛舞刀刃",
			'type'		=>	2,
			'prop'		=>	1,
			'rate'		=>	1.25,
			'range'		=>	array(
								array(0,1,1,1,0),
								array(1,1,1,1,1),
								array(1,1,1,1,1),
								array(1,1,1,1,1),
								array(0,1,1,1,0)
							)
		);
	public $attackLoop = array(2, 0, 1, 0, 0);
	function castUltimate(){
		$this->cast($this, $this->ultimate);
		return true;
	}
	function caseSkill1(){
		$this->cast($this, $this->skill1);
		return true;
	}
}
