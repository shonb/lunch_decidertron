<?php
require_once(__DIR__ . "/includes/lunchdecidertron.php");

$decider = new LunchDecidertron('./includes/config_ade.php');

include(__DIR__ . '/index_all.php');