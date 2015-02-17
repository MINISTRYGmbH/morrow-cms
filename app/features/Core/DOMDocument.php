<?php

namespace app\features\Core;
use Morrow\Factory;
use Morrow\Debug;

class DOMDocument extends \DOMDocument {
	protected $_path;
	public $xpath;

	public function __construct($version = '1.0', $encoding = 'utf-8') {
		parent::__construct($version, $encoding);
	}
}
