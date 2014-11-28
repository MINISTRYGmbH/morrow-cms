<?php

use \Morrow\Debug;

class Form extends \Morrow\Form {
	public function label($name, $value, $attributes = [], $required = false, $info = '') {
		$returner = parent::label($name, $value, $attributes);
		
		if ($required) {
			$returner .= ' <span class="fa fa-asterisk"></span>';
		}
		
		if ($info) {
			$returner .= '<div class="form-info"><span class="fa fa-info-circle"></span> ' . $info . '</div>';
		}
		
		$error = $this->error($name);
		if ($error) {
			$returner .= '<div class="form-error-info"><span class="fa fa-exclamation-circle"></span> ' . $error . '</div>';
		}
		
		$extra = isset($this->_errors[$name]) ? self::$error_class : '';
		
		return '<div class="form-label ' . $extra . '">' . $returner . '</div>';
	}

	protected function _getDefaultInputHtml($type, $name, $attributes, $value_fixed = null) {
		$returner = parent::_getDefaultInputHtml($type, $name, $attributes, $value_fixed);
		
		return '<div class="form-field">' . $returner . '</div>';
	}
	
	public function textarea($name, $attributes = []) {
		$returner = parent::textarea($name, $attributes);
		
		return '<div class="form-field">' . $returner . '</div>';
	}

	public function select($name, $values, $attributes = []) {
		$returner = parent::select($name, $values, $attributes);
		
		return '<div class="form-field">' . $returner . '</div>';
	}
}