<?php
class army_3 extends army_prototype{
	public $title = "鏢槍手";
	public $hpRate = 0.9;
	public $atkRate = 1.1;
	public $defRate = 1;
	public $movementRange = 1;
	public $attack		=	array(
								'type'	=>	1,
								'range'	=>	array(
												array(0,0,1,0,0),
												array(0,0,0,0,0),
												array(1,0,1,0,1),
												array(0,0,0,0,0),
												array(0,0,1,0,0)
											)
							);
}
