<?php

use \Morrow\Debug;

class Api {
	protected $_mappings = [];

	public function __construct() {
	}

	public function register($path, $data = []) {
		$this->_mappings[$path] = $data;
	}

	public function execute($path, $parameters = []) {
		return call_user_func_array($this->_mappings[$path]['callback'], $parameters);
	}

	public function toc($path = null) {
		if ($path === null) {
			return $this->_mappings;
		} else {
			return $this->_mappings[$path];
		}
	}
}