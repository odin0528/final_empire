<?php
class char_2 extends character_prototype{
	public $name = "杜蘭";
	public $type = 'str';
	public $star = 4;
	public $hp = 600;
	public $atk = 100;
	public $def = 500;
	public $strRate = array(1.6, 1.8, 2, 2.15, 2.5);
	public $dexRate = array(0.6, 0.8, 1, 1.15, 1.3);
	public $staRate = array(2, 2.2, 2.5, 2.8, 3);
	public $intRate = array(0.4, 0.8, 1.2, 1.6, 2);
	public $ultimate = array(
			'title'		=>	"大地噴出劍",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1.1,
			'range'		=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0)
								),
			'splash'	=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0)
								),
			'debuff'	=>	1
		);
	public $skill1 = array(
			'title'		=>	"擊暈",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	1,
			'range'		=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0)
								),
			'debuff'	=>	1
		);
	public $attackLoop = array(1, 0, 0, 0);
}
