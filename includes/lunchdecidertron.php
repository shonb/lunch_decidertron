<?php
require_once(__DIR__ . "/simpledailyrecorder.php");
require_once(__DIR__ . "/randompicker.php");

class LunchDecidertron {
	private $record_dir;
	private $options;

	// TODO: Move to config
	const RECORD_DIR = '/home/robin/lunch/';

	public function __construct($config_file) {
		if (is_file($config_file)) {
			include($config_file);

			$this->record_dir = $config_record_dir;
			$this->options = $config_options;
		}
	}

	public function choose_todays_lunch_place() {
		$day_of_week = date('l');
		$recorder = new SimpleDailyRecorder($this->record_dir);
		$place = $recorder->get_record($day_of_week);

		if (empty($place)) {
			$picker = new RandomPicker($this->options);

			$yesterdays_pick = $recorder->get_record(date('l', strtotime('last weekday')));
			if (!empty($yesterdays_pick)) {
				$picker->add_ignore($yesterdays_pick);
			}

			$place = $picker->pick();

			if (!empty($place)) {
				$recorder->record($day_of_week, $place);
			}
		}

		return $place;
	}

	public function get_options() {
		return $this->options;
	}
}
