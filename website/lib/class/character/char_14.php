<?php
class char_14 extends character_prototype{
	public $name = "羅卡";
	public $type = 'dex';
	public $star = 3;
	public $hp = 400;
	public $atk = 300;
	public $def = 55;
	public $critRating = 150;
	public $strRate = array(0.6, 0.8, 1, 1.15, 1.3);
	public $dexRate = array(2, 2.2, 2.5, 2.8, 3);
	public $staRate = array(1.6, 1.8, 2, 2.15, 2.5);
	public $intRate = array(0.4, 0.8, 1.2, 1.6, 2);
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
	public $attackLoop = array(0, 0, 1, 0, 0);
	function caseSkill1(){
		$this->cast($this, $this->skill1);
		return true;
	}
}
