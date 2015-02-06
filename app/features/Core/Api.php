<?php

namespace app\features\Core;
use Morrow\Factory;
use Morrow\Debug;

class Api {
	protected $_mappings = [];

	public function register($path, $data = []) {
		$this->_mappings[$path] = $data;
	}

	public function execute($path, $parameters = []) {
		return call_user_func($this->_mappings[$path]['callback'], $parameters);
	}

	public function toc($path = null) {
		if ($path === null) {
			return $this->_mappings;
		} else {
			return $this->_mappings[$path];
		}
	}
}
