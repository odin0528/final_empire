<?php
class army_2 extends army_prototype{
	public $title = "盜賊";
	public $hpRate = 1;
	public $atkRate = 1;
	public $defRate = 0.8;
	public $movementRange = 2;
	public $attack		=	array(
								'type'	=>	1,
								'range'	=>	array(
												array(1,1,1),
												array(1,1,1),
												array(1,1,1)
											),
							);
}
