<?php

class SimpleDailyRecorder {
	private $dir;

	public function __construct($dir) {
		$this->dir = $dir;
		if (substr($this->dir, -1) != '/') {
			$this->dir .= '/';
		}
	}

	public function get_record($day_of_week) {
		$filename = $this->get_filename($day_of_week);
		if (is_file($filename) && filemtime($filename) > strtotime('last ' . date('l'))) {
			return trim(file_get_contents($filename));
		} else {
			return false;
		}
	}

	public function record($day_of_week, $value) {
		file_put_contents($this->get_filename(date('l')), $value);
	}
	
	private function get_filename($day_of_week) {
		return $this->dir . $day_of_week;
	}
}
