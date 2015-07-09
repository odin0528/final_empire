<?php
class army_1 extends army_prototype{
	public $title = "戰士";
	public $hpRate = 1.1;
	public $atkRate = 0.7;
	public $defRate = 1.1;
	public function __construct(&$char){
		$char->hp += 200;
		parent::__construct($char);
	}
}
