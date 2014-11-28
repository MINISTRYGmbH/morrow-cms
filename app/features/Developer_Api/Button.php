<?php

namespace app\features\Developer_Api;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="developer/api"><span class="fa fa-puzzle-piece fa-fw"></span> API</a>';
	}
}