<?php
class char_3 extends character_prototype{
	public $name = "安琪拉";
	public $type = 'int';
	public $star = 3;
	public $hp = 300;
	public $atk = 20;
	public $def = 20;
	public $strRate = array(0.6, 0.8, 1, 1.15, 1.3);
	public $dexRate = array(0.6, 0.8, 1, 1.15, 1.3);
	public $staRate = array(1, 1.2, 1.5, 1.8, 2);
	public $intRate = array(2, 2.5, 3, 3.5, 4);
	public $attackLoop = array(0, 1, 1, 0, 0, 0, 0, 0, 0, 0);
	public $ultimate = array(
			'title'		=>	"星落",
			'type'		=>	3,
			'prop'		=>	2,
			'rate'		=>	2.05,
			'range'		=>	array(
								array(
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,1,1,0),
									array(0,0,0,1,1,1,1),
									array(0,0,0,0,1,1,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
								),array(
									array(0,0,0,1,0,0,0),
									array(0,0,1,1,1,0,0),
									array(0,0,1,1,1,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
								),array(
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,1,1,0,0,0,0),
									array(1,1,1,1,0,0,0),
									array(0,1,1,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
								),array(
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,1,1,1,0,0),
									array(0,0,1,1,1,0,0),
									array(0,0,0,1,0,0,0),
								),
							)

		);
	public $skill1 = array(
			'title'		=>	"點燃",
			'type'		=>	1,
			'prop'		=>	2,
			'range'		=>	array(
									array(0,0,1,0,0),
									array(0,1,1,1,0),
									array(1,1,1,1,1),
									array(0,1,1,1,0),
									array(0,0,1,0,0)
								),
			'debuff'	=>	2
		);
	function caseSkill1(){
		$target = $this->getTarget($this->skill1);
		if(!empty($target)){
			$this->cast($target, $this->skill1);
			return true;
		}
		return false;
	}
}
