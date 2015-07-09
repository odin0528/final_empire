<?php

function getLeastHpTarget(&$targetSet){
	$leastHpTarget=null;
	foreach($targetSet as &$target){
		if($target->hp < $target->maxHp && (empty($leastHpTarget) || $target->hp < $leastHpTarget->hp))
			$leastHpTarget = $target;
	}
	return $leastHpTarget;
}

function withinRange($step, $center, $attackRange, $range){
	$x = $step->x - ($center['x'] - $range);
	$y = $step->y - ($center['y'] - $range);
	return ($attackRange[$x][$y]===1)?true:false;
}

function isOverRange($step, $center, $attackRange, $range){
	$x = $step->x - ($center['x'] - $range);
	$y = $step->y - ($center['y'] - $range);
	return !isset($attackRange[$x][$y])?true:false;
}