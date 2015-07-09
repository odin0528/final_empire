<?php
class char_4 extends character_prototype{
	public $name = "夏洛特";
	public $type = 'int';
	public $star = 3;
	public $hp = 3000;
	public $atk = 20;
	public $def = 20;
	public $strRate = array(0.7, 0.97, 1.1, 1.23, 1.3);
	public $dexRate = array(0.6, 0.8, 1, 1.15, 1.3);
	public $staRate = array(1, 1.3, 1.5, 1.7, 1.9);
	public $intRate = array(2, 2.3, 2.55, 2.78, 2.96);
	public $ultimate = array(
			'title'		=>	"治療之光",
			'type'		=>	2,
			'prop'		=>	2,
			'rate'		=>	2.25,
		);
	public $skill1 = array(
			'title'		=>	"恢復術",
			'type'		=>	2,
			'prop'		=>	2,
			'rate'		=>	1.55,
			'range'		=>	array(
									array(0,1,1,1,0),
									array(1,1,1,1,1),
									array(1,1,1,1,1),
									array(1,1,1,1,1),
									array(0,1,1,1,0)
								),
			'target'	=>	'ally'
		);
	public $attackLoop = array(0, 0, 1, 0, 0);
	function castUltimate(){
		$target = battleground::getAlly($this);
		$this->heal($target, $this->ultimate);
		return true;
	}

	function caseSkill1(){
		$target = $this->getTarget($this->skill1);
		if(!empty($target)){
			//從所有的目標之中取出血量最少的
			$target = getLeastHpTarget($target);
			if(!empty($target)){
				$this->heal($target, $this->skill1);
				return true;
			}
		}
		return false;
	}
}
