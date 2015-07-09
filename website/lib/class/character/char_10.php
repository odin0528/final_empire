<?php
class char_10 extends character_prototype{
	public $name = "格羅姆";
	public $title = "狂戰士";
	public $type = 'str';
	public $class = 3;
	public $star = 3;
	public $hp = 3000;
	public $atk = 1000;
	public $def = 1000;
	public $strRate = array(7.28, 7.59, 7.81, 8.04, 8.28);
	public $dexRate = array(2.4, 2.64, 2.85, 3.05, 3.2);
	public $staRate = array(6.89, 7.24, 7.42, 7.58, 7.77);
	public $intRate = array(1.12, 1.34, 1.56, 1.78, 2);
	public $ultimate = array(
			'title'		=>	"狂暴",
			'buff'		=>	4,
			'debuff'	=>	6
		);
	public $skill1 = array(
			'title'		=>	"撕裂",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1.2,
			'range'		=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0)
								),
			'debuff'	=>	4
		);
	public $skill2 = array(
			'title'		=>	"嗜血",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1.8,
			'range'		=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0)
								),
		);
	public $skill3 = array(
			'title'		=>	"旋風斬",
			'type'		=>	2,
			'prop'		=>	1,
			'rate'		=>	1.5,
			'range'		=>	array(
									array(1,1,1),
									array(1,1,1),
									array(1,1,1)
								)
		);
	public $attackLoop = array(1, 0, 3, 0, 2, 0);
	function castUltimate(){
		$this->cast($this, $this->ultimate);
		return true;
	}

	function caseSkill2(){
		$target = $this->getTarget($this->skill2);
		if(!empty($target)){
			$this->damage($target, $this->skill2);

			//恢復造成傷害的30%生命
			$recovery = 0;
			foreach($target as &$t){
				$recovery += $t->hurt;
			}
			$recovery = round($recovery * 0.3);
			$this->recovery($recovery);

			$data = array(
				'prop'			=>	2,
				'targetId'		=>	$this->side . '-' . $this->charId,
				'targetTitle'	=>	$this->side . ' - ' . $this->title. $this->name,
				'title'			=>	$this->skill2['title'],
				'heal'			=>	$this->recovery
			);
			battleground::addMessage('heal', $data);


			return true;
		}
		return false;
	}
}
