<?php
require_once(__DIR__ . "/includes/lunchdecidertron.php");

$decider = new LunchDecidertron('./includes/config_syd.php');
$options = $decider->get_options();
$selected = $decider->choose_todays_lunch_place();

include(__DIR__ . "/tpl.php");
