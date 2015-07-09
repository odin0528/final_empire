<?php
require('../bootstrap.php');
require('character.php');

$character = new character();

$view = new view();
$view->character 	= $character->getAll();
$pageBreak = new pageBreak($character->count(), RESULT_PER_PAGE);
$view->pagebar = $pageBreak->getPageBar();
$view->show();