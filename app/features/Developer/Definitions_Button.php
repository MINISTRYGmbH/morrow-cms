<?php

namespace app\features\Developer;
use Morrow\Factory;
use Morrow\Debug;

class Definitions_Button extends _Default {
	public function run($dom) {
		return '<a href="developer/definitions"><span class="fa fa-check-square fa-fw"></span> Definitionen</a>';
	}
}