<?php
class char_12 extends character_prototype{
	public $name = "格羅姆";
	public $title = "戰場督軍";
	public $type = 'str';
	public $class = 3;
	public $star = 3;
	public $hp = 5000;
	public $atk = 700;
	public $def = 1500;
	public $strRate = array(7.09, 7.44, 7.62, 7.78, 7.97);
	public $dexRate = array(2.4, 2.64, 2.85, 3.05, 3.2);
	public $staRate = array(7.08, 7.39, 7.61, 7.84, 8.08);
	public $intRate = array(2.12, 2.34, 2.56, 2.78, 2.9);
	public $ultimate = array(
			'title'		=>	"挫志怒吼",
			'type'		=>	2,
			'prop'		=>	1,
			'range'		=>	array(
									array(0,0,1,0,0),
									array(0,1,1,1,0),
									array(1,1,1,1,1),
									array(0,1,1,1,0),
									array(0,0,1,0,0)
								),
			'debuff'	=>	7
		);
	public $skill1 = array(
			'title'		=>	"戰爭踐踏",
			'type'		=>	2,
			'prop'		=>	1,
			'rate'		=>	1.5,
			'range'		=>	array(
									array(1,1,1),
									array(1,1,1),
									array(1,1,1)
								),
			'debuff'	=>	1
		);
	public $skill2 = array(
			'title'		=>	"復仇",
			'type'		=>	1,
			'prop'		=>	1,
			'buff'		=>	7
		);
	public $skill3 = array(
			'title'		=>	"戒備戰吼",
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
			'buff'		=>	5
		);
	public $attackLoop = array(1, 0, 3, 0, 0, 0);
	function appear(){
		$this->cast($this, $this->skill2);
		return true;
	}

	function castUltimate(){
		$target = $this->getTarget($this->ultimate);
		if(!empty($target)){
			$this->cast($target, $this->ultimate);
			return true;
		}
		return false;
	}

	function caseSkill3(){
		$target = $this->getTarget($this->skill3);
		if(!empty($target)){
			$this->cast($target, $this->skill3);
			return true;
		}
		return false;
	}

	function hurt($damage, $prop = 1, &$attacker = null){
		$this->hurt = $damage;
		$this->buffEffect('hurt');
		$this->debuffEffect('hurt');
		$this->hurtPool += $this->hurt;
		$this->addEnergy(15);

		if($prop == 1){
			//因為復仇的關係，受到物理傷害時，反彈傷害給攻擊者
			//反彈的傷害為真實傷害，不得再減傷
			$attacker->hurtPool += round($this->hurt * 0.2);

			$data = array(
				'prop'			=>	3,
				'targetId'		=>	$attacker->side . '-' . $attacker->charId,
				'targetTitle'	=>	$attacker->side . ' - ' . $attacker->title. $attacker->name,
				'title'			=>	"復仇",
				'damage'		=>	round($this->hurt * 0.2)
			);
			battleground::addMessage('damage', $data);
		}
	}
}
