<?php
require('bootstrap.php');
require('character.php');

$character = new character();

$view = new view();

if(!empty($id)){
	$view->character 	= $character->getChar($id);
}
$view->show();