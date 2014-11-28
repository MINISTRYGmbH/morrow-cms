<?php

namespace app\features\Developer_HTMLElements;
use Morrow\Factory;
use Morrow\Debug;

class Page {
	public function run($dom) {
		return new \Morrow\Views\Serpent;
	}
}