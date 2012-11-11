<?php
require_once(__DIR__ . "/simpledailyrecorder.php");
require_once(__DIR__ . "/randompicker.php");

class LunchDecidertron {
	private $options;

	// TODO: Move to config
	const RECORD_DIR = '/home/robin/lunch/';

	public function choose_todays_lunch_place() {
		$day_of_week = date('l');
		$recorder = new SimpleDailyRecorder(self::RECORD_DIR);
		$place = $recorder->get_record($day_of_week);

		if (empty($place)) {
			$this->load_options();

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
		if (empty($this->options)) {
			$this->load_options();
		}

		return $this->options;
	}

	private function load_options() {
		if (empty($this->options)) {
			// TODO: Move to config
			$this->options = array(
				'Peko Peko' => 50,
				'Not All There' => 0,
				'Cafe 434' => 100,
				'Blue Moose' => 100,
				'Soup Place' => 10,
				'Next to Soup Place' => 10,
				'Oriental East' => 100,
			);
		}
	}
}
