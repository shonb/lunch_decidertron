<?php

class SimpleDailyRecorder {
	const OVERWRITE_FILENAME = 'overwrite';

	private $dir;


	public function __construct($dir) {
		$this->dir = $dir;
		if (substr($this->dir, -1) != '/') {
			$this->dir .= '/';
		}
	}

	public function get_record($day_of_week) {
		$filename = $this->get_filename($day_of_week);
		if (is_file($filename) && filemtime($filename) >= mktime(0, 0, 0, date('n'), date('j')-6)) {
			return trim(file_get_contents($filename));
		} else {
			return false;
		}
	}

	public function record($day_of_week, $value) {
		file_put_contents($this->get_filename(date('l')), $value);
	}

	public function flag_overwrite() {
		$filename = $this->get_overwrite_flag_filename();
		touch($filename);
	}

	public function get_last_overwrite_time() {
		$filename = $this->get_overwrite_flag_filename();
		return is_file($filename) ? filemtime($filename) : false;
	}

	private function get_filename($day_of_week) {
		return $this->dir . $day_of_week;
	}

	private function get_overwrite_flag_filename() {
		return $this->dir . self::OVERWRITE_FILENAME;
	}
}
