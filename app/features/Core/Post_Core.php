<?php

namespace app\features\Core;
use Morrow\Factory;
use Morrow\Debug;

class Post_Core {
	public function run($dom) {
		// save the XML data
		$doc = Factory::load('\app\features\Core\DOMDocument');
		$doc->save(ROOT_PATH . 'data/data.xml');
	}
}
