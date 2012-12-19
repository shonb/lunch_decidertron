<?php
require_once(__DIR__ . "/simpledailyrecorder.php");
require_once(__DIR__ . "/randompicker.php");

class LunchDecidertron {
	private $record_dir;
	private $options;

	// How many days of past selected options to ignore (i.e.: not chosen again)
	const IGNORE_DAYS = 3;

	public function __construct($config_file) {
		if (is_file($config_file)) {
			include($config_file);

			$this->record_dir = $config_record_dir;
			$this->options = $config_options;
		}
	}

	public function choose_todays_lunch_place($overwrite = false) {
		$day_of_week = date('l');
		$recorder = new SimpleDailyRecorder($this->record_dir);
		$place = $recorder->get_record($day_of_week);

		// Don't mark as overwritten if nothing has been chosen yet
		if (empty($place) && $overwrite) {
			$overwrite = false;
		}

		if (empty($place) || $overwrite) {
			$picker = new RandomPicker($this->options);

			// For 'choose again' make sure it doesn't choose the same option again
			if ($overwrite) {
				$picker->add_ignore($place);
			}

			// Don't choose what's been chosen in the past 3 days
			$days_to_ignore = min(self::IGNORE_DAYS, $picker->count_available_options());
			for ($i = 1; $i <= $days_to_ignore; $i++) {
				$past_day = date('l', strtotime("-{$i} day"));
				$past_selection = $recorder->get_record($past_day);
				if (!empty($past_selection)) {
					$picker->add_ignore($past_selection);
				}
			}

			$place = $picker->pick();

			if (!empty($place)) {
				$recorder->record($day_of_week, $place);
				if ($overwrite) {
					$recorder->flag_overwrite();
				}
			}
		}

		return $place;
	}

	public function get_last_overwrite_time() {
		$recorder = new SimpleDailyRecorder($this->record_dir);
		return $recorder->get_last_overwrite_time();
	}

	public function get_options() {
		return $this->options;
	}
}
