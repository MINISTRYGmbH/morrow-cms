<?php

namespace app\features\Authentication;
use Morrow\Factory;
use Morrow\Debug;

class EmailPassword extends _Default {
	public function run($dom) {
		return new \Morrow\Views\Serpent;
	}
}