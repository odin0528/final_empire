<?php
require('../bootstrap.php');
require('character.php');
require('army.php');

$character = new character();
$army = new army();

$view = new view();
$view->appendJs('/js/view/admin/formation.js');
$view->appendJs('/js/external/jquery.mousewheel.js');
$view->character 	= $character->getAll();
$view->army 		= $army->getAll();
$view->show();