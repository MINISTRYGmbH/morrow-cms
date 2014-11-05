<?php

namespace app\features\Authorization;
use Morrow\Factory;
use Morrow\Debug;

class Groups_Button extends _Default {
	public function run($dom) {
		return '<a href="authorization/groups"><span class="fa fa-users fa-fw"></span> Gruppen</a>';
	}
}