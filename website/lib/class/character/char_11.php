<?php
class char_11 extends character_prototype{
	public $name = "格羅姆";
	public $title = "百夫長";
	public $type = 'str';
	public $class = 3;
	public $star = 3;
	public $hp = 3000;
	public $atk = 1000;
	public $def = 1000;
	public $strRate = array(7.08, 7.39, 7.61, 7.84, 8.08);
	public $dexRate = array(2.4, 2.64, 2.85, 3.05, 3.2);
	public $staRate = array(7.09, 7.44, 7.62, 7.78, 7.97);
	public $intRate = array(1.12, 1.34, 1.56, 1.78, 2);
	private $ultimate = array(
			'title'		=>	"闢地猛擊",
			'type'		=>	3,
			'prop'		=>	1,
			'rate'		=>	1.8,
			'range'		=>	array(
								array(
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,1),
									array(0,0,0,0,0,1,1),
									array(0,0,0,1,1,1,1),
									array(0,0,0,0,0,1,1),
									array(0,0,0,0,0,0,1),
									array(0,0,0,0,0,0,0),
								),array(
									array(0,1,1,1,1,1,0),
									array(0,0,1,1,1,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
								),array(
									array(0,0,0,0,0,0,0),
									array(1,0,0,0,0,0,0),
									array(1,1,0,0,0,0,0),
									array(1,1,1,1,0,0,0),
									array(1,1,0,0,0,0,0),
									array(1,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
								),array(
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,0,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,0,1,0,0,0),
									array(0,0,1,1,1,0,0),
									array(0,1,1,1,1,1,0),
								),
							)
		);
	public $skill1 = array(
			'title'		=>	"撕裂",
			'type'		=>	2,
			'prop'		=>	1,
			'rate'		=>	1.2,
			'range'		=>	array(
									array(1,1,1),
									array(1,1,1),
									array(1,1,1)
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

	public $skill3 = array(
			'title'		=>	"戰爭怒吼",
			'type'		=>	2,
			'prop'		=>	1,
			'rate'		=>	1,
			'range'		=>	array(
									array(0,0,1,0,0),
									array(0,1,1,1,0),
									array(1,1,1,1,1),
									array(0,1,1,1,0),
									array(0,0,1,0,0)
								),
			'target'	=>	'ally',
			'buff'		=>	6
		);
	public $attackLoop = array(0, 0, 3, 1, 0, 2, 0, 1);

	function caseSkill3(){
		$target = $this->getTarget($this->skill3);
		if(!empty($target)){
			$this->cast($target, $this->skill3);
			return true;
		}
		return false;
	}
}
