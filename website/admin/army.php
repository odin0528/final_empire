<?php
require('../bootstrap.php');
require('character.php');

$army = new army();

$view = new view();
$view->army 	= $army->getAll();
$pageBreak = new pageBreak($army->count(), RESULT_PER_PAGE);
$view->pagebar = $pageBreak->getPageBar();
$view->show();
