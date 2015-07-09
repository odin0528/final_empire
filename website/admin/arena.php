<?php
require('../bootstrap.php');
require('character.php');
require(CLASS_PATH . '/class.Battle.php');

//取得game object
$character = new character();
$offensiveTeam = array();
$defenderTeam = array();

$countOffensive = count($_POST['offensive']['char_id']);
$countDefender = count($_POST['defender']['char_id']);
$team = array();
if(!class_exists('character_prototype'))
	require(CLASS_PATH . '/character/prototype.php');

for($i = 0; $i < $countOffensive; $i++){
	$data = $_POST['offensive'];
	if($data['char_id'][$i] == "")	break;
	if(!class_exists('char_'.$data['char_id'][$i]))
		require(CLASS_PATH . '/character/char_'.$data['char_id'][$i].'.php');

	$className = 'char_' . $data['char_id'][$i];
	$char = new $className(
			array(
				'id'		=>	$data['char_id'][$i],
				'char_id'	=>	$data['char_id'][$i],
				'army_id'	=>	$data['army_id'][$i],
				'lv'		=>	$data['lv'][$i],
			)
		);
	$offensiveTeam[] = $char;
}

for($i = 0; $i < $countDefender; $i++){
	$data = $_POST['defender'];
	if($data['char_id'][$i] == "")	break;
	if(!class_exists('char_'.$data['char_id'][$i]))
		require(CLASS_PATH . '/character/char_'.$data['char_id'][$i].'.php');

	$className = 'char_' . $data['char_id'][$i];
	$char = new $className(
			array(
				'id'		=>	$data['char_id'][$i],
				'char_id'	=>	$data['char_id'][$i],
				'army_id'	=>	$data['army_id'][$i],
				'lv'		=>	$data['lv'][$i],
			)
		);
	$defenderTeam[] = $char;
}


$battleOptions = array(
	'offensive_team'		=>	$offensiveTeam,
	'defender_team'			=>	$defenderTeam
);

ob_start();

$battle = new battle();

$battle->newBattle($battleOptions);

$view = new view();
$view->battle = ob_get_clean();
$view->show();
?>