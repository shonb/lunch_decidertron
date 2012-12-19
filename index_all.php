<?php

$overwrite = array_key_exists('overwrite', $_POST) && $_POST['overwrite'] == 1;

$options = $decider->get_options();
$selected = $decider->choose_todays_lunch_place($overwrite);

// Redirect to avoid accidentally re-requesting overwrite when the page is reloaded
if ($overwrite) {
	header('Location: ' . $_SERVER['PHP_SELF']);
}

$last_overwrite = $decider->get_last_overwrite_time();
$last_overwrite = 
	$last_overwrite === false ?
	'Never' :
	date('Y-m-d H:i:s', $last_overwrite);

include(__DIR__ . '/tpl.php');
