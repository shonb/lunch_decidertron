<?php

class RandomPicker {
	private $options;
	private $ignored_list;

	public function __construct(array $options) {
		$this->options = $options;
	}

	public function pick() {
		$options = $this->get_available_options();
		$rand = mt_rand(1, array_sum($options));
		return $this->get_selection_on_index($options, $rand);
	}

	public function add_ignore($ignore) {
		$this->ignored_list[] = $ignore;
	}

	private function get_available_options() {
		$options = $this->options;
		if (is_array($this->ignored_list)) {
			foreach ($this->ignored_list as $ignore) {
				if (array_key_exists($ignore, $options)) {
					$options[$ignore] = 0;
				}
			}
		}

		return $options;
	}

	private function get_selection_on_index(array $options, $weighted_index) {
		$total_weight = 0;

		foreach ($options as $selection => $weight) {
			if ($weighted_index >= $total_weight && $weighted_index <= $total_weight + $weight) {
				return $selection;
			}

			$total_weight += $weight;
		}

		return null;
	}
}

