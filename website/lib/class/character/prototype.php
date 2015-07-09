<?php
class character_prototype{
	public $charId;
	public $name, $title, $army;
	protected $charNo, $x, $y;
	public $side = 0;	//1: 進攻方 2: 防守方
	public $lv = 1;
	public $star = 1;
	public $class = 1;	//階級(幾轉)
	public $rank = 1;	//進階級數
	public $type = 'str';
	public $maxHp, $hp = 300, $shield =0;
	public $en = 0;
	public $energyPool = 0;
	public $hurtPool = 0;		//損血計量
	public $str = 10, $dex = 10, $sta = 10, $int = 10;
	public $atk = 30, $def = 10, $res = 0, $ap = 100, $mp = 100, $dp = 100, $sp = 0, $sdp = 0;
	public $_atk, $_def, $_res, $_ap, $_mp, $_dp, $_sp, $_sdp;
	public $damage, $heal, $hurt, $recovery, $dodge, $crit;
	public $critRating = 0, $dodgeRating = 0, $hitRating = 0;
	public $_critRating, $_dodgeRating, $_hitRating;
	public $critRate = 2;
	protected $strRate = array(1,1.5,2,2.5,3);
	protected $dexRate = array(1,1.5,2,2.5,3);
	protected $staRate = array(1,1.5,2,2.5,3);
	protected $intRate = array(1,1.5,2,2.5,3);
	public $hpRate;
	public $atkRate;
	public $defRate;
	public $resRate;
	public $attack, $_attack;
	public $loopPos		=	0;
	public $attackLoop 	= array(0);
	public $debuff = array(
			'status'		=>	array(),
			'damage'		=>	array(),
			'recovery'		=>	array(),
			'hurt'			=>	array(),
			'heal'			=>	array(),
			'end'			=>	array(),
			'attr'			=>	array(),
			'dodge'			=>	array()
		);
	public $buff = array(
			'status'		=>	array(),
			'damage'		=>	array(),
			'recovery'		=>	array(),
			'hurt'			=>	array(),
			'heal'			=>	array(),
			'end'			=>	array(),
			'attr'			=>	array(),
			'dodge'			=>	array()
		);
	protected $ultimate;
	public $movementRange;
	public $attacked = false;	//是否已攻擊
	public $dead = false;		//是否陣亡
	public $isComa = false;		//是否昏迷
	public $isVisible = true;	//戰場中是否可見

	function __construct($option){
		if(!class_exists('army_prototype')) require(CLASS_PATH . '/army/prototype.php');
		if(!class_exists('army_'.$option['army_id'])) require(CLASS_PATH . '/army/army_'.$option['army_id'].'.php');
		$className = 'army_' . $option['army_id'];
		new $className($this);

		$s = $this->star - 1;
		$type = $this->type;

		$this->charId 	= 	$option['id'];
		$this->charNo 	= 	$option['char_id'];
		$this->lv 		= 	$option['lv'];
		$this->str		=	round($this->str + ($this->lv - 1) * $this->strRate[$s]);
		$this->dex		=	round($this->dex + ($this->lv - 1) * $this->dexRate[$s]);
		$this->sta		=	round($this->sta + ($this->lv - 1) * $this->staRate[$s]);
		$this->int		=	round($this->int + ($this->lv - 1) * $this->intRate[$s]);

		$this->maxHp	=	$this->hp	=	round(($this->hp + $this->sta * STAMINA_TO_HP + $this->str * STRENGTH_TO_HP) * $this->hpRate);
		$this->_atk		=	$this->atk	=	round(($this->atk + $this->$type * MAIN_ATTR_TO_ATK) * $this->atkRate);
		$this->_def		=	$this->def	=	round(($this->def + $this->str * STRENGTH_TO_DEF + $this->dex * DEXTERITY_TO_DEF) * $this->defRate);
		$this->_res		=	$this->res	=	round(($this->res + $this->sta * STAMINA_TO_RES + $this->int * INTELLECT_TO_RES) * $this->resRate);

		$this->_ap		=	$this->ap	=	round($this->ap + $this->$type * MAIN_ATTR_TO_AP);
		$this->_sp		=	$this->sp	=	round($this->sp + $this->int * INTELLECT_TO_SP);
		$this->_mp		=	$this->mp	=	round($this->mp + $this->int * INTELLECT_TO_MP);
		$this->_dp		=	$this->dp	=	round($this->dp + $this->str * STRENGTH_TO_DP + $this->dex * DEXTERITY_TO_DP + $this->sta * STAMINA_TO_DP);
		$this->_sdp		=	$this->sdp	=	round($this->sdp + $this->int * INTELLECT_TO_SDP + $this->sta * STAMINA_TO_SDP);

		$this->_critRating	=	$this->critRating	=	round($this->critRating + $this->dex * DEXTERITY_TO_CRIT + $this->int * INTELLECT_TO_CRIT);
		$this->_dodgeRating	=	$this->dodgeRating	=	round($this->dodgeRating + $this->dex * DEXTERITY_TO_DODGE + $this->int * INTELLECT_TO_DODGE);
		$this->_hitRating	=	$this->hitRating	=	round($this->hitRating + $this->dex * DEXTERITY_TO_HIT + $this->int * INTELLECT_TO_HIT);
	}

	function fight(){
		if(!$this->isComa){
			if($this->en == 100 && !empty($this->ultimate)){
				if($this->castUltimate()){
					$this->loopPos++;
					$this->en = 0;
					$this->attacked = true;
				}
			}

			if(!$this->attacked){
				$key = ($this->loopPos) % count($this->attackLoop);
				$active = $this->attackLoop[$key];
				if($active != 0){
					$caseSkillName = "caseSkill{$active}";
					//施放成功，或攻擊成功，都進行能量的計算
					if($this->$caseSkillName() || $this->attack()){
						$this->activeSuccess();
					}
				}else{
					if($this->attack()){
						$this->activeSuccess();
					}
				}
				
			}
		}else{
			$this->loopPos++;
			$this->attacked = true;
			$data = array(
				'title'		=>	"{$this->side} - {$this->title}{$this->name}",
				'charId'	=>	"{$this->side}-{$this->charId}",
				'status'	=>	"昏迷"
			);
			battleground::addMessage('status', $data);
		}
	}

	function attack(){
		$target = $this->getTarget($this->attack);
		if(!empty($target)){
			$this->damage($target);
			return true;
		}
		return false;
	}

	function damage($target, $spell = null){
		$dodge = false;
		$crit = false;
		$damaged = 0;

		if(!is_array($target))
			$target = array($target);

		if(empty($spell))
			$spell = array('action'=>1, 'title'=>"攻擊", 'prop'=>1, 'rate'=>1);
		else
			$spell['action'] = 2;

		switch($spell['prop']){
			case 1:	//物理傷害
			case 3:	//物理真傷
				$damege = intval($this->atk * $spell['rate']);
				break;
			case 2:	//魔法傷害
			case 4:	//魔法真傷
				$damege = intval($this->mp * $spell['rate']);
				break;
		}

		foreach($target as $t){
			if($spell['prop'] == 1)	//物理攻擊進行閃避判斷
				$dodge  = $this->isDodge($t);

			if(!$dodge){	//沒閃掉的話進行傷害計算及暴擊判定
				$this->damage = $this->calcDamage($damege, $t, $spell['prop']);
				$this->buffEffect('damage');
				$this->debuffEffect('damage');
				$crit   = $this->isCrit($t, $spell['prop']);
				if($crit)
					$this->damage *= $this->critRate;
				//TODO:增加攻擊者參數
				$t->hurt($this->damage, $spell['prop'], $this);

				if(!empty($spell['buff']))
					$buff = $t->addBuff($this, $spell['buff']);
				if(!empty($spell['debuff']))
					$debuff = $t->addDebuff($this, $spell['debuff']);
			}

			$data = array(
				'action'		=>	$spell['action'],
				'prop'			=>	$spell['prop'],
				'attkerId'		=>	$this->side . '-' . $this->charId,
				'attkerTitle'	=>	$this->side . ' - ' . $this->title . $this->name,
				'targetId'		=>	$t->side . '-' . $t->charId,
				'targetTitle'	=>	$t->side . ' - ' . $t->title. $t->name,
				'title'			=>	$spell['title'],
				'damage'		=>	$t->hurt,
				'damageProp'	=>	$spell['prop'],
				'isCrit'		=>	$crit,
				'isDodge'		=>	$dodge,
				'buff'			=>	empty($buff)? null : $buff,
				'debuff'		=>	empty($debuff)? null : $debuff,
			);
			battleground::addMessage('attack', $data);
		}
	}

	function heal(&$target, $spell){
		$this->heal = intval($this->mp * $spell['rate']);
		$this->buffEffect('heal');
		$this->debuffEffect('heal');
		if(!is_array($target))
			$target = array($target);

		foreach($target as $t){
			$t->recovery($this->heal);

			if(!empty($spell['buff']))
				$buff = $t->addBuff($this, $spell['buff']);
			if(!empty($spell['debuff']))
				$debuff = $t->addDebuff($this, $spell['debuff']);

			$data = array(
				'action'		=>	2,
				'prop'			=>	2,
				'attkerId'		=>	$this->side . '-' . $this->charId,
				'attkerTitle'	=>	$this->side . ' - ' . $this->title. $this->name,
				'targetId'		=>	$t->side . '-' . $t->charId,
				'targetTitle'	=>	$t->side . ' - ' . $t->title. $t->name,
				'title'			=>	$spell['title'],
				'heal'			=>	$t->recovery,
				'buff'			=>	empty($buff)? null : $buff,
				'debuff'		=>	empty($debuff)? null : $debuff,
			);
			battleground::addMessage('attack', $data);
		}
	}

	function cast(&$target, $spell){
		if(!is_array($target))
			$target = array($target);

		foreach($target as $t){
			if(!empty($spell['buff']))
				$buff = $t->addBuff($this, $spell['buff']);
			if(!empty($spell['debuff']))
				$debuff = $t->addDebuff($this, $spell['debuff']);

			$data = array(
				'action'		=>	2,
				'attkerId'		=>	$this->side . '-' . $this->charId,
				'attkerTitle'	=>	$this->side . ' - ' . $this->title. $this->name,
				'targetId'		=>	$t->side . '-' . $t->charId,
				'targetTitle'	=>	$t->side . ' - ' . $t->title. $t->name,
				'title'			=>	$spell['title'],
				'buff'			=>	empty($buff)? null : $buff,
				'debuff'		=>	empty($debuff)? null : $debuff,
			);
			battleground::addMessage('attack', $data);
		}
	}

	function processBuff(){
		foreach($this->buff as $type => &$buffset){
			foreach($buffset as &$buff){
				$buff->nextRound();
			}
		}

		foreach($this->debuff as $type => &$debuffset){
			foreach($debuffset as &$debuff){
				$debuff->nextRound();
			}
		}
	}

	function buffEffect($type){
		foreach($this->buff[$type] as &$buff){
			if(!empty($buff) && $buff->isEnable)
				$buff->effect();
		}
	}

	function debuffEffect($type){
		foreach($this->debuff[$type] as &$debuff){
			if(!empty($debuff) && $debuff->isEnable)
				$debuff->effect();
		}
	}

	function addDebuff(&$caster, $no){
		$exist = $this->existDebuff($no);
		$className = 'debuff_' . $no;
		$newDebuff = new $className($this, $caster);
		if(!$exist)
			$this->debuff[$newDebuff->type][$no]	=	$newDebuff;
		else
			$this->debuff[$newDebuff->type][$no]->stack();
		return $newDebuff;
	}

	function addBuff(&$caster, $no){
		$exist = $this->existBuff($no);
		$className = 'buff_' . $no;
		$newBuff = new $className($this, $caster);
		if(!$exist)
			$this->buff[$newBuff->type][$no]	=	$newBuff;
		else
			$this->buff[$newBuff->type][$no]->stack();
		return $newBuff;
	}

	function existBuff($no){
		if(!class_exists('buff_prototype')) require(CLASS_PATH . '/buff/prototype.php');
		if(!class_exists('buff_'.$no)) require(CLASS_PATH . '/buff/buff_'.$no.'.php');
		$className = 'buff_' . $no;
		$buff = new $className($this, $caster);
		return !empty($this->buff[$buff->type][$buff->id]);
	}

	function existDebuff($no){
		if(!class_exists('debuff_prototype')) require(CLASS_PATH . '/debuff/prototype.php');
		if(!class_exists('debuff_'.$no)) require(CLASS_PATH . '/debuff/debuff_'.$no.'.php');
		$className = 'debuff_' . $no;
		$debuff = new $className();
		return !empty($this->debuff[$debuff->type][$debuff->id]);
	}

	function hurt($damage, $prop = 1, &$attacker = null){
		$this->hurt = $damage;
		$this->buffEffect('hurt');
		$this->debuffEffect('hurt');
		$this->hurtPool += $this->hurt;
		$this->addEnergy(15);
	}

	//持續性傷害
	function dot($damage){
		$this->hurt = $damage;
		$this->buffEffect('hurt');
		$this->debuffEffect('hurt');
		$this->hurtPool += $this->hurt;
	}

	function recovery($heal){
		$this->recovery = $heal;
		$this->buffEffect('recovery');
		$this->debuffEffect('recovery');
		$this->hp = intval($this->hp + $this->recovery);
	}

	function addEnergy($num){
		$this->energyPool += $num;
	}

	//是否已完成攻擊, 僅用於移動回合判斷
	function isAttacked(){
		return $this->attacked;
	}

	function isCrit(&$target, $attackProp){
		if($attackProp == 1){
			$crit = ($this->critRating * (1 + ($this->lv - $target->lv) * 0.05)) / ($this->lv * LEVEL_TO_CRIT_REDUCTION) + 5;
			$crit = floor ($crit * 100);
		}else{
			$crit = ($this->critRating * (1 + ($this->lv - $target->lv) * 0.05)) / ($this->lv * LEVEL_TO_CRIT_REDUCTION) + 5;
			$crit = floor ($crit * 100);
		}
		
		if(rand(0,10000) < $crit)
			return true;
		return false;
	}

	function isDodge(&$target){
		$dodge = ($target->dodgeRating * (1 + ($target->lv - $this->lv) * 0.05) - $this->hitRating) / ($this->lv * LEVEL_TO_DODGE_REDUCTION) + 5;
		$this->dodge = floor ($dodge * 100);
		$this->buffEffect('dodge');
		$this->debuffEffect('dodge');
		if(rand(0,10000) < $this->dodge)
			return true;
		return false;
	}

	function dead(){
		$data = array(
			'title'		=>	"{$this->side} - {$this->title}{$this->name}",
			'charId'	=>	"{$this->side}-{$this->charId}",
		);
		$this->dead = true;
		battleground::$map[$this->x][$this->y]->clearChar();
		battleground::addMessage('dead', $data);
	}

	function moveTo(&$pos){
		battleground::$map[$this->x][$this->y]->clearChar();
		battleground::$map[$pos->x][$pos->y]->setChar($this);

		$data = array(
			'title'		=>	"{$this->side} - {$this->title}{$this->name}",
			'charId'	=>	"{$this->side}-{$this->charId}",
			'x'			=>	$pos->x, 
			'y'			=>	$pos->y
		);
		battleground::addMessage('move', $data);
		$this->setPos($pos->x, $pos->y);
	}

	function startStep(){
		$this->reset();
		$this->buffEffect('status');
		$this->debuffEffect('status');
		$this->buffEffect('attr');
		$this->debuffEffect('attr');
	}

	function endStep(){
		//計算結束回合的debuff
		$this->buffEffect('end');
		$this->debuffEffect('end');

		//回合結束時，一次性扣掉血量
		//先扣到護盾值上，如果護盾值為負數就再直接扣到血量上
		$this->shield -= $this->hurtPool;
		if($this->shield < 0){
			$this->hp += $this->shield;
			$this->shield = 0;
		}
		$this->hurtPool = 0;

		if($this->hp > $this->maxHp)
			$this->hp = $this->maxHp;

		if($this->hp <= 0 && !$this->dead){
			$this->dead();
			return true;	//有死人就回傳true，讓外面做戰鬥結束的判斷
		}

		$this->processBuff();

		//回合結束時，增加能量
		$this->en += $this->energyPool;
		$this->energyPool = 0;
		if($this->en > 100) $this->en = 100;
		return false;
	}

	//動作完成
	function activeSuccess(){
		$this->addEnergy(15);
		$this->attacked = true;
		$this->loopPos++;
	}

	//重置
	function reset(){
		// 還原角色狀態
		$this->isComa = false;
		$this->isVisible = true;
		$this->attacked = false;

		// 還原角色屬性
		$this->atk		=	$this->_atk;
		$this->def		=	$this->_def;
		$this->res		=	$this->_res;
		$this->ap		=	$this->_ap;
		$this->sp		=	$this->_sp;
		$this->mp		=	$this->_mp;
		$this->dp		=	$this->_dp;
		$this->sdp		=	$this->_sdp;
		$this->critRating	=	$this->_critRating;
		$this->dodgeRating	=	$this->_dodgeRating;
		$this->hitRating	=	$this->_hitRating;

		//還原角色的攻擊模式
		$this->attack 	= $this->_attack;
	}

	/*
	params:
		damage:		基礎傷害
		&defender:	防禦方角色件
		spell:		施放的技能
	*/
	function calcDamage($damage, &$defender, $attackProp){
		switch($attackProp){
			case 1:
				$damage = round($damage * (1 - $defender->def / ($defender->def + $defender->lv * LEVEL_TO_DAMAGE_REDUCTION)));
				$rate =$this->ap / $defender->dp;
				break;
			case 2:
				$damage = round($damage * (1 - $defender->res / ($defender->res + $defender->lv * LEVEL_TO_MAGIC_REDUCTION)));
				$rate =$this->sp / $defender->sdp;
				break;
			case 3:
				$rate = 1;
				break;
		}

		if($rate > 1.5)
			$rate = 1.5;
		elseif($rate < 0.5)
			$rate = 0.5;

		$damage = rand($damage, round($damage * $rate));
		return $damage;
	}

	//攻擊目標搜尋演算法
	function getTarget($attack, $pos = array()){
		//計算範圍的基準點
		$center = array(
				'x'	=>	(isset($pos['x']))?$pos['x']:$this->x,
				'y'	=>	(isset($pos['y']))?$pos['y']:$this->y,
			);
		$attackArea = $attack['range'];
		$attackType = $attack['type'];
		$splash = (isset($attack['splash']))?$attack['splash']:null;
		$searchTarget = (isset($attack['target']) && $attack['target'] == 'ally')? 'isAlly':'isEnemy';

		$map = &battleground::$map;
		$time = microtime(true);
		$mark = array();
		$queue = array();
		$queue[] = new step($center['x'], $center['y'], -1);
		$side = $this->getSide();
		$range = floor(count($attackArea) / 2);
		$target = array();

		if($attackType == 3){
			foreach($attackArea as $area){
				$target[] = $this->getTarget(array('range'=>$area, 'type'=>2));
			}
			foreach($target as $key => $t){
				if(empty($t))
					unset($target[$key]);
			}
			if(!empty($target)){
				$target = $target[array_rand($target, 1)];
			}


		}else{
			while(count($queue)){
				$p = array_shift($queue);
				if (empty($map[$p->x][$p->y]) || isOverRange($p, $center, $attackArea, $range) || !empty($mark[$p->x][$p->y])) continue;

				if(withinRange($p, $center, $attackArea, $range) && $map[$p->x][$p->y]->$searchTarget($this)){
					if($attack['type'] == 1 && empty($splash))	//單體攻擊
						return array($map[$p->x][$p->y]->getChar());
					elseif($attack['type'] == 1 && !empty($splash)){
						$target = $this->getTarget(array('range'=>$splash,'type'=>2), array('x'=>$p->x, 'y'=>$p->y));
						return $target;
					}elseif($attack['type'] == 2){
						$target[] = $map[$p->x][$p->y]->getChar();
					}
				}
				$mark[$p->x][$p->y] = 99;

				if($side == 1){
					$queue[] = new Step($p->x - 1, $p->y, 0);
					$queue[] = new Step($p->x + 1, $p->y, 0);
					$queue[] = new Step($p->x, $p->y - 1, 0);
					$queue[] = new Step($p->x, $p->y + 1, 0);
				}else{
					$queue[] = new Step($p->x + 1, $p->y, 0);
					$queue[] = new Step($p->x - 1, $p->y, 0);
					$queue[] = new Step($p->x, $p->y - 1, 0);
					$queue[] = new Step($p->x, $p->y + 1, 0);
				}
			}
		}
		return $target;
	}

	function getCharNo(){
		return $this->charNo;
	}

	function setPos($x, $y){
		$this->x = $x;
		$this->y = $y;
		return $this;
	}

	function getPos(){
		return array('x'=>$this->x, 'y'=>$this->y);
	}

	function setSide($side){
		$this->side = $side;
		return $this;
	}

	function getSide(){
		return $this->side;
	}

	function getMovementRange(){
		return $this->movementRange;
	}

	function getAttackRange(){
		return $this->attack;
	}

	function appear(){}	//角色出現的時候，用來設定被動技能的效果
	function castUltimate(){
		$target = $this->getTarget($this->ultimate);
		if(!empty($target)){
			$this->damage($target, $this->ultimate);
			return true;
		}
		return false;
	}
	function caseSkill1(){
		$target = $this->getTarget($this->skill1);
		if(!empty($target)){
			$this->damage($target, $this->skill1);
			return true;
		}
		return false;
	}

	function caseSkill2(){
		$target = $this->getTarget($this->skill2);
		if(!empty($target)){
			$this->damage($target, $this->skill2);
			return true;
		}
		return false;
	}

	function caseSkill3(){
		$target = $this->getTarget($this->skill3);
		if(!empty($target)){
			$this->damage($target, $this->skill3);
			return true;
		}
		return false;
	}

	function caseSkill4(){
		$target = $this->getTarget($this->skill4);
		if(!empty($target)){
			$this->damage($target, $this->skill4);
			return true;
		}
		return false;
	}

	function info(){
		$string = '<div class="character">';
		$string .= "名稱:{$this->title}{$this->name} ({$this->lv}) - {$this->type}<br>";
		$string .= "兵種:{$this->army}<br>";
		$string .= "str:{$this->str} dex:{$this->dex}<br>";
		$string .= "sta:{$this->sta} int:{$this->int}<br>";
		$string .= "atk:{$this->atk} mp:{$this->mp}<br>";
		$string .= "def:{$this->def} res:{$this->res}<br>";
		$string .= "ap:{$this->ap} sp:{$this->sp}<br>";
		$string .= "dp:{$this->dp} sdp:{$this->sdp}<br>";
		$string .= "crit:{$this->critRating} dodge:{$this->dodgeRating} hit:{$this->hitRating}";
		$string .= "</div>";
		return $string;
	}
}

?>