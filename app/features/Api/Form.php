<?php

namespace app\features\Api;
use Morrow\Factory;
use Morrow\Debug;

class Form extends \Morrow\Form {
	public function radiogroup($name, $values, $attributes = []) {
		$html = '';
		foreach ($values as $value => $name) {
			$html .= $this->radio($name, $value, $attributes) . $name;
		}
		return $html;
	}
}
