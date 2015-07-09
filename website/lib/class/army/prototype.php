<?php
class army_prototype{
	public $title;
	public $hpRate = 1;
	public $atkRate = 1;
	public $defRate = 1;
	public $resRate = 1;
	public $movementRange = 1;
	public $attack		=array(
								'type'	=>	1,		
								//1:單體  
								//2:範圍(有splash的時候，type還是帶1就好)
								//3:方向性攻擊
								'range'	=>	array(
												array(0,1,0),
												array(1,1,1),
												array(0,1,0)
											),
								'prop'	=>	1
								//1:物理
								//2:法術
							);
	/*
	public $attackRange = array(
								array(0,0,1,0,0),
								array(0,0,1,0,0),
								array(1,1,1,1,1),
								array(0,0,1,0,0),
								array(0,0,1,0,0)
							);
	protected $attackRange = array(
								array(0,0,0,1,0,0,0),
								array(0,0,1,1,1,0,0),
								array(0,1,1,1,1,1,0),
								array(1,1,1,1,1,1,1),
								array(0,1,1,1,1,1,0),
								array(0,0,1,1,1,0,0),
								array(0,0,0,1,0,0,0),
							);*/

	public function __construct(&$char){
		$char->army = $this->title;
		$char->movementRange = $this->movementRange;
		$char->attack = $char->_attack = $this->attack;
		$char->hpRate = $this->hpRate;
		$char->defRate = $this->defRate;
		$char->resRate = $this->resRate;
		$char->atkRate = $this->atkRate;
	}
}
