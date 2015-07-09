<?php
class buff_prototype{
	public $id;
	public $char;		//在某角色身上
	public $caster;		//施於此debuff的角色
	public $title = '';
	public $type = 'status';
	public $duration = 1;
	public $orgDuration = 1;	//原始持續時間
	public $stackCount = 1;
	public $stackMaxCount = 1;
	public $isEnable = false;
	public $isStacked = false;
	private $addStack = 0;

	function __construct(&$char = null, &$caster = null){
		$this->char = $char;
		$this->caster = $caster;
	}

	function effect(){}
	function nextRound(){
		if($this->addStack > 0){
			$this->stackCount += $this->addStack;
			$this->addStack = 0;
			if($this->stackCount > $this->stackMaxCount)
				$this->stackCount = $this->stackMaxCount;
		}
		if(!$this->isEnable){
			$this->isEnable = true;
		}else{
			$this->duration--;
			if($this->duration == 0)
				$this->finish();
		}
	}

	function finish(){
		unset($this->char->buff[$this->type][$this->id]);
		$data = array(
			'targetId'		=>	$this->char->side . '-' . $this->char->charId,
			'targetTitle'	=>	$this->char->side . ' - ' . $this->char->title. $this->char->name,
			'title'			=>	$this->title,
		);
		battleground::addMessage('endStep', $data);
	}

	function stack(){
		if($this->isStacked && $this->stackCount < $this->stackMaxCount)
			$this->addStack++;
		$this->duration = $this->orgDuration;
	}
}

?>