<?php

namespace app\features\Core;
use Morrow\Factory;
use Morrow\Debug;

class DOMDocument extends \DOMDocument {
	protected $_path;
	public $xpath;

	public function __construct($path, $version = '1.0', $encoding = 'utf-8') {
		parent::__construct($version, $encoding);
		$this->registerNodeClass('DOMElement', 'app\features\Core\DOMElement');
		$this->preserveWhiteSpace = false;
		$this->load($path);
		$this->__path = $path;
		$this->xpath = new \DOMXpath($this);
	}

}
