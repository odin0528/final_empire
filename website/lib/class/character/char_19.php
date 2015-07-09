<?php
class char_18 extends character_prototype{
	public $name = "羅卡";
	public $title = "俠盜";
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
			'title'		=>	"伏擊",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	2.25,
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
			'title'		=>	"煙霧彈",
			'type'		=>	1,
			'prop'		=>	1,
			'range'		=>	array(
								array(0,0,1,0,0),
								array(0,1,1,1,0),
								array(1,1,1,1,1),
								array(0,1,1,1,0),
								array(0,0,1,0,0)
							),
			'splash'	=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0)
								),
			'debuff'	=>	8
		);
	public $skill3 = array(
			'title'		=>	"毒刃",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1.2,
			'range'		=>	array(
									array(1,1,1),
									array(1,1,1),
									array(1,1,1)
								),
			'debuff'	=>	9
		);
	public $attackLoop = array(3, 2, 0, 3, 1, 0,0);

	function castUltimate(){
		$target = $this->getTarget($this->ultimate);
		if(!empty($target)){
			$ultimate = $this->ultimate;
			//在匿蹤狀態中，傷害變為3.5倍
			if($this->existBuff(9) >= 0)
				$ultimate['rate'] = 3.5;
			$this->damage($target, $ultimate);
			return true;
		}
		return false;
	}

	function caseSkill1(){
		$this->cast($this, $this->skill1);
		return true;
	}

	function caseSkill2(){
		$target = $this->getTarget($this->skill2);
		if(!empty($target)){
			$this->cast($target, $this->skill2);
			return true;
		}
		return false;
	}
}
