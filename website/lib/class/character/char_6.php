<?php
class char_6 extends character_prototype{
	public $name = "凱恩";
	public $type = 'str';
	public $star = 3;
	public $hp = 950;
	public $atk = 320;
	public $def = 100;
	public $strRate = array(1.97, 2.1, 2.4, 2.65, 2.9);
	public $dexRate = array(1.6, 1.8, 2.1, 2.35, 2.6);
	public $staRate = array(1.3, 1.5, 1.7, 1.9, 2.0);
	public $intRate = array(1.1, 1.2, 1.3, 1.4, 1.5);
	public $ultimate = array(
			'title'		=>	"夢想阿修羅拳",
			'type'		=>	1,
			'prop'		=>	1,
			'rate'		=>	3,
			'range'		=>	array(
									array(0,1,0),
									array(1,1,1),
									array(0,1,0),
							)

		);
	public $skill1 = array(
			'title'		=>	"刺拳",
			'type'		=>	1,
			'prop'		=>	1,
			'range'		=>	array(
								array(0,1,0),
								array(1,0,1),
								array(0,1,0),
							),
			'debuff'	=>	3,
			'rate'		=>	1
		);
	public $attackLoop = array(1, 0, 0, 0, 0, 0, 0);
}
