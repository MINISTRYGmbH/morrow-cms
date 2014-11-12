<?php

namespace app\features\Authorization;
use Morrow\Factory;
use Morrow\Debug;

class Permissions extends _Default {
	public function run($dom) {
		return new \Morrow\Views\Serpent;
	}
}