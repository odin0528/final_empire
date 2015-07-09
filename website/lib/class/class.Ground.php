<?php
class ground{
	private $movable;
	private $side = 0;
	private $char;

	public function setChar(&$char){
		$this->side = $char->getSide();
		$this->char = $char;
	}

	public function getSide(){
		return $this->side;
	}

	public function getChar(){
		return $this->char;
	}

	public function clearChar(){
		$this->side = 0;
		$this->char = null;
	}

	public function isMovable(){
		return $this->getSide()==0?true:false;
	}

	public function isEnemy(&$char){
		return ($this->side != 0 && $this->char->isVisible && $char->getSide() != $this->getSide());
	}

	public function isAlly(&$char){
		return ($this->side != 0 && $this->char->isVisible && $char->getSide() == $this->getSide());
	}
}
