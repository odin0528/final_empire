<?php
class char_13 extends character_prototype{
	public $name = "格羅姆";
	public $title = "巨盾勇士";
	public $type = 'str';
	public $class = 3;
	public $star = 3;
	public $hp = 5000;
	public $atk = 500;
	public $def = 2000;
	protected $strRate = array(6.39, 6.44, 6.92, 7.08, 7.27);
	protected $dexRate = array(2.4, 2.64, 2.85, 3.05, 3.2);
	protected $staRate = array(7.78, 8.09, 8.31, 8.54, 8.78);
	protected $intRate = array(2.12, 2.34, 2.56, 2.78, 2.9);
	protected $ultimate = array(
			'title'		=>	"大地裂隙",
			'type'		=>	3,
			'prop'		=>	1,
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
							),
			'debuff'	=>	1

		);
	protected $skill1 = array(
			'title'		=>	"重盾衝鋒",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1,
			'range'		=>	array(
									array(0,0,0,1,0,0,0),
									array(0,0,1,1,1,0,0),
									array(0,1,1,1,1,1,0),
									array(1,1,1,1,1,1,1),
									array(0,1,1,1,1,1,0),
									array(0,0,1,1,1,0,0),
									array(0,0,0,1,0,0,0),
								),
			'debuff'	=>	1
		);

	protected $skill2 = array(
			'title'		=>	"盾牌屏障",
			'type'		=>	1,
			'prop'		=>	1
		);

	//受到暈眩時，在回合開始的階段恢復20%生命
	protected $skill3 = array(
			'title'		=>	"勢不可當",
			'type'		=>	1,
			'prop'		=>	1,
			'buff'		=>	8
		);
	public $attackLoop = array(1, 0, 2, 0, 0, 0);
	function appear(){
		$this->cast($this, $this->skill3);
		return true;
	}

	//重盾衝鋒：如果普攻打的到人，就不衝鋒，改用普攻
	function caseSkill1(){
		$target = $this->getTarget($this->attack);
		if(!empty($target)){
			$this->damage($target);
			return true;
		}else{
			$target = $this->getTarget($this->skill1);
			if(!empty($target)){
				foreach($target as $t){
					$pos = battleground::getMovePathByPos($this, $t->getPos(), 3);
					if($pos != null){
						$this->damage($t, $this->skill1);
						$this->moveTo($pos);
						return true;
					}
				}
			}
			return false;
		}
	}

	//增加10%的最大生命到護盾上
	function caseSkill2(){
		$this->shield += round($this->maxHp * 0.1);
		return true;
	}

	function caseSkill3(){
		$target = $this->getTarget($this->skill3);
		if(!empty($target)){
			$this->cast($target, $this->skill3);
			return true;
		}
		return false;
	}
}
