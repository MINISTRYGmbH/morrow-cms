<?php

namespace app\features\Developer_Definitions;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="developer/definitions"><span class="fa fa-check-square fa-fw"></span> Definitionen</a>';
	}
}