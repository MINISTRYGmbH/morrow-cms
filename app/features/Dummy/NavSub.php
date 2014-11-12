<?php

namespace app\features\Dummy;
use Morrow\Factory;
use Morrow\Debug;

class NavSub extends _Default {
	public function run($dom) {
		return new \Morrow\Views\Serpent;
	}
}