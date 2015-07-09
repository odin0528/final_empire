<?php
class battleground{
	private static $width = 10;
	private static $height = 5;
	public static $map = array();
	private static $offensivePosition = array(array(1,1), array(1,2), array(0,3), array(0,2), array(0,1));
	private static $defenderPosition = array(array(8,1), array(8,2), array(9,3), array(9,2), array(9,1));
	private static $offensiveTeam;
	private static $defenderTeam;
	private static $allChar = array();
	private static $defenderTeamGameOver = false;
	private static $offensiveTeamGameOver = false;
	public static $message = array();
	public static $battleData = array();
	public static $roundNumber = 0;
	private static $moveCounter = 1;
	
	public static function init(){
		if(!class_exists('ground'))	require('class.Ground.php');
		for($x = 0; $x < self::$width; $x++){
			for($y = 0; $y < self::$height; $y++){
				self::$map[$x][$y]	=	new ground();
			}
		}
	}

	public static function startStep(){
		self::$roundNumber++;
		self::$moveCounter = 1;
		self::$message = array();
		self::$battleData = array();

		//回合開始處理所有狀態debuff buff
		$allChar = array_merge(self::$offensiveTeam, self::$defenderTeam);
		foreach($allChar as &$char){
			if($char->dead)	continue;
			$char->startStep();
		}
		unset($allChar);
	}

	public static function setOffensive($offensiveTeam){
		self::$offensiveTeam = $offensiveTeam;
		//設定初始站位
		$count = count($offensiveTeam);
		for($i = 0;$i < $count;$i++){
			array_push(self::$allChar, $offensiveTeam[$i]);
			$pos = self::$offensivePosition[$i];
			$x = $pos[0];
			$y = $pos[1];
			$offensiveTeam[$i]->setPos($x,$y)->setSide(1)->appear();
			self::$map[$x][$y]->setChar($offensiveTeam[$i]);

			$data = array(
				'title'		=>	"1 - {$offensiveTeam[$i]->title}{$offensiveTeam[$i]->name}",
				'charId'	=>	"1-{$offensiveTeam[$i]->charId}",
				'x'			=>	$x,
				'y'			=>	$y
			);
			self::addMessage('battleStart', $data);
		}
	}

	public static function setDefender($defenderTeam){
		self::$defenderTeam = $defenderTeam;
		//設定初始站位
		$count = count($defenderTeam);
		for($i = 0;$i < $count;$i++){
			array_push(self::$allChar, $defenderTeam[$i]);
			$pos = self::$defenderPosition[$i];
			$x = $pos[0];
			$y = $pos[1];
			$defenderTeam[$i]->setPos($x,$y)->setSide(2)->appear();
			self::$map[$x][$y]->setChar($defenderTeam[$i]);

			$data = array(
				'title'		=>	"2 - {$defenderTeam[$i]->title}{$defenderTeam[$i]->name}",
				'charId'	=>	"2-{$defenderTeam[$i]->charId}",
				'x'			=>	$x,
				'y'			=>	$y
			);
			self::addMessage('battleStart', $data);
		}
	}

	public static function shuffle(){
		shuffle(self::$allChar);
		var_dump(self::$allChar);
		exit;
	}

	public static function moveStep(){
		do{
			$offensiveMove= self::offensiveMove();
			$defenderMove = self::defenderMove();
			self::$moveCounter++;
		}while($offensiveMove || $defenderMove);
	}

	public static function offensiveMove(){
		$flag = false;
		foreach(self::$offensiveTeam as &$char){
			if($char->dead || $char->isAttacked())	continue;
			//若角色的移動力大於等於步數，就再進行移動
			if($char->getMovementRange() >= self::$moveCounter){
				$moveTo = self::getMovePath($char);
				if(!empty($moveTo))
					$char->moveTo($moveTo);
				$flag = true;
			}
		}
		return $flag;
	}

	public static function defenderMove(){
		$flag = false;
		foreach(self::$defenderTeam as &$char){
			if($char->dead || $char->isAttacked())	continue;
			//若角色的移動力大於等於步數，就再進行移動
			if($char->getMovementRange() >= self::$moveCounter){
				$moveTo = self::getMovePath($char);
				if(!empty($moveTo))
					$char->moveTo($moveTo);
				$flag = true;
			}
		}
		return $flag;
	}

	public static function fight(){
		$allChar = array_merge(self::$offensiveTeam, self::$defenderTeam);
		foreach($allChar as &$char){
			if($char->dead)	continue;
			$char->fight();
		}
		unset($allChar);
	}

	public static function endStep(){
		//若有人死亡，就做結束遊戲的計算
		self::$offensiveTeamGameOver = true;
		self::$defenderTeamGameOver = true;
		foreach(self::$offensiveTeam as &$char){
			if(!$char->dead && !$char->endStep()){
				self::$offensiveTeamGameOver = false;
				break;
			}
		}

		foreach(self::$defenderTeam as &$char){
			if(!$char->dead && !$char->endStep()){
				self::$defenderTeamGameOver = false;
				break;
			}
		}

		if(self::$offensiveTeamGameOver && self::$defenderTeamGameOver)
			return 'both';
		elseif(self::$offensiveTeamGameOver)
			return 'defender';
		elseif(self::$defenderTeamGameOver)
			return 'offensive';

		if(self::$roundNumber >= 45){
			return 'timeover';
		}

		return false;
	}

	public static function getAlly(&$char){
		$side = ($char->side == 1)? 'offensiveTeam':'defenderTeam';
		$team = array();
		foreach(self::$$side as &$member){
			if(!$member->dead)
				$team[] = $member;
		}
		return $team;
	}

	//定點移動路徑演算法
	public static function getMovePathByPos(&$char, $target, $limit = 0){
		$pos = $char->getPos();
		$startX = $pos['x'];
		$startY = $pos['y'];
		$mark = array();
		$queue = array();
		$queue[] = new step($startX, $startY, -1);
		$footprint = array();
		$side = $char->getSide();

		while(count($queue)){
			$p = array_shift($queue);

			//如果超出距離就換下一個點
			if($limit > 0 && (abs($p->x - $startX) + abs($p->y - $startY)) > $limit)
				continue;

			if ($p->x == $target['x'] && $p->y == $target['y']){
				//抓出最早碰到目標的點
				return $footprint[$p->s];
				break;
			}

			//如果超出範圍，或是已經計算過，或是不在起點又不可移動的時候就跳過換下一個
			if (self::isOverBg($p->x, $p->y) || !empty($mark[$p->x][$p->y]) || 
				($p->x != $startX || $p->y != $startY) && !self::$map[$p->x][$p->y]->isMovable()) 
					continue;

			$mark[$p->x][$p->y] = 99;
			$indx = count($footprint);
			$footprint[] = $p;

			if($side == 1){
				$queue[] = new Step($p->x + 1, $p->y, $indx);
				$queue[] = new Step($p->x, $p->y - 1, $indx);
				$queue[] = new Step($p->x, $p->y + 1, $indx);
				$queue[] = new Step($p->x - 1, $p->y, $indx);
			}else{
				$queue[] = new Step($p->x - 1, $p->y, $indx);
				$queue[] = new Step($p->x, $p->y - 1, $indx);
				$queue[] = new Step($p->x, $p->y + 1, $indx);
				$queue[] = new Step($p->x + 1, $p->y, $indx);
			}
			// self::paint($mark);
		}
		return null;
	}

	//移動路徑演算法
	private static function getMovePath(&$char){
		$pos = $char->getPos();
		$startX = $pos['x'];
		$startY = $pos['y'];
		$time = microtime(true);
		$mark = array();
		$queue = array();
		$queue[] = new step($startX, $startY, -1);
		$footprint = array();
		$i_step = -1;
		$side = $char->getSide();
		$hasEnemy = false;

		//尋找同一列的敵人
		if($side == 1){
			for($i = 1; $i < self::$width; $i++){
				if($startX + $i >= self::$width && $startX - $i < 0)
					break;

				if(($startX + $i < self::$width && self::$map[$startX + $i][$startY]->isEnemy($char)) || 
					($startX - $i >= 0 && self::$map[$startX - $i][$startY]->isEnemy($char))){
					$hasEnemy = true;
					break;
				}
			}
		}else{
			for($i = 1; $i < self::$width; $i++){
				if($startX + $i >= self::$width && $startX - $i < 0)
					break;

				if(($startX - $i >= 0 && self::$map[$startX - $i][$startY]->isEnemy($char)) || 
					($startX + $i < self::$width && self::$map[$startX + $i][$startY]->isEnemy($char))){
					$hasEnemy = true;
					break;
				}
			}
		}

		//可攻擊位置計算
		$attackPosition = self::getAttackPosition($char);
		if(!empty($attackPosition[$startX][$startY]))
			return false;

		while(count($queue)){
			$p = array_shift($queue);

			//如果超出範圍，或是已經計算過，或是不在起點又不可移動的時候就跳過換下一個
			if (self::isOverBg($p->x, $p->y) || !empty($mark[$p->x][$p->y]) || 
				($p->x != $startX || $p->y != $startY) && !self::$map[$p->x][$p->y]->isMovable()) 
					continue;

			$mark[$p->x][$p->y] = 99;
			$indx = count($footprint);
			$footprint[] = $p;

			if (!empty($attackPosition[$p->x][$p->y])){
				$i_step = $indx;
				break;
			}

			if($hasEnemy){
				if($side == 1){
					$queue[] = new Step($p->x + 1, $p->y, $indx);
					$queue[] = new Step($p->x, $p->y - 1, $indx);
					$queue[] = new Step($p->x, $p->y + 1, $indx);
					$queue[] = new Step($p->x - 1, $p->y, $indx);
				}else{
					$queue[] = new Step($p->x - 1, $p->y, $indx);
					$queue[] = new Step($p->x, $p->y - 1, $indx);
					$queue[] = new Step($p->x, $p->y + 1, $indx);
					$queue[] = new Step($p->x + 1, $p->y, $indx);
				}
			}else{
				if($side == 1){
					$queue[] = new Step($p->x, $p->y - 1, $indx);
					$queue[] = new Step($p->x, $p->y + 1, $indx);
					$queue[] = new Step($p->x + 1, $p->y, $indx);
					$queue[] = new Step($p->x - 1, $p->y, $indx);
				}else{
					$queue[] = new Step($p->x, $p->y - 1, $indx);
					$queue[] = new Step($p->x, $p->y + 1, $indx);
					$queue[] = new Step($p->x - 1, $p->y, $indx);
					$queue[] = new Step($p->x + 1, $p->y, $indx);
				}
			}
			// self::paint($mark);
		}
		
		$result = false;
		if ($i_step > -1){
			$moveStack = array();
			$lastStep = $footprint[$i_step];
			do{
				$mark[$lastStep->x][$lastStep->y] = 1;
				$moveStack[] = $lastStep;
				$lastStep = $footprint[$lastStep->s];
			}while($lastStep->s  != -1);
			if(count($moveStack) >= 1)
				$result = array_pop($moveStack);
		}
		// $time -= microtime(true);
		// echo $time;
		// self::paint($mark);
		return $result;
		// exit;
	}

	//取得可以攻擊的位置
	public static function getAttackPosition(&$char){
		$attackPos = array();
		$attackRange = $char->getAttackRange();
		$side = $char->getSide();
		$enemyTeam = ($side==1)?'defenderTeam':'offensiveTeam';
		foreach(self::$$enemyTeam as &$enemy){
			//當角色已死亡，或是不可見的時候跳過此角色
			if($enemy->dead || !$enemy->isVisible)	continue;
			$pos = $enemy->getPos();
			$range = count($attackRange['range']);
			$dist = floor(count($attackRange['range']) / 2);
			for($i=0;$i<$range;$i++){
				for($j=0;$j<$range;$j++){
					$x = $pos['x'] + ($i - $dist);
					$y = $pos['y'] + ($j - $dist);
					if(empty($attackRange['range'][$i][$j]) || self::isOverBg($x, $y))	continue;
					$attackPos[$x][$y] = true;
				}
			}
		}
		// var_dump($attackPos);
		// self::paint($attackPos);
		// exit;
		return $attackPos;
	}

	public static function isOverBg($x, $y){
		return empty(self::$map[$x][$y]);
	}

	public static function getBattleData(){
		return self::$battleData;
	}

	public static function getMessage(){
		$message = '';
		if(!empty(self::$message['battleStart'])){
			foreach(self::$message['battleStart'] as $msg){
				$message .= $msg . '<br>';
			}
		}
		if(!empty(self::$message['status'])){
			foreach(self::$message['status'] as $msg){
				$message .= $msg . '<br>';
			}
		}
		if(!empty(self::$message['attack'])){
			foreach(self::$message['attack'] as $msg){
				$message .= $msg . '<br>';
			}
		}
		if(!empty(self::$message['move'])){
			foreach(self::$message['move'] as $msg){
				$message .= $msg . '<br>';
			}
		}
		if(!empty(self::$message['damage'])){
			foreach(self::$message['damage'] as $msg){
				$message .= $msg . '<br>';
			}
		}
		if(!empty(self::$message['heal'])){
			foreach(self::$message['heal'] as $msg){
				$message .= $msg . '<br>';
			}
		}
		if(!empty(self::$message['endStep'])){
			foreach(self::$message['endStep'] as $msg){
				$message .= $msg . '<br>';
			}
		}
		if(!empty(self::$message['dead'])){
			foreach(self::$message['dead'] as $msg){
				$message .= $msg . '<br>';
			}
		}
		return $message;
	}

	public static function addMessage($key, $data){
		switch($key){
			case 'battleStart':

				$msg = "{$data['title']} 在 X:{$data['x']} Y:{$data['y']} 出現";
				break;

			case 'status':
				$msg = "{$data['title']} {$data['status']}";
				break;

			case 'endStep':
				$msg = "{$data['targetTitle']} 身上的 {$data['title']} 消失";
				break;

			case 'move':

				$msg = "{$data['title']} 移動到 X:{$data['x']} Y:{$data['y']}";
				break;

			case 'damage':
				$msg = "{$data['title']} 對 {$data['targetTitle']} 造成了 {$data['damage']} 傷害";
				break;
			case 'heal':
				$msg = "{$data['title']} 對 {$data['targetTitle']} 恢復 {$data['heal']} 生命";
				break;

			case 'attack':

				if($data['action'] == 2)
						$msg = "{$data['attkerTitle']} 對 {$data['targetTitle']} 施放 「{$data['title']}」";
					else
						$msg = "{$data['attkerTitle']} 對 {$data['targetTitle']} 攻擊 ";

				if(!empty($data['isDodge']))
					$msg .= ' 未命中';
				elseif(!empty($data['heal']))
					$msg .= " 恢復 {$data['heal']} 生命";
				elseif(!empty($data['damage'])){
					$msg .= " 造成 {$data['damage']} ";
					if($data['prop'] == 2)
						$msg .= ' 法術';
					$msg .= '傷害';
				}

				if(!empty($data['debuff']))
					$msg .= " 造成了 「{$data['debuff']->title}({$data['debuff']->duration})」";
				if(!empty($data['buff']))
					$msg .= " 獲得了 「{$data['buff']->title}({$data['buff']->duration})」";

				if(!empty($data['isCrit']))
					$msg = '<span style="color:#F00">' . $msg . '</span>';
				if(!empty($data['isDodge']))
					$msg = '<span style="color:#00F">' . $msg . '</span>';

				break;

			case 'dead':
				$msg = "{$data['title']} 死亡";
		}
		self::$battleData[$key][] = $data;
		self::$message[$key][] = $msg;
	}

	public static function draw(){
		$bgHtml = '';
		for($y = 0; $y < self::$height; $y++){
			for($x = 0; $x < self::$width; $x++){
				$className = 'battleground';
				switch(self::$map[$x][$y]->getSide()){
					case 1:
						$className .=	' offensive';
						break;
					case 2:
						$className .=	' defender';
				}
				$char = self::$map[$x][$y]->getChar();
				if(empty($char))
					$bgHtml .= "<div class=\"{$className}\"></div>\n";
				else{
					$bgHtml .= "<div class=\"{$className}\">". $char->title.$char->name . "<br>" . $char->hp;
					$bgHtml .= " " . (($char->shield > 0)?"({$char->shield})":"") . "<br>" . $char->en . "</div>\n";
				}
				if($x == self::$width - 1)
					$bgHtml .= '<div class="clear"></div>';
			}
		}
		$msg = self::getMessage();
		$roundNumber = (self::$roundNumber > 0)?"Round " . self::$roundNumber . "!!":"Battle Start!!";
		include(ROOT_PATH . '/templates/battleground.php');
	}

	public static function showCharInfo(){
		$bgHtml = '<div class="page-title ui-widget-content ui-corner-all"><h1><b>進攻方</b></h1><div class="other">';
		foreach(self::$offensiveTeam as &$char){
			$bgHtml .= $char->info();
		}
		$bgHtml .= '<div class="clear"></div></div>';
		$bgHtml .= '<h1><b>防守方</b></h1><div class="other">';
		foreach(self::$defenderTeam as &$char){
			$bgHtml .= $char->info();
		}
		$bgHtml .= '<div class="clear"></div></div></div>';
		echo $bgHtml;
	}

	public static function paint($mark){
		$bgHtml = '';
		for($y = 0; $y < self::$height; $y++){
			for($x = 0; $x < self::$width; $x++){
				$className = 'battleground';
				switch(self::$map[$x][$y]->getSide()){
					case 1:
						$className .=	' offensive';
						break;
					case 2:
						$className .=	' defender';
						break;
					default:
						if(empty($mark[$x][$y])){
							
						}elseif($mark[$x][$y] == 99)
							$className .=	' mark';
						elseif($mark[$x][$y] == 1)
							$className .=	' path';
				}

				$bgHtml .= "<div class=\"{$className}\"></div>\n";
				if($x == self::$width - 1)
					$bgHtml .= '<div class="clear"></div>';
			}
		}
		$roundNumber = '';
		$msg = '';
		include(ROOT_PATH . '/templates/battleground.php');
	}
}

class step{
	public $x, $y, $s;
	
	public function __construct($x, $y, $s)
	{
		$this->x = $x;
		$this->y = $y;
		$this->s = $s;
	}
}
?>