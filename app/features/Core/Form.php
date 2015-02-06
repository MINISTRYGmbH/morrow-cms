<?php

namespace app\features\Core;
use Morrow\Factory;
use Morrow\Debug;

class Form extends \Morrow\Form {
	/**
	 * Contains all user form definitions.
	 * @var array $_definitions
	 */
	protected $_definitions;

	public function __construct($input, $errors, $definitions) {
		$this->_definitions = $definitions;

		parent::__construct($input, $errors);
	}

	public function label($name, $value, $info = '', $attributes = []) {
		$required = in_array('required', $this->_definitions[$name]['validator']);

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

	public function hidden($name, $value, $attributes = []) {
		return parent::hidden($name, $value, $attributes);
	}

	protected function _textfield($type, $name, $attributes = [], $prefix = '', $suffix = '') {
		return
			'<div class="form-row form-type-text">'
			. call_user_func_array([$this, 'label'], array_merge([$name], $this->_definitions[$name]['label']))
			. '<div class="form-field"><div class="form-extension">'
			. ($prefix ? '<div class="form-extension-prefix">' . $prefix . '</div>' : '')
			. parent::{$type}($name, $attributes)
			. ($suffix ? '<div class="form-extension-suffix">' . $suffix . '</div>' : '')
			. '</div></div></div>';
	}

	public function input($name, $attributes = [], $prefix = '', $suffix = '') {
		return $this->_textfield('input', $name, $attributes, $prefix, $suffix);
	}

	public function text($name, $attributes = [], $prefix = '', $suffix = '') {
		return $this->_textfield('text', $name, $attributes, $prefix, $suffix);
	}

	public function password($name, $attributes = [], $prefix = '', $suffix = '') {
		return $this->_textfield('password', $name, $attributes, $prefix, $suffix);
	}

	public function file($name, $attributes = []) {
		return
			'<div class="form-row">'
			. call_user_func_array([$this, 'label'], array_merge([$name], $this->_definitions[$name]['label']))
			. '<div class="form-field">'
			. parent::file($name, $attributes)
			. '</div></div>';
	}

	public function textarea($name, $attributes = []) {
		return
			'<div class="form-row form-type-textarea">'
			. call_user_func_array([$this, 'label'], array_merge([$name], $this->_definitions[$name]['label']))
			. '<div class="form-field">'
			. parent::textarea($name, $attributes)
			. '</div></div>';
	}

	public function checkbox($name, $values, $attributes = [], $horizontal = true) {
		$returner = '';
		$i = 0;
		foreach ($values as $value => $title) {
			if ($i++ > 0) $attributes['id'] = md5($value);
			$returner .= '<label>' . parent::checkbox($name . '[]', $value, $attributes) . ' ' . $title . '</label>';
			if (!$horizontal) $returner .= '<br />';
		}

		return
			'<div class="form-row form-type-checkbox">'
			. call_user_func_array([$this, 'label'], array_merge([$name], $this->_definitions[$name]['label']))
			. '<div class="form-field">'
			. $returner
			. '</div></div>';
	}

	public function radio($name, $values, $attributes = [], $horizontal = true) {
		$returner = '';
		$i = 0;
		foreach ($values as $value => $title) {
			if ($i++ > 0) $attributes['id'] = md5($value);
			$returner .= '<label>' . parent::radio($name, $value, $attributes) . ' ' . $title . '</label>';
			if (!$horizontal) $returner .= '<br />';
		}

		return
			'<div class="form-row form-type-radio">'
			. call_user_func_array([$this, 'label'], array_merge([$name], $this->_definitions[$name]['label']))
			. '<div class="form-field">'
			. $returner
			. '</div></div>';
	}

	public function select($name, $values, $attributes = []) {
		return
			'<div class="form-row form-type-select">'
			. call_user_func_array([$this, 'label'], array_merge([$name], $this->_definitions[$name]['label']))
			. '<div class="form-field">'
			. parent::select($name, $values, $attributes)
			. '</div></div>';
	}

	public function select_list($name, $values, $attributes = []) {
		return
			'<div class="form-row form-type-select-list">'
			. call_user_func_array([$this, 'label'], array_merge([$name], $this->_definitions[$name]['label']))
			. '<div class="form-field">'
			. parent::select($name, $values, $attributes)
			. '</div></div>';
	}
}
