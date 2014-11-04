<?php

namespace app\features\Developer;
use Morrow\Factory;
use Morrow\Debug;

class API_Button extends _Default {
	public function run($dom) {
		return '<a href="developer/api" class="navi-item"><span class="fa fa-puzzle-piece fa-fw"></span> API</a>';
	}
}