<?php

namespace app\features\Developer;
use Morrow\Factory;
use Morrow\Debug;

class Database extends _Default {
	public function run($dom) {
		return new \Morrow\Views\Serpent;
	}
}