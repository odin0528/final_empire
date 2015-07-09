<?php
class char_5 extends character_prototype{
	public $name = "莉絲";
	public $type = 'dex';
	public $star = 3;
	public $hp = 550;
	public $atk = 220;
	public $def = 120;
	public $strRate = array(1.44, 1.62, 1.93, 2.15, 2.4);
	public $dexRate = array(1.6, 1.8, 2.1, 2.35, 2.6);
	public $staRate = array(1.3, 1.5, 1.7, 1.9, 2.0);
	public $intRate = array(1.1, 1.24, 1.48, 1.63, 1.8);
	public $ultimate = array(
			'title'		=>	"旋風槍",
			'type'		=>	3,
			'prop'		=>	1,
			'rate'		=>	1.8,
			'range'		=>	array(
								array(
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,1,1,1,1),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
								),array(
									array(0,0,0,1,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
								),array(
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(1,1,1,1,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
								),array(
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,1,0,0,0),
								),
							)

		);
	public $skill1 = array(
			'title'		=>	"攻擊增幅",
			'buff'		=>	1
		);
	public $attackLoop = array(1, 0, 0, 0, 0, 0, 0);
	function caseSkill1(){
		$this->cast($this, $this->skill1);
		return true;
	}
}
