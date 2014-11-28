<?php

namespace app\features\Authentication_LoginPassword;
use Morrow\Factory;
use Morrow\Debug;

class Page {
	public function run($dom) {
		return new \Morrow\Views\Serpent;
	}
}