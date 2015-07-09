<?php
class battle{
	private $time;
	private $end = false;
	private $battleData = array();

	public function __construct(){
		$this->time = microtime(true);
	}

	public function newBattle($options){
		if(!class_exists('battleground'))  require(CLASS_PATH . '/class.Battleground.php');
		battleground::init();
		battleground::setOffensive($options['offensive_team']);
		battleground::setDefender($options['defender_team']);
		battleground::shuffle();
		$this->battleData[] = battleground::getBattleData();	//取得站位設定的資料
		battleground::showCharInfo();
		battleground::draw();
		while($this->end == false){
			$this->nextRound();
		}
		// echo json_encode($this->battleData);
		return $time = microtime(true) - $this->time;
	}

	public function nextRound(){
		$this->startStep();			//開始階段
		$this->attackStep();		//攻擊階段
		$this->moveStep();			//移動階段
		$this->endStep();			//結束階段
	}

	public function startStep(){
		battleground::startStep();
	}

	public function attackStep(){
		battleground::fight();
	}

	public function moveStep(){
		battleground::moveStep();
	}

	public function endStep(){
		$result = battleground::endStep();
		battleground::draw();
		if($result == "timeover"){
			echo "超出回合限制";
			$this->end = true;
		}elseif(!empty($result)){
			echo "戰鬥結束 {$result} 獲勝";
			$this->end = true;
		}
		
		$this->battleData[] = battleground::getBattleData();	//回合結束時取得這回合的戰鬥資料
	}
}
