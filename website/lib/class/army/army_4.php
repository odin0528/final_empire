<?php
class army_4 extends army_prototype{
	public $title = "弓箭手";
	public $hpRate = 0.9;
	public $atkRate = 1.1;
	public $defRate = 0.8;
	public $movementRange = 1;
	public $attack		=	array(
								'type'	=>	1,
								'range'	=>	array(
												array(0,0,1,0,0),
												array(0,1,1,1,0),
												array(1,1,1,1,1),
												array(0,1,1,1,0),
												array(0,0,1,0,0)
											)
							);
}
